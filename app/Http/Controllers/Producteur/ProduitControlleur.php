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
        return view('producteur.produits.index', compact('produits'));
    }

    // Affiche le formulaire pour ajouter un nouveau produit. (CREATE - Form)
    public function create()
    {
        return view('producteur.produits.create');
    }

    // Enregistre un nouveau produit dans la base de données. (CREATE - Store)
    public function store(Request $request)
    {
        // Utilisation de la Façade pour récupérer l'ID
        $producteurId = Auth::id(); 
        
        // Validation des champs requis.
        $request->validate([
            'nom' => 'required',
            'prix' => 'required|numeric',
            'image' => 'required', 
        ]);

        // Crée et enregistre le produit.
        Produit::create([
            'nom' => $request->nom,
            'prix' => $request->prix,
            'image' => $request->image,
            // Utilisation de la variable explicite
            'producteur_id' => $producteurId 
        ]);

        // Redirige avec un message de succès.
        return redirect()->back()->with('success', 'Produit ajouté');
    }
}