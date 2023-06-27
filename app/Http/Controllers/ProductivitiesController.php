<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductivitiesController extends Controller
{
    public function Productivities(){
        $data = DB::table('productivities')->get();
        $task = DB::table('task')->get();
        $project = DB::table('project')->get();
        $profile = DB::table('users')
        ->where('users.user_id', '=', session('user_id'))
        ->get();
        return view('Admins.Productivities.Productivities',["data" => $data, "task" => $task, "project" => $project, "profile" => $profile]);
    }

    public function ProductivitiesShow(){
        $data = DB::table('productivities')
        ->leftJoin('project', function ($join) {
            $join->on('productivities.project_id', '=', 'project.project_id');
        })
        ->select('productivities.*', 'project.*')
        ->get();
        return response()->json($data);
    }

    public function ProductivitiesStore(Request $req){
        $product_id  = $req->input('product_id ');
        $data = $req->input();
        unset($data['_token']);

        $Validator = Validator::make($req->all(), [
            'project_id' => 'required',
            'task_id' => 'required',
            'product_subject' => 'required',
            'product_from_date' => 'required',
            'product_to_date' => 'required',
            'product_status' => 'required',
            'product_description' => 'required'
        ]);

        if ($Validator->fails()) {
            return response()->json(["validate" => true, "message" => $Validator->errors()->all()[0]]);
        }

        try {
            $Product = DB::table('productivities')->updateOrInsert(
                ['product_id' => $req->input('product_id')],
               $data
            );

            return response()->json(["success" => true, "message" => !$req->input('product_id') ? "Product Detail Create Successfully" : "Product Detail Updated Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err" => $th->getMessage()]);
        }
    }

    public function ProductivitiesEdit(Request $req){
        return response()->json(["data" => DB::table('productivities')->where('product_id', $req->input('product_id'))->get()]);
    }

    public function ProductivitiesDelete(Request $req){
        if (DB::table('productivities')->where('product_id', $req->input('product_id'))->delete()) {
            return response()->json(["success"=>true, "message"=>"product Delete!"]);
        }else{
            return response()->json(["success"=>false, "message"=>"Oops Something Went wrong"]);
        }
    }
}
