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
        Schema::create('paniers', function (Blueprint $table) {
            $table->id('id_panier');
            $table->unsignedBigInteger('utilisateur_id');
            $table->timestamps();

            $table->foreign('utilisateur_id')->references('id_utilisateur')->on('utilisateurs')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paniers');
    }
};
