<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Avis; // Modèle de la table 'avis'

// Contrôleur de gestion et de modération des avis clients (zone Admin)
class ReviewController extends Controller
{
    // Affiche la liste de tous les avis. (READ)
    public function index()
    {
        // Récupère tous les avis en chargeant les relations 'utilisateur' et 'produit' (Eager Loading).
        $avis = Avis::with('utilisateur', 'produit')->get();
        
        // Affiche la vue 'admin.avis.index' avec les données.
        return view('admin.avis.index', compact('avis'));
    }

    // Supprime un avis de la base de données (action de modération). (DELETE)
    public function destroy($id)
    {
        // Supprime l'avis correspondant à l'ID.
        Avis::destroy($id);
        
        // Redirige l'utilisateur avec un message de succès.
        return redirect()->back()->with('success', 'Avis supprimé.');
    }
}