<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modèle Eloquent pour la table 'produits'
class Produit extends Model
{
    // 1. Configuration de base de la table
    
    // Définit la clé primaire personnalisée de la table
    protected $primaryKey = 'id_produit';
    
    // Colonnes que l'on peut facilement remplir (sécurité)
    protected $fillable = [
        'nom','description','prix_unitaire','stock','image',
        'categorie_id','producteur_id'
    ];

    // 2. Relations du produit (Clés étrangères)

    /**
     * Le produit appartient à UNE catégorie.
     */
    public function categorie()
    {
        // Relation Un-à-Un inverse (belongsTo)
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    /**
     * Le produit appartient à UN producteur (Utilisateur).
     */
    public function producteur()
    {
        // Relation Un-à-Un inverse (belongsTo)
        // Utilise le modèle Utilisateur, lié par la clé 'producteur_id'
        return $this->belongsTo(Utilisateur::class, 'producteur_id');
    }

    // 3. Relations des Interactions (Clés primaires)

    /**
     * Le produit a plusieurs Avis (commentaires/évaluations).
     */
    public function avis()
    {
        // Relation Un-à-Plusieurs (hasMany)
        return $this->hasMany(Avis::class, 'produit_id');
    }

    /**
     * Le produit a plusieurs Conversations associées.
     */
    public function conversations()
    {
        // Relation Un-à-Plusieurs (hasMany)
        return $this->hasMany(Conversation::class, 'produit_id');
    }
}