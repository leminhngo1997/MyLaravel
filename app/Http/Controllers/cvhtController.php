<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class cvhtController extends Controller
{	
    public function get_value_phanhoicvht(){
        $current_user = Auth::user()->id;
        $co_so = DB::table('coso')->join('sv_coso','coso.id','=','sv_coso.coso_id')->where('sv_coso.sv_id',$current_user)->get();
        
        $list_posts = array();
        foreach($co_so as $key=>$value)
        {
            $sv_coso = DB::table('sv_coso')->where('coso_id',$value->coso_id)->get();
        }
     
        foreach($sv_coso as $key=>$value)
        {
            $posts[] = DB::table('posts')->where('sv_id',$value->sv_id)->get();
        }
        foreach($posts as $item){
            foreach($item as $key=>$value)
            {
                array_push($list_posts,$value);
            }
        }
   
        
        return view('cvht.phanhoicvht',[
            'co_so'=>$co_so,
            'list_posts'=>$list_posts,
            ]);
    }
   
}
