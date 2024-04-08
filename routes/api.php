<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TestscoreController;
use App\Http\Controllers\TwoFactorController;
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


//Register route
Route::post('/register', [UserController::class, 'register']);

//OTP Route
Route::post('/verify', [TwoFactorController::class, 'Verify_otp']);

Route::post('/resend_otp', [TwoFactorController::class, 'Resend_otp']);

//Login Router
Route::middleware('api')->post('/login', [UserController::class, 'login']);

//Password Route
Route::post('/forget_password', [PasswordController::class, 'forget_pass']);

Route::post('/reset_password', [PasswordController::class, 'reset_password']);

//middleware group to authincate that user can't join these
//endpoints without the sanctum Authincation(Token)
Route::group(['middleware' => ['auth:sanctum']], function () {

    //Users Routes
    Route::get('/users', [UserController::class, 'index_users']);

    Route::post('/logout', [UserController::class, 'logout']);

    Route::put('/user/update_profile', [UserController::class, 'put_user']);

    Route::get('/users/{user:name}', [UserController::class, 'show']);
    //Doctors Route

    Route::get('/doctors', [DoctorController::class, 'index']);



    //Task Route

    Route::middleware('api')->post('/task', [TaskController::class, 'store']);

    Route::middleware('api')->post('/tskcompleted/{id}', [TaskController::class, 'completed']);

    Route::middleware('api')->get('/tasks/{id}', [TaskController::class, 'index']);

    Route::get('/taskslast7days', [TaskController::class, 'Getlast7days']);

    Route::get('/taskalast30days', [TaskController::class, 'Getlast30days']);

    //Testscore Route

    Route::middleware('api')->post('/testscore', [TestscoreController::class, 'store']);

    Route::middleware('api')->get('/testscores/{id}', [TestscoreController::class, 'index']);
});
