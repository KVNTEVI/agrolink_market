<?php

namespace App\Http\Controllers\Acheteur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importation de la Façade Auth pour l'utilisateur

// Contrôleur dédié au tableau de bord et à la gestion du profil de l'acheteur
class AcheteurController extends Controller
{
    // Applique les middlewares de sécurité.
    public function __construct()
{
    $this->middleware(['auth', 'acheteur']);
}

    // Affiche le tableau de bord principal de la zone Acheteur.
    public function dashboard()
    {
        // Affiche la vue : resources/views/acheteur/dashboard.blade.php
        return view('acheteur.dashboard');
    }

    // Affiche le formulaire d'édition/consultation du profil de l'utilisateur connecté. (READ)
    public function profil()
    {
        // Récupère l'objet Utilisateur actuellement authentifié.
        $user = Auth::user(); 
        
        // Affiche la vue 'acheteur.profil' avec les données de l'utilisateur.
        return view('acheteur.profil', compact('user'));
    }

    // Gère la mise à jour des informations du profil (nom, email). (UPDATE)
    public function updateProfil(Request $request)
    {
        // Récupère l'objet Utilisateur connecté.
        // NOTE: Il est préférable d'utiliser le type hint PHPDoc pour éviter les avertissements de l'éditeur:
        // /** @var \App\Models\Utilisateur $user */
        $user = Auth::user(); 

        // Validation des données : nom requis, email requis et format valide.
        $request->validate([
            'nom' => 'required',
            'email' => 'required|email'
        ]);

        /** @var \App\Models\Utilisateur $user */
        // Met à jour les champs 'nom' et 'email' de l'utilisateur (via Mass Assignment).
        $user->update($request->only(['nom', 'email']));

        // Redirige l'utilisateur vers la page précédente (back()) avec un message de succès.
        return back()->with('success', 'Profil mis à jour.');
    }
}