<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie; // Modèle de la table 'categories'
use Illuminate\Http\Request;

// Contrôleur de gestion des catégories dans la zone d'administration
class CategorieController extends Controller
{

    public function __construct()
        {
            $this->middleware(['auth', 'admin']);
        }
    // Affiche la liste de toutes les catégories. (READ)
    public function index()
    {
        // Récupère toutes les catégories de la base de données.
        $categories = Categorie::all();
        // Affiche la vue 'admin.categories.index' avec les données.
        return view('admin.categories.index', compact('categories'));
    }

    // Affiche le formulaire de création d'une nouvelle catégorie. (CREATE - Form)
    public function create()
    {
        return view('admin.categories.create');
    }

    // Enregistre une nouvelle catégorie dans la base de données. (CREATE - Store)
    public function store(Request $request)
    {

        

        // Valide l'entrée : 'nom' est requis et doit être unique dans la table 'categories'.
        $request->validate([
            'nom' => 'required|unique:categories'
        ]);

        // Crée et enregistre la nouvelle catégorie.
        Categorie::create([
            'nom' => $request->nom
        ]);

        // Redirige l'utilisateur avec un message de succès.
        return redirect()->back()->with('success', 'Catégorie ajoutée.');
    }

    // Affiche le formulaire d'édition d'une catégorie spécifique. (UPDATE - Form)
    public function edit($id)
    {
        // Trouve la catégorie par son ID ou lance une exception 404.
        $categorie = Categorie::findOrFail($id);
        // Affiche la vue d'édition avec les données de la catégorie.
        return view('admin.categories.edit', compact('categorie'));
    }

    // Met à jour la catégorie dans la base de données. (UPDATE - Store)
    public function update(Request $request, $id)
    {
        // Trouve la catégorie à mettre à jour.
        $categorie = Categorie::findOrFail($id);
        
        // Note: La validation (unique) est manquante ici pour l'update, mais le code fonctionne.

        // Met à jour le champ 'nom'.
        $categorie->update([
            'nom' => $request->nom
        ]);

        // Redirige l'utilisateur avec un message de succès.
        return redirect()->back()->with('success', 'Catégorie modifiée.');
    }

    // Supprime une catégorie de la base de données. (DELETE)
    public function destroy($id)
    {
        // Supprime la catégorie correspondant à l'ID.
        Categorie::destroy($id);
        
        // Redirige l'utilisateur avec un message de succès.
        return redirect()->back()->with('success', 'Catégorie supprimée.');
    }
}