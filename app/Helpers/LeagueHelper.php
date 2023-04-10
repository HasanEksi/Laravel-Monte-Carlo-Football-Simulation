<?php

namespace App\Helpers;

use App\Models\Fixture;
use App\Models\League;

class LeagueHelper
{
    /*
     * Generate league table
     *
     * @return array
     *
     */

    public static function generateLeague()
    {
        $fixtures = Fixture::with('homeTeam', 'awayTeam')
            ->where('is_played', 1)
            ->get();

        League::truncate();

        foreach ($fixtures as $fixture) {
            $homeTeam = $fixture->homeTeam;
            $awayTeam = $fixture->awayTeam;

            // Takımların puanlarını hesapla
            if ($fixture->home_team_score > $fixture->away_team_score) {
                $homePoints = 3;
                $awayPoints = 0;
            } elseif ($fixture->home_team_score < $fixture->away_team_score) {
                $homePoints = 0;
                $awayPoints = 3;
            } else {
                $homePoints = 1;
                $awayPoints = 1;
            }

            if ($fixture->home_team_score - $fixture->away_team_score > 0) {
                $homeStatus = 'W';
                $awayStatus = 'L';
            } elseif ($fixture->home_team_score - $fixture->away_team_score < 0) {
                $homeStatus = 'L';
                $awayStatus = 'W';
            } else {
                $homeStatus = 'D';
                $awayStatus = 'D';
            }

            // homeTeam'in verilerini league tablosuna kaydet
            League::create([
                'team_id' => $homeTeam->id,
                'fixture_id' => $fixture->id,
                'week' => $fixture->week,
                'points' => $homePoints,
                'played' => 1,
                'won' => $homePoints == 3 ? 1 : 0,
                'drawn' => $homePoints == 1 ? 1 : 0,
                'lost'  => $homePoints == 0 ? 1 : 0,
                'goals_for' => $fixture->home_team_score,
                'goals_against' => $fixture->away_team_score,
                'goal_difference' => ($fixture->home_team_score - $fixture->away_team_score),
                'position' => 0,
                'status' => $homeStatus,
                'is_played' => 1,
            ]);

            // awayTeam'in verilerini league tablosuna kaydet
            League::create([
                'team_id' => $awayTeam->id,
                'fixture_id' => $fixture->id,
                'week' => $fixture->week,
                'points' => $awayPoints,
                'played' => 1,
                'won' => $awayPoints == 3 ? 1 : 0,
                'drawn' => $awayPoints == 1 ? 1 : 0,
                'lost' => $awayPoints == 0 ? 1 : 0,
                'goals_for' => $fixture->away_team_score,
                'goals_against' => $fixture->home_team_score,
                'goal_difference' => $fixture->away_team_score - $fixture->home_team_score,
                'position' => 0,
                'status' => $awayStatus,
                'is_played' => 1,
            ]);
        }
    }
}
