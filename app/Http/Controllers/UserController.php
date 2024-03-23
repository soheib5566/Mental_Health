<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    //


    public function register(Request $request)
    {


        $attributes = $request->validate([
            'name' => 'required|unique:users,name',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:8|max:30',
            'phone' => 'required|max:11'
        ], [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken.',
            'email.required' => 'The email field is required.',
            'email.unique' => 'The email has already been taken.',
            'email.email' => 'The email must be a valid email address.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least :8 Digits .',
            'password.max' => 'The password may not be greater than :30 Digits.',
            'phone.required' => 'The phone field is required.',
            'phone.max' => 'the Phone conisist of 11 numbers'
        ]);

        $attributes['password'] = bcrypt($attributes['password']);

        $user = User::create($attributes);
        $token = $user->createToken($user->name)->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token]);
        //    dd($request->all());
    }

    //function is trrigered when the user hit error with fields
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    public function index_users()
    {
        return User::all();
    }

    public function show($id)
    {

        return DB::table('users')->find($id);
    }

    public function login(Request $request)
    {
        $keys = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (auth()->attempt($keys)) {


            return response()->json(['message' => 'login successfully']);
        } else {
            throw ValidationException::withMessages([
                'email' => 'Email Address is wrong',
                'password' => 'Password is wrong'
            ]);
        }
    }

    public function logout()
    {
        if (auth()->check()) {
            // @ts-ignore
            auth()->user()->tokens()->delete();

            return 'Logout successfully';
        } else {
            return 'user already Logout';
        }
    }
}
