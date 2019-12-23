<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class cvhtController extends Controller
{	
    public function AuthSV(){
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
        $user_role = DB::table('user_role')->where('sv_id', $auth_id)->first('role_id');
        $role = DB::table('roles')->where('id', $user_role->role_id)->first('name');
        if($role->name == "cvht"){
            
		}else{
            Redirect::to('login')->send();
        }
    }

    public function get_value_phanhoicvht(){
        $this->AuthSV(); 
        if(Auth::user()!==NULL)
        {
            $current_user = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }

        $co_so = DB::table('coso')->join('sv_coso','coso.id','=','sv_coso.coso_id')->where('sv_coso.sv_id',$current_user)->get();
        
        $list_posts = array();
        if(count($co_so)>0){

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
        $this->AuthSV(); 
        if(Auth::user()!==NULL)
        {
            $current_user = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
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
        $this->AuthSV(); 
        //get id user hiện tại  
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
        $coso_id = DB::table('coso')->join('sv_coso','coso.id','=','sv_coso.coso_id')
        ->where('sv_coso.sv_id',$auth_id)->get();
        foreach($coso_id as $key=>$value)
        {
            //$x là mã cơ sở của user hiện tại
            $x = $value->coso_id;
        }
        $list_cauhoi = DB::table('cauhoi')->where('coso_id',$x)->get();

        return view('cvht.votecvht',[
            'list_cauhoi'=>$list_cauhoi,
            ]);
    }
    // Thêm bầu chọn
    public function insert_cauhoi_vote(Request $request){
        $this->AuthSV(); 
        //get id user hiện tại  
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
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


    public function get_ketqua_bauchon_cvht($id){
        $this->AuthSV(); 
        if(Auth::user()!==NULL)
        {
            $current_user = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
        $list_cauhoi = DB::table('cauhoi')->where('id',$id)->get();
        $list_traloi = DB::table('traloi')->where('cauhoi_id',$id)->get();
        
        $x = array();
        
        foreach($list_traloi as $key=>$value)
        {
            array_push($x,explode(',',$value->name_traloi));
            
        }
        $temp = array();
        //dd($x);
        foreach($x as $key=>$value)
        {
            if($key===0){
                foreach($value as $index => $id){
                        $ungcuvien_id[] = array(
                            'id' => $id,
                            'count'=>1
                        );
                    }     
            }
            else{
                foreach($value as $index => $id){
                    $check = 0; 
                    foreach($ungcuvien_id as $i => $v){
                        
                        if($v['id'] === $id)
                        {
                            $count = intval($v['count']);
                            $count ++;
                            $ungcuvien_id[$i] = array(
                                'id' => $id,
                                'count'=>$count
                            );
                            $check++; 
                        }
                    }
                    
                    if($check === 0){
                        $ungcuvien_id[] = array(
                            'id' => $id,
                            'count'=>1
                        );
                    }
                    
                }
            }
            
        }

        
        foreach($ungcuvien_id as $item => $value)
        {
            $user_name = DB::table('users')->where('id',$value['id'])->get();
            foreach($user_name as $m=>$n)
            {
                $value['user_name'] = $n->name;
                $value['email'] = $n->email;
                $ungcuvien_id[$item] = $value; 
            }   
        }
        //hàm sắp giảm -> tìm top
        function build_sorter($key) {
            return function ($a, $b) use ($key) {
                return strnatcmp($b[$key], $a[$key]);
            };
        }    
               
        usort($ungcuvien_id, build_sorter('count'));

        // dd($ungcuvien_id);
        
        return view('cvht.ketquabauchon',[
            'list_cauhoi'=>$list_cauhoi,
            'ungcuvien_id'=>$ungcuvien_id,
            ]);
    }

    public function get_value_thongkecvht()
    {
        //$this->AuthSV();
        //get id user hiện tại  
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
        
        
        //get si_so
        $coso_id = DB::table('sv_coso')->where('sv_id', $auth_id)->take(1)->get('coso_id')->toArray();
        if(count($coso_id)>0){
        $coso_id = end($coso_id);
        $coso_id = end($coso_id);
        $siso = DB::table('coso')->where('id', $coso_id)->first('siso')->siso;
        $coso_name = DB::table('coso')->where('id', $coso_id)->first('name')->name;
        //doituong_id của user hiện tại
        $doituong_id = DB::table('coso')->where('id',$coso_id)->first('doituong_id')->doituong_id;
        //các bảng điểm thuộc doituong_id
        $bangdiem_id = DB::table('bangdiem_doituong')->where('doituong_id',$doituong_id)->get('bangdiem_id');
        $bangdiem = DB::table('bangdiem')->get();
        }else{
            $bangdiem_id=array();
            $bangdiem=array();
        }
        return view('cvht.thongke_cvht',[
            'bangdiem_id'=>$bangdiem_id,
            'bangdiem'=>$bangdiem,
        ]);
    }
    
}
