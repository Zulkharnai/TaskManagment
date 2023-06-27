<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function Login(){
        return view('login');
    }

    public function LoginUser(Request $req){

        $validator = Validator::make($req->all(), [
            'user_email' => 'required',
            'user_password' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(["validate" => true, "message" =>$validator->errors()->all()[0]]);
        }

        $user = DB::table('users')->where(["user_email" => $req->input('user_email')])->first();

        if(!$user){
        return response()->json(["success" => false, "message" => "Invalid Credential"]);
        }

        if($req->input('user_password') == $user->user_password){
            Session::put('user_id', $user->user_id);
            Session::put('user_name', $user->user_last_name);
            Session::put('user_email', $user->user_email);
            Session::save();
            return response()->json(["success" => true, "message" => "Login Successfull", "data" => $user]);
        }
        else{
            return response()->json(["success" => false, "message" => "Invalid Credential"]);
        }
    }

    public function Dashboard() {
        $users = DB::table('users')
        ->where('users.user_id', '=', session('user_id'))
        ->get();

        $admin = DB::table('users')->count();
        $member = DB::table('team_member')->count();
        $designation = DB::table('designation')->count();
        $categories = DB::table('categories')->count();
        $project = DB::table('project')->count();
        $pending = DB::table('task')->where('task.task_status', '=', 0)->count();
        $completed = DB::table('task')->where('task.task_status', '=', 1)->count();
        $productivities = DB::table('productivities')->count();

        return view('Admins.Dashboard.Dashboard', ["profile" => $users, "admin"=>$admin, "member"=>$member, "category" => $categories,"designation"=> $designation, "project"=>$project, "pending" => $pending, "completed"=>$completed, "productivities" => $productivities]);
    }
    public function EmployeeDashboard() {
        $users = DB::table('users')
        ->where('users.user_id', '=', session('user_id'))
        ->get();

        $Task = DB::table('task')->where('user_id',session('user_id'))->count();
        $completed = DB::table('task')->where('user_id',session('user_id'))->where('task.task_status', '=', 1)->count();
        $pending = DB::table('task')->where('user_id',session('user_id'))->where('task.task_status', '=', 0)->count();

        return view('Employee.Dashboard.EmployeeDashboard', ["profile" => $users, "task" => $Task, "completed" => $completed, "pending"=>$pending]);
    }
}
