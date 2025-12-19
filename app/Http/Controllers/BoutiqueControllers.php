<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;

/**
 * Ce contrôleur gère l'interface publique de la boutique.
 * Il permet aux visiteurs et acheteurs de parcourir les produits disponibles.
 */
class BoutiqueController extends Controller
{
    /**
     * Affiche la liste des produits mis en vente.
     * Inclut la logique de recherche et de filtrage par catégorie.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // 1. Début de la requête sur les produits
        // On ne récupère QUE les produits ayant le statut 'valide' (approuvés par l'admin).
        $produits = Produit::where('statut', 'valide')
            
            // 2. Filtrage par Catégorie (si présent dans l'URL : ?categorie=ID)
            // La méthode when() exécute la fonction seulement si $request->categorie n'est pas vide.
            ->when($request->categorie, function ($q) use ($request) {
                $q->where('categorie_id', $request->categorie);
            })

            // 3. Recherche par Nom (si présent dans l'URL : ?search=TEXTE)
            // Utilise l'opérateur LIKE pour trouver des correspondances partielles.
            ->when($request->search, function ($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->search . '%');
            })

            // 4. Tri et Pagination
            // Affiche les produits les plus récents en premier et limite à 10 par page.
            ->latest()
            ->paginate(10);

        // 5. Récupération de toutes les catégories pour les afficher dans la barre latérale/filtre.
        $categories = Categorie::all();

        // 6. Retourne la vue avec les données (compact crée un tableau à partir des variables).
        return view('boutique.index', compact('produits', 'categories'));
    }

    /**
     * Affiche la page de détail d'un produit spécifique.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Récupère le produit par son ID s'il est valide.
        // findOrFail() renvoie automatiquement une erreur 404 si le produit n'existe pas.
        $produit = Produit::where('statut', 'valide')->findOrFail($id);

        // Retourne la vue de détail du produit.
        return view('boutique.show', compact('produit'));
    }
}