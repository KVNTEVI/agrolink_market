<?php

namespace App\Notifications;

use App\Models\Conversation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage; 

/**
 * SECTION 1 : CONFIGURATION DE LA NOTIFICATION
 * Notification déclenchée lors d'un événement dans une négociation (message, offre, statut).
 * Elle est destinée à l'utilisateur qui n'est PAS l'expéditeur de l'action.
 */
class NouvelleNegociationNotification extends Notification
{
    use Queueable; // Permet l'envoi asynchrone via les files d'attente (queues).

    /**
     * SECTION 2 : CONSTRUCTEUR
     * @param Conversation $conversation L'objet Conversation concerné.
     * @param string $type Le type d'événement (message, offre, accepte, refuse).
     */
    public function __construct(
        // Utilisation du Property Promotion de PHP 8+
        public Conversation $conversation,
        public string $type // message | offre | accepte | refuse
    ) {}

    /**
     * SECTION 3 : CANAUX DE DIFFUSION
     * @param  mixed  $notifiable L'entité à notifier (User).
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * SECTION 4 : PRÉPARATION DES DONNÉES (BASE DE DONNÉES)
     * Cette méthode définit ce qui sera stocké dans la colonne 'data' de la table notifications.
     */
    public function toDatabase($notifiable)
    {
        return [
            // Identifiant de la conversation pour les liens de redirection
            'conversation_id' => $this->conversation->id_conversation,
            
            // SECTION 4.1 : LOGIQUE DU MESSAGE (Match)
            // Détermine dynamiquement le texte affiché selon l'action effectuée
            'message' => match($this->type) {
                'offre'   => 'Nouvelle offre de prix reçue',
                'accepte' => 'Votre offre a été acceptée',
                'refuse'  => 'Votre offre a été refusée',
                default   => 'Nouveau message'
            },

            // SECTION 4.2 : INFORMATIONS COMPLÉMENTAIRES
            'produit'    => $this->conversation->produit->nom,
            'type'       => $this->type,
            'prix_final' => $this->conversation->prix_final,
        ];
    }
}