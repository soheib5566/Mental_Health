<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TestscoreController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DailymoodController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
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

    Route::get('/users/{id}', [UserController::class, 'show']);
    //Doctors Route

    Route::get('/doctors', [DoctorController::class, 'index']);

    //checktokenexpiration

    Route::get('/checktoken', [UserController::class, 'checktoken']);


    //Task Route

    Route::middleware('api')->post('/store_task', [TaskController::class, 'store']);

    Route::middleware('api')->post('/tskcompleted', [TaskController::class, 'completed']);

    Route::middleware('api')->get('/tasks/{id}', [TaskController::class, 'index']);

    Route::get('/taskslast7days/{id}', [TaskController::class, 'Getlast7days']);

    Route::get('/taskalast30days/{id}', [TaskController::class, 'Getlast30days']);

    Route::delete('/deletetask/{id}', [TaskController::class, 'delete']);

    //Testscore Route

    Route::middleware('api')->post('/testscore', [TestscoreController::class, 'store']);

    Route::middleware('api')->get('/testscores/{id}', [TestscoreController::class, 'index']);

    //moods Route

    Route::post('/store_mood', [DailymoodController::class, 'store']);

    Route::get('/moodlast7days/{id}', [DailymoodController::class, 'getlast7days']);

    Route::get('/moodlast30days/{id}', [DailymoodController::class, 'getlast30days']);

    Route::get('/user_moods/{id}', [DailymoodController::class, 'index_moods']);
});

Route::get('/notification', [TaskController::class, 'show'])->name('task.show');

Route::get('/ping', function (Request  $request) {
    $connection = DB::connection('mongodb');
    $msg = 'MongoDB is accessible!';
    try {
        $connection->command(['ping' => 1]);
    } catch (\Exception  $e) {
        $msg = 'MongoDB is not accessible. Error: ' . $e->getMessage();
    }
    return ['msg' => $msg];
});
