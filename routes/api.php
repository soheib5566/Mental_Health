<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TestscoreController;
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


// register route
Route::post('/register', [UserController::class, 'register']);

//logout Router
Route::middleware('api')->post('/authuser', [UserController::class, 'login']);

//middleware group to authincate that user can't join these
//endpoints without the sanctum Authincation
Route::group(['middleware' => ['auth:sanctum']], function () {

    //Users Routes
    Route::get('/users', [UserController::class, 'index_users']);

    Route::get('/users/{user:name}', [UserController::class, 'show']);

    Route::post('/logout', [UserController::class, 'logout']);

    //Doctors Route

    Route::middleware('api')->get('/doctors', [DoctorController::class, 'index']);


    //Task Route

    Route::middleware('api')->post('/task', [TaskController::class, 'store']);

    Route::middleware('api')->post('/tskcompleted/{id}', [TaskController::class, 'completed']);

    Route::middleware('api')->get('/tasks/{id}', [TaskController::class, 'index']);

    //Testscore Route

    Route::middleware('api')->post('/testscore', [TestscoreController::class, 'store']);

    Route::middleware('api')->get('/testscores/{id}', [TestscoreController::class, 'index']);
});
