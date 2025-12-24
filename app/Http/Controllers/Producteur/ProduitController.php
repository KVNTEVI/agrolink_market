<?php

namespace App\Http\Controllers\Producteur;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

// Contrôleur de gestion des produits par le producteur connecté
class ProduitController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'producteur']);
    }

    // Affiche la liste des produits créés UNIQUEMENT par l'utilisateur connecté. (READ)
    public function index()
    {
        // Utilisation de la Façade pour récupérer l'ID
        $producteurId = Auth::id(); 

        // Récupère les produits où 'producteur_id' correspond à l'ID stocké.
        $produits = Produit::where('producteur_id', $producteurId)->get();
        
        // Affiche la vue 'producteur.produits.index'.
        return view('producteur.produit.index', compact('produits'));
    }

    // Affiche le formulaire pour ajouter un nouveau produit. (CREATE - Form)
    public function create()
    {
        return view('producteur.produit.create');
    }

    // Enregistre un nouveau produit dans la base de données. (CREATE - Store)
    public function store(Request $request)
    {
        // Validation des champs requis.
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix_unitaire' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|string', // Ou file si tu gères l'upload
            'description' => 'nullable|string',
        ]);

        // Crée et enregistre le produit.
        Produit::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix_unitaire' => $request->prix_unitaire,
            'stock' => $request->stock,
            'image' => $request->image,
            'producteur_id' => Auth::id()
        ]);

        // Redirige vers l'index avec un message de succès.
        return redirect()->route('producteur.produit.index')->with('success', 'Produit ajouté avec succès !');
    }
}