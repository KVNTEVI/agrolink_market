<?php

namespace App\Notifications;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class CommandePayeeNotification extends Notification
{
    use Queueable;

    protected $commande;

    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'commande_id' => $this->commande->id_commande,
            'montant' => $this->commande->montant_total,
            'message' => 'Une commande a été payée par un acheteur.'
        ];
    }
}
