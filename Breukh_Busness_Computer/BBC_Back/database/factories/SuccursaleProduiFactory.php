<?php

namespace Database\Factories;

use App\Models\Succursale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SuccursaleProduiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        $prixGlobal = fake()->randomFloat(2, 1, 999999); 
        $prix = fake()->randomFloat(2, $prixGlobal + 0.01, 1000000);  
        return [
            "prix" => $prix,
            "prixGlobal" => $prixGlobal,
        ];
    }
}
