<?php

namespace App\Http\Controllers\Acheteur;

use App\Http\Controllers\Controller;
use App\Models\Commande; // Modèle Commande
use App\Models\Panier;   // Modèle Panier
use Illuminate\Support\Facades\Auth; // Importation de la Façade Auth

// Contrôleur de gestion des commandes et du passage de commande (Checkout)
class CommandeController extends Controller
{
    // Affiche la liste des commandes passées UNIQUEMENT par l'acheteur connecté. (READ)
    public function index()
    {
        // Récupère les commandes filtrées par l'ID de l'acheteur.
        $commandes = Commande::where('acheteur_id', Auth::id())
            // Charge les relations 'produit' et 'vendeur' (Eager Loading).
            ->with('produit', 'vendeur')
            ->get();

        // Affiche la vue d'index des commandes.
        return view('acheteur.commandes.index', compact('commandes'));
    }

    // Crée une commande à partir du contenu du panier (action de validation/checkout). (CREATE)
    public function store()
    {
        // 1. Récupère tous les articles du panier de l'acheteur.
        $items = Panier::where('acheteur_id', Auth::id())->get();

        // 2. Boucle sur chaque article pour créer une entrée de Commande.
        foreach ($items as $item) {
            Commande::create([
                'acheteur_id' => Auth::id(), // L'acheteur actuel
                
                // Récupère le vendeur du produit associé à l'article du panier.
                'vendeur_id' => $item->produit->vendeur_id, 
                
                'produit_id' => $item->produit_id,
                'quantite' => $item->quantite,
                'statut' => 'en_attente' // Statut initial de la commande
            ]);
        }

        // 3. Vide le panier de l'acheteur une fois la commande passée.
        Panier::where('acheteur_id', Auth::id())->delete();

        // Redirige avec un message de succès.
        return back()->with('success', 'Commande passée avec succès.');
    }
}