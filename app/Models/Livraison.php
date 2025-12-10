<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livraison extends Model
{
    protected $primaryKey = 'id_livraison';
    protected $fillable = [
        'commande_id','adresse_livraison','statut','date_livraison'
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class,'commande_id');
    }
}

