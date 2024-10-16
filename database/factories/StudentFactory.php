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
        $contractStartDate = $this->faker->dateTimeBetween('-5 years', '+5 years');
        $contractEndDate = $this->faker->dateTimeBetween($contractStartDate, '+5 years');
        return [
            'name' => $this->faker->firstName . ' ' . $this->faker->lastName, // Random first name
            'private_number' => $this->faker->unique()->numerify('###########'),  // 11-digit unique number
            'grade' => $this->faker->numberBetween(1,12),
            'group' => $this->faker->randomElement(['ა', 'ბ', 'გ', 'დ', 'ე', 'ვ', 'ზ', 'თ', 'ი', 'კ', 'A', 'B', 'C', 'D', 'E','F','G','H','I','J']),  // Random group
            'sector' => $this->faker->randomElement(['ქართული', 'IB', 'ASAS', 'ბაღი']),  // Random sector
            'additional_information' => $this->faker->optional()->sentence,  // Nullable string
            'yearly_payment' => $this->faker->numberBetween(1000,100000),  // Nullable string
            'contract_start_date' => $contractStartDate,
            'contract_end_date' => $contractEndDate,
        ];
    }
}
