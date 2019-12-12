<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use DB;




class ctsvController extends Controller
{	
    //GET
    public function get_value_quanlibangdiem(){
        $loaibangdiem = DB::table('loaibangdiem')->get();
        $doituong = DB::table('doituong')->get();
        return view('ctsv.quanlibangdiem',[
            'loaibangdiem'=>$loaibangdiem,
            'doituong'=>$doituong,
            ]);
    }
    public function get_value_quanlitieuchi(){
        $loaibangdiem = DB::table('loaibangdiem')->get();
        $bangdiem = DB::table('bangdiem')->get();
        return view('ctsv.quanlitieuchi',[
            'loaibangdiem'=>$loaibangdiem,
            'bangdiem'=>$bangdiem,
        ]);
    }
    public function get_value_quanliphongtrao(){
        $loaibangdiem = DB::table('loaibangdiem')->get();
        $bangdiem = DB::table('bangdiem')->get();
        return view('ctsv.quanliphongtrao',[
            'loaibangdiem'=>$loaibangdiem,
            'bangdiem'=>$bangdiem,
        ]);
    }
    public function get_value_quanlihoatdong(){
        $loaibangdiem = DB::table('loaibangdiem')->get();
        $bangdiem = DB::table('bangdiem')->get();
        return view('ctsv.quanlihoatdong',[
            'loaibangdiem'=>$loaibangdiem,
            'bangdiem'=>$bangdiem,
        ]);
    }

    
    
