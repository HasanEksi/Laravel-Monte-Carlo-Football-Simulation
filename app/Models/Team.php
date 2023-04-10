<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'power_rate',
        'home_advantage',
        'goalkeeper_factor',
        'winning_probability'
    ];

    public function fixtures()
    {
        return $this->hasMany(Fixture::class, 'home_team_id', 'id')
            ->orWhere('away_team_id', $this->id);
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }
}
