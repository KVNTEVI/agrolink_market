<?php

namespace App\Http\Controllers\Acheteur;

use App\Http\Controllers\Controller;
use App\Models\Panier;
use App\Models\PanierItem;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;

/**
 * Ce contrôleur gère toutes les actions relatives au Panier pour l'Acheteur.
 * Il est placé dans le namespace 'Acheteur' pour des raisons d'organisation.
 */
class PanierController extends Controller
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
     * Affiche le contenu du panier de l'utilisateur connecté.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 1. Récupère le panier de l'utilisateur connecté.
        $panier = Panier::where('utilisateur_id', Auth::id())
            // 2. Charge les relations des éléments du panier (items) et de leurs produits associés (produit)
            // C'est une optimisation Eager Loading pour éviter les problèmes de N+1.
            ->with('items.produit')
            ->first();

        // 3. Passe le panier à la vue d'index.
        return view('acheteur.panier.index', compact('panier'));
    }

    /**
     * Ajoute un produit au panier. Cette méthode gère l'ajout pour un achat direct
     * sans négociation préalable.
     *
     * @param  int  $produitId L'ID du produit à ajouter.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add($produitId)
    {
        // Récupère le produit, ou lance une erreur 404 si non trouvé.
        $produit = Produit::findOrFail($produitId);

        // 1️⃣ Créer ou récupérer le panier de l'utilisateur.
        // firstOrCreate crée un nouveau panier si aucun n'existe pour cet utilisateur.
        $panier = Panier::firstOrCreate([
            'utilisateur_id' => Auth::id()
        ]);
        
        // 🚨 Assurez-vous d'avoir la bonne clé primaire :
        // Si la clé primaire du modèle Panier est 'id', utilisez $panier->id.
        // Si elle est personnalisée (comme ici), utilisez $panier->id_panier.

        // 2️⃣ Ajouter le produit comme un nouvel élément dans le panier (PanierItem).
        PanierItem::create([
            'panier_id' => $panier->id_panier,
            'produit_id' => $produit->id_produit,
            // Pour l'achat direct, on suppose une quantité de 1 par défaut.
            'quantite' => 1, 
            // 'prix_negocie' est null car il n'y a pas eu de négociation, 
            // le prix appliqué sera celui du produit par défaut au moment de la commande.
            'prix_negocie' => null 
        ]);

        return back()->with('success', 'Produit ajouté au panier');
    }
    
}