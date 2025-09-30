<?php

namespace Database\Factories;

use App\Models\Flag;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition(): array
    {
        return [
            'fantasy_name' => $this->faker->unique()->company(),
            'social_reason' => $this->faker->companySuffix(),
            'cnpj' => $this->faker->unique()->numerify('##############'), // CNPJ fake
            'flag_id' => Flag::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // States úteis
    public function forFlag(Flag $flag)
    {
        return $this->state(fn (array $attributes) => [
            'flag_id' => $flag->id,
        ]);
    }

    public function withFantasyName(string $name)
    {
        return $this->state(fn (array $attributes) => [
            'fantasy_name' => $name,
        ]);
    }
}
