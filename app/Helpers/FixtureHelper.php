<?php

namespace App\Helpers;

use App\Models\Fixture;
use App\Models\Team;

class FixtureHelper
{
    /*
     * Generate games for a league
     * @param $weeks
     *
     * @return array
     */
    public static function generateFixtures($weeks)
    {

        Fixture::truncate();

        self::createFixtures($weeks);
    }

    /*
     * Create games for a league
     * This method randomly matches teams to weeks.
     * @param $teams
     * @param $weeks
     *
     * @return array
     */
    public static function createFixtures($weeks)
    {

        $teams = Team::all();

        $fixtures = [];

        for ($week = 1; $week <= $weeks; $week++) {
            $fixtures[$week] = [];
            $teams = $teams->shuffle();
            $teamsCount = $teams->count();
            $half = $teamsCount / 2;

            for ($i = 0; $i < $half; $i++) {
                $homeTeam = $teams[$i];
                $awayTeam = $teams[$teamsCount - $i - 1];

                $fixtures[$week][] = [
                    'home_team_id' => $homeTeam->id,
                    'away_team_id' => $awayTeam->id,
                    'week' => $week,
                ];
            }
        }

        foreach ($fixtures as $week => $games) {
            foreach ($games as $game) {
                Fixture::create($game);
            }
        }

        return $fixtures;

    }

}
