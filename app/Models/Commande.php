<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $primaryKey = 'id_commande';
    protected $fillable = [
        'acheteur_id','producteur_id','montant_total','statut'
    ];

    public function acheteur()
    {
        return $this->belongsTo(Utilisateur::class,'acheteur_id');
    }

    public function producteur()
    {
        return $this->belongsTo(Utilisateur::class,'producteur_id');
    }

    public function items()
    {
        return $this->hasMany(CommandeItem::class, 'commande_id');
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class, 'commande_id');
    }

    public function livraison()
    {
        return $this->hasOne(Livraison::class, 'commande_id');
    }
}

