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
                'firsttime' => 'required|date_format:g:i A',
                'endtime' => 'required|date_format:g:i A',
                'user_id' => 'required|exists:users,id',
            ]
        );

        $task = task::create($attributes);

        return response()->json(["message" => "Task has been Added"]);
    }

    public function completed(Request $request)
    {
        $request->validate(
            [
                'completed' => 'boolean|required',
                'id' => 'required|exists:tasks,id'
            ]
        );

        $task = task::findOrFail($request->id);

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
        $user = User::find($id);
        $tasks = $user->tasks()->select(['id', 'date', 'taskname', 'firsttime', 'endtime'])->get();

        $taskdata = [];
        foreach ($tasks as $task) {
            $taskdata[] =
                [
                    'id' => $task->id,
                    'date' => $task->date,
                    'taskname' => $task->taskname,
                    'firsttime' => date('g:i A', strtotime($task->firsttime)),
                    'endtime' => date('g:i A', strtotime($task->endtime)),
                ];
        }


        return response()->json($taskdata);
    }

    public function Getlast7days($id)
    {
        $startdate = Carbon::now()->subDays(7)->startOfDay();

        $enddate = Carbon::now()->endOfDay();

        $user = User::findOrFail($id);
        $tasks_7 = $user->tasks()->whereBetween('date', [$startdate, $enddate])->get();

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


    public function Getlast30days($id)
    {
        $startdate = Carbon::now()->subDays(30)->startOfDay();

        $enddate = Carbon::now()->endOfDay();

        $user = User::findOrFail($id);
        $tasks_30 = $user->tasks()->whereBetween('date', [$startdate, $enddate])->get();

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


    public function delete($id)
    {
        $task = task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task Deleted Successfully']);
    }
}
