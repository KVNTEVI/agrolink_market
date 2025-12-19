<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécute la migration pour créer la table.
     */
    public function up(): void
    {
        Schema::create('message_contacts', function (Blueprint $table) {
            // Clé primaire auto-incrémentée
            $table->id(); 

            // Nom de l'expéditeur
            $table->string('nom'); 

            // Email pour pouvoir lui répondre
            $table->string('email'); 

            // Le contenu du message (type text pour de longs messages)
            $table->text('message'); 

            // Créé les colonnes created_at et updated_at (essentiel pour le tri)
            $table->timestamps(); 
        });
    }

    /**
     * Annule la migration (supprime la table).
     */
    public function down(): void
    {
        Schema::dropIfExists('message_contacts');
    }
};