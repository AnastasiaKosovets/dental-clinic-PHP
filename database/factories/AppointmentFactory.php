<?php

namespace Database\Factories;

use App\Models\User;
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
        // $userRoles = [2,3];
        $patientId = User::where('role_id', 2)->inRandomOrder()->first()->id;
        $doctorId = User::where('role_id', 3)->inRandomOrder()->first()->id;

        return [
        'doctor_id' => $doctorId,
        'patient_id' => $patientId,
        // 'role' => fake()->randomElement($userRoles),
        'treatment_id' => fake()->randomElement([1, 2, 3, 4, 5, 6, 7]),
        // 'role_id' => fake()->randomElement(range(1, 50)),
        'date' => fake()->dateTime($max = 'now', $timezone = null)
        ];
    }
}
