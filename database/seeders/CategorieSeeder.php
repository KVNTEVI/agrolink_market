<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Soja','Café','Cacao','Sésame','Karité','Anacarde','Cajou'];
        foreach ($categories as $cat) {
            \App\Models\Categorie::create(['nom' => $cat]);
        }

    }
}
