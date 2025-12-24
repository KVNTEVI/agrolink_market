<?php

namespace App\Http\Controllers\Acheteur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Contrôleur dédié au tableau de bord et à la gestion du profil de l'acheteur
class AcheteurController extends Controller
{
    // Applique les middlewares de sécurité.
    public function __construct()
    {
        $this->middleware(['auth', 'acheteur']);
    }

    // Affiche le tableau de bord principal de la zone Acheteur.
    public function dashboard()
    {
        /** @var \App\Models\Utilisateur $user */
        $user = Auth::user();

        // 1. Nombre de notifications non lues
        $unreadNotificationsCount = $user->unreadNotifications->count();

        // 2. Nombre de messages (conversations actives)
        $messagesCount = \App\Models\Conversation::where('acheteur_id', $user->id_utilisateur)->count();

        // 3. Historique des paiements de l'acheteur
        // On récupère les paiements via les commandes passées par cet acheteur
        $paiements = \App\Models\Paiement::whereHas('commande', function($query) use ($user) {
            // Note : Assurez-vous que la colonne est bien 'id_utilisateur' ou 'acheteur_id' dans votre table commandes
            $query->where('id_utilisateur', $user->id_utilisateur);
        })->with('commande')->latest()->get();

        // 4. Notifications récentes (3 dernières) pour l'affichage rapide
        $recentNotifications = $user->notifications()->take(3)->get();

        return view('acheteur.dashboard', compact(
            'unreadNotificationsCount', 
            'messagesCount', 
            'paiements', 
            'recentNotifications'
        ));
    }

    /**
     * Affiche la liste complète des notifications de l'acheteur avec pagination
     */
    public function notifications()
    {
        /** @var \App\Models\Utilisateur $user */
        $user = Auth::user();

        // On récupère toutes les notifications avec une pagination (10 par page)
        $allNotifications = $user->notifications()->paginate(10);

        return view('acheteur.notifications', compact('allNotifications'));
    }

    // Affiche le formulaire d'édition/consultation du profil de l'utilisateur connecté.
    public function profil()
    {
        $user = Auth::user(); 
        return view('acheteur.profil.index', compact('user'));
    }

    // Gère la mise à jour des informations du profil (nom, email).
    public function updateProfil(Request $request)
    {
        /** @var \App\Models\Utilisateur $user */
        $user = Auth::user(); 

        $request->validate([
            'nom' => 'required',
            'email' => 'required|email'
        ]);

        $user->update($request->only(['nom', 'email']));

        return back()->with('success', 'Profil mis à jour.');
    }
}