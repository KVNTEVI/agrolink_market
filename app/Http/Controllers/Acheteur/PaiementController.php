<?php

namespace App\Http\Controllers\Acheteur;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Paiement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Notifications\CommandePayeeNotification;
use App\Models\Utilisateur;

class PaiementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'acheteur']);
    }

    /**
     * Affiche l'historique des paiements de l'acheteur avec le total global.
     */
    public function index()
    {
        // 1. On prépare la requête de base pour cet acheteur
        $query = Paiement::whereHas('commande', function ($q) {
            $q->where('acheteur_id', Auth::id());
        });

        // 2. On calcule le TOTAL GLOBAL de tous les paiements (toutes pages confondues)
        // C'est cette variable que tu utiliseras dans l'en-tête de ta vue
        $totalDepense = $query->sum('montant');

        // 3. On récupère les paiements paginés pour le tableau
        $paiements = $query->with('commande')
            ->latest()
            ->paginate(10);

        // 4. On envoie les deux variables à la vue
        return view('acheteur.paiement.index', compact('paiements', 'totalDepense'));
    }

    /**
     * Affiche la page de confirmation de paiement.
     */
    public function show($commandeId)
    {
        $commande = Commande::where('id_commande', $commandeId)
            ->where('acheteur_id', Auth::id())
            ->firstOrFail();

        return view('acheteur.paiement.show', compact('commande'));
    }

    /**
     * Traite la simulation du paiement.
     */
    public function payer($commandeId)
    {
        $commande = Commande::where('id_commande', $commandeId)
            ->where('acheteur_id', Auth::id())
            ->firstOrFail();

        if ($commande->statut === 'payée') {
            return redirect()->route('acheteur.commandes.index')
                ->with('warning', 'Cette commande a déjà été réglée.');
        }

        $montantFinal = $commande->montant_total;

        // Création de l'enregistrement
        Paiement::create([
            'commande_id' => $commande->id_commande,
            'montant'     => $montantFinal,
            'mode'        => request('mode', 'Mobile Money'),
            'statut'      => 'payée'
        ]);

        // Mise à jour de la commande
        $commande->update(['statut' => 'payée']);

        // Notifications
        $producteur = Utilisateur::find($commande->producteur_id);
        $admins = Utilisateur::where('role_id', 1)->get(); 

        try {
            if($producteur) {
                $producteur->notify(new CommandePayeeNotification($commande));
            }
            foreach($admins as $admin) {
                $admin->notify(new CommandePayeeNotification($commande));
            }
        } catch (\Exception $e) {
            Log::error("Erreur notification paiement : " . $e->getMessage());
        }

        return redirect()
            ->route('acheteur.commandes.index')
            ->with('success', "Le paiement de " . number_format($montantFinal, 0, ',', ' ') . " FCFA a été validé.");
    }
}