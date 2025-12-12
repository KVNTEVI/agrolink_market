<?php

namespace App\Http\Controllers\Producteur;

use App\Http\Controllers\Controller;
use App\Models\Commande; // Modèle Commande
use Illuminate\Support\Facades\Auth; // Importation de la Façade Auth

// Contrôleur de gestion des commandes reçues par le producteur connecté
class CommandeController extends Controller
{
    // Affiche la liste des commandes destinées uniquement au producteur connecté. (READ)
    public function index()
    {
        // Récupère les commandes où 'vendeur_id' correspond à l'ID de l'utilisateur.
        $commandes = Commande::where('vendeur_id', Auth::id())
            // Charge les relations associées pour éviter les requêtes N+1.
            ->with('produit', 'acheteur')
            ->get();

        // Affiche la vue d'index des commandes.
        return view('producteur.commandes.index', compact('commandes'));
    }

    // Met à jour le statut d'une commande spécifique (Ex: expédiée, annulée). (UPDATE)
    public function updateStatus($id, $status)
    {
        // Trouve la commande par ID ET s'assure qu'elle appartient bien au vendeur connecté.
        $commande = Commande::where('vendeur_id', Auth::id())->findOrFail($id);

        // Met à jour le statut de la commande.
        $commande->statut = $status;
        $commande->save();

        // Redirige avec un message de succès.
        return redirect()->back()->with('success', 'Statut de commande mis à jour.');
    }
}