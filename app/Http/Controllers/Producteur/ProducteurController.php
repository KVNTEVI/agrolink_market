<?php

namespace App\Http\Controllers\Producteur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Utilisateur; // Modèle Utilisateur
use Illuminate\Support\Facades\Auth; // Importation de la Façade Auth

// Contrôleur dédié au tableau de bord et à la gestion du profil du producteur
class ProducteurController extends Controller
{
    // Applique les middlewares de sécurité.
    public function __construct()
    {
        $this->middleware(['auth', 'producteur']);
    }

    // Affiche le tableau de bord principal de la zone Producteur.
    public function dashboard()
    {
        // Affiche la vue : resources/views/producteur/dashboard.blade.php
        return view('producteur.dashboard');
    }

    // Affiche le formulaire d'édition/consultation du profil de l'utilisateur connecté. (READ)
    public function profil()
    {
        // Récupère l'objet Utilisateur actuellement authentifié.
        $user = Auth::user(); 
        
        // Affiche la vue 'producteur.profil' avec les données de l'utilisateur.
        return view('producteur.profil', compact('user'));
    }

    // Gère la mise à jour des informations du profil (nom, email). (UPDATE)
    public function updateProfil(Request $request)
    {
        /** @var \App\Models\Utilisateur $user */
        // Récupère l'objet Utilisateur connecté.
        $user = Auth::user(); 

        // Validation des données : nom requis, email requis et format valide.
        $request->validate([
            'nom' => 'required',
            'email' => 'required|email'
        ]);

        // Met à jour les champs 'nom' et 'email' de l'utilisateur.
        $user->update($request->only(['nom', 'email']));

        // Redirige l'utilisateur avec un message de succès.
        return redirect()->back()->with('success', 'Profil mis à jour.');
    }
}