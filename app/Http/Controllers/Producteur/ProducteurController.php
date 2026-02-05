<?php

namespace App\Http\Controllers\Producteur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commande; 
use App\Models\Produit;  
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\Password;

class ProducteurController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'producteur']);
    }

    public function dashboard()
    {
        $userId = Auth::id(); 
        
        $chiffreAffaires = Commande::where('producteur_id', $userId)
            ->whereIn('statut', ['payée', 'payé', 'payee','expédiée', 'livrée'])
            ->sum('montant_total');

        $commandesEnAttente = Commande::where('producteur_id', $userId)
            ->where('statut', 'en_attente')
            ->count();

        $totalProduits = Produit::where('producteur_id', $userId)->count();
        $satisfaction = 92; 

        $commandesRecentes = Commande::where('producteur_id', $userId)
            ->with('acheteur')
            ->latest()
            ->take(4)
            ->get();

        $alertesStock = Produit::where('producteur_id', $userId)
            ->where('stock', '<', 5)
            ->get();
        
        return view('producteur.dashboard', compact(
            'chiffreAffaires', 
            'commandesEnAttente', 
            'totalProduits', 
            'satisfaction',
            'commandesRecentes',
            'alertesStock'
        ));
    }

    public function notifications()
    {
        /** @var \App\Models\Utilisateur $user */
        $user = Auth::user();

        $allNotifications = $user->notifications()
            ->latest() 
            ->paginate(10);

        return view('producteur.notifications', compact('allNotifications'));
    }

    public function profil() 
    { 
        return view('producteur.profil.index', ['user' => Auth::user()]); 
    }

public function updateProfil(Request $request)
{
    // On récupère l'utilisateur via le modèle pour être sûr que save() fonctionne
    $user = \App\Models\Utilisateur::find(Auth::id());

    $request->validate([
        'nom' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $user->nom = $request->nom;
    $user->email = $request->email;
    $user->telephone = $request->telephone;
    $user->adresse = $request->adresse;

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $fileName = time() . '_' . $user->id_utilisateur . '.' . $file->getClientOriginalExtension();
        
        // Déplace le fichier physiquement
        $file->move(public_path('images/utilisateurs'), $fileName);

        // Met à jour le nom en base de données
        $user->image = $fileName;
    }

    // Le save() va maintenant envoyer les données à MySQL
    $user->save(); 

    return back()->with('success', 'Profil mis à jour !');
}

    

    /**
     * Affiche le formulaire de modification du mot de passe
     */
    public function editPassword()
    {
        return view('producteur.profil.password');
    }

    /**
     * Traite la mise à jour du mot de passe
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.current_password' => 'Votre mot de passe actuel est incorrect.',
            'password.confirmed' => 'La confirmation ne correspond pas.',
        ]);

        /** @var \App\Models\Utilisateur $user */
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('producteur.profil')->with('success', 'Mot de passe modifié avec succès !');
    }

    /**
     * Désactive le compte du producteur
     */
    public function desactiver()
    {
        $user = Auth::user();
        // Optionnel : marquer le compte comme inactif si vous avez une colonne 'statut'
        // $user->update(['statut' => 'inactif']);
        
        Auth::logout();
        return redirect('/')->with('success', 'Votre boutique a été désactivée.');
    }
}