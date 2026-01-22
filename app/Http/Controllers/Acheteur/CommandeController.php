<?php

namespace App\Http\Controllers\Acheteur;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\CommandeItem;
use App\Models\Panier;
use App\Models\Utilisateur; // Importé pour notifier le producteur
use App\Notifications\NouvelleCommandeNotification; // Importé pour la notification
use Illuminate\Support\Facades\Auth;

/**
 * Ce contrôleur gère la liste des Commandes et le processus de "checkout"
 * (conversion du Panier en Commandes effectives) pour l'Acheteur.
 */
class CommandeController extends Controller
{
    /**
     * Applique les middlewares pour s'assurer que seul un utilisateur authentifié
     * avec le rôle 'acheteur' peut accéder à ces méthodes.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'acheteur']);
    }

    /**
     * Affiche la liste historique des commandes passées par l'acheteur connecté.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupère toutes les commandes de cet acheteur.
        $commandes = Commande::where('acheteur_id', Auth::id())
            // Optimisation (Eager Loading) : charge les éléments de commande et les produits associés.
            ->with('items.produit')
            ->latest()
            ->paginate(10);

        // Passe la collection de commandes à la vue.
        return view('acheteur.commandes.index', compact('commandes'));
    }


    public function show($id)
    {
        $commande = Commande::where('id_commande', $id)
            ->where('acheteur_id', Auth::id())
            ->with('items.produit')
            ->firstOrFail();

        return view('acheteur.commandes.show', compact('commande'));
    }


    /**
     * Crée une ou plusieurs commandes à partir du contenu du panier de l'acheteur.
     * * NOTE IMPORTANTE : Ce contrôleur crée UNE NOUVELLE COMMANDE PAR LIGNE D'ARTICLE DE PANIER.
     * Si l'objectif est d'avoir une seule commande avec plusieurs producteurs, la logique devrait être ajustée
     * pour regrouper les articles par producteur avant la création des commandes.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        // 1. Récupérer le panier de l'utilisateur avec tous les détails.
        $panier = Panier::where('utilisateur_id', Auth::id())
            ->with('items.produit')
            ->firstOrFail(); 

        // 2. Traiter chaque article du panier pour créer une commande.
        foreach ($panier->items as $item) {

            // 🔑 DÉTERMINATION DU PRIX FINAL
            $prixFinal = $item->prix_negocie ?? $item->produit->prix_unitaire;

            // 1️⃣ Création de la COMMANDE principale
            $commande = Commande::create([
                'acheteur_id' => Auth::id(),
                'producteur_id' => $item->produit->producteur_id, 
                'montant_total' => $prixFinal * $item->quantite, 
                'statut' => 'en_attente' 
            ]);

            // 2️⃣ Création de l'élément de commande (CommandeItem)
            CommandeItem::create([
                'commande_id' => $commande->id_commande,
                'produit_id' => $item->produit_id,
                'quantite' => $item->quantite,
                'prix_final' => $prixFinal 
            ]);

            // --- NOTIFICATION DU PRODUCTEUR ---
            // On récupère le producteur du produit pour lui envoyer l'alerte
            $producteur = Utilisateur::find($item->produit->producteur_id);
            if ($producteur) {
                $producteur->notify(new NouvelleCommandeNotification($commande));
            }
            // ----------------------------------
            
        }

        // 3️⃣ Vider le panier après la conversion réussie en commandes.
        $panier->items()->delete();

        return redirect()->route('acheteur.commandes.index')->with('success', 'Votre commande a été passée avec succès !');
    }
}