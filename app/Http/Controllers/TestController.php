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
    function Test(Request $request){
        $array = [
            1, 23, 32, 5,43, 321, 312, 352, 2, 13 ,153, 21,32 ,1
        ];
        sort($array);
        $count = 1;
        // dd($array);
        for ($i = 0; $i < count($array); $i++){
            if($array[$i]=$array[$i+1]){
                $count = $count+1;
                echo "Số".$array[i]." trùng";
            }
        }
        dd(1);
        return 0;
    }
}
