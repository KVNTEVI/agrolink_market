<?php

namespace App\Http\Controllers\Acheteur;

use App\Http\Controllers\Controller;
use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth; 

// Contrôleur de gestion du panier d'achat pour l'utilisateur connecté
class PanierController extends Controller
{
    // Affiche le contenu du panier de l'acheteur connecté. (READ)
    public function index()
    {
        // Récupère les articles du panier où 'acheteur_id' correspond à l'ID de l'utilisateur connecté.
        $items = Panier::where('acheteur_id', Auth::id())->get();
        
        // Affiche la vue 'acheteur.panier.index'.
        return view('acheteur.panier.index', compact('items'));
    }

    // Ajoute un produit au panier de l'utilisateur connecté. (CREATE)
    public function add($id)
    {
        // Crée une nouvelle entrée dans la table Panier.
        Panier::create([
            'acheteur_id' => Auth::id(), 
            'produit_id' => $id,
            'quantite' => 1
        ]);

        // Redirige avec un message de succès.
        return redirect()->back()->with('success', 'Produit ajouté au panier');
    }
}