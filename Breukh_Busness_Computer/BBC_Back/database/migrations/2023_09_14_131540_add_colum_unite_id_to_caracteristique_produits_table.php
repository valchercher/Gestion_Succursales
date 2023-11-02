<?php

use App\Models\Unite;
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
        Schema::table('caracteristique_produits', function (Blueprint $table) {
            $table->foreignIdFor(Unite::class)->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('caracteristique_produits', function (Blueprint $table) {
            //
        });
    }
};
