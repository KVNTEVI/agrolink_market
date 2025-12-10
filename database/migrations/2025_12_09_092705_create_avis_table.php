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
        Schema::create('avis', function (Blueprint $table) {
            $table->id('id_avis');
            $table->unsignedBigInteger('utilisateur_id');
            $table->unsignedBigInteger('produit_id');
            $table->tinyInteger('note');
            $table->text('commentaire')->nullable();
            $table->timestamps();

            $table->foreign('utilisateur_id')->references('id_utilisateur')->on('utilisateurs')->onDelete('cascade');
            $table->foreign('produit_id')->references('id_produit')->on('produits')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};
