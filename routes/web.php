<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admindash', [AdminController::class, 'admindash']);

Route::get('/doctors', [AdminController::class, 'getdoctorspg']);

Route::delete('admindash/{id}', [UserController::class, 'Destroy']);

Route::post("/admin/{id}", [UserController::class, 'Block'])->name('admin.block');

Route::get('/doctors', [DoctorController::class, 'indexdoctors']);

Route::get('/add_doctor', [DoctorController::class, 'add_page']);

Route::post('/store_doctor', [DoctorController::class, 'store_doctor']);

Route::get('/edit_doctor/{id}', [DoctorController::class, 'edit_doctor']);

Route::delete('/delete_doctor/{id}', [DoctorController::class, 'delete_doctor']);

Route::put('update_doctor/{id}', [DoctorController::class, 'update_doctor']);

Route::get('/admindash/users', [admincontroller::class, 'getuserspg']);


Route::middleware('auth')->group(function () {


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
