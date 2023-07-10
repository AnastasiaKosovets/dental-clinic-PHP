<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //'doctor_id',
        // 'patient',
        // 'treatment',
        // 'date'
        'doctor_id' => 3,
        'patient_id' => 2,
        'treatment_id' => 2,
        'date' => fake()->dateTime($max = 'now', $timezone = null)
        ];
    }
}
