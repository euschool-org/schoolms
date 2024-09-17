<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'firstname' => $this->faker->firstName,  // Random first name
            'lastname' => $this->faker->lastName,    // Random last name
            'private_number' => $this->faker->unique()->numerify('###########'),  // 11-digit unique number
            'grade' => $this->faker->numberBetween(0, 12),  // Grade between 0 and 12
            'group' => $this->faker->randomElement(['ა', 'ბ', 'გ', 'დ', 'A', 'B', 'C', 'D']),  // Random group
            'sector' => $this->faker->numberBetween(1, 5),  // Random sector
            'pupil_status' => $this->faker->randomElement([-1, 0, 1]),  // Status: -1, 0, or 1
            'additional_information' => $this->faker->optional()->sentence,  // Nullable string
        ];
    }
}
