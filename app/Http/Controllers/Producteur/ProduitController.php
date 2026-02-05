<?php

namespace App\Http\Controllers\Producteur;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Str;


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
        $produits = Produit::where('producteur_id', $producteurId)
        ->latest()
        ->paginate(10);
        
        // Affiche la vue 'producteur.produits.index'.
        return view('producteur.produit.index', compact('produits'));
    }

    // Affiche le formulaire pour ajouter un nouveau produit. (CREATE - Form)
    public function create()
    {
        $categories = \App\Models\Categorie::all();
        return view('producteur.produit.create', compact('categories'));
    }

    // Enregistre un nouveau produit dans la base de données. (CREATE - Store)
public function store(Request $request)
{
    // 1. Validation des données
    $request->validate([
        'nom' => 'required|string|max:255',
        'prix_unitaire' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'description' => 'nullable|string',
        'categorie_id' => 'required|exists:categories,id_categorie',
        'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Max 2Mo
    ]);

    // 2. Création de l'instance du produit
    $produit = new Produit();
    $produit->categorie_id = $request->categorie_id;
    $produit->nom = $request->nom;
    $produit->prix_unitaire = $request->prix_unitaire;
    $produit->stock = $request->stock;
    $produit->description = $request->description;
    $produit->producteur_id = Auth::id(); // Associe au producteur connecté
    $produit->statut = 'en_attente'; // Par défaut pour modération

    // 3. Gestion de l'image
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        
        // Générer un nom unique : ex 1735564800_sac-de-soja.jpg
        $fileName = time() . '_' . Str::slug($request->nom) . '.' . $file->getClientOriginalExtension();
        
        // Déplacer le fichier vers public/images/produits
        $file->move(public_path('images/produits'), $fileName);
        
        // Enregistrer le nom du fichier en base de données
        $produit->image = $fileName;
    }

    // 4. Sauvegarde
    $produit->save();

    return redirect()->route('producteur.produit.index')
                     ->with('success', 'Produit ajouté avec succès ! Il est en attente de validation.');
}

public function destroy($id)
{
    $produit = Produit::where('producteur_id', Auth::id())->findOrFail($id);

    // Supprimer le fichier image du dossier public s'il existe
    if ($produit->image) {
        $imagePath = public_path('images/produits/' . $produit->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    $produit->delete();

    return redirect()->back()->with('success', 'Produit supprimé avec succès.');
}

// Affiche le formulaire de modification
public function edit($id)
{
    // On vérifie que le produit appartient bien au producteur connecté
    $produit = Produit::where('producteur_id', Auth::id())->findOrFail($id);
    $categories = \App\Models\Categorie::all();
    
    return view('producteur.produit.edit', compact('produit', 'categories'));
}

// Met à jour le produit (UPDATE)
public function update(Request $request, $id)
{
    $produit = Produit::where('producteur_id', Auth::id())->findOrFail($id);

    // 1. Validation
    $request->validate([
        'nom' => 'required|string|max:255',
        'prix_unitaire' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'description' => 'nullable|string',
        'categorie_id' => 'required|exists:categories,id_categorie',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // nullable car optionnelle ici
    ]);

    // 2. Mise à jour des textes
    $produit->nom = $request->nom;
    $produit->prix_unitaire = $request->prix_unitaire;
    $produit->stock = $request->stock;
    $produit->description = $request->description;
    $produit->categorie_id = $request->categorie_id;

    // 3. Gestion de la nouvelle image (si fournie)
    if ($request->hasFile('image')) {
        // Supprimer l'ancienne image physiquement pour ne pas encombrer le serveur
        if ($produit->image) {
            $oldImagePath = public_path('images/produits/' . $produit->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Enregistrer la nouvelle image
        $file = $request->file('image');
        $fileName = time() . '_' . Str::slug($request->nom) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/produits'), $fileName);
        
        $produit->image = $fileName;
    }

    $produit->save();

    return redirect()->route('producteur.produit.index')
                     ->with('success', 'Produit mis à jour avec succès.');
}
}