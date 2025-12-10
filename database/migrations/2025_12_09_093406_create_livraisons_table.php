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
        Schema::create('livraisons', function (Blueprint $table) {
            $table->id('id_livraison');
            $table->unsignedBigInteger('commande_id');
            $table->text('adresse_livraison');
            $table->string('statut')->default('en_attente');
            $table->date('date_livraison')->nullable();
            $table->timestamps();

            $table->foreign('commande_id')->references('id_commande')->on('commandes')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livraisons');
    }
};
