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
        Schema::create('messages', function (Blueprint $table) {
            $table->id('id_message');
            $table->unsignedBigInteger('conversation_id');
            $table->unsignedBigInteger('expediteur_id');
            $table->text('contenu')->nullable();
            $table->decimal('prix_propose', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('conversation_id')->references('id_conversation')->on('conversations')->onDelete('cascade');
            $table->foreign('expediteur_id')->references('id_utilisateur')->on('utilisateurs')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
