<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function Project(){
        $data = DB::table('project')->get();
        $categories = DB::table('categories')->get();
        $user = DB::table('users')->get();
        $team_member = DB::table('team_member')->get();
        $profile = DB::table('users')
        ->where('users.user_id', '=', session('user_id'))
        ->get();
        return view('Admins.Project.Project', ["data" => $data, "categories" => $categories, "user" => $user, "team_member" => $team_member, "profile" => $profile]);
    }

    public function ProjectShow(){
        $data = DB::table('project')
        ->leftJoin('categories', function ($join) {
            $join->on('project.categories_id', '=', 'categories.categories_id');
            })
        ->leftJoin('users', function ($join) {
            $join->on('project.user_id', '=', 'users.user_id');
            })
            ->select('project.*', 'categories.*', 'users.*')
        ->get();
        return response()->json($data);
    }

    public function ProjectStore(Request $req){
        $project_id = $req->input('project_id');
        $data = $req->input();
        unset($data['_token']);

        $Validator = Validator::make($req->all(), [
            'project_name' => 'required',
            'categories_id' => 'required',
            'project_from_date' => 'required',
            'project_to_date' => 'required',
            'user_id' => 'required',
            'team_member_id' => 'required',
            'project_status' => 'required'
        ]);

        if ($Validator->fails()) {
            return response()->json(["validate" => true, "message" => $Validator->errors()->all()[0]]);
        }

        try {
            $project = DB::table('project')->updateOrInsert(
                ['project_id'   => $req->input('project_id')],
              $data
            );

            return response()->json(["success" => true, "message" => !$req->input('project_id') ? "Project Group Create Successfully" : "Project Group Updated Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err" => $th->getMessage()]);
        }
    }

    public function ProjectEdit(Request $req){
        return response()->json(["data" => DB::table('project')->where('project_id', $req->input('project_id'))->get()]);
    }

    public function ProjectDelete(Request $req){
        if (DB::table('project')->where('project_id', $req->input('project_id'))->delete()) {
            return response()->json(["success"=>true, "message"=>"Project Deleted!"]);
        }else{
            return response()->json(["success"=>false, "message"=>"Oops Something went Wrong!"]);
        }
    }
}
