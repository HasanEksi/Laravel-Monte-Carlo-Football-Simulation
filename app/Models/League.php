<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'fixture_id',
        'week',
        'points',
        'played',
        'won',
        'drawn',
        'lost',
        'goals_for',
        'goals_against',
        'goal_difference',
        'position',
        'status',
        'is_played',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function fixture()
    {
        return $this->belongsTo(Fixture::class);
    }

}
