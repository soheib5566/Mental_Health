<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\task;
use App\Models\User;
use Carbon\Carbon;

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

    public function Getlast7days()
    {
        $startdate = Carbon::now()->subDays(7)->startOfDay();

        $enddate = Carbon::now()->endOfDay();


        $tasks_7 = task::whereBetween('date', [$startdate, $enddate])->get();

        $completed = 0;
        foreach ($tasks_7 as $task) {

            if ($task->completed == 1) {
                $completed += 1;
            }
        }
        $not_completed = count($tasks_7) - $completed;

        return response()->json([
            'Tasks' => count($tasks_7), 'completed' => $completed, 'not_completed' => $not_completed
        ]);
    }


    public function Getlast30days()
    {
        $startdate = Carbon::now()->subDays(30)->startOfDay();

        $enddate = Carbon::now()->endOfDay();


        $tasks_30 = task::whereBetween('date', [$startdate, $enddate])->get();

        $completed = 0;
        foreach ($tasks_30 as $task) {

            if ($task->completed == 1) {
                $completed += 1;
            }
        }
        $not_completed = count($tasks_30) - $completed;

        return response()->json([
            'Tasks' => count($tasks_30), 'completed' => $completed, 'not_completed' => $not_completed
        ]);
    }
}
