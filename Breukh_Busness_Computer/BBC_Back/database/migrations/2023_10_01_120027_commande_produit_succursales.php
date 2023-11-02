<?php

use App\Models\ProduitSuccursale;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commande_produit_succursales', function (Blueprint $table) {
            $table->id();
            $table->float('prix');
            $table->integer('quantite');
            $table->integer('reduction')->nullable();
            $table->foreignIdFor(ProduitSuccursale::class)->constrained()->OnDelete('cascade');
            $table->foreignId('commande_id')->constrained('commandes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
