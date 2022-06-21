<?php

namespace App\Http\Controllers;

use App\Http\Resources\CountryResource;
use App\Models\Country;
use App\Models\League;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{


    public function index(){
        $countries=Country::all();
        return CountryResource::collection($countries)->all();
    }
    public function store(Request $request){
    $validator=Validator::make($request->all(),[
        'name'=>'required|max:255',
        'key'=>'required'
    ]);
    if ($validator->fails()){
        return response()->json(['error'=>$validator->getMessageBag()],400);
    }
    $country=new Country();
    $country->name=$request->name;
    $country->key=$request->key;
    $country->save();
    return response()->json($country,200);
}
}
