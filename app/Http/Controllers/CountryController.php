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
        'key'=>'required|unique:countries'
    ]);

        if ($validator->fails()) {
            $msg = "تاكد من البيانات المدخلة";
            $data = $validator->errors();
            return response()->json(compact('msg', 'data'), 402);
        }
    $country=new Country();
    $country->name=$request->name;
    $country->key=$request->key;
    $country->save();
    return response()->json($country,200);
}

public function update(Request $request,$id){
    $validator=Validator::make($request->all(),[
        'name'=>'required|max:255',
        'key'=>'required|unique:countries,key,'.$id
    ]);

    if ($validator->fails()) {
        $msg = "تاكد من البيانات المدخلة";
        $data = $validator->errors();
        return response()->json(compact('msg', 'data'), 402);
    }
    $country=Country::Find($id);
    $country->name=$request->name;
    $country->key=$request->key;
    $country->save();
    return response()->json($country,200);
}

    public function destroy($id)
    {
        $data = Country::destroy($id);
        if ($data == 0) {
            return response()->json(["message" => "delete Country fail",], 404);

        } else {
            return response()->json(["message" => "Country deleted",], 200);
        }
    }
}
