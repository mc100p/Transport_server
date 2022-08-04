<?php

namespace App\Http\Controllers;

use App\Models\Issues;
use Illuminate\Http\Request;

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
}
