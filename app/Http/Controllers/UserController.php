<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\TwoFactor;
use Dotenv\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Carbon\Carbon;

class UserController extends Controller
{
    //


    public function register(Request $request)
    {


        $attributes = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:8|max:30',
            'image' => 'nullable|image'
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
        $public_id = 'profile/icon_profile';

        $attributes['image'] = 'profile/icon_profile';

        $user = User::create($attributes);
        $user->generete_code();

        $user->notify(new TwoFactor);

        return response()->json(['id' => $user->id], 200);
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
        $user = User::findOrFail($id);
        $imageUrl = Cloudinary::getUrl($user->image);

        // Check if the image exists on Cloudinary
        $headers = get_headers($imageUrl);
        $exists = strpos($headers[0], '200');

        if ($exists) {


            // Return the image file in the response
            return response(['name' => $user->name, 'phone' => $user->phone, 'gender' => $user->gender, 'DOB' => $user->DOB, 'image' => $imageUrl]);
        } else {
            // Return a response indicating that the file doesn't exist
            return response()->json(['message' => 'Image not found'], 404);
        }
    }

    public function login(Request $request)
    {
        $keys = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);


        $user = User::where('email', $keys['email'])->first();
        if (!$user) {
            return response()->json(['message' => 'Email Not Exist'], 401);
        }


        if ($user->code) {
            return response()->json(['Message' => 'Email is not activated'], 422);
        }

        if (auth()->attempt($keys) && password_verify($request->password, $user->password)) {
            $expiration = now()->addDays(7);
            $token = $user->createToken($user->name, ['*'], $expiration)->plainTextToken;
            return response()->json([
                'id' => $user->id,
                'Name' => $user->name,
                'email' => $user->email,
                'token' => $token,
                'expires_at' => $expiration->toDateString()
            ]);
        } else {
            throw ValidationException::withMessages([
                'email' => 'Email Address is wrong or Password',

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

        if ($user->is_allowed) {
            $user->is_allowed = false;
        } else {
            $user->is_allowed = true;
        }

        $user->save();

        return back();
    }

    public function put_user(Request $request)
    {

        $attributes = $request->validate([
            'id' => 'nullable|exists:users,id',
            'name' => 'nullable|string',
            'phone' => 'nullable|string|unique:users,phone,' . $request->id,
            'gender' => 'nullable|string',
            'DOB' => 'nullable|date|date_format:Y/m/d',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ], [
            'phone.unique' => 'this Phone Number Already used.',
            'phone.min' => 'the phone consist of 11 numbers.',
            'DOB.date' => 'enter a valid Date.',
            'image.image' => 'Supported Extension is image.',
            'image.mimes' => 'The image must be a type of: jpeg, png, jpg, gif.',
            'id.required' => 'ID Not exist.',
        ]);


        $user = User::findOrFail($attributes['id']);
        $user->name = $attributes['name'];
        if (isset($attributes['phone']) && $attributes['phone'] !== $user->phone) {
            $user->phone = $attributes['phone'];
        }
        $user->phone = $attributes['phone'];
        $user->gender = $attributes['gender'];
        $user->DOB = $attributes['DOB'];

        if ($request->hasFile('image')) {
            $oldimage = $user->image;
            $url = Cloudinary::getUrl($oldimage);

            if ($oldimage && $url != null && $oldimage != 'profile/icon_profile') {
                Cloudinary::destroy($oldimage);
            }
            $id_name = str_replace(' ', '_', $user->name);
            $newimage = Cloudinary::uploadApi()->upload($request->file('image')->getRealPath(), [
                'folder' => 'profile',
                'resource_type' => 'auto',
                'public_id' => $id_name,
            ]);

            $user->image = $newimage['public_id'];
        }
        $user->save();

        return response()->json(['message' => 'User Profile Updated', 'name' => $user->name, 'phone' => $user->phone, 'gender' => $user->gender, 'DOB' => $user->DOB, 'image' => Cloudinary::getUrl($user->image)]);
    }

    public function checktoken(Request $request)
    {

        $tokenExpiration = Carbon::parse($request->user()->currentAccessToken()->expires_at);
        if ($tokenExpiration->isPast()) {
            auth()->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Token has expired'], 401);
        } else {
            return response()->json([
                'message' => 'Token Still Active',
                'id' => auth()->user()->id,
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ], 200);
        }
    }
}
