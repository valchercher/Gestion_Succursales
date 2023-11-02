<?php

namespace Database\Factories;

use App\Models\Unite;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CaracteristiqueProduiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $unites = Unite::inRandomOrder()->first();
        return [
            "descriprion"=>fake()->sentence,
            "valeur"=>fake()->word,
            "unite_id"=>$unites->id,
        ];
    }
}
