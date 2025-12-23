<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // On récupère les 4 ou 8 derniers produits valides pour l'accueil
        $produitsPhares = Produit::where('statut', 'valide')
                                ->latest()
                                ->take(4) // On en prend seulement 4 pour l'accueil
                                ->get();

        return view('home', compact('produitsPhares')); 
    }
}
