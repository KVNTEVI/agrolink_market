<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $primaryKey = 'id_conversation';
    protected $fillable = [
        'acheteur_id','producteur_id','produit_id','statut','prix_final'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class,'conversation_id');
    }

    public function acheteur()
    {
        return $this->belongsTo(Utilisateur::class,'acheteur_id');
    }

    public function producteur()
    {
        return $this->belongsTo(Utilisateur::class,'producteur_id');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }
}

