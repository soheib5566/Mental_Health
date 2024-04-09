<?php

use App\Http\Controllers\admincontroller;
use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/admindash', [admincontroller::class, 'admindash']);

Route::get('/doctors', [admincontroller::class, 'getdoctorspg']);

Route::delete('admindash/{id}', [UserController::class, 'Destroy']);

Route::post("/admin/{id}", [UserController::class, 'Block'])->name('admin.block');

Route::get('/doctors', [DoctorController::class, 'indexdoctors']);

Route::get('/add_doctor', [DoctorController::class, 'add_page']);

Route::get('/info', function () {
    phpinfo();
});

// Route::get('/admindash/users', [admincontroller::class, 'indexusers']);
// Route::get('/users', [UserController::class, 'store_user']);

// Route::get('/logoutuser', [UserController::class, 'logout']);
