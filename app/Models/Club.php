<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function league(){
        $this->belongsTo(League::class,'league_id','id');
    }
    public function match(){
        $this->hasMany(MatchModel::class,[
            'home_team_id',
            'away_team_id'
        ],'id');
    }


}
