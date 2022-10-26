<?php
use App\Http\Controllers\OrderController;
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


//Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/issues', [IssuesController::class, 'store']);
    Route::get('/issues', [IssuesController::class, 'index']);
    Route::post('/update/issues/{id}', [IssuesController::class, 'update']);
    Route::delete('delete/issues/user/{id}', [IssuesController::class, 'destroy']);
    Route::post('/personnelReviews', [PersonnelRatingsController::class, 'store']);
    Route::get('/personnelReviews', [PersonnelRatingsController::class, 'index']);
    Route::post('/update/personnelReviews/{id}', [PersonnelRatingsController::class,'update']);
    Route::delete('/delete/personnelReviews/{id}', [PersonnelRatingsController::class,'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users', [AuthController::class, 'index']);
    Route::post('/update/user/{id}', [AuthController::class,'update']);
    Route::delete('/deleteProfilePhoto/user/{id}', [AuthController::class,'deleteProfilePhoto']);  
    Route::delete('delete/user/{id}', [AuthController::class,'destroy']);
    Route::post('/order', [OrderController::class, 'store']);
    Route::get('/order/search/{id}', [OrderController::class, 'show']);
    Route::get('/order', [OrderController::class, 'index']);
    Route::delete('delete/order/user/{id}', [OrderController::class, 'destroy']);
    Route::post('update/order/user/{id}', [OrderController::class, 'update']);
    Route::delete('/deleteDeliveryPhoto/user/{id}', [OrderController::class,'deleteDeliveryPhoto']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
