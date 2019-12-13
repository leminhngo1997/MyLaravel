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
        return view('sinhvien.dashboard',[
            'siso'=>$siso,
            'coso_name'=>$coso_name,
            'bangdiem_id'=>$bangdiem_id,
            'bangdiem'=>$bangdiem,
            'tieuchi'=> $tieuchi,

            ]);
    }

    public function get_value_hoatdong(){
        // $auth_id = Auth::user()->id;
        $current_term = DB::table('bangdiem')->orderBy('ngayketthuc','DESC')->first();
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
        //tên cơ sở
        $auth_id = Auth::user()->id;
        $coso_id_hoatdong = DB::table('sv_coso')->where('sv_id',$auth_id)->get('id');
        foreach($coso_id_hoatdong as $item){
            $current_coso_id = $item->id;
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
        // $data_phongtrao_hoatdong = array();
        // $current_hoat_dong_id = DB::table('hoatdong')->orderBy('id','DESC')->first()->id;
        // $data_phongtrao_hoatdong['phongtrao_id'] = $request->input_phongtrao_id_hoatdong;
        // $data_phongtrao_hoatdong['hoatdong_id'] = $current_hoat_dong_id;
        // $data_phongtrao_hoatdong['status'] = 1;
        // $data_phongtrao_hoatdong['nguoiduyet'] = $nguoi_tao_duyet;
        // DB::table('phongtrao_hoatdong')->insert($data_phongtrao_hoatdong);
        //insert table coso_hoatdong
        // $data_coso_hoatdong = array();
        // $current_id_bangdiem = $request->current_id_bangdiem;
        // // dd($current_id_bangdiem);
        // $current_doituong_id = DB::table('bangdiem_doituong')->where('bangdiem_id',$current_id_bangdiem)->get('doituong_id');
        // // dd($current_doituong_id);
       
        // foreach($current_doituong_id as $item){
        //     $doi_tuong_id[] = $item->doituong_id;
        // }
        // // dd($doi_tuong_id);
        // foreach($doi_tuong_id as $item){
        //     $current_coso_id[] = DB::table('coso')->where('doituong_id',$item)->get();
        // }
        // foreach($data_hoatdong_coso as $key=>$value){
        //     if($value==='TẤT CẢ'){
        //         foreach($current_coso_id as $item){
        //             foreach($item as $key=>$value){
        //                 $data_coso_hoatdong['coso_id'] = $value->id;
        //                 $data_coso_hoatdong['hoatdong_id'] = $current_hoat_dong_id;
        //                 DB::table('coso_hoatdong')->insert($data_coso_hoatdong);
        //             }
                    
        //         }
        //         Session::put('message','Thêm hoạt động thành công.');
        //         return Redirect::to('quanlihoatdong');
        //     }
        // }
        // // lay co so
        // $coso_id = array();
        // foreach($data_hoatdong_coso as $key=>$value){
        //         $coso[] = DB::table('coso')->where('name',$value)->get('id');
        //    }
        // //tim id co so
        // foreach($coso as $row){
        //     foreach($row as $item){
        //         $coso_id[] = $item->id;
        //     }
        // }
        // // insert coso_hoatdong
        // foreach($coso_id as $key){
        //     $data_coso_hoatdong['coso_id'] = $key;
        //     $data_coso_hoatdong['hoatdong_id'] = $current_hoat_dong_id;
        //     DB::table('coso_hoatdong')->insert($data_coso_hoatdong);
        // }
        Session::put('message','Thêm hoạt động thành công.');
        return back();
    }
    
}
