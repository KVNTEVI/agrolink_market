<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produit; // Modèle de la table 'produits'

// Contrôleur de gestion et de modération des produits (zone Admin)
class ProductController extends Controller
{
    // Affiche la liste de tous les produits (inclut ceux en attente de modération). (READ)
    public function index()
    {
        // Récupère tous les produits de la base de données.
        $produits = Produit::all();
        // Affiche la vue 'admin.produits.index'.
        return view('admin.produits.index', compact('produits'));
    }

    // Approuve un produit et change son statut à 'valide'. (MODERATION)
    public function approve($id)
    {
        // Trouve le produit par son ID.
        $produit = Produit::findOrFail($id);
        
        // Met à jour le statut du produit.
        $produit->statut = 'valide';
        $produit->save();

        // Redirige avec un message de succès.
        return redirect()->back()->with('success', 'Produit validé.');
    }

    // Rejette un produit et change son statut à 'refuse'. (MODERATION)
    public function reject($id)
    {
        // Trouve le produit par son ID.
        $produit = Produit::findOrFail($id);
        
        // Met à jour le statut du produit.
        $produit->statut = 'refuse';
        $produit->save();

        // Redirige avec un message d'erreur/avertissement.
        return redirect()->back()->with('error', 'Produit refusé.');
    }

    // Supprime définitivement un produit de la base de données. (DELETE)
    public function destroy($id)
    {
        // Supprime le produit correspondant à l'ID.
        Produit::destroy($id);
        
        // Redirige avec un message de succès.
        return redirect()->back()->with('success', 'Produit supprimé.');
    }
}