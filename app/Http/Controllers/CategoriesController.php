<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function Categories(){
        $profile = DB::table('users')
        ->where('users.user_id', '=', session('user_id'))
        ->get();
        $data = DB::table('categories')->get();
        return view('Admins.Categories.Categories', ["data"=> $data, "profile" => $profile]);

    }

    public function CategoriesShow(){

        $data = DB::table('categories')->get();
        // dd($data);
        // return false;
        return response()->json($data);

    }

    public function CategoriesStore(Request $req){
        $categories_id = $req->input('categories_id');
        $data = $req->input();

        $validator = Validator::make($req->all(), [
            'categories_name' => 'required',
            'categories_note' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["validate" => true, "message" => $validator->errors()->all()[0]]);
        }

        try {
            $Admin = DB::table('categories')->updateOrInsert(
                ['categories_id'   => $req->input('categories_id')],
                [
                 'categories_name' => $req->input('categories_name'),
                 'categories_note' => $req->input('categories_note'),
                 'categories_status' => $req->input('categories_status') == "" ? 0 : 1
                ]
            );

            return response()->json(["success" => true, "message" => !$req->input('categories_id') ? "Admin Group Create Successfully" : "Admin Group Updated Successfully"]);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "message" => "Opps an Error Occured", "err" => $th->getMessage()]);
        }
    }

    public function CategoriesEdit(Request $req){
        return response()->json(["data" => DB::table('categories')->where('categories_id', $req->input('categories_id'))->get()]);
    }

    public function CategoriesDelete(Request $req){
        if (DB::table('categories')->where('categories_id',$req->input('categories_id'))->delete()) {
            return response()->json(['success'=>true, 'Message'=>"Category has been Deleted"]);
        }else{
            return response()->json(['success'=>false, 'Message'=>"Oops Something went wrong"]);
        }
    }
}
