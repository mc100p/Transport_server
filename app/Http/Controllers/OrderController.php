<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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
                'package_delivery_photo' => 'nullable|image',
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
                $user -> delivery_status = $request->delivery_status;
                $user -> order_status = $request -> order_status;
                $user -> delivery_personnel = $request -> delivery_personnel;
                $user -> customer_id = $request -> customer_id;
                $user -> customer_name = $request->customer_name;
                $user -> customer_email = $request-> customer_email;
                $user -> customer_address = $request -> customer_address;
                $user -> customer_parish = $request -> customer_parish;
                $user -> customer_phone_number = $request -> customer_phone_number;
                $user -> package_location = $request -> package_location;
                $user -> package_street_address = $request -> package_street_address;
                $user -> package_parish_address = $request -> package_parish_address;
                $user -> delivery_instructions = $request -> delivery_instructions;
                $user -> fragility = $request -> fragility;
                $user -> item_name  = $request -> item_name;
                $user -> item_payment_status = $request ->item_payment_status;
                $user -> item_height = $request -> item_height;
                $user -> item_width = $request -> item_width;
                $user -> item_weight = $request -> item_weight;
                $user -> item_description  = $request -> item_description;
                $user -> ideal_vehicle = $request -> ideal_vehicle;
                $user -> estimated_delivery_time = $request -> estimated_delivery_time;

                if($request->package_delivery_photo && $request->package_delivery_photo->isValid()){
                    if($request->hasFile('package_delivery_photo') != null){
                        $imagePath = 'deliveryPhotos'.$user->package_delivery_photo;


                    if(File::exists($imagePath)){
                        File::delete($imagePath);
                    }

                    $file_name = $id.$user->customer_name.'.'.$request->package_delivery_photo->extension();
                    $request->package_delivery_photo->move(public_path('deliveryPhotos'), $file_name);
                    $path = "$file_name";
                    $user->package_delivery_photo = $path;
                    } else{
                        $file_name = $user->package_delivery_photo;
                    }
                }
                //$user -> update($request->all());
               $user -> update();
                return response()->json(['status' => 'true', 'message' => 'order updated successfully!', 'data' => $user]);
            }
        } catch(\Exception $e){
            return response()->json(['status' => 'false', 'message' =>$e->getMessage(), 'data'=>[]], 500);
        }
    }

    public function deleteDeliveryPhoto(Request $request, $id){
        try{$user = Order::find($id);
            error_log('deliveryPhotos/'.$id.$user->customer_name.'.jpg');
            if(File::exists(public_path('deliveryPhotos/'.$id.$user->customer_name.'.jpg')))
            File::delete(public_path('deliveryPhotos/'.$id.$user->customer_name.'.jpg'));
            $user->update(['package_delivery_photo' => NULL]);
        } catch (\Exception $e){
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data'=>[]], 500);
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
