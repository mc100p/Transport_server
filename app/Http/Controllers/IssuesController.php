<?php

namespace App\Http\Controllers;

use App\Models\Issues;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IssuesController extends Controller
{
    public function index(){
    try{ 
        return Issues::all();
     }
       catch(\Exception $e){
        return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data'=>[]], 500);
       }
    }

    public function store(Request $request){
        try{
            return Issues::create($request->all());
        }
        catch(\Exception $e){
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data'=>[]], 500);
        }
    }

    public function destroy($id){
        try{
            return Issues::destroy($id);
        } catch(\Exception $e){
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data'=>[]], 500);
        }
    }

    public function update(Request $request, $id){
        try{
            $validator  = Validator::make($request->all(), [
                'name' => 'nullable|string',
                'email' => 'nullable|string',
                'phone' => 'nullable|string',
                'issue' => 'required|string',
                'uid' => 'required|integer',

            ]);
            if($validator->fails()){
                $error = $validator->errors()->all()[0];
                return response()->json(['status' => 'false', 'message' => $error, 'data' => []], 422);
            } else{
                $user = Issues::find($id);
                $user->update($request->all());
                //-> issue = $request->issue;
                return response()->json(['status' => 'true','message' => 'issue updated!', 'data' =>$user]);
            }
            // $issue->update();
        } catch(\Exception $e){
            return response()->json(['status'=> 'false', 'message' => $e->getMessage(), 'data'=>[]], 500);
        }
    }
}
