<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'date'=>$this->date,
            'state'=>$this->state,
            'home_team_score'=>$this->home_team_score,
            'away_team_score'=>$this->away_team_score,
            'league'=>new LeagueResource($this->league),
            'home_team'=>new ClubResource($this->home_club),
            'away_team'=>new ClubResource($this->away_club),
        ];
    }
}
