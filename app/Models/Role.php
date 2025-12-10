<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modèle Eloquent pour la table 'roles'
class Role extends Model
{
    // Définit la clé primaire personnalisée de la table
    protected $primaryKey = 'id_role';
    
    // Permet l'affectation de masse (Mass Assignment) pour cette colonne
    protected $fillable = ['nom_role'];

    
     // Relation : Un Rôle a plusieurs Utilisateurs.
     
    public function utilisateurs()
    {
        // Définit la relation Un-à-Plusieurs (One-to-Many).
        // 'role_id' est la clé étrangère dans la table 'utilisateurs'.
        return $this->hasMany(Utilisateur::class, 'role_id');
    }
}