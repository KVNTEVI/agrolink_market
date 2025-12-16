<?php

namespace App\Http\Controllers\Acheteur;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Paiement;
use Illuminate\Support\Facades\Auth;

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
        // 1. Vérifie à nouveau l'existence et la propriété de la commande (sécurité).
        $commande = Commande::where('id_commande', $commandeId)
            ->where('acheteur_id', Auth::id())
            ->firstOrFail();

        // 💡 OPTIMISATION : Vous pourriez ajouter une vérification pour s'assurer que
        // la commande n'est pas déjà 'payée' ou 'annulée' avant de procéder.

        // 2. Création de l'enregistrement de paiement (Simulation)
        // Ceci enregistre la transaction de paiement dans la base de données.
        Paiement::create([
            'commande_id' => $commande->id_commande,
            'montant' => $commande->montant_total,
            'mode' => 'cash / mobile money', // Exemple de mode de paiement simulé
            'statut' => 'payé' // Statut de la transaction de paiement
        ]);

        // 3. Mise à jour du statut de la commande principale
        // La commande passe du statut 'en_attente' (ou autre) à 'payée'.
        $commande->update([
            'statut' => 'payée'
        ]);

        // 4. Redirection et message de succès
        // Redirige l'utilisateur vers la liste de ses commandes.
        return redirect()
            ->route('acheteur.commandes.index')
            ->with('success', 'Paiement effectué avec succès');
    }
}