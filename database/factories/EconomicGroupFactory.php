<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\EconomicGroup;

class EconomicGroupFactory extends Factory
{
    protected $model = EconomicGroup::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company(),      // Nome fictício
            'cnpj' => $this->faker->unique()->numerify('##############'), // CNPJ fake
        ];
    }
}
