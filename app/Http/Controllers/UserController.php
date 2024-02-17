<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    //

    public function store_user(Request $request)
    {


        $attributes = $request->validate([
            'name' => 'required|unique:users,name',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:4|max:30',
            'location' => 'required'
        ]);

        $attributes['password'] = bcrypt($attributes['password']);


        return User::create($attributes);
        //    dd($request->all());
    }

    public function index_users()
    {
        return User::all();
    }

    public function show($id)
    {

        return DB::table('users')->find($id);
    }

    public function login()
    {
        $keys = request()->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (auth()->attempt($keys)) {
            return 'Login succefully';
        } else {
            throw ValidationException::withMessages([
                'email' => 'Email Address is wrong',
                'password' => 'Password is wrong'
            ]);
        }
    }
}
