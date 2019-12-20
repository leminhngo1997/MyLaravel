<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class cvhtController extends Controller
{	
    public function get_value_phanhoicvht(){
        
        if(Auth::user()!==NULL)
        {
            $current_user = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }

        $co_so = DB::table('coso')->join('sv_coso','coso.id','=','sv_coso.coso_id')->where('sv_coso.sv_id',$current_user)->get();
        
        if(count($co_so)>0){

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
        }
        return view('cvht.phanhoicvht',[
            'co_so'=>$co_so,
            'list_posts'=>$list_posts,
            ]);
    }
   
    public function get_value_create_vote_cvht(){
        $su_lua_chon = DB::table('suluachon')->get();
        $current_user = Auth::user()->id;
        $current_coso_id = DB::table('coso')->join('sv_coso','coso.id','=','sv_coso.coso_id')
        ->where('sv_coso.sv_id',$current_user)->get();
        foreach($current_coso_id as $key=>$value)
        {
            $list_user[] = DB::table('users')
            ->join('sv_coso','users.id','=','sv_coso.sv_id')
            ->join('user_role','users.id','=','user_role.sv_id')
            ->where([['sv_coso.coso_id',$value->coso_id],['user_role.role_id',1]])->get();
            
        }
        // dd($list_user);
        return view('cvht.createvotecvht',[
            'su_lua_chon'=> $su_lua_chon,
            'list_user'=>$list_user
            ]);
    }
    public function get_value_votecvht(){
        return view('cvht.votecvht');
    }
    // Thêm bầu chọn
    public function insert_cauhoi_vote(Request $request){
        $current_user = Auth::user()->id;
        $current_coso_id = DB::table('coso')->join('sv_coso','coso.id','=','sv_coso.coso_id')
        ->where('sv_coso.sv_id',$current_user)->get();
        foreach($current_coso_id as $key=>$value)
        {
            // x là cơ sở id hiện tại
            $x = $value->coso_id;
        }
        if($request->check == null)
        {
            Session::put('message','Lỗi: Check sinh viên');
            return back();
        }
        //id sinh viên check
        $check = $request->check;
        
        $data_cauhoi = array();
        $data_cauhoi['name_cauhoi'] = $request->input_cauhoi;
        $data_cauhoi['suluachon_id'] = $request->input_suluachon;
        $data_cauhoi['coso_id'] = $x;
        $data_cauhoi['ngaybatdau'] = $request->input_ngaybatdau_vote;
        $data_cauhoi['ngayketthuc'] = $request->input_ngayketthuc_vote;
        $data_cauhoi['ungcuvien'] = implode(',', $check);
        DB::table('cauhoi')->insert($data_cauhoi);
        Session::put('message','Thêm bầu chọn điểm thành công.');
        return back();
    }
}
