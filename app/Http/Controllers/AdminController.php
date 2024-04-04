<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\Doctor;

class AdminController extends Controller
{
    //
    public function showadmin()
    {

        return;
    }

    public function loginadmin(Request $request)
    {
        $request->validate([
            "email" => ["required"],
            "password" => ["required"]
        ]);
        $request = request()->all();
        $admin = Admin::where('username', $request['email'])->first();
        // dd($request['password'] == $user->password);
        if (!$admin) {
            return back()->withErrors(["email" => "invalid email"]);
        }

        if ($request['password'] != $admin->password) {
            return back()->withErrors(["email" => "invalid password"]);
        }
        auth()->login($admin);

        return;
    }

    public function admindash()
    {

        $doctor = Doctor::count();
        $user = User::count();
        $users = User::all();
        return view('index', ['doctors' => $doctor, 'userscount' => $user, 'users' => $users]);
    }
    public function getuserspg()
    {

        return view('index');
    }

    // public function indexdoctors()
    // {
    //     $doctors = Doctor::get();
    //     return view('admindash');
    // }


    // public function getdoctorspg()
    // {
    //     return view('Doctors');
    // }
}
