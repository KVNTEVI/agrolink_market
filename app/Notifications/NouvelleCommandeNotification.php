<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Commande;

class NouvelleCommandeNotification extends Notification
{
    use Queueable;

    protected $commande;

    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
    }

    public function via(object $notifiable): array
    {
        // On utilise 'database' pour l'affichage interne et 'mail' si vous le souhaitez
        return ['database']; 
    }

    public function toArray(object $notifiable): array
    {
        return [
            'id_commande' => $this->commande->id_commande,
            'acheteur_nom' => $this->commande->acheteur->nom ?? 'Un client',
            'montant' => $this->commande->montant_total,
            'message' => 'Vous avez reçu une nouvelle commande #' . $this->commande->id_commande,
        ];
    }
}