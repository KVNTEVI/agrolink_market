<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paiement; // Modèle de la table 'paiements'

// Contrôleur de gestion et de consultation des paiements (zone Admin)
class PaymentController extends Controller
{
    // Affiche la liste de tous les paiements enregistrés. (READ)
    public function index()
    {
        // Récupère toutes les transactions de paiement.
        $paiements = Paiement::all();
        
        // Affiche la vue 'admin.paiements.index' avec la liste des paiements.
        return view('admin.paiements.index', compact('paiements'));
    }
}