<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Helpers\FixtureHelper;
use App\Helpers\LeagueHelper;
use App\Helpers\SimulationHelper;
use App\Models\Fixture;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            TeamSeeder::class,
            //FixtureSeeder::class,
        ]);

        /*
        SimulationHelper::playMatch();

        LeagueHelper::generateLeague();
        */

    }
}
