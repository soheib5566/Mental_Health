<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\TwoFactor;
use Dotenv\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session as FacadesSession;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    //


    public function register(Request $request)
    {


        $attributes = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:8|max:30',
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.unique' => 'The email has already been taken.',
            'email.email' => 'The email must be a valid email address.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least :8 Digits .',
            'password.max' => 'The password may not be greater than :30 Digits.',
        ]);

        $attributes['password'] = bcrypt($attributes['password']);


        $user = User::create($attributes);
        $user->generete_code();

        $user->notify(new TwoFactor);

        return response()->json([], 200);
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
        $user = User::where('email', $keys['email'])->first();


        if (auth()->attempt($keys)) {
            $token = $user->createToken($user->name)->plainTextToken;
            return response()->json(['message' => 'login successfully', 'token' => $token]);
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

            return response()->json(['message' => 'Logout successfully']);
        }
    }


    public function Destroy($id)
    {
        User::destroy($id);

        return redirect('/admindash');
    }

    public function Block($id)
    {
        $user = User::findOrFail($id);

        if ($user['is_allowed']) {
            $user['is_allowed'] = 0;
            $user->save();
        }



        return redirect('/admindash');
    }
}
