<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id('id_commande');
            $table->unsignedBigInteger('acheteur_id');
            $table->unsignedBigInteger('producteur_id');
            $table->decimal('montant_total', 12, 2);
            $table->string('statut')->default('en_attente');
            $table->timestamps();

            $table->foreign('acheteur_id')->references('id_utilisateur')->on('utilisateurs')->onDelete('cascade');
            $table->foreign('producteur_id')->references('id_utilisateur')->on('utilisateurs')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
