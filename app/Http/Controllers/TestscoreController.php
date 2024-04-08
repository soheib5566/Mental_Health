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
            'mentalscores' => 'required|integer',
            'phyicalscores' => 'required|integer',
            'user_id' => 'required|exists:users,id',
        ]);
        $testscore = Testscore::create($attributes);

        return response()->json(["message" => 'Score has been added']);
    }

    public function index($id)
    {
        $testscores = User::find($id)->testscores;
        $testscoresdt = [];
        foreach ($testscores as $testscore) {
            $testscoresdt[] =
                [
                    'totalscores' => $testscore->totalscores,
                    'phyicalscores' => $testscore->phyicalscores,
                    'mentalscores' => $testscore->mentalscores
                ];
        }

        return response()->json($testscoresdt);
    }
}
