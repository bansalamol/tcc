<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {
        return [
            'code' => 'P' . $this->faker->unique()->numerify('####'),
            'name' => $this->faker->name(),
            'phone_number' => $this->faker->numerify('##########'),
            'sex' => 'Male',
            'birth_date' => $this->faker->date(),
            'age' => $this->faker->numberBetween(18,60),
            'address' => $this->faker->address(),
        ];
    }
}
