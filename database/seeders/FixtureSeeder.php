<?php

namespace Database\Seeders;

use App\Helpers\FixtureHelper;
use App\Models\Fixture;
use Illuminate\Database\Seeder;

class FixtureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FixtureHelper::generateFixtures(config('simulation.weeks'));
    }
}
