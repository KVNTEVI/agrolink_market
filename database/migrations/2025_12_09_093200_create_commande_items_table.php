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
        Schema::create('commande_items', function (Blueprint $table) {
            $table->id('id_item');
            $table->unsignedBigInteger('commande_id');
            $table->unsignedBigInteger('produit_id');
            $table->integer('quantite')->default(1);
            $table->decimal('prix_final', 10, 2);
            $table->timestamps();

            $table->foreign('commande_id')->references('id_commande')->on('commandes')->onDelete('cascade');
            $table->foreign('produit_id')->references('id_produit')->on('produits')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande_items');
    }
};
