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
        $notifications = Auth::user()->notifications()->paginate(10);
        return view('producteur.notifications', compact('notifications'));
    }

    public function profil() 
    { 
        return view('producteur.profil.index', ['user' => Auth::user()]); 
    }

    // NOUVELLE MÉTHODE : Mise à jour du profil
   // NOUVELLE MÉTHODE : Mise à jour du profil
    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        // 1. Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email,' . $user->id_utilisateur . ',id_utilisateur',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:500',
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 2. Mise à jour des informations de base
        $user->nom = $request->nom;
        $user->email = $request->email;
        $user->telephone = $request->telephone;
        $user->adresse = $request->adresse;

        // --- AJOUT : LOGIQUE DE MODIFICATION DE L'IMAGE ---
        if ($request->hasFile('image')) {
            $destinationPath = public_path('images/utilisateurs');

            // Supprimer l'ancienne image si elle existe
            if ($user->image) {
                $oldFile = $destinationPath . '/' . $user->image;
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }

            // Enregistrer la nouvelle image
            $file = $request->file('image');
            $fileName = time() . '_' . $user->id_utilisateur . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            
            $user->image = $fileName;
        }
        // --------------------------------------------------

        // 3. Mise à jour du mot de passe (uniquement si rempli)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Votre profil a été mis à jour avec succès !');
    }
}