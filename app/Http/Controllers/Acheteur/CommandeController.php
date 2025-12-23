<?php

namespace App\Http\Controllers\Acheteur;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\CommandeItem;
use App\Models\Panier;
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
            ->get();

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
            ->firstOrFail(); // Lance 404 si le panier est introuvable (ne devrait pas arriver si le panier existe).
        
        // S'il n'y a pas d'articles, vous pourriez vouloir ajouter une vérification ici: 
        // if ($panier->items->isEmpty()) { return back()->with('error', 'Le panier est vide.'); }

        // 2. Traiter chaque article du panier pour créer une commande.
        foreach ($panier->items as $item) {

            // 🔑 DÉTERMINATION DU PRIX FINAL
            // Si le prix négocié est renseigné ($item->prix_negocie), on l'utilise.
            // Sinon, on prend le prix de base du produit ($item->produit->prix).
            $prixFinal = $item->prix_negocie ?? $item->produit->prix_unitaire;

            // 1️⃣ Création de la COMMANDE principale
            $commande = Commande::create([
                'acheteur_id' => Auth::id(),
                // L'ID du producteur est tiré du produit associé à l'article du panier.
                'producteur_id' => $item->produit->producteur_id, 
                // Calcul du montant total pour CETTE commande (puisque c'est une commande par article ici).
                'montant_total' => $prixFinal * $item->quantite, 
                'statut' => 'en_attente' // Statut initial après la commande.
            ]);

            // 2️⃣ Création de l'élément de commande (CommandeItem)
            // L'élément de commande détaille ce qui a été commandé.
            // Assurez-vous que 'id_commande' est la clé primaire correcte si elle n'est pas 'id'.
            CommandeItem::create([
                'commande_id' => $commande->id_commande,
                'produit_id' => $item->produit_id,
                'quantite' => $item->quantite,
                'prix_final' => $prixFinal // Le prix appliqué est stocké pour l'historique.
            ]);
            
        }

        // 3️⃣ Vider le panier après la conversion réussie en commandes.
        // On supprime tous les items, pas le panier lui-même.
        $panier->items()->delete();

        return redirect()->route('acheteur.commandes.index')->with('success', 'Votre commande a été passée avec succès !');
    }
}