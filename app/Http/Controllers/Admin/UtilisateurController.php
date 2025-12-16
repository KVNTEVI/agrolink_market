<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;

class UtilisateurController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    // Liste des utilisateurs
    public function index()
    {
        $utilisateurs = Utilisateur::with('role')->get();
        return view('admin.utilisateurs.index', compact('utilisateurs'));
    }

    // Bloquer / débloquer
    public function toggleStatut($id)
    {
        $user = Utilisateur::findOrFail($id);
        $user->statut = !$user->statut;
        $user->save();

        return back()->with('success', 'Statut utilisateur mis à jour');
    }

    // Supprimer utilisateur
    public function destroy($id)
    {
        Utilisateur::destroy($id);
        return back()->with('success', 'Utilisateur supprimé');
    }
}
