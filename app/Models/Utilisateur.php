<?php

namespace App\Models;

// NOUVELLES IMPORTATIONS pour l'authentification et les notifications
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Modèle Eloquent pour la table 'utilisateurs'.
 * Il hérite de 'Authenticatable' pour fonctionner avec le système de connexion de Laravel.
 */
class Utilisateur extends Authenticatable //  Hérite de la classe d'authentification
{
    use Notifiable; // Permet d'envoyer des notifications (ex: réinitialisation de mot de passe)

    // Indique à Eloquent d'utiliser la table 'utilisateurs'
    protected $table = 'utilisateurs';
    
    // Définit la clé primaire personnalisée
    protected $primaryKey = 'id_utilisateur';

    // 1. Configuration des champs de la table
    protected $fillable = [
        'nom', 'email', 'password', 'telephone', 'adresse', 'role_id'
    ];

    // Champs qui ne DOIVENT PAS être affichés lorsque le modèle est converti en tableau ou JSON (sécurité)
    protected $hidden = [
        'password',
        'remember_token' // Clé de sécurité utilisée pour la fonction "Se souvenir de moi"
    ];

    // 2. Relations de l'utilisateur (conservées de votre ancien code)

    /**
     * Relation : L'utilisateur appartient à UN Rôle.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Relation (Producteur) : Produits créés par cet utilisateur.
     */
    public function produits()
    {
        return $this->hasMany(Produit::class, 'producteur_id');
    }

    /**
     * Relation (Acheteur) : Commandes passées par cet utilisateur.
     */
    public function commandes()
    {
        return $this->hasMany(Commande::class, 'acheteur_id');
    }

    /**
     * Relation : Conversations où l'utilisateur est l'Acheteur.
     */
    public function conversationsAcheteur()
    {
        return $this->hasMany(Conversation::class, 'acheteur_id');
    }

    /**
     * Relation : Conversations où l'utilisateur est le Producteur.
     */
    public function conversationsProducteur()
    {
        return $this->hasMany(Conversation::class, 'producteur_id');
    }
}