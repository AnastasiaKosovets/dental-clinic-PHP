<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Treatment>
 */
class TreatmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //'treatmentName',
        // 'description'
        'treatmentName' => fake()->sentence($nbWords = 6, $variableNbWords = true),
        'description' => fake()->paragraph($nbSentences = 3, $variableNbSentences = true)
    ];
    }
}
