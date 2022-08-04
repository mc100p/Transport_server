<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IssuesController;
use App\Http\Controllers\PersonnelRatingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Route::get('/users', function(Request $request){
//     return $request::all();
// });




//Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/issues', [IssuesController::class, 'store']);
    Route::get('/issues', [IssuesController::class, 'index']);
    Route::post('/personnelReviews', [PersonnelRatingsController::class, 'store']);
    Route::get('/personnelReviews', [PersonnelRatingsController::class, 'index']);
    Route::post('/update/personnelReviews/{id}', [PersonnelRatingsController::class,'update']);
    Route::delete('/delete/personnelReviews/{id}', [PersonnelRatingsController::class,'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users', [AuthController::class, 'index']);
    Route::post('/update/user/{id}', [AuthController::class,'update']);
    Route::delete('/deleteProfilePhoto/user/{id}', [AuthController::class,'deleteProfilePhoto']);  
    Route::delete('delete/user/{id}', [AuthController::class,'destroy']);

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
