<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Paiement;
use App\Models\Commande;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        // Calcul du gain total de la plateforme (somme des commissions)
        $revenusPlateforme = Commande::where('statut', 'payée')->sum('commission_montant');

        return view('admin.dashboard', [
            'totalUtilisateurs' => Utilisateur::count(), 
            'totalProduits' => Produit::count(),     
            'totalCategories' => Categorie::count(),   
            'totalPaiements' => Paiement::count(),
            'revenusPlateforme' => $revenusPlateforme, // Nouvelle variable
            'utilisateursRecents' => Utilisateur::with('role')->latest()->limit(5)->get(),
        ]);
    }

    public function profil()
{
    $user = Auth::user();
    return view('admin.profil', compact('user'));
}

public function updateProfil(Request $request)
{
     /** @var \App\Models\Utilisateur $user */
    $user = Auth::user();
    
    $request->validate([
        'nom' => 'required|string|max:255',
        'email' => 'required|email|unique:utilisateurs,email,' . $user->id,
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $user->nom = $request->nom;
    $user->email = $request->email;
    $user->telephone = $request->telephone;

    if ($request->hasFile('image')) {
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images/utilisateurs'), $imageName);
        $user->image = $imageName;
    }

    $user->save();
    return back()->with('success', 'Profil mis à jour avec succès.');
}
}