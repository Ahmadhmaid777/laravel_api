<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchModel extends Model
{
    use HasFactory;
    protected $table='matches';

    public function league(){
        return $this->belongsTo(League::class,'league_id','id');
    }

    public function home_club(){
        return $this->belongsTo(Club::class,'home_team_id','id',);
    }
    public function away_club(){
        return $this->belongsTo(Club::class,'away_team_id','id');
    }
}
