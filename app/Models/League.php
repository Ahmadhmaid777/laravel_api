<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'country',
    ];

    public function club(){
        return $this->hasMany(Club::class,'league_id','id');
    }
    public function match(){
        return $this->hasMany(MatchModel::class,'league_id','id');
    }

}
