<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;

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
    }

    public function indexusers()
    {
        $users = User::all();
        return view("adminDashBoard", ['users' => $users]);
    }

    public function indexdoctors()
    {
    }
}
