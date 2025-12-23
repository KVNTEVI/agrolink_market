<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProduitSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('produits')->insert([
            [
                'nom' => 'Soja Graines',
                'description' => 'Soja bio de haute qualité, idéal pour la transformation en huile ou lait.',
                'prix_unitaire' => 1000.00, // Prix au kg par exemple
                'stock' => 5000,
                'image' => 'soja.jpg',
                'statut' => 'valide',
                'categorie_id' => 1,
                'producteur_id' => 2,
                'created_at' => now(),
            ],
            [
                'nom' => 'Noix d\'Anacarde',
                'description' => 'Noix de cajou brutes prêtes pour la transformation ou l\'exportation.',
                'prix_unitaire' => 425.00,
                'stock' => 2500,
                'image' => 'anacarde.jpg',
                'statut' => 'valide',
                'categorie_id' => 2,
                'producteur_id' => 2,
                'created_at' => now(),
            ],
            [
                'nom' => 'Café Robusta (Togo)',
                'description' => 'Café Robusta pur, cultivé dans la région des Plateaux. Arôme puissant et corsé.',
                'prix_unitaire' => 1735.00, // Prix au kg
                'stock' => 1500,
                'image' => 'cafe.jpg',
                'statut' => 'valide',
                'categorie_id' => 2,
                'producteur_id' => 4,
                'created_at' => now(),
            ],
        ]);
    }
}