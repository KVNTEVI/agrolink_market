<?php

namespace App\Notifications;

use App\Models\Conversation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage; 

/**
 * Notification déclenchée lors d'un événement dans une négociation (message, offre, statut).
 * * Elle est destinée à l'utilisateur qui n'est PAS l'expéditeur de l'action
 * (ex: si l'Acheteur envoie un message, cette notification est envoyée au Producteur).
 */
class NouvelleNegociationNotification extends Notification
{
    use Queueable; // Permet de mettre la notification en file d'attente (queue) pour l'envoi asynchrone.

    /**
     * Crée une nouvelle instance de la notification.
     * * @param Conversation $conversation L'objet Conversation concerné par l'événement.
     * @param string $type Le type d'événement (message, offre, accepte, refuse) pour déterminer le message affiché.
     */
    public function __construct(
        // Utilisation du Property Promotion de PHP 8+ pour définir et assigner les propriétés en une seule fois.
        public Conversation $conversation,
        public string $type // message | offre | accepte | refuse
    ) {}

    /**
     * Obtient les canaux de diffusion de la notification.
     * * Dans ce cas, nous utilisons le canal 'database' pour stocker la notification
     * dans la table 'notifications' de la base de données.
     *
     * @param  mixed  $notifiable L'entité à notifier (généralement un modèle User).
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Prépare le tableau de données à stocker dans la colonne 'data' de la table 'notifications'.
     *
     * @param  mixed  $notifiable L'entité à notifier.
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            // Clé essentielle pour lier la notification à la conversation.
            // Assurez-vous que 'id_conversation' est la clé correcte ou utilisez simplement 'id'.
            'conversation_id' => $this->conversation->id_conversation,
            
            // Informations sur le produit pour le contexte de la notification.
            'produit' => $this->conversation->produit->nom,
            
            // Le type d'événement, utilisé côté Vue/Front-end pour générer le texte (ex: "Nouvelle offre").
            'type' => $this->type,
            
            // Le prix final est inclus si la notification est de type 'accepte'.
            'prix_final' => $this->conversation->prix_final,
        ];
    }
}