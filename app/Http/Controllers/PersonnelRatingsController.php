<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\PersonnelRatings;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class PersonnelRatingsController extends Controller
{
    public function index(){
        try{
             return PersonnelRatings::all();
        } catch(\Exception $e){
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data'=>[]], 500);
        }
    }

    public function store(Request $request){
        try{
            return  PersonnelRatings::create($request->all());
        } catch(\Exception $e){
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data'=>[]], 500);
        }
    }

    public function destroy($id){
        try{
            return PersonnelRatings::destroy($id);
        } catch(\Exception $e){
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data'=>[]], 500);
        }
    }

    public function update(Request $request, $id){
        try{
            $validator = Validator::make($request->all(), [
                'clientName' => 'required|string',
                'comment' => 'required|string',
                'deliveryPersonnel' => 'required|string',
                'dpid' => 'required|integer',
                'uid' => 'required|integer',
                'ratings' => 'required|integer',
            ]);

            if($validator->fails()){
                $error = $validator->errors()->all()[0];
                return response()->json(['status' => 'false', 'message' => $error, 'data'=> []], 422);

            } else{
                $user = PersonnelRatings::find($id);
                $user ->update($request->all());
                return response()->json(['status' => 'true', 'message' => "Profile Updated!", 'data'=> $user]);
            }
        } catch(\Exception $e){
            return response()->json(['status' => 'false', 'message'=>$e->getMessage(), 'data'=>[]], 500);
        }
    }
}
