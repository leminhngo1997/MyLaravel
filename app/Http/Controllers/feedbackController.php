<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use DB;

class feedbackController extends Controller
{
    public function get_value_feedbackdetail($id){
        $posts = DB::table('posts')->where('id',$id)->get();
        return view('sinhvien.chitietphanhoi',[
            'posts'=>$posts,
            ]);
    }
}
