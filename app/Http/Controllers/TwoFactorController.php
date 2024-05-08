<?php

namespace App\Http\Controllers;

use App\Notifications\TwoFactor;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Iluminate\Support\Facades\Session;
use Carbon\Carbon;

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
                'otp.digits' => 'OTP Code must have 4 Digits',
                'id.exists' => 'The selected id is invalid.'
            ]
        ]);


        $user = User::findOrFail($request->id);

        $expiresDate = Carbon::parse($user->expires_at);


        $minutesDifference = now()->diffInMinutes($expiresDate);

        if (!$user->code) {
            return response()->json(['Message' => 'Email is Already activited'], 200);
        }

        if ($minutesDifference > 5) {
            return response()->json(['Message' => 'OTP expired'], 422);
        }

        if ($user->code != $request->otp) {
            return response()->json(['Message' => 'Invalid OTP'], 404);
        }


        if ($user->code) {
            $user->reset_code();
        }


        $expiration = now()->addDays(7);
        $token = $user->createToken($user->name, ['*'], $expiration)->plainTextToken;



        return response()->json([
            'id' => $user->id,
            'Name' => $user->name,
            'email' => $user->email,
            'token' => $token,
            'expires_at' => $expiration->toDateString()
        ]);
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
