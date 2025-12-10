<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modèle Eloquent pour la table 'categories'
class Categorie extends Model
{
    // Définit la clé primaire personnalisée de la table
    protected $primaryKey = 'id_categorie';
    
    // Colonnes que l'on peut remplir facilement (sécurité)
    protected $fillable = ['nom'];

    /**
     * Relation : Une Catégorie a plusieurs Produits.
     */
    public function produits()
    {
        // Définit la relation Un-à-Plusieurs (One-to-Many).
        // 'categorie_id' est la clé étrangère dans la table 'produits'.
        return $this->hasMany(Produit::class, 'categorie_id');
    }
}