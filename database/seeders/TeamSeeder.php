<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            [
                'name' => 'Manchester United',
                'power_rate' => rand(50, 100),
                'home_advantage' => rand(50, 100),
                'goalkeeper_factor' => rand(50, 100),
            ],
            [
                'name' => 'Manchester City',
                'power_rate' => rand(50, 100),
                'home_advantage' => rand(50, 100),
                'goalkeeper_factor' => rand(50, 100),
            ],
            [
                'name' => 'Liverpool',
                'power_rate' => rand(50, 100),
                'home_advantage' => rand(50, 100),
                'goalkeeper_factor' => rand(50, 100),
            ],
            [
                'name' => 'Chelsea',
                'power_rate' => rand(50, 100),
                'home_advantage' => rand(50, 100),
                'goalkeeper_factor' => rand(50, 100),
            ],
        ];

        foreach ($teams as $team) {
            \App\Models\Team::create($team);
        }

    }
}
