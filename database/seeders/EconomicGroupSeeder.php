<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EconomicGroup;

class EconomicGroupSeeder extends Seeder
{
    public function run()
    {
        EconomicGroup::factory()->count(10)->create();
    }
}
