<?php

namespace App\Helpers;

use App\Models\Fixture;
use App\Models\Team;

class ProbabilityHelper
{

    /*
     * Calculate the probability of each team winning, drawing and losing
     * this method use the Monte Carlo method to simulate the season
     * and calculate the probability of each team winning, drawing and losing
     * @return array
     *
     */
    public static function calculateTeamsProbabilities()
    {
        $teams = Team::all();
        $fixtures = Fixture::all();

        $simulations = config('simulation.number_of_simulations');

        $winningProbabilities = [];

        $teamPowers = [];

        foreach ($teams as $team) {
            //  Calculate the total strength for each team
            $homeTeamStrength = $team->power_rate + $team->home_advantage;

            // Calculate the goalkeeper strength for each team
            $homeGoalkeeperFactor = SimulationHelper::calculateGoalkeeperFactor($team->goalkeeper_factor);

            // Apply the goalkeeper factor to each team's strength
            $teamPowers[$team->id] = $homeTeamStrength * $homeGoalkeeperFactor;
        }


        foreach ($teams as $team) {
            $teamPoints = 0;

            foreach ($fixtures as $fixture) {
                if ($fixture->home_team_id == $team->id) {
                    $teamPoints += self::calculatePoints($fixture->home_team_score, $fixture->away_team_score);
                } elseif ($fixture->away_team_id == $team->id) {
                    $teamPoints += self::calculatePoints($fixture->away_team_score, $fixture->home_team_score);
                }
            }

            $winningProbabilities[$team->id] = $teamPoints / $simulations * $teamPowers[$team->id];
        }

        $totalProbabilities = array_sum($winningProbabilities);

        foreach ($winningProbabilities as $teamId => $probability) {
            $winningProbabilities[$teamId] = $probability / $totalProbabilities * 100;
        }


        arsort($winningProbabilities);

        foreach ($teams as $team) {
            $team->update([
                'winning_probability' => $winningProbabilities[$team->id]
            ]);
        }


        return $winningProbabilities;
    }

    protected static function calculatePoints($homeTeamScore, $awayTeamScore)
    {
        if ($homeTeamScore > $awayTeamScore) {
            return 3;
        } else if ($homeTeamScore == $awayTeamScore) {
            return 1;
        } else {
            return 0;
        }
    }
}
