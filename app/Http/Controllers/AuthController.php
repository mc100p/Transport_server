<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function index(){
        try{
            return User::all();
        } catch(\Exception $e){
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data'=>[]], 500);
        }
    }
    public function register(Request $request){
    try{      
          $fields = $request -> validate([
            'name'=>'required|string',
            'email'=>'required|string|unique:users,email',
            'address'=>'nullable|string',
            'phone'=>'nullable|string',
            'password'=>'required|string',
            'role'=>'required|string',
            'company'=>'nullable|string', 
            'socialType'=>'required|string',
            'profile_photo'=>'nullable|image',
        ]);
        $user = User::create([
            'name'=> $fields['name'],
            'email' => $fields['email'],
            'address' => $fields['address'],
            'phone' => $fields['phone'],
            'password' => bcrypt($fields['password']),
            'role' => $fields['role'],
            'company'=>$fields['company'],
            'socialType'=>$fields['socialType'],
            'profile_photo' => $fields['profile_photo'],
        ]);

        $token = $user-> createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];
        return response($response, 200);}
        catch(\Exception $e){
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data'=>[]], 500);
        }
    }


    public function login(Request $request){

    try{      
      $fields = $request -> validate([
            'email'=> 'required|string',
            'password'=> 'required|string',  
        ]);

        $user = User::where('email', $fields['email'])-> first();

        if(!$user){
            return response([
                'message'=> 'There is no user record corresponding to this identifier. The record may have been deleted.'
            ], 401);
        }

        if(!Hash::check($fields['password'], $user->password)){
            return response([
                'message' => 'The password is incorrect.'
            ], 401);
        }

        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'message' => 'User records do not exist or may have been deleted.'
            ], 401);
        }

        $token = $user-> createToken('myapptoken')->plainTextToken;

        $response = [
            'user'=>$user,
            'token'=>$token,
        ]; 
        return response($response, 200);
    } 
        catch(\Exception $e){
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data'=>[]], 500);
        }
    }


    public function update(Request $request, $id){
        try{
            $validator = Validator::make($request->all(),[
                'name' => 'required|string',
                'email' => 'required|string|unique:users, email'.$request->user()->id,
                'address'=>'nullable|string',
                'phone'=>'nullable|string',
                'company'=>'nullable|string', 
                'profile_photo'=>'nullable|image:jpeg,jpg,png',
            ]);
            if($validator->fails()){
                $error = $validator->errors()->all()[0];
                return response()->json(['status' => 'false', 'message' => $error, 'data' => []], 422);
            } else{
                $user = User::find($request->user()->id);
                $user -> name = $request->name;
                $user -> email = $request->email;
                $user -> address =$request->address;
                $user -> phone = $request->phone;
                $user -> company = $request->company;

                if($request->profile_photo && $request->profile_photo->isValid()){

                    if($request->hasFile('profile_photo') != null){

                        $imagePath = 'images'.$user->profile_photo;
                    
                        if(File::exists($imagePath)){
                            File::delete($imagePath);
                        }

                        $file_name = $id.'.'.$request->profile_photo->extension();
                            $request->profile_photo->move(public_path('images'),$file_name);
                            $path = "$file_name";
                            $user->profile_photo = $path;
                    } else{
                        $file_name = $user->profile_photo;
                    }  
                }
                $user->update();
                return response()->json(['status' => 'true', 'message' => "Profile Updated!", 'data'=> $user]);
            }
        } catch(\Exception $e){
            return response()->json(['status' => 'false', 'message' =>$e->getMessage(), 'data'=>[]],500);

        }
    } 

    public function deleteProfilePhoto(Request $request, $id){
        try{
             $user = User::find($id);
            if(File::exists(public_path('images/'.$id.'.jpg')))
                File::delete(public_path('images/'.$id.'.jpg'));
            $user->update(['profile_photo' => NULL]);
            return response()->json(['status' => 'true', 'message' => "Profile photo removed!", 'data'=> $user]);
        } catch (\Exception $e){
            return response()->json(['status' => 'false', 'message' =>$e->getMessage(), 'data'=>[]],500);
        }
    }

    public function destroy($id){
        try{
            return User::destroy($id);
        } catch(\Exception $e){
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data'=>[]], 500);
        }
    }

    public function logout(Request $request){
        try{
            auth()->user()->tokens()->delete();
            return [
                'message' => 'User logged out'
            ];
        } catch(\Exception $e){
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data'=>[]], 500);
        }
    }
}
