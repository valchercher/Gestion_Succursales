<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produit>
 */
class ProduitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
      
        return [
            "libelle"=>$this->faker->unique()->word,
            "description"=>fake()->sentence,
            'photo' => fake()->imageUrl(200, 200,'../storage/app/public/image', true), 
            'code' => fake()->unique()->numberBetween(1000, 9999), 
        ];

    }
}
