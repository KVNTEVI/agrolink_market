<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewContactMessage extends Notification
{
    use Queueable;

    protected $details;

    /**
     * Le constructeur doit recevoir l'objet du message pour extraire les détails.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * On définit les canaux de diffusion (ici uniquement la base de données).
     */
    public function via($notifiable): array
    {
        return ['database']; 
    }

    /**
     * C'est ce contenu qui sera stocké dans la colonne 'data' de votre table notifications.
     */
    public function toArray($notifiable): array
    {
        return [
            'message' => 'Nouveau message de contact reçu de ' . $this->details['nom'],
            'email' => $this->details['email'],
            'contact_id' => $this->details['id'] ?? $this->details['id_message'] ?? null,
            'type' => 'contact'
        ];
    }
}