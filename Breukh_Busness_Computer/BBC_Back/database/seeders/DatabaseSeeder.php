<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Unite;
use App\Models\Succursale;
use App\Models\Caracteristique;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
         \App\Models\Unite::factory(10)->create();
         \App\Models\Caracteristique::factory(10)->create();
        \App\Models\Produit::factory(10)->create()->each(function ($produit)  {
            $succursale = Succursale::inRandomOrder()->first();
            $caracteristique = Caracteristique::inRandomOrder()->first();

            $prixGlobal = fake()->randomFloat(2, 1, 999999);
            $quantite = fake()->numberBetween(1, 100);
            $unite = Unite::inRandomOrder()->first();
            $prix = fake()->randomFloat(2, $prixGlobal + 0.01, 1000000);

            // Utilisez la méthode attach() pour créer les relations dans la table de liaison
            $produit->succursales()->attach($succursale->id, [
                "prix" => $prix,
                "prixGlobal" => $prixGlobal,
                "quantiteStock" => $quantite,
            ]);

            $produit->caracteristiques()->attach($caracteristique->id, [
                "description" => fake()->sentence,
                "valeur" => fake()->word,
                "unite_id" => $unite->id,
            ]);
        });

    }
}
