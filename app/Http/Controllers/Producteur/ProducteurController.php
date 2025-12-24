<?php

namespace App\Http\Controllers\Producteur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commande; 
use App\Models\Produit;  
use Illuminate\Support\Facades\Auth;

class ProducteurController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'producteur']);
    }

    public function dashboard()
    {
        $userId = Auth::id(); 

        // 1. Statistiques du haut (KPIs)
        // Note: On utilise 'montant_total' selon ton modèle Commande
        $chiffreAffaires = Commande::where('producteur_id', $userId)
            ->where('statut', 'payé')
            ->sum('montant_total');

        $commandesEnAttente = Commande::where('producteur_id', $userId)
            ->where('statut', 'en_attente')
            ->count();

        $totalProduits = Produit::where('producteur_id', $userId)->count();
        $satisfaction = 92; 

        // 2. Données pour les tableaux
        // On récupère les 4 dernières commandes avec l'acheteur
        $commandesRecentes = Commande::where('producteur_id', $userId)
            ->with('acheteur')
            ->latest()
            ->take(4)
            ->get();

        // Alertes Stock : On utilise 'stock' selon ton modèle Produit
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

    public function profil() 
    { 
        return view('producteur.profil', ['user' => Auth::user()]); 
    }
}