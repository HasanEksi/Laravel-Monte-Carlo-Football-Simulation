<?php

namespace App\Http\Controllers;

use App\Helpers\FixtureHelper;
use App\Models\Fixture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class FixtureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fixtures = \App\Models\Fixture::with('homeTeam', 'awayTeam')->get();

        // group by week
        $fixtures = $fixtures->collect()->groupBy('week');

        return \Inertia\Inertia::render('Fixtures/Index', [
            'fixtures' => $fixtures,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        FixtureHelper::generateFixtures(config('simulation.weeks'));

        return Response::json([
            'success' => true,
            'message' => 'Games generated successfully',
        ]);
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
        //
    }
}
