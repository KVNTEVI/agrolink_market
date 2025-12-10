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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id('id_conversation');
            $table->unsignedBigInteger('acheteur_id');
            $table->unsignedBigInteger('producteur_id');
            $table->unsignedBigInteger('produit_id');
            $table->string('statut')->default('ouverte'); // ouverte, accord_trouve, cloturee
            $table->decimal('prix_final', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('acheteur_id')->references('id_utilisateur')->on('utilisateurs')->onDelete('cascade');
            $table->foreign('producteur_id')->references('id_utilisateur')->on('utilisateurs')->onDelete('cascade');
            $table->foreign('produit_id')->references('id_produit')->on('produits')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
