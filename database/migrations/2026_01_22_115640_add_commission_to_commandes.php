<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::table('commandes', function (Blueprint $table) {
        // La commission que VOUS (la plateforme) gagnez
        $table->decimal('commission_montant', 12, 2)->default(0)->after('montant_total');
        
        // Ce qui reste réellement pour le PRODUCTEUR
        $table->decimal('montant_net_producteur', 12, 2)->default(0)->after('commission_montant');
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
        $table->dropColumn(['commission_montant', 'montant_net_producteur']);
        });
    }
};
