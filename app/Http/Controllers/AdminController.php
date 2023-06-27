<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller
{

    // Admins Login
    public function Admin(){
        $users = DB::table('users')->get();
        $group = DB::table('users_group')->get();
        $profile = DB::table('users')
        ->where('users.user_id', '=', session('user_id'))
        ->get();
        return view('Admins.Admin.Admin', ['data' => $users, 'group'=> $group, "profile"=>$profile]);
    }

    public function AdminShow(){
        $users = DB::table('users')
        ->leftJoin('users_group', function ($join) {
            $join->on('users_group.group_id', '=', 'users.group_id');
        })
        ->select('users.*', 'users_group.*')
        ->get();
        return response()->json($users);
    }

    public function AdminStore(Request $req){
        $user_id = $req->input('user_id');
        $data = $req->input();
        unset($data['_token']);

        $validator = Validator::make($req->all(), [
            'user_first_name' => 'required',
            'user_last_name' => 'required',
            'user_email' => 'required',
            'user_phone' => 'required',
            'group_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(["validate" => true, "message" => $validator->errors()->all()[0]]);
        }

        if($req->hasFile('user_image')){
            $image=$req->file('user_image');
            $data['user_image'] = Str::random(20) . '.' . $image->getClientOriginalExtension();
            file_put_contents(base_path("public/Admin/" . $data['user_image']), file_get_contents($image));
        }

        try {
            $Admin = DB::table('users')->updateOrInsert(
                ['user_id'   => $req->input('user_id')],
              $data
            );

            return response()->json(["success" => true, "message" => !$req->input('user_id') ? "Admin Detail Create Successfully" : "Category Detail Updated Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err" => $th->getMessage()]);
        }
    }

    public function AdminEdit(Request $req){

        return response()->json(['data'=> DB::table('users')->where('user_id',$req->input('user_id'))->get()]);

    }

    public function AdminDelete(Request $req){
        if (DB::table('users')->where('user_id',$req->input('user_id'))->delete()) {
            return response()->json(['success'=>true, 'message'=>"Admin Deleted Successfully"]);
        }else{
            return response()->json(['success'=>false, 'message'=>"Oops somethings went wrong"]);
        }
    }

    public function AdminGroup(){
        $data = DB::table('users_group')->get();
        $profile = DB::table('users')
        ->where('users.user_id', '=', session('user_id'))
        ->get();
        return view('Admins.Admin.AdminGroup', ["data" => $data, "profile" => $profile]);
    }

    public function AdminGroupShow(){
        $data = DB::table('users_group')->get();
        return response()->json($data);
    }

    public function AdminGroupStore(Request $req){
        $group_id = $req->input('group_id');
        $data = $req->input();

        $validator = Validator::make($req->all(), [
            'group_name' => 'required',
            'group_description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["validate" => true, "message" => $validator->errors()->all()[0]]);
        }

        try {
            $Admin = DB::table('users_group')->updateOrInsert(
                ['group_id'   => $req->input('group_id')],
                [
                 'group_name' => $req->input('group_name'),
                 'group_description' => $req->input('group_description')
                ]
            );

            return response()->json(["success" => true, "message" => !$req->input('group_id') ? "Admin Group Create Successfully" : "Admin Group Updated Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err" => $th->getMessage()]);
        }
    }

    public function AdminGroupEdit(Request $req){

        return response()->json(['data'=> DB::table('users_group')->where('group_id',$req->input('group_id'))->get()]);

    }

    public function AdminGroupDelete(Request $req){
        if (DB::table('users_group')->where('group_id',$req->input('group_id'))->delete()) {
            return response()->json(["success"=>true, "message"=>"Admin Group Delete!"]);
        }else{
            return response()->json(["success"=>false, "message"=>"Admin Group Delete failed!"]);
        }
    }

    // Employee Login

    public function EmployeeProfile(){
        $users = DB::table('users')->get();
        $group = DB::table('users_group')->get();

        $profile = DB::table('users')
        ->where('users.user_id', '=', session('user_id'))
        ->get();
        return view('Employee.Setting.setting', ['data' => $users, 'group'=> $group, "profile"=> $profile]);
    }

    public function EmployeeProfileShow(){
        $users = DB::table('users')
        ->leftJoin('users_group', function ($join) {
            $join->on('users_group.group_id', '=', 'users.group_id');
        })
        ->where('users.user_id', '=', session('user_id'))
        ->select('users.*', 'users_group.*')
        ->get();
        return response()->json($users);
    }
}
