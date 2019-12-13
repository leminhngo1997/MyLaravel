<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;

class TestController extends Controller
{
    public function GetUser(){
       return view('test.test3');
    }
}
