<?php

namespace App\Http\Controllers;

use App\Notifications\TwoFactor;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Iluminate\Support\Facades\Session;

class TwoFactorController extends Controller
{
    //

    public function Verify_otp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:4',
            'id' => 'required|exists:users,id',
            [
                'otp.required' => 'OTP Fields are required',
                'otp.digits' => 'OTP Code must have 4 Digits'
            ]
        ]);


        $user = User::findOrFail($request->id);
        if ($user->expires_at < now()) {
            return response()->json(['Message' => 'OTP expired']);
        }

        if ($user->code != $request->otp) {
            return response()->json(['Message' => 'Invalid OTP']);
        }


        if ($user->code) {
            $user->reset_code();
        }


        $token = $user->createToken($user->name)->plainTextToken;


        return response()->json(['id' => $user->id, 'Name' => $user->name, 'email' => $user->email, 'token' => $token]);
    }


    public function Resend_otp(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id'
        ]);

        $user = User::findOrFail($request->id);

        if ($user->code) {
            $user->reset_code();
        }

        $user->generete_code();

        $user->notify(new TwoFactor);
        return response(['message' => 'OTP Resent'], 200);
    }
}
