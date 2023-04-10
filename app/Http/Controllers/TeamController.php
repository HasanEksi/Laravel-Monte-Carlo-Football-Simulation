<?php

namespace App\Http\Controllers;

use App\Helpers\FixtureHelper;
use App\Helpers\LeagueHelper;
use App\Models\Fixture;
use App\Models\League;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = \App\Models\Team::orderBy('name')->get();
        return Inertia::render('Teams/Index', [
            'teams' => $teams,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'powerRate' => ['required', 'numeric', 'min:0', 'max:100'],
            'homeAdvantage' => ['required', 'numeric', 'min:0', 'max:100'],
            'goalkeeperFactor' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        if ($validated->fails()) {
            return Response::json([
                'status' => 'error',
                'errors' => $validated->errors(),
            ], 422);
        }

        $team = Team::create([
            'name' => $request->name,
            'power_rate' => $request->powerRate,
            'home_advantage' => $request->homeAdvantage,
            'goalkeeper_factor' => $request->goalkeeperFactor,
        ]);

        FixtureHelper::generateFixtures(config('simulation.weeks'));

        return Response::json([
            'status' => 'success',
            'message' => 'Team created successfully',
            'team' => $team,
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $team = Team::find($id);

        if (!$team) {
            return Response::json([
                'status' => 'error',
                'message' => 'Team not found',
            ], 404);
        }

        if (!$team->delete()) {
            return Response::json([
                'status' => 'error',
                'message' => 'Team could not be deleted',
            ], 500);
        }

        League::truncate();
        Fixture::truncate();
        Team::query()->update(['winning_probability' => 0]);

        return Response::json([
            'status' => 'success',
            'message' => 'Team deleted successfully',
        ], 200);
    }
}
