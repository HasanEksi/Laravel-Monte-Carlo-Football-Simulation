<?php

namespace App\Http\Controllers;

use App\Helpers\LeagueHelper;
use App\Helpers\ProbabilityHelper;
use App\Helpers\SimulationHelper;
use App\Models\Fixture;
use App\Models\League;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class LeagueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $leagueTable = League::selectRaw('team_id, sum(points) as points, sum(played) as played, sum(won) as won, sum(drawn) as drawn, sum(lost) as lost, sum(goals_for) as goals_for, sum(goals_against) as goals_against, sum(goal_difference) as goal_difference')
            ->with('team')
            ->groupBy('team_id')
            ->get();

        $leagueTable = $leagueTable->sortByDesc('points')->values()->all();


        $teams = Team::orderBy('winning_probability', 'desc')->get();

        return Inertia::render('League/Index', [
            'leagueTable' => $leagueTable,
            'teams' => $teams
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $res = SimulationHelper::playMatch($request->has('next'));

        if ($res['code'] != 200)
        {
            return Response::json($res, $res['code']);
        }

        LeagueHelper::generateLeague();

        if($res['week'] > 2 || !$request->has('next')){
            ProbabilityHelper::calculateTeamsProbabilities();
        }

        return Response::json($res, $res['code']);
    }

    /**
     * Reset the league table.
     */
    public function reset()
    {
        League::truncate();

        Team::query()->update(['winning_probability' => 0]);

        Fixture::query()->update(['is_played' => 0, 'home_team_score' => null, 'away_team_score' => null]);

        return Response::json(['success' => true]);
    }
}
