<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

class UtilisateurController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    // Liste des utilisateurs
public function index(Request $request)
{
    $search = $request->input('search');
    // On récupère le filtre de rôle depuis l'URL
    $roleFilter = $request->input('role'); 

    $utilisateurs = Utilisateur::with('role')
        ->when($search, function ($query, $search) {
            return $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        })
        ->when($roleFilter, function ($query, $roleFilter) {
            return $query->where('role_id', $roleFilter);
        })
        ->latest()
        ->get();

    // TRÈS IMPORTANT : Ajouter 'roleFilter' dans le compact()
    return view('admin.utilisateurs.index', compact('utilisateurs', 'search', 'roleFilter'));
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
