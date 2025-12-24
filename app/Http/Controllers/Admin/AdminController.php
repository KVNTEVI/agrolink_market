<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur; // Import du modèle Utilisateur
use App\Models\Produit;     // Import du modèle Produit
use App\Models\Categorie;   // Import du modèle Catégorie
use App\Models\Paiement;    // Import du modèle Paiement

// Contrôleur principal pour la zone d'administration
class AdminController extends Controller
{
    /**
     * Applique les middlewares de sécurité.
     */
    public function __construct()
    {
        // Nécessite d'être connecté et d'avoir le rôle 'admin' pour toutes les actions
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Affiche le tableau de bord de l'administrateur.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Retourne la vue du tableau de bord avec les statistiques (cartes KPI) et données récentes
        return view('admin.dashboard', [
            // Compte le nombre total d'utilisateurs
            'totalUtilisateurs' => Utilisateur::count(), 
            // Compte le nombre total de produits
            'totalProduits' => Produit::count(),     
            // Compte le nombre total de catégories
            'totalCategories' => Categorie::count(),   
            // Compte le nombre total de paiements enregistrés
            'totalPaiements' => Paiement::count(),    
            // On récupère les 5 derniers utilisateurs pour l'affichage avec leur rôle
            'utilisateursRecents' => Utilisateur::with('role')->latest()->limit(5)->get(),
        ]);
    }
}