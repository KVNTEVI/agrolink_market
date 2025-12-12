<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;  

class RoleSeeder extends Seeder
{

    public function run(): void
    {
        // 1. (Optionnel mais recommandé) Vider la table avant de la remplir
        // Utile lors de l'exécution de 'migrate:fresh' ou pour réinitialiser les données.
        Role::truncate(); 

        // 2. Définition des rôles avec leurs ID pour un mappage facile
        $roles = [
            // ID 1 : Généralement réservé au super utilisateur
            ['id_role' => 1, 'nom_role' => 'Administrateur'],
            
            // ID 2 : Rôle par défaut si l'utilisateur ne choisit rien (ou rôle standard acheteur)
            ['id_role' => 2, 'nom_role' => 'Acheteur'],
            
            // ID 3 : Rôle pour ceux qui vendent
            ['id_role' => 3, 'nom_role' => 'Producteur'],
        ];

        // 3. Insertion des données
        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}