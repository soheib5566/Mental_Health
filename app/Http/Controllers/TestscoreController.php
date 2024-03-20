<?php

namespace App\Http\Controllers;

use App\Models\Testscore;
use App\Models\User;
use Illuminate\Http\Request;

class TestscoreController extends Controller
{
    //

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'totalscores' => 'required|integer',
            'user_id' => 'required|exists:users,id'
        ]);
        $testscore = Testscore::create($attributes);

        return response()->json($testscore);
    }

    public function index($id)
    {
        $testscore = User::find($id)->testscores;

        return response()->json(['testscore' => $testscore]);
    }
}
