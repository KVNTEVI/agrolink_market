<?php

namespace App\Http\Controllers\Acheteur;

use App\Http\Controllers\Controller;
use App\Models\Panier;
use App\Models\PanierItem;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;

// Contrôleur pour la gestion du panier d'un acheteur
class PanierController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'acheteur']);
    }

    /**
     * Affiche le contenu du panier
     */
    public function index()
    {
        $panier = Panier::where('utilisateur_id', Auth::id())
            ->with('items.produit')
            ->first();

        return view('acheteur.panier.index', compact('panier'));
    }

    /**
     * Ajoute un produit au panier ou augmente la quantité
     */
    public function add($produitId)
    {
        $produit = Produit::findOrFail($produitId);

        // 1. Récupérer ou créer le panier
        $panier = Panier::firstOrCreate([
            'utilisateur_id' => Auth::id()
        ]);

        // 2. Chercher si l'article existe déjà (On utilise les bonnes clés primaires)
        $item = PanierItem::where('panier_id', $panier->id_panier)
            ->where('produit_id', $produit->id_produit)
            ->first();

        if ($item) {
            // Augmenter la quantité si déjà présent
            $item->increment('quantite');
        } else {
            // Créer une nouvelle ligne si absent
            PanierItem::create([
                'panier_id'    => $panier->id_panier,
                'produit_id'   => $produit->id_produit,
                'quantite'     => 1,
                'prix_negocie' => null
            ]);
        }

        return back()->with('success', 'Produit ajouté au panier');
    }

    /**
     * Supprime un produit du panier
     */
    public function remove($itemId)
    {
        // On sécurise pour que l'utilisateur ne puisse supprimer que ses propres articles
        $item = PanierItem::where('id_item', $itemId)
            ->whereHas('panier', function ($q) {
                $q->where('utilisateur_id', Auth::id());
            })
            ->firstOrFail();

        $panier = $item->panier;

        // Supprimer l'article
        $item->delete();

        // Si le panier n'a plus d'articles, on le supprime totalement
        if ($panier->items()->count() === 0) {
            $panier->delete();
        }

        return back()->with('success', 'Produit supprimé du panier');
    }
}