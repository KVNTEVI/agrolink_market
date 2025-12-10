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
        Schema::create('panier_items', function (Blueprint $table) {
            $table->id('id_item');
            $table->unsignedBigInteger('panier_id');
            $table->unsignedBigInteger('produit_id');
            $table->integer('quantite')->default(1);
            $table->decimal('prix_negocie', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('panier_id')->references('id_panier')->on('paniers')->onDelete('cascade');
            $table->foreign('produit_id')->references('id_produit')->on('produits')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panier_items');
    }
};
