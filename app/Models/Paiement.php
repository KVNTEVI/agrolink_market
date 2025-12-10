<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $primaryKey = 'id_paiement';
    protected $fillable = ['commande_id','montant','mode','statut'];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }
}

