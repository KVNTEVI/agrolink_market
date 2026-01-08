<?php

namespace App\Http\Controllers\Producteur;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'producteur']);
    }

    public function index()
    {
        $commandes = Commande::where('producteur_id', Auth::id())
            ->with(['items.produit', 'acheteur'])
            ->latest()
            ->get();

        // --- MARQUAGE AUTOMATIQUE COMME LU ---
        // On marque toutes les notifications de commande comme lues quand il consulte la liste
        Auth::user()->unreadNotifications
            ->filter(function($notification) {
                // On vérifie si c'est une notification de commande (qui n'a pas de conversation_id)
                return !isset($notification->data['conversation_id']);
            })
            ->markAsRead();
        // -------------------------------------

        return view('producteur.commandes.index', compact('commandes'));
    }

    public function updateStatus($id, $status)
    {
        $commande = Commande::where('producteur_id', Auth::id())->findOrFail($id);
        $commande->statut = $status;
        $commande->save();

        return redirect()->back()->with('success', 'Le statut a été mis à jour en : ' . $status);
    }
}