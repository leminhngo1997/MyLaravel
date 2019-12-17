<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class feedbackController extends Controller
{
    public function get_value_feedbackdetail($id){
        return view('sinhvien.chitietphanhoi');
    }
}
