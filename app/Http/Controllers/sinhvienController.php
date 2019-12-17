<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use DB;

class sinhvienController extends Controller
{	
    public function get_value_dashboard(){
        //get id user hiện tại  
        $auth_id = Auth::user()->id;
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

        //tính tổng điểm cộng 
        foreach ($bangdiem_id as $key => $value){
            $sum = 0;
            $diemcong = DB::table('tieuchi')
            ->Join('tieuchi_phongtrao', 'tieuchi.id', '=', 'tieuchi_phongtrao.tieuchi_id')
            ->Join('phongtrao', 'tieuchi_phongtrao.phongtrao_id', '=', 'phongtrao.id')
            ->Join('phongtrao_hoatdong','phongtrao.id', '=', 'phongtrao_hoatdong.phongtrao_id')
            ->Join('hoatdong', 'phongtrao_hoatdong.hoatdong_id', '=', 'hoatdong.id')
            ->Join('user_hoatdong', 'hoatdong.id', '=', 'user_hoatdong.hoatdong_id')
            ->where([
                        ['tieuchi.bangdiem_id', '=', $value->bangdiem_id],
                        ['user_hoatdong.sv_id', '=', $auth_id],
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
                        ['user_hoatdong.sv_id', '=', $auth_id],
                        ['hoatdong.status_clone','=',1],
                        ['user_hoatdong.heso', '=', -1],
                    ])->sum('hoatdong.diem');

            $sum = intval($diemcong)-intval($diemtru);
        }
        //end tính điểm tổng


        return view('sinhvien.dashboard',[
            'siso'=>$siso,
            'coso_name'=>$coso_name,
            'bangdiem_id'=>$bangdiem_id,
            'bangdiem'=>$bangdiem,
            'tieuchi'=> $tieuchi,
            'sum'=>$sum
            ]);
    }

    public function get_value_hoatdong(){
        // $auth_id = Auth::user()->id;
        $current_term = DB::table('bangdiem')->orderBy('id','DESC')->first();
        //get tiêu chí của học kì hiện tại
        $tieuchi = DB::table('tieuchi')->where('bangdiem_id',$current_term->id)->get();
        return view('sinhvien.thamgiahoatdong',[
            'tieuchi'=> $tieuchi,
            ]);
    }

    public function get_value_feedback(){
        // $auth_id = Auth::user()->id;
        $current_term = DB::table('bangdiem')->orderBy('ngayketthuc', 'DESC')->first();
        //get tieu chi của học kì hiện tại
        $tieuchi = DB::table('tieuchi')->where('bangdiem_id', $current_term->id)->get();
        return view('sinhvien.feedback',[
            'tieuchi'=> $tieuchi,
            ]);
    }

    //--Thêm hoạt động
    public function insert_hoat_dong_thamgiahoatdong(Request $request){
        //insert table hoatdong
        $data_hoatdong = array();
        $nguoi_tao = Auth::user()->name;
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
    
}
