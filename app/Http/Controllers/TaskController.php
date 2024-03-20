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

        return response()->json("Task has been Added");
    }

    public function completed(Request $request, $id)
    {
        $request->validate(
            [
                'completed' => 'boolean|required'
            ]
        );

        $task = task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        if ($task->completed == 0) {
            $task->update(['completed' => $request['completed']]);

            $task->save();

            return response()->json(['message' => 'Task Has been Completed']);
        }



        return response()->json(['message' => 'Task is Already Completed']);
    }


    public function index($id)
    {
        $user = User::find($id)->tasks;

        return response()->json(['tasks' => $user]);
    }
}
