<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use DB;
use Egulias\EmailValidator\Exception\InvalidEmail;

class sinhvienController extends Controller
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
        if($role->name == "sinh viên"){
            
		}else{
            Redirect::to('login')->send();
        }
    }

    public function get_value_dashboard(){
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
        //get phân quyền
        $quyen_id = DB::table('user_role')->where('sv_id',$auth_id)->get('role_id');
        $quyen_id = end($quyen_id);
        $quyen_id = end($quyen_id);
        $quyen_id = end($quyen_id);

        switch($quyen_id)
        {
            case 1: $quyen = 'sinhvien'; break;
            case 2: $quyen = 'loptruong'; break;
            case 3: $quyen = 'ctsv'; break;
        }
        
        //get si_so
        $coso_id = DB::table('sv_coso')->where('sv_id', $auth_id)->first('coso_id')->coso_id;
        $siso = DB::table('coso')->where('id', $coso_id)->first('siso')->siso;
        $coso_name = DB::table('coso')->where('id', $coso_id)->first('name')->name;
        //doituong_id của user hiện tại
        $doituong_id = DB::table('coso')->where('id',$coso_id)->first('doituong_id')->doituong_id;
        //các bảng điểm thuộc doituong_id
        $bangdiem_id = DB::table('bangdiem_doituong')->where('doituong_id',$doituong_id)->get('bangdiem_id');
        $bangdiem = DB::table('bangdiem')->get();
        //tieuchi
        $tieuchi = DB::table('tieuchi')->get();
//diem trung binh
        //danh sach sinh vien
        $sinhvien = DB::table('users')
        ->join('sv_coso','users.id','=','sv_coso.sv_id')
        ->join('user_role','users.id','=','user_role.sv_id')
        ->where([
            ['sv_coso.coso_id','=',$coso_id],
            ['user_role.role_id','<',3]
        ])
        ->select('users.id','users.name','users.email')
        ->get('id');

        //tính trung bình
            foreach($sinhvien as $index => $item){  
            
                $sum = 0;
                foreach($bangdiem_id as $key => $value){
                        $diemcong = DB::table('tieuchi')
                        ->Join('tieuchi_phongtrao', 'tieuchi.id', '=', 'tieuchi_phongtrao.tieuchi_id')
                        ->Join('phongtrao', 'tieuchi_phongtrao.phongtrao_id', '=', 'phongtrao.id')
                        ->Join('phongtrao_hoatdong','phongtrao.id', '=', 'phongtrao_hoatdong.phongtrao_id')
                        ->Join('hoatdong', 'phongtrao_hoatdong.hoatdong_id', '=', 'hoatdong.id')
                        ->Join('user_hoatdong', 'hoatdong.id', '=', 'user_hoatdong.hoatdong_id')
                        ->where([
                                    ['tieuchi.bangdiem_id', '=', $value->bangdiem_id],
                                    ['user_hoatdong.sv_id', '=', $item->id],
                                    ['hoatdong.status_clone','=',1],
                                    ['user_hoatdong.heso', '=', 1],
                                ])->sum('hoatdong.diem');
                        $diemtru = DB::table('tieuchi')
                        ->Join('tieuchi_phongtrao', 'tieuchi.id', '=', 'tieuchi_phongtrao.tieuchi_id')
                        ->Join('phongtrao', 'tieuchi_phongtrao.phongtrao_id', '=', 'phongtrao.id')
                        ->Join('phongtrao_hoatdong','phongtrao.id', '=', 'phongtrao_hoatdong.phongtrao_id')
                        ->Join('hoatdong', 'phongtrao_hoatdong.hoatdong_id', '=', 'hoatdong.id')
                        ->Join('user_hoatdong', 'hoatdong.id', '=', 'user_hoatdong.hoatdong_id')
                        ->where([
                                    ['tieuchi.bangdiem_id', '=', $value->bangdiem_id],
                                    ['user_hoatdong.sv_id', '=', $item->id],
                                    ['hoatdong.status_clone','=',1],
                                    ['user_hoatdong.heso', '=', -1],
                                ])->sum('hoatdong.diem');
                        $sum += intval($diemcong)-intval($diemtru);
                }

                $avr = $sum / count($bangdiem_id);
                $xephang[] = array('id'=>$item->id,'trung_binh'=>$avr);
            }
            function build_sorter($key) {
                return function ($a, $b) use ($key) {
                    return strnatcmp($b[$key], $a[$key]);
                };
            }    
                   
            usort($xephang, build_sorter('trung_binh'));
           
            //xếp hạng
            foreach($xephang as $key => $value){
                if($auth_id === $value['id']){
                    $hang = $key+1;
                    $chitietxephang = array('id'=>$auth_id, 
                    'trung_binh' => $value['trung_binh'],
                    'xep_hang'=>$hang
                    );
                }
            }
            //dd($xephang);
        return view('sinhvien.dashboard',[
            'siso'=>count($sinhvien),
            'coso_name'=>$coso_name,
            'bangdiem_id'=>$bangdiem_id,
            'bangdiem'=>$bangdiem,
            'tieuchi'=> $tieuchi,
            'quyen' => $quyen,
            'chitietxephang'=>$chitietxephang,
            ]);
    }

    public function get_value_hoatdong(){
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
        $current_term = DB::table('bangdiem')->orderBy('id','DESC')->first();
        //get tiêu chí của học kì hiện tại
        $tieuchi = DB::table('tieuchi')->where('bangdiem_id',$current_term->id)->get();
        //get phân quyền
        $quyen_id = DB::table('user_role')->where('sv_id',$auth_id)->get('role_id');
        $quyen_id = end($quyen_id);
        $quyen_id = end($quyen_id);
        $quyen_id = end($quyen_id);

        $quyen = '';
        switch($quyen_id)
        {
            case 1: $quyen = 'sinhvien'; break;
            case 2: $quyen = 'loptruong'; break;
            case 3: $quyen = 'ctsv'; break;
        }
        return view('sinhvien.thamgiahoatdong',[
            'tieuchi'=> $tieuchi,
            'quyen'=>$quyen
            ]);
    }

    public function get_value_feedback(){
        $this->AuthSV();
        if(Auth::user()!==NULL)
        {
            $current_user_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }

        $current_term = DB::table('bangdiem')->orderBy('id','DESC')->first();
        //get tiêu chí của học kì hiện tại
        $tieuchi = DB::table('tieuchi')->where('bangdiem_id',$current_term->id)->get();
        //get phân quyền
        $quyen_id = DB::table('user_role')->where('sv_id',$current_user_id)->get('role_id');
        $quyen_id = end($quyen_id);
        $quyen_id = end($quyen_id);
        $quyen_id = end($quyen_id);

        $quyen = '';
        switch($quyen_id)
        {
            case 1: $quyen = 'sinhvien'; break;
            case 2: $quyen = 'loptruong'; break;
            case 3: $quyen = 'ctsv'; break;
        }

        $current_user_id = Auth::user()->id;
        $posts = DB::table('posts')->where('sv_id',$current_user_id)->get();
        $current_term = DB::table('bangdiem')->orderBy('ngayketthuc', 'DESC')->first();
        //get tieu chi của học kì hiện tại
        $tieuchi = DB::table('tieuchi')->where('bangdiem_id', $current_term->id)->get();
        return view('sinhvien.feedback',[
            'tieuchi'=> $tieuchi,
            'posts'=> $posts,
            'quyen'=>$quyen
            ]);
    }

    //--Thêm hoạt động
    public function insert_hoat_dong_thamgiahoatdong(Request $request){
        $this->AuthSV();
        if(Auth::user()!==NULL)
        {
            $nguoi_tao = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }

        $current_term = DB::table('bangdiem')->orderBy('id','DESC')->first();
        //get tiêu chí của học kì hiện tại
        $tieuchi = DB::table('tieuchi')->where('bangdiem_id',$current_term->id)->get();
        
        //insert table hoatdong
        $data_hoatdong = array();

        //--tên cơ sở
        $auth_id = Auth::user()->id;
        
        $coso_id_hoatdong = DB::table('sv_coso')->where('sv_id',$auth_id)->get('coso_id');
        foreach($coso_id_hoatdong as $item){
            $current_coso_id = $item->coso_id;
        }
        $coso_name_hoatdong = DB::table('coso')->where('id',$current_coso_id)->get('name');
        foreach($coso_name_hoatdong as $item){
            $current_coso_name = $item->name;
        }
        
        $data_hoatdong['name'] = $request->input_name_hoatdong;
        $data_hoatdong['mota'] = $request->input_mota_hoatdong;
        $data_hoatdong['diem'] = $request->input_diem_hoatdong;
        $data_hoatdong['doituong'] = $current_coso_name;
        // tách chuỗi
        // $data_hoatdong_coso = explode("-",$data_hoatdong['doituong']);
        $data_hoatdong['ngaybatdau'] = $request->input_ngaybatdau_hoatdong;
        $data_hoatdong['ngayketthuc'] = $request->input_ngayketthuc_hoatdong;
        $data_hoatdong['nguoitao'] = $nguoi_tao;
        $data_hoatdong['status_clone'] = 0;
        DB::table('hoatdong')->insert($data_hoatdong);
        //insert table phongtrao_hoatdong
        $current_hoatdong_id = DB::table('hoatdong')->orderBy('id', 'DESC')->first()->id;
        $data_phongtrao_hoatdong = array();
        $data_phongtrao_hoatdong['phongtrao_id'] = $request->input_id_phongtrao;
        $data_phongtrao_hoatdong['hoatdong_id'] = $current_hoatdong_id;
        $data_phongtrao_hoatdong['status'] = 0;
        DB::table('phongtrao_hoatdong')->insert($data_phongtrao_hoatdong);
        //insert table coso_hoatdong
        $data_coso_hoatdong = array();
        $data_coso_hoatdong['coso_id'] = $current_coso_id;
        $data_coso_hoatdong['hoatdong_id'] = $current_hoatdong_id;
        DB::table('coso_hoatdong')->insert($data_coso_hoatdong);
        Session::put('message','Thêm hoạt động thành công.');
        return back();
    }


    public function diem_cong_theo_tieu_chi($user_id, $bangdiem_id){
        $temp = DB::table('tieuchi')
        ->Join('tieuchi_phongtrao', 'tieuchi.id', '=', 'tieuchi_phongtrao.tieuchi_id')
        ->Join('phongtrao', 'tieuchi_phongtrao.phongtrao_id', '=', 'phongtrao.id')
        ->Join('phongtrao_hoatdong','phongtrao.id', '=', 'phongtrao_hoatdong.phongtrao_id')
        ->Join('hoatdong', 'phongtrao_hoatdong.hoatdong_id', '=', 'hoatdong.id')
        ->Join('user_hoatdong', 'hoatdong.id', '=', 'user_hoatdong.hoatdong_id')
        ->where([
                    ['tieuchi.bangdiem_id', '=', $bangdiem_id],
                    ['user_hoatdong.sv_id', '=', $user_id],
                    ['hoatdong.status_clone','=',1],
                    ['user_hoatdong.heso', '=',1],
                ])->sum('hoatdong.diem');

        return $temp;
    }
    //--Thêm feedback
    public function insert_feedback(Request $request){
        $this->AuthSV();
        //insert table posts
        if(Auth::user()!==NULL)
        {
            $current_user = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
        
        $bang_diem_id = DB::table('bangdiem')->orderBy('id', 'DESC')->first()->id;
        $name_tieuchi = DB::table('tieuchi')->where('id',$request->input_name_tieuchi)->first()->name;
        $name_phongtrao = DB::table('phongtrao')->where('id',$request->input_name_phongtrao)->first()->name;
        $name_hoatdong = DB::table('hoatdong')->where('id',$request->input_name_hoatdong)->first()->name;
        // dd($name_hoatdong);
        $data = array();
        $data['mota'] = $request->input_mota;
        $data['name_tieuchi'] = $name_tieuchi;
        $data['name_phongtrao'] = $name_phongtrao;
        $data['name_hoatdong'] = $name_hoatdong;
        $data['sv_id'] = $current_user;
        $data['bangdiem_id'] = $bang_diem_id;
        DB::table('posts')->insert($data);
        Session::put('message','Thêm phản hồi thành công.');
        return back();
    }

    //chi tiết điểm tiêu chí
    public function chitietTieuchi($id){
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
        //get phân quyền
        $quyen_id = DB::table('user_role')->where('sv_id',$auth_id)->get('role_id');
        $quyen_id = end($quyen_id);
        $quyen_id = end($quyen_id);
        $quyen_id = end($quyen_id);

        $quyen = '';
        switch($quyen_id)
        {
            case 1: $quyen = 'sinhvien'; break;
            case 2: $quyen = 'loptruong'; break;
            case 3: $quyen = 'ctsv'; break;
        }
        
        //get phong trào
        $phongtrao = DB::table('tieuchi')
        ->join('tieuchi_phongtrao','tieuchi.id','=','tieuchi_phongtrao.tieuchi_id')
        ->join('phongtrao','tieuchi_phongtrao.phongtrao_id','=','phongtrao.id')
        ->join('phongtrao_hoatdong','phongtrao.id','=','phongtrao_hoatdong.phongtrao_id')
        ->join('hoatdong','phongtrao_hoatdong.hoatdong_id','=','hoatdong.id')
        ->join('user_hoatdong','hoatdong.id','=','user_hoatdong.hoatdong_id')
        ->where([
            ['tieuchi.id','=',$id],
            ['user_hoatdong.sv_id','=',$auth_id],
            //['user_hoatdong.heso','!=',0]
            ])
        ->orderBy('phongtrao.id','DESC')
        ->select(
            'phongtrao.id as phongtrao_id',
            'phongtrao.name as phongtrao_name',
            'hoatdong.id as hoatdong_id',
            'hoatdong.name as hoatdong_name',
            'hoatdong.diem',
            'user_hoatdong.heso')->get();

            //dd($phongtrao);
        $sum_phongtrao=0;
        $phongtrao_id_old = null;
        $phongtrao_list = array();
        $hoatdong_list = array();
        foreach($phongtrao as $index  => $value){
                if($value->phongtrao_id!==$phongtrao_id_old){
                    $phongtrao_list[] = array(
                        'phongtrao_id' => $value->phongtrao_id,
                        'phongtrao_name' => $value->phongtrao_name
                    );

                    $phongtrao_id_old = $value->phongtrao_id;
                    
                }

                $hoatdong_list[] = array(
                    'phongtrao_id'=> $value->phongtrao_id,
                    'hoatdong_id' => $value->hoatdong_id,
                    'hoatdong_name' => $value->hoatdong_name,
                    'diem' => $value->diem,
                    'heso' => $value->heso
                );         

                $sum_phongtrao += intval($value->diem) * floatval($value->heso);
        }

        return view('sinhvien.chitiettieuchi',[
            'phongtrao_list' => $phongtrao_list,
            'hoatdong_list' => $hoatdong_list,
            'quyen'=>$quyen
        ]);
    }

    public function thongke_loptruong(){
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
        //get phân quyền
        $quyen_id = DB::table('user_role')->where('sv_id',$auth_id)->get('role_id');
        $quyen_id = end($quyen_id);
        $quyen_id = end($quyen_id);
        $quyen_id = end($quyen_id);

        $quyen = '';
        switch($quyen_id)
        {
            case 1: $quyen = 'sinhvien'; break;
            case 2: $quyen = 'loptruong'; break;
            case 3: $quyen = 'ctsv'; break;
        }
        

        //get si_so
        $coso_id = DB::table('sv_coso')->where('sv_id', $auth_id)->first('coso_id')->coso_id;
        $siso = DB::table('coso')->where('id', $coso_id)->first('siso')->siso;
        $coso_name = DB::table('coso')->where('id', $coso_id)->first('name')->name;
        //doituong_id của user hiện tại
        $doituong_id = DB::table('coso')->where('id',$coso_id)->first('doituong_id')->doituong_id;
        //các bảng điểm thuộc doituong_id
        $bangdiem_id = DB::table('bangdiem_doituong')->where('doituong_id',$doituong_id)->get('bangdiem_id');
        $bangdiem = DB::table('bangdiem')->get();

        return view('sinhvien.thongke_loptruong',[
            'bangdiem_id'=>$bangdiem_id,
            'bangdiem'=>$bangdiem,
            'quyen'=>$quyen
        ]);
    }

    public function get_value_vote(){
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
        //get phân quyền
        $quyen_id = DB::table('user_role')->where('sv_id',$auth_id)->get('role_id');
        $quyen_id = end($quyen_id);
        $quyen_id = end($quyen_id);
        $quyen_id = end($quyen_id);

        $quyen = '';
        switch($quyen_id)
        {
            case 1: $quyen = 'sinhvien'; break;
            case 2: $quyen = 'loptruong'; break;
            case 3: $quyen = 'ctsv'; break;
        }

        $coso_id = DB::table('coso')->join('sv_coso','coso.id','=','sv_coso.coso_id')
        ->where('sv_coso.sv_id',$auth_id)->get();
        foreach($coso_id as $key=>$value)
        {
            //$x là mã cơ sở của user hiện tại
            $x = $value->coso_id;
        }
        $list_cauhoi = DB::table('cauhoi')->where('coso_id',$x)->get();
        // dd($list_cauhoi);
        return view('sinhvien.vote',[
            'list_cauhoi'=>$list_cauhoi,
            'quyen'=>$quyen
            ]);
    }

    public function get_value_vote_chitiet($id){
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
        //get phân quyền
        $quyen_id = DB::table('user_role')->where('sv_id',$auth_id)->get('role_id');
        $quyen_id = end($quyen_id);
        $quyen_id = end($quyen_id);
        $quyen_id = end($quyen_id);

        $quyen = '';
        switch($quyen_id)
        {
            case 1: $quyen = 'sinhvien'; break;
            case 2: $quyen = 'loptruong'; break;
            case 3: $quyen = 'ctsv'; break;
        }
        $cau_hoi = DB::table('cauhoi')->where('id',$id)->get();
        foreach($cau_hoi as $key=>$value)
        {
            foreach(explode(',',$value->ungcuvien) as $item){
                $users[] = DB::table('users')->where('id',$item)->get();
            }
        }
        
        
        return view('sinhvien.votechitiet',[
            'quyen'=>$quyen,
            'cau_hoi'=>$cau_hoi,
            'users'=>$users,
            ]);
    }

     //--Thêm feedback
     public function insert_traloi_vote(Request $request){
        $this->AuthSV();
        //insert table posts
        if(Auth::user()!==NULL)
        {
            $current_user = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }

        if($request->check == null)
        {
            Session::put('message','Lỗi: Vui lòng check lựa chọn');
            return back();
        }
   
        if($request->input_suluachon_id ==1){
            if(count($request->check) > 1){
                Session::put('message','Lỗi: Bạn chỉ được chọn tối đa 1 lựa chọn');
                return back();
            }
        }

        $check_traloi_table = DB::table('traloi')->select('sv_id')->where('cauhoi_id',$request->input_cauhoi_id)->get();
        foreach($check_traloi_table as $key=>$value)
        {
            if($current_user = Auth::user()->id === $value->sv_id)
            {
                
                Session::put('message','Bạn đã bầu chọn topic này rồi !!');
                return back();
            }
           

        }

        $check = $request->check;
        $current_user = Auth::user()->id;
        $data_traloi = array();
        $data_traloi['name_traloi'] = implode(',', $check);;
        $data_traloi['sv_id'] = $current_user;
        $data_traloi['cauhoi_id'] = $request->input_cauhoi_id;
        $data_traloi['tinhtrang'] = 1;
        DB::table('traloi')->insert($data_traloi);
        Session::put('message','Bầu chọn thành công.');
        return back();
       
        

        //id sinh viên check
        
    }
}
