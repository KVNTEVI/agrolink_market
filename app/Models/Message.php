<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $primaryKey = 'id_message';
    protected $fillable = ['conversation_id','expediteur_id','contenu','prix_propose'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class,'conversation_id');
    }

    public function expediteur()
    {
        return $this->belongsTo(Utilisateur::class,'expediteur_id');
    }
}

