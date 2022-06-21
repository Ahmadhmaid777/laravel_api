<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClubResource;
use App\Http\ResponseTrait;
use App\Models\Club;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;

class ClubController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clubs=Club::all();

        return $this->fetchData("success",200,ClubResource::collection($clubs));
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
        $validator = Validator::make(request()->all(), [
            'name' => 'required|max:255|unique:clubs',
            'founding_date'=>'required|date',
            'logo' => 'mimes:jpeg,png,jpg,gif',
            'league_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $club = new Club();

        if($request->hasFile('logo')){
            $file =$request->file('logo');
            $logo_name=time().'.'.$file->getClientOriginalExtension();
            $path='images'.'/'.$logo_name;
            $file->move(public_path('images',$logo_name));
            $club->logo=$path;
        }

        $club->name = $request->name;
        $club->founding_date =$request->founding_date;
        $club->category = $request->category;
        $club->league_id = $request->league_id;
        $club->save();

        return response()->json($club);
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

        $club = Club::Find($id);
        $validator = Validator::make(request()->all(), [
            'name' => 'required|max:255|unique:clubs,name,'.$id,
            'founding_date'=>'required|date',
            'logo' => 'mimes:jpeg,png,jpg,gif',
            'league_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }


        if($request->hasFile('logo')){
            $file =$request->file('logo');
            $logo_name=time().'.'.$file->getClientOriginalExtension();
            $path='images'.'/'.$logo_name;
            $file->move(public_path('images',$logo_name));
            $club->logo=$path;
        }

        $club->name = $request->name;
        $club->founding_date =$request->founding_date;
        $club->category = $request->category;
        $club->league_id = $request->league_id;
        $club->update();

        return response()->json(['message'=>"تم التعديل بنجاح"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $data=Club::destroy($id);
        if ($data==0){
            return response()->json(["message"=>"delete club fail",],404);

        }else{
            return response()->json(["message"=>"club deleted",],200);
        }
    }
}
