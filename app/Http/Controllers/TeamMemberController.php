<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TeamMemberController extends Controller
{
    //Team Member Controller
    public function TeamMember(){
        $data = DB::table('team_member')->get();
        $categories = DB::table('categories')->get();
        $designation = DB::table('designation')->get();
        $profile = DB::table('users')
        ->where('users.user_id', '=', session('user_id'))
        ->get();
        return view('Admins.TeamMembers.TeamMember', ["data" => $data, "categories" => $categories, "designation" => $designation, "profile" => $profile]);
    }

    public function TeamMemberShow(){
        $data =  DB::table('team_member')
            ->leftJoin('categories', function ($join) {
            $join->on('team_member.categories_id', '=', 'categories.categories_id');
            })
            ->leftJoin('designation', function ($join) {
            $join->on('team_member.designation_id', '=', 'designation.designation_id');
            })
            ->select('team_member.*', 'categories.*', 'designation.*')
            ->get();
        return response()->json($data);
    }

    public function TeamMemberStore(Request $req){
        $data = $req->input();
        unset($data['_token']);
        $team_member_id = $req->input('team_member_id');

        if($req->hasFile('team_member_image')){
            $image=$req->file('team_member_image');
            $data['team_member_image'] = Str::random(20) . '.' . $image->getClientOriginalExtension();
            file_put_contents(base_path("public/TeamMember/" . $data['team_member_image']), file_get_contents($image));
        }

        try {
            $Member = DB::table('team_member')->updateOrInsert(
                ['team_member_id'=>$team_member_id],
               $data
                );

            return response()->json(["success" => true, "message" => !$req->input('user_id') ? "Designation Detail Create Successfully" : "Designation Detail Updated Successfully"]);

        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err" => $th->getMessage()]);
        }

    }

    public function TeamMemberEdit(Request $req){
        return response()->json(["data" => DB::table('team_member')->where('team_member_id', $req->input('team_member_id'))->get()]);
    }

    public function TeamMemberDelete(Request $req){
        if (DB::Table('team_member')->where('team_member_id',$req->input('team_member_id'))->delete()) {
            return response()->json(["success" => true, "message" => "Member Deleted!"]);
        }else{
            return response()->json(["success" => false, "message" => "Ooops Something Went wrong"]);
        }
    }


    //Desgination Controller
    public function Designation(){
        $data = DB::table('designation')->get();
        $categories = DB::table('categories')->get();
        $profile = DB::table('users')
        ->where('users.user_id', '=', session('user_id'))
        ->get();
        return view('Admins.TeamMembers.Designation', ["data" => $data, "categories" => $categories, "profile"=> $profile]);
    }

    public function DesginationShow(){
      $data =  DB::table('designation')
        ->leftJoin('categories', function ($join) {
        $join->on('designation.categories_id', '=', 'categories.categories_id');
        })
        ->select('designation.*', 'categories.*')
        ->get();
        // dd($data);
            // $data = DB::table('designation')->get();
            return response()->json($data);
    }

    public function DesignationStore(Request $req){
        $designation_id = $req->input('designation_id');
        $data = $req->input();

        $Validator = Validator::make($req->all(),[
            'designation_name' => 'required',
            'categories_id' => 'required',
            'designation_description' => 'required',
        ]);

        if($Validator->fails()){
            return response()->json(["validate" => true, "message" => $Validator->errors()->all()[0]]);
        }

        try {
            $Designation = DB::table('designation')->updateOrInsert(
                ['designation_id'=>$designation_id],
                [
                    'designation_name'=> $req->input('designation_name'),
                    'categories_id'=> $req->input('categories_id'),
                    'designation_description'=> $req->input('designation_description')
                ]
                );

            return response()->json(["success" => true, "message" => !$req->input('user_id') ? "Designation Detail Create Successfully" : "Designation Detail Updated Successfully"]);

        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err" => $th->getMessage()]);
        }
    }

    public function DesignationEdit(Request $req){
        return response()->json(['data' => DB::table('designation')->where('designation_id', $req->input('designation_id'))->get()]);
        // return response()->json(['data'=> DB::table('users')->where('user_id',$req->input('user_id'))->get()]);

    }

    public function DesignationDelete(Request $req){
        if (DB::table('designation')->where('designation_id', $req->input('designation_id'))->delete()) {
            return response()->json(['success'=>true, 'message'=>"Admin Deleted Successfully"]);
        }else{
            return response()->json(['success'=>false, 'message'=>"Oops somethings went wrong"]);
        }
    }
}
