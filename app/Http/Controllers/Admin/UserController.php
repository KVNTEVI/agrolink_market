<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur; // Modèle de la table 'utilisateurs'

// Contrôleur de gestion des utilisateurs dans la zone d'administration
class UserController extends Controller
{
    // Affiche la liste de tous les utilisateurs avec leurs rôles. (READ)
    public function index()
    {
        // Récupère tous les utilisateurs et charge Eager Loading leur relation 'role'.
        $users = Utilisateur::with('role')->get();
        // Affiche la vue 'admin.users.index' avec les données.
        return view('admin.users.index', compact('users'));
    }

    // Supprime un utilisateur de la base de données. (DELETE)
    public function destroy($id)
    {
        // Supprime l'utilisateur correspondant à l'ID.
        Utilisateur::destroy($id);
        
        // Redirige l'utilisateur avec un message de succès.
        return redirect()->back()->with('success', 'Utilisateur supprimé');
    }
}