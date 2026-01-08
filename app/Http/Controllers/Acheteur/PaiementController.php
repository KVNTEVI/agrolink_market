<?php

namespace App\Http\Controllers\Acheteur;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Paiement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Notifications\CommandePayeeNotification;
use App\Models\Utilisateur;


/**
 * Ce contrôleur gère l'affichage de la page de paiement et la logique
 * de traitement (simulation) du paiement pour une commande donnée.
 * Il assure que seul l'acheteur de la commande peut effectuer cette action.
 */
class PaiementController extends Controller
{
    /**
     * Applique les middlewares pour s'assurer que seul un utilisateur authentifié
     * avec le rôle 'acheteur' peut accéder à ces méthodes.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'acheteur']);
    }

    /**
     * Affiche l'historique des paiements de l'acheteur.
     */
    public function index()
    {
        // On récupère les paiements liés aux commandes de l'utilisateur connecté
        $paiements = Paiement::whereHas('commande', function ($query) {
            $query->where('acheteur_id', Auth::id());
        })
        ->with('commande') // Charger la commande pour éviter les requêtes N+1
        ->latest()         // Trier du plus récent au plus ancien
        ->get();

        return view('acheteur.paiement.index', compact('paiements'));
    }

    /**
     * Affiche la page de confirmation de paiement pour une commande spécifique.
     * Cette page présente généralement les détails de la commande et les options de paiement.
     *
     * @param  int  $commandeId L'ID de la commande à payer.
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    public function show($commandeId)
    {
        // 1. Récupère la commande et vérifie la propriété :
        // On s'assure que :
        // a) La commande existe (id_commande correspond).
        // b) L'utilisateur connecté (Auth::id()) est bien l'acheteur de cette commande.
        $commande = Commande::where('id_commande', $commandeId)
            ->where('acheteur_id', Auth::id())
            ->firstOrFail(); // Lance 404 si la commande n'existe pas ou n'appartient pas à l'utilisateur.

        // 2. Affiche la vue de paiement, en passant l'objet commande.
        return view('acheteur.paiement.show', compact('commande'));
    }

    /**
     * Traite la simulation du paiement de la commande.
     * Dans un système réel, cette méthode appellerait une API de paiement (Stripe, PayPal, etc.).
     *
     * @param  int  $commandeId L'ID de la commande à payer.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function payer($commandeId)
    {
        // 1. Récupération avec sécurité renforcée
        $commande = Commande::where('id_commande', $commandeId)
            ->where('acheteur_id', Auth::id())
            ->firstOrFail();

        // 2. Vérification : Empêcher le double paiement
        if ($commande->statut === 'payée') {
            return redirect()->route('acheteur.commandes.index')
                ->with('warning', 'Cette commande a déjà été réglée.');
        }

        // 3. Récupération du montant (Le montant_total doit être celui de la négociation)
        $montantFinal = $commande->montant_total;

        // 4. Création de l'enregistrement de paiement
        Paiement::create([
            'commande_id' => $commande->id_commande,
            'montant'     => $montantFinal,
            'mode'        => request('mode', 'Mobile Money'), // Valeur par défaut si vide
            'statut'      => 'payée'
        ]);

        // 5. Mise à jour de la commande
        $commande->update([
            'statut' => 'payée',
            // On s'assure que la date de paiement est enregistrée si tu as une colonne dédiée
            // 'paid_at' => now(), 
        ]);

        // 6. Notification du producteur
        // Important : On récupère l'ID du producteur directement depuis la commande
        $producteur = Utilisateur::find($commande->producteur_id);
        
        if($producteur) {
            try {
                $producteur->notify(new CommandePayeeNotification($commande));
            } catch (\Exception $e) {
                // Log l'erreur si la notification échoue mais ne bloque pas l'utilisateur
                Log::error("Erreur notification : " . $e->getMessage());
            }
        }

        // 7. Redirection
        return redirect()
            ->route('acheteur.commandes.index')
            ->with('success', "Le paiement de " . number_format($montantFinal, 0, ',', ' ') . " FCFA a été validé.");
    }
}