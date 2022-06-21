<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\League;
use App\Models\MatchModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function Symfony\Component\String\u;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\MatchResource;
use App\Http\ResponseTrait;

class MatchController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matches = MatchModel::all();
        return $this->fetchData('success', 200, MatchResource::collection($matches));
    }

    public function filterMatches(Request $request)
    {


        $matches = MatchModel::select('matches.*')
            ->join('leagues', 'leagues.id', '=', 'matches.league_id')
            ->when($request->name, function ($query) use ($request) {
                $query->where('leagues.name', 'Like', '%' . $request->leagueName . '%');
            }
            )->when($request->match_date, function ($query) use ($request) {
                $query->whereDate('date', date('Y-m-d', strtotime($request->match_date)));

            })->when($request->team_id, function ($query) use ($request) {
                $query->where('matches.home_team_id', $request->team_id)->orWhere('matches.away_team_id', $request->team_id);

            })
            ->with('league', 'home_club', 'away_club')
            ->get();
        $matches = $matches->unique('id');
        return $this->fetchData('success', 200, MatchResource::collection($matches));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'league_id' => 'required|numeric',
            'home_team_id' => 'required|numeric',
            'away_team_id' => 'required|numeric',
            'state' => 'required',
            'date' => 'required|date',
            'home_team_score' => 'numeric',
            'away_team_score' => 'numeric'

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $home_team = Club::Find($request->home_team_id);
        $away_team = Club::Find($request->away_team_id);

        if ($home_team->league_id != $request->league_id) {
            return response()->json(['error' => 'home team not exist in the league you choose']);

        } elseif ($away_team->league_id != $request->league_id) {
            return response()->json(['error' => 'away team not exist in the league you choose']);
        }

        $match = new MatchModel();
        $match->league_id = $request->league_id;
        $match->home_team_id = $request->home_team_id;
        $match->away_team_id = $request->away_team_id;
        $match->state = $request->state;
        $match->date = $request->date;
        $match->home_team_score = $request->home_team_score;
        $match->away_team_score = $request->away_team_score;
        $match->save();

        return response()->json($match, 200);


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $match = MatchModel::Find($id);

        $validator = Validator::make($request->all(), [
            'league_id' => 'required|numeric',
            'home_team_id' => 'required|numeric',
            'away_team_id' => 'required|numeric',
            'state' => 'required',
            'date' => 'required|date',
            'home_team_score' => 'numeric',
            'away_team_score' => 'numeric'

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $home_team = Club::Find($request->home_team_id);
        $away_team = Club::Find($request->away_team_id);

        if ($home_team->league_id != $request->league_id) {
            return response()->json(['error' => 'home team not exist in the league you choose']);

        } elseif ($away_team->league_id != $request->league_id) {
            return response()->json(['error' => 'away team not exist in the league you choose']);
        }

        $match->league_id = $request->league_id;
        $match->home_team_id = $request->home_team_id;
        $match->away_team_id = $request->away_team_id;
        $match->state = $request->state;
        $match->date = $request->date;
        $match->home_team_score = $request->home_team_score;
        $match->away_team_score = $request->away_team_score;
        $match->save();

        return response()->json(["message" => "update match success"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = MatchModel::destroy($id);
        if ($data == 0) {
            return response()->json(["message" => "delete match fail",], 404);

        } else {
            return response()->json(["message" => "match deleted",], 200);
        }
    }
}