    //POST
    //--Thêm loại bảng điểm
    public function insert_loai_bang_diem(Request $request){
        $data = array();
        $data['name'] = $request->input_loaibangdiem;
        DB::table('loaibangdiem')->insert($data);
        Session::put('message','Thêm loại bảng điểm thành công.');
        return Redirect::to('quanlibangdiem');
    }
    //--Xóa loại bảng điểm
    public function delete_loai_bang_diem($id){
        DB::table('loaibangdiem')->where('id',$id)->delete();
        Session::put('message','Xóa loại bảng điểm thành công.');
        return Redirect::to('quanlibangdiem');
    }
    //--Thêm bảng điểm
    public function insert_bang_diem(Request $request){
        //insert table bangdiem
        $data_bangdiem = array();
        $data_bangdiem['name'] = $request->input_name_bangdiem;
        $data_bangdiem['loaibangdiem_id'] = $request->input_loaibangdiem_id_bangdiem;
        $data_bangdiem['maxbangdiem'] = $request->input_maxbangdiem_bangdiem;
        $data_bangdiem['ngaybatdau'] = $request->input_ngaybatdau_bangdiem;
        $data_bangdiem['ngayketthuc'] = $request->input_ngayketthuc_bangdiem;
        DB::table('bangdiem')->insert($data_bangdiem);
        //insert table bangdiem_doituong
        $current_bangdiem = DB::table('bangdiem')->orderBy('id','DESC')->first()->id;
        $doituong = $request->doituong;
        dd($doituong);
        foreach($doituong as $key=>$value){
            DB::table('bangdiem_doituong')->insert(array(
                //insert nhiều dòng 
                array('bangdiem_id'=> $current_bangdiem, 'doituong_id'=> $value)
            ));
        }
        Session::put('message','Thêm bảng điểm thành công.');
        return Redirect::to('quanlibangdiem');
    }    
    //--Thêm tiêu chí
    public function insert_tieu_chi_quanlitieuchi(Request $request){
        //insert table tieuchi
        $data = array();
        $data['name'] = $request->input_name_tieuchi;
        $data['bangdiem_id'] = $request->input_bangdiem_id_tieuchi;
        $data['maxtieuchi'] = $request->input_maxtieuchi_tieuchi;
        DB::table('tieuchi')->insert($data);
        Session::put('message','Thêm tiêu chí thành công.');
        return Redirect::to('quanlitieuchi');
    }
    //--Xóa tiêu chí
    public function delete_tieu_chi_quanlitieuchi($id){
        DB::table('tieuchi')->where('id',$id)->delete();
        Session::put('message','Xóa tiêu chí thành công.');
        return Redirect::to('quanlitieuchi');
    }
    //--Thêm phong trào
    public function insert_phong_trao_quanliphongtrao(Request $request){
        //insert table phongtrao
        $data = array();
        $data['name'] = $request->input_name_phongtrao;
        $data['maxphongtrao'] = $request->input_maxphongtrao_phongtrao;
        DB::table('phongtrao')->insert($data);
        //insert table tieuchi_phongtrao
        $data_tieuchi_phongtrao = array();
        $current_phongtrao_id = DB::table('phongtrao')->orderBy('id','DESC')->first()->id;
        $data_tieuchi_phongtrao['phongtrao_id'] = $current_phongtrao_id;
        $data_tieuchi_phongtrao['tieuchi_id'] = $request->input_tieuchi_id;
        DB::table('tieuchi_phongtrao')->insert($data_tieuchi_phongtrao);
        Session::put('message','Thêm phong trào thành công.');
        return Redirect::to('quanliphongtrao');
    }
    //--Xóa phong trào
    public function delete_phong_trao_quanliphongtrao($id){
        DB::table('tieuchi_phongtrao')->where('phongtrao_id',$id)->delete();
        DB::table('phongtrao')->where('id',$id)->delete();
        Session::put('message','Xóa phong trào thành công.');
        return Redirect::to('quanliphongtrao');
    }
    //--Thêm hoạt động
    public function insert_hoat_dong_quanlihoatdong(Request $request){
        //insert table hoatdong
        
        $data_hoatdong = array();
        $nguoi_tao_duyet = Auth::user()->name;
        $data_hoatdong['name'] = $request->input_name_hoatdong;
        $data_hoatdong['diem'] = $request->input_diem_hoatdong;
        $data_hoatdong['doituong'] = $request->input_doituong_hoatdong;
        // tách chuỗi
        $data_hoatdong_coso = explode("-",$data_hoatdong['doituong']);
        $data_hoatdong['ngaybatdau'] = $request->input_ngaybatdau_hoatdong;
        $data_hoatdong['ngayketthuc'] = $request->input_ngayketthuc_hoatdong;
        $data_hoatdong['nguoitao'] = $nguoi_tao_duyet;
        $data_hoatdong['nguoiduyet'] = $nguoi_tao_duyet;
        $data_hoatdong['status_clone'] = 1;
        DB::table('hoatdong')->insert($data_hoatdong);
        //insert table phongtrao_hoatdong
        $data_phongtrao_hoatdong = array();
        $current_hoat_dong_id = DB::table('hoatdong')->orderBy('id','DESC')->first()->id;
        $data_phongtrao_hoatdong['phongtrao_id'] = $request->input_phongtrao_id_hoatdong;
        $data_phongtrao_hoatdong['hoatdong_id'] = $current_hoat_dong_id;
        $data_phongtrao_hoatdong['status'] = 1;
        $data_phongtrao_hoatdong['nguoiduyet'] = $nguoi_tao_duyet;
        DB::table('phongtrao_hoatdong')->insert($data_phongtrao_hoatdong);
        //insert table coso_hoatdong
        $data_coso_hoatdong = array();
        $current_id_bangdiem = $request->current_id_bangdiem;
        // dd($current_id_bangdiem);
        // $current_id_bangdiem= DB::table('bangdiem')->where('name',$current_name_bangdiem);
        // dd($current_id_bangdiem);
        $current_doituong_id = DB::table('bangdiem_doituong')->where('bangdiem_id',$current_id_bangdiem)->get('doituong_id');
        // dd($current_doituong_id);
       
        foreach($current_doituong_id as $item){
            $doi_tuong_id[] = $item->doituong_id;
        }
        // dd($doi_tuong_id);
        foreach($doi_tuong_id as $item){
            $current_coso_id = DB::table('coso')->where('doituong_id',$item)->get();
        }
        
        // dd($current_coso_id);
        foreach($data_hoatdong_coso as $key=>$value){
            if($value==='TẤT CẢ'){
                foreach($current_coso_id as $item){
                    $data_coso_hoatdong['coso_id'] = $item->id;
                    $data_coso_hoatdong['hoatdong_id'] = $current_hoat_dong_id;
                }
               
            }
           else{
                $coso_id = DB::table('coso')->where('name',$value)->get('id');
                $data_coso_hoatdong['coso_id'] = $coso_id;
                $data_coso_hoatdong['hoatdong_id'] = $current_hoat_dong_id;
           }
        }
        DB::table('coso_hoatdong')->insert($data_coso_hoatdong);
      
        // $i = 0;
        // foreach($data_hoatdong_coso as $key=>$value){
        //     if($value==='TẤT CẢ')
        //     {
        //         $i = 1;
        //     }
        // }

        // if($i==0){

        // }
        // else
        // {

        // }
        Session::put('message','Thêm hoạt động thành công.');
        return Redirect::to('quanlihoatdong');
    }
    //--Xóa hoạt động
    public function delete_hoat_dong_quanlihoatdong(Request $request){
        //delete 2 table phongtrao_hoatdong & hoatdong
        $check = $request->check;
        //dd($check);
        foreach($check as $key => $value){
            //dd($value);
            DB::table('phongtrao_hoatdong')->where('hoatdong_id',$value)->delete();
            DB::table('hoatdong')->where('id',$value)->delete();
        }
        Session::put('message','Xóa hoạt động thành công.');
        return Redirect::to('quanlihoatdong');
    }    

}
