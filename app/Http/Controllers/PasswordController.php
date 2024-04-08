<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Password;

class PasswordController extends Controller
{
    //
    public function forget_pass(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'The Email is required',
            'email.email' => 'The Field Support Only Email'
        ]);

        try {
            $user = User::where('email', $request->email)->firstOrFail();
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Email Not Exist']);
        }


        return response()->json([], 200);
    }

    public function reset_password(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ], [
            'password.required' => 'Password Field required.',
            'password.confirmed' => 'Password does not match. '
        ]);


        $user = User::where('email', $request->email)->first();

        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(['message' => 'Password Reset Succefully']);
    }
}
