<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Users Routes

Route::middleware('api')->post('/user', [UserController::class, 'store_user']);

Route::middleware('api')->get('/users', [UserController::class, 'index_users']);

Route::middleware('api')->get('/users/{user:name}', [UserController::class, 'show']);


Route::middleware('api')->post('/authuser', [UserController::class, 'login']);

Route::get('/logoutuser', [UserController::class, 'logout']);

//Doctors Route

Route::middleware('api')->get('/doctors', [DoctorController::class, 'index']);
