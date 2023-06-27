<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class TaskController extends Controller
{
    // Admin Login
    public function Task(){
        $data = DB::table('task')->get();
        $user = DB::table('users')->get();
        $project = DB::table('project')->get();
        $profile = DB::table('users')
        ->where('users.user_id', '=', session('user_id'))
        ->get();
        return view('Admins.Task.Task',["data" => $data, "user"=>$user, "project" => $project, "profile" => $profile]);
    }

    public function TaskShow(){
        $data = DB::table('task')
        ->leftJoin('project', function ($join) {
            $join->on('task.project_id', '=', 'project.project_id');
        })
        ->leftJoin('users', function ($join) {
            $join->on('task.user_id', '=', 'users.user_id');
        })
            ->select('task.*', 'users.*', 'project.*')
            ->get();
        return response()->json($data);
    }

    public function TaskStore(Request $req){
        $task_id = $req->input('task_id');
        $data = $req->input();
        unset($data['_token']);

        $Validator = Validator::make($req->all(), [
            'user_id' => 'required',
            'project_id' => 'required',
            'task_from_date' => 'required',
            'task_to_date' => 'required',
            'task_status' => 'required',
            'task_description' => 'required'
        ]);

        if ($Validator->fails()) {
            return response()->json(["validate" => true, "message" => $Validator->errors()->all()[0]]);
        }

        try {
            $Task = DB::table('task')->updateOrInsert(
                ['task_id' => $req->input('task_id')],
               $data
            );

            return response()->json(["success" => true, "message" => !$req->input('task_id') ? "Task Detail Create Successfully" : "Category Detail Updated Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err" => $th->getMessage()]);
        }

    }

    public function TaskEdit(Request $req){
        return response()->json(["data" => DB::table('task')->where('task_id', $req->input('task_id'))->get()]);
    }

    public function TaskDelete(Request $req){
        if (DB::table('task')->where('task_id', $req->input('task_id'))->delete()) {
            return response()->json(["success"=>true, "message"=>"Task Delete!"]);
        }else{
            return response()->json(["success"=>false, "message"=>"Oops Something Went wrong"]);
        }
    }

    // Employee Login
    public function EmployeeTask(){
        $data = DB::table('task')->where('user_id',session('user_id'))->first();
        $user = DB::table('users')->get();
        $project = DB::table('project')->get();
        $profile = DB::table('users')
        ->where('users.user_id', '=', session('user_id'))
        ->get();

        return view('Employee.Task.Task',["data" => $data, "user"=>$user, "project" => $project, "profile" => $profile]);
   }

    public function EmployeeTaskShow(){
        $data = DB::table('task')
        ->leftJoin('project', function ($join) {
            $join->on('task.project_id', '=', 'project.project_id');
        })
        ->leftJoin('users', function ($join) {
            $join->on('task.user_id', '=', 'users.user_id');
        })
        ->where('task.user_id','=', session('user_id'))
        ->select('task.*', 'users.*', 'project.*')
        ->get();
        return response()->json($data);
    }

    public function Completed(){
        $data = DB::table('task')->where('user_id',session('user_id'))->get();
        $user = DB::table('users')->get();
        $project = DB::table('project')->get();

        $profile = DB::table('users')
        ->where('users.user_id', '=', session('user_id'))
        ->get();

        return view('Employee.Task.CompletedTask',["data" => $data, "user"=>$user, "project" => $project, "profile"=>$profile]);
    }
    public function CompletedTaskShow(){
        $data = DB::table('task')
        ->leftJoin('project', function ($join) {
            $join->on('task.project_id', '=', 'project.project_id');
        })
        ->leftJoin('users', function ($join) {
            $join->on('task.user_id', '=', 'users.user_id');
        })
        ->where('task.user_id','=', session('user_id'))
        ->where('task.task_status','=', 1)
        ->select('task.*', 'users.*', 'project.*')
        ->get();
        return response()->json($data);
    }

    public function Pending(){
        $data = DB::table('task')->where('user_id',session('user_id'))->first();
        $user = DB::table('users')->get();
        $project = DB::table('project')->get();
        $profile = DB::table('users')
        ->where('users.user_id', '=', session('user_id'))
        ->get();

        return view('Employee.Task.PendingTask',["data" => $data, "user"=>$user, "project" => $project, "profile"=> $profile]);
    }
    public function PendingTaskShow(){
        $data = DB::table('task')
        ->leftJoin('project', function ($join) {
            $join->on('task.project_id', '=', 'project.project_id');
        })
        ->leftJoin('users', function ($join) {
            $join->on('task.user_id', '=', 'users.user_id');
        })
        ->where('task.user_id','=', session('user_id'))
        ->where('task.task_status','=', 0)
        ->select('task.*', 'users.*', 'project.*')
        ->get();
        return response()->json($data);
    }

    public function EmployeeTaskStore(Request $req){
        $task_id = $req->input('task_id');
        $data = $req->input();
        unset($data['_token']);

        $Validator = Validator::make($req->all(), [
            'task_from_date' => 'required',
            'task_to_date' => 'required',
            'task_status' => 'required'
        ]);

        if ($Validator->fails()) {
            return response()->json(["validate" => true, "message" => $Validator->errors()->all()[0]]);
        }

        try {
            $Task = DB::table('task')->updateOrInsert(
                ['task_id' => $req->input('task_id')],
               $data
            );

            return response()->json(["success" => true, "message" => !$req->input('task_id') ? "Task Detail Create Successfully" : "Category Detail Updated Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err" => $th->getMessage()]);
        }

    }
}
