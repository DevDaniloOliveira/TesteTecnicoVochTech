<?php

namespace Database\Factories;

use App\Models\EconomicGroup;
use App\Models\Flag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flag>
 */
class FlagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Flag::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company(),
            'cnpj' => $this->faker->unique()->numerify('##############'), // CNPJ fake
            'economic_group_id' => EconomicGroup::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // States úteis
    public function forEconomicGroup(EconomicGroup $group)
    {
        return $this->state(fn (array $attributes) => [
            'economic_group_id' => $group->id,
        ]);
    }

    public function withName(string $name)
    {
        return $this->state(fn (array $attributes) => [
            'name' => $name,
        ]);
    }
}
