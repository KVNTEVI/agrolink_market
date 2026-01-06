<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageContact extends Model
{
    use HasFactory;

    // Nom de la table (si différent du pluriel automatique)
    protected $table = 'message_contacts';

    // Champs autorisés lors du MessageContact::create()
    protected $fillable = [
        'nom',
        'email',
        'message'
    ];
}