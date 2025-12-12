<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Utilisateur; // Importe votre modèle Utilisateur
use Illuminate\Support\Facades\Hash; // Nécessaire pour hacher les mots de passe

class UtilisateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Crée des utilisateurs de base pour le développement.
     */
    public function run(): void
    {
        // (Optionnel mais recommandé) Vider la table avant de la remplir
        Utilisateur::truncate(); 

        // Création de l'Administrateur (ID Rôle 1)
        Utilisateur::create([
            'nom' => 'TEVI Adjé Josué',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Adje1320'),
            'telephone' => '97909802',
            'adresse' => 'Bureau Principal, ADN Golfe 1',
            'role_id' => 1, // ID du Rôle Administrateur
        ]);

        // Création d'un Producteur (ID Rôle 3)
        Utilisateur::create([
            'nom' => 'TOSSOU Herman Producteur',
            'email' => 'prod@gmail.com',
            'password' => Hash::make('Toss1234'), 
            'telephone' => '90000000',
            'adresse' => 'Ferme Prod, Région plateux',
            'role_id' => 3, // ID du Rôle Producteur
        ]);

        // Création d'un Acheteur (ID Rôle 2)
        Utilisateur::create([
            'nom' => 'DZIWONU Abla Acheteur',
            'email' => 'acheteur@gmail.com',
            'password' => Hash::make('Abla1234'),
            'telephone' => '91111111',
            'adresse' => 'Lomé',
            'role_id' => 2, // ID du Rôle Acheteur
        ]);
        
    }
}