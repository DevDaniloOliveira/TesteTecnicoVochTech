<?php

namespace Database\Factories;

use App\Models\Unit;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'cpf' => $this->faker->unique()->numerify('###########'), // CPF fake
            'unit_id' => Unit::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // States úteis
    public function forUnit(Unit $unit)
    {
        return $this->state(fn (array $attributes) => [
            'unit_id' => $unit->id,
        ]);
    }

    public function withName(string $name)
    {
        return $this->state(fn (array $attributes) => [
            'name' => $name,
        ]);
    }
}
