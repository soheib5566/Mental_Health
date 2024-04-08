<?php

namespace App\Http\Controllers;

use App\Models\dailymood;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DailymoodController extends Controller
{
    //

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'value' => 'required|integer',
            'date' => 'required|date|date_format:Y/m/d H:i'

        ]);

        $dictionary = [
            4 => "Very Happy",
            3 => "Happy",
            2 => "Natural",
            1 => "Sad",
            0 => "Very Sad"
        ];

        $mood = new dailymood();

        $mood->mood = $dictionary[$request->value];
        $mood->value = $request->value;
        $mood->datetime = $request->date;
        $mood->save();

        $user = User::find($request->user_id);

        $user->dailymoods()->attach($mood->id, ['created_at' => now(), 'updated_at' => now()]);

        return response()->json(['message' => 'Mood had been added']);
    }


    public function getlast7days($id)
    {
        $startdate = Carbon::now()->subDays(7)->startOfDay();

        $enddate = Carbon::now()->endOfDay();

        $user = User::find($id);
        $moods_7 = $user->dailymoods()->whereBetween('datetime', [$startdate, $enddate])->get();

        $moods = [
            "Very Happy" => 0,
            "Happy" => 0,
            "Natural" => 0,
            "Sad" => 0,
            "Very Sad" => 0
        ];

        foreach ($moods_7 as $mood) {

            $moods[$mood->mood] += 1;
        }




        return response()->json([
            "Very Happy" => $moods['Very Happy'], 'Happy' => $moods['Happy'],
            'Natural' => $moods['Natural'],
            'Sad' => $moods['Sad'],
            'Very Sad' => $moods['Very Sad']
        ]);
    }

    public function getlast30days($id)
    {
        $startdate = Carbon::now()->subDays(30)->startOfDay();

        $enddate = Carbon::now()->endOfDay();

        $user = User::find($id);
        $moods_7 = $user->dailymoods()->whereBetween('datetime', [$startdate, $enddate])->get();

        $moods = [
            "Very Happy" => 0,
            "Happy" => 0,
            "Natural" => 0,
            "Sad" => 0,
            "Very Sad" => 0
        ];

        foreach ($moods_7 as $mood) {

            $moods[$mood->mood] += 1;
        }




        return response()->json([
            "Very Happy" => $moods['Very Happy'], 'Happy' => $moods['Happy'],
            'Natural' => $moods['Natural'],
            'Sad' => $moods['Sad'],
            'Very Sad' => $moods['Very Sad']
        ]);
    }
    public function index_moods($id)
    {
        $user = User::findOrFail($id);
        $moods = $user->dailymoods()->select('id', 'mood', 'value', 'datetime')->get();


        $moodsData = [];
        foreach ($moods as $mood) {
            $moodsData[] = [
                'id' => $mood->id,
                'mood' => $mood->mood,
                'value' => $mood->value,
                'date' => $mood->datetime,
            ];
        }

        return response()->json($moodsData);
    }
}
