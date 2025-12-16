<?php

namespace App\Http\Controllers\Producteur;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Commande; // Import nécessaire si vous créez une commande
use Illuminate\Support\Facades\Auth;
use App\Notifications\NouvelleNegociationNotification;

class ConversationController extends Controller
{
    /**
     * Applique les middlewares pour s'assurer que seul un producteur connecté peut y accéder.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'producteur']);
    }

    /**
     * Permet au Producteur d'accepter la dernière offre de prix et de créer la Commande.
     *
     * @param  int  $conversationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accepterOffre($conversationId)
    {
        // 1. Vérifie l'autorisation (le producteur connecté doit être le propriétaire de la conversation)
        $conversation = Conversation::where('producteur_id', Auth::id())
            ->findOrFail($conversationId);

        // 2. Récupère le dernier prix proposé
        $dernierPrix = $conversation->messages()
            ->whereNotNull('prix_propose')
            ->latest()
            ->value('prix_propose');

        if (!$dernierPrix) {
            return back()->with('error', 'Aucune proposition de prix valide trouvée.');
        }

        // 3. Met à jour le statut de la Conversation
        $conversation->update([
            'statut' => 'accord_trouve',
            'prix_final' => $dernierPrix
        ]);

        // 4. Crée la Commande (si l'accord est trouvé)
        if ($conversation->statut === 'accord_trouve') {
            Commande::create([
                'acheteur_id' => $conversation->acheteur_id,
                'producteur_id' => $conversation->producteur_id,
                'produit_id' => $conversation->produit_id,
                'prix' => $conversation->prix_final,
                'statut' => 'en_attente'
            ]);

            // 5. Notifie l'Acheteur de l'acceptation de l'offre
            // Assurez-vous que la relation 'acheteur' existe sur votre modèle Conversation
            $acheteur = $conversation->acheteur; 
            
            // Envoie la notification 'accepte' à l'acheteur
            $acheteur->notify(
                new NouvelleNegociationNotification($conversation, 'accepte')
            );
        }

        return back()->with('success', 'Offre acceptée et Commande créée.');
    }

    /**
     * Permet au Producteur de refuser la négociation et de clôturer la conversation.
     *
     * @param  int  $conversationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refuser($conversationId)
    {
        // 1. Vérifie l'autorisation (le producteur connecté doit être le propriétaire de la conversation)
        $conversation = Conversation::where('producteur_id', Auth::id())
            ->findOrFail($conversationId);

        // 2. Met à jour le statut
        $conversation->update([
            'statut' => 'cloturee'
        ]);

        // 3. Notifie l'Acheteur du refusé
        $acheteur = $conversation->acheteur; 
        
        // Envoie la notification 'refuse' à l'acheteur
        $acheteur->notify(
            new NouvelleNegociationNotification($conversation, 'refuse')
        );

        // 3. Redirection
        return back()->with('error', 'Négociation refusée et conversation clôturée.');
    }
}