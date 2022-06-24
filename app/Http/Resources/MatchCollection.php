<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MatchCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap=null;
    public function toArray($request)
    {
        return [
            'current_page'=>$this->currentPage(),
            'total_page'=>$this->total(),
            'count'=>$this->count(),
            'last_page'=>$this->lastPage(),
            'data'=>MatchResource::collection($this->collection)
        ];
    }
}
