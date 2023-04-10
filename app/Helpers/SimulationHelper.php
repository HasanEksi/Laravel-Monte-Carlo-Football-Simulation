<?php

namespace App\Helpers;

use App\Models\Fixture;

class SimulationHelper
{

    /*
     * Play match between two teams
     *
     */

    public static function playMatch($nextWeek = null)
    {
        if ($nextWeek) {

            $week = Fixture::where('is_played', 0)->min('week');

            if (!$week) {
                return [
                    'status' => 'error',
                    'message' => 'There are no more fixtures to play.',
                    'code' => 400,
                    'week' => 0
                ];
            }

            $fixtures = Fixture::where('week', $week)->get();
        } else {
            $fixtures = Fixture::get();
        }

        foreach ($fixtures as $fixture) {
            $homeTeam = $fixture->homeTeam;
            $awayTeam = $fixture->awayTeam;

            //  Calculate the total strength for each team
            $homeTeamStrength = $homeTeam->power_rate + $homeTeam->home_advantage;
            $awayTeamStrength = $awayTeam->power_rate;

            // Calculate the goalkeeper strength for each team
            $homeGoalkeeperFactor = self::calculateGoalkeeperFactor($homeTeam->goalkeeper_factor);
            $awayGoalkeeperFactor = self::calculateGoalkeeperFactor($awayTeam->goalkeeper_factor);

            // Apply the goalkeeper factor to each team's strength
            $homeTeamStrength *= $homeGoalkeeperFactor;
            $awayTeamStrength *= $awayGoalkeeperFactor;

            // Determine the number of goals scored by each team
            $homeTeamScore = self::simulateMatch($homeTeamStrength, $awayTeamStrength);
            $awayTeamScore = self::simulateMatch($awayTeamStrength, $homeTeamStrength);


            $fixture->update([
                'home_team_score' => $homeTeamScore,
                'away_team_score' => $awayTeamScore,
                'is_played' => 1,
            ]);
        }

        return [
            'status' => 'success',
            'message' => 'Match played successfully.',
            'code' => 200,
            'week' => $week ?? null
        ];
    }

    public static function calculateGoalkeeperFactor($goalkeeper_factor)
    {
        // 0-100 scale

        if ($goalkeeper_factor >= 0 && $goalkeeper_factor <= 25) {
            return 0.9;
        } elseif ($goalkeeper_factor > 25 && $goalkeeper_factor <= 50) {
            return 0.95;
        } elseif ($goalkeeper_factor > 50 && $goalkeeper_factor <= 75) {
            return 1.05;
        } elseif ($goalkeeper_factor > 75 && $goalkeeper_factor <= 100) {
            return 1.1;
        }
    }

    public static function simulateMatch($team1Strength, $team2Strength)
    {
        // Calculate the probability of team1 winning
        $team1_probability = $team1Strength / ($team1Strength + $team2Strength);

        // Simulate a random number between 0 and 1
        $random_number = mt_rand(0, 100) / 100;

        // Determine the winner or if it's a draw
        if ($random_number < $team1_probability) {
            return mt_rand(0, 8); // Team1 wins
        } else if ($random_number > $team1_probability) {
            return mt_rand(0, 4); // Team2 wins
        } else {
            return mt_rand(0, 2); // Draw
        }
    }
}
