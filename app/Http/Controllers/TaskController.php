<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\task;
use App\Models\User;

class TaskController extends Controller
{
    //

    public function store(Request $request)
    {
        $attributes = $request->validate(
            [
                'taskname' => 'required',
                'date' => 'required|date',
                'firsttime' => 'required|date_format:H:i',
                'endtime' => 'required|date_format:H:i|after:firsttime',
                'user_id' => 'required|exists:users,id',
            ]
        );

        $task = task::create($attributes);

        return response()->json($task);
    }
}
