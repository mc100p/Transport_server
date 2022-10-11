<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return Order::all();
        }
        catch(\Exception $e){
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data'=>[]], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            return Order::create($request->all());
        } 
        catch(\Exception $e){
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data'=>[]], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            return Order::where('id', 'like', '%'.$id.'%')->get();
        }  catch(\Exception $e){
            return response()->json(['status' => 'false', 'message' =>$e->getMessage(), 'data'=>[]], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $validator = Validator::make($request->all(),[
                'delivery_status' => 'nullable|string',
                'order_status' => 'nullable|string',
                'package_delivery_photo' => 'nullable|string',
                'delivery_personnel' => 'nullable|string',
                'customer_id' => 'required|string',
                'customer_email'=> 'required|string',
                'customer_name' => 'required|string',
                'customer_address' => 'required|string',
                'customer_parish' => 'required|string',
                'customer_phone_number' => 'required|string',
                'package_location' => 'required|string',
                'package_street_address' => 'required|string',
                'package_parish_address' => 'required|string',
                'delivery_instructions' => 'nullable|string',
                'fragility' => 'required|string',
                'item_name' => 'required|string',
                'item_payment_status' => 'required|string',
                'item_height' => 'nullable|numeric|between:0,99.99',
                'item_width' => 'nullable|numeric|between:0,99.99',
                'item_weight' => 'nullable|numeric|between:0,99.99',
                'item_description' =>'nullable|string',
                'ideal_vehicle' => 'nullable|string',
                'estimated_delivery_time' => 'nullable|date',
            ]);
            if($validator->fails()){
                $error = $validator->errors()->all()[0];
                return response()->json(['status'=>'false', 'message' => $error, 'data' => []], 422);
            } else{
                $user = Order::find($id);
                $user -> update($request->all());
                return response()->json(['status' => 'true', 'message' => 'order updated successfully!', 'data' => $user]);
            }
        } catch(\Exception $e){
            return response()->json(['status' => 'false', 'message' =>$e->getMessage(), 'data'=>[]], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            return Order::destroy($id);
        } catch(\Exception $e){
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data'=>[]], 500);        }
    }
}
