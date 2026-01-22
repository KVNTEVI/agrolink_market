<?php

namespace App\Http\Controllers\Producteur;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Importé pour sécuriser la transaction

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
            ->paginate(10);

        Auth::user()->unreadNotifications
            ->filter(function($notification) {
                return !isset($notification->data['conversation_id']);
            })
            ->markAsRead();

        return view('producteur.commandes.index', compact('commandes'));
    }

    public function updateStatus($id, $status)
    {
        $commande = Commande::where('producteur_id', Auth::id())->findOrFail($id);
        
        // Si le producteur annule une commande déjà payée, on rend le stock
        if ($status == 'annulée' && ($commande->statut == 'payée' || $commande->statut == 'expédiée')) {
            DB::transaction(function () use ($commande) {
                foreach ($commande->items as $item) {
                    $item->produit->increment('stock', $item->quantite);
                }
            });
        }

        $commande->statut = $status;
        $commande->save();

        return redirect()->back()->with('success', 'Statut mis à jour.');
    }
}