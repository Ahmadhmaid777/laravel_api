<?php

namespace App\Http\Controllers;

use App\Http\Resources\LeagueResource;
use App\Http\ResponseTrait;
use App\Models\Country;
use App\Models\League;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeagueController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {


        $leagues = League::all();
        return $this->fetchData('success', 200, LeagueResource::collection($leagues->unique('id')));
    }

    public function filterLeagues(Request $request){
        $leagues = League::select('leagues.*')
            ->join('countries','leagues.country_key','=','countries.key')
            ->when($request->country_name, function ($query) use ($request) {
                $query->where('countries.name', 'Like', '%' . $request->country_name . '%');
            })->when($request->name, function ($query) use ($request) {
                $query->where('leagues.name', 'Like', '%' . $request->name.'%');
            }) ->when($request->country_key, function ($query) use ($request) {
                $query->where('countries.key', 'Like', '%' . $request->country_key . '%');
            })
            ->get();
        return $this->fetchData('success', 200, LeagueResource::collection($leagues->unique('id')));

    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'country_key' => 'required|max:4'
        ],);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()], 400);
        }
        $league = new League();
        $league->name = $request->name;
        $league->country_key = $request->country_key;
        $league->save();
        return response()->json($league, 200);
    }
}
