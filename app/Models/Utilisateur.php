<?php

namespace App\Models;

// Importe la classe de base Model d'Eloquent pour l'ORM.
use Illuminate\Database\Eloquent\Model;

/**
 * Modèle Eloquent pour la table 'utilisateurs'.
 * Représente un utilisateur, qu'il soit acheteur, producteur ou administrateur.
 */
class Utilisateur extends Model
{
    // 1. Configuration de base de la table
    
    // Définit la clé primaire personnalisée de la table au lieu du défaut 'id'.
    protected $primaryKey = 'id_utilisateur';
    
    // Protection contre l'affectation de masse (Mass Assignment).
    // Ces colonnes peuvent être remplies via la méthode create() ou update().
    protected $fillable = [
        'nom','email','mot_de_passe','telephone','adresse','role_id'
    ];
    // Note : Pour la sécurité, 'mot_de_passe' devrait idéalement être géré séparément ou être masqué.

    // 2. Relations de l'utilisateur

    /**
     * Relation : Un Utilisateur appartient à UN Rôle. (One-to-One)
     */
    public function role()
    {
        // Définit la relation Un-à-Un inverse (belongsTo).
        // L'Utilisateur est lié au modèle Role via la clé étrangère 'role_id'.
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Relation (Spécifique au rôle Producteur) : Un Utilisateur peut avoir plusieurs Produits.
     */
    public function produits()
    {
        // Définit la relation Un-à-Plusieurs (One-to-Many).
        // Cela suppose que la table 'produits' contient une clé étrangère nommée 'producteur_id'.
        return $this->hasMany(Produit::class, 'producteur_id');
    }

    /**
     * Relation (Spécifique au rôle Acheteur) : Un Utilisateur peut passer plusieurs Commandes.
     */
    public function commandes()
    {
        // Définit la relation Un-à-Plusieurs (One-to-Many).
        // Cela suppose que la table 'commandes' contient une clé étrangère nommée 'acheteur_id'.
        return $this->hasMany(Commande::class, 'acheteur_id');
    }

    /**
     * Relation : Utilisateur en tant qu'Acheteur a plusieurs Conversations Initiées.
     */
    public function conversationsAcheteur()
    {
        // Définit la relation Un-à-Plusieurs sur la table 'conversations'.
        // Elle utilise 'acheteur_id' comme clé étrangère.
        return $this->hasMany(Conversation::class, 'acheteur_id');
    }

    /**
     * Relation : Utilisateur en tant que Producteur est impliqué dans plusieurs Conversations.
     */
    public function conversationsProducteur()
    {
        // Définit la relation Un-à-Plusieurs sur la table 'conversations'.
        // Elle utilise 'producteur_id' comme clé étrangère.
        return $this->hasMany(Conversation::class, 'producteur_id');
    }
}