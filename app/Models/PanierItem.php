<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PanierItem extends Model
{
    protected $table = 'panier_items';
    protected $primaryKey = 'id_item';
    protected $fillable = ['panier_id','produit_id','quantite','prix_negocie'];

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    public function panier()
    {
        return $this->belongsTo(Panier::class, 'panier_id');
    }
}

