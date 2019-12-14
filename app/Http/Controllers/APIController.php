<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class APIController extends Controller
{	//SINHVIEN
    //--DASHBOARD
    function GetTieuChi_dashboard(Request $request){
        // $auth_id = Auth::user()->id;
        $term = $request->term;
        $tieuChi = DB::table('tieuchi')->where('bangdiem_id', $term)->get();
        return $tieuChi;
    }
    //--THAM GIA HOAT DONG
    function GetPhongTrao_thamgiahoatdong(Request $request){
        $tieu_chi_id = $request->tieu_chi_id;
        //get phong trào ở học kì hiện tại
        $phong_trao = DB::table('phongtrao')->join('tieuchi_phongtrao', 'phongtrao.id','=','tieuchi_phongtrao.phongtrao_id')
        ->where('tieuchi_phongtrao.tieuchi_id',$tieu_chi_id)->get();
        return $phong_trao;
    }
    //--FEEDBACK
    function GetPhongTrao_feedback(Request $request){
        $tieu_chi_id = $request->tieu_chi_id;
        $phong_trao = DB::table('phongtrao')->join('tieuchi_phongtrao', 'phongtrao.id', '=', 'tieuchi_phongtrao.phongtrao_id')
        ->where('tieuchi_phongtrao.tieuchi_id', $tieu_chi_id)->get();
        return $phong_trao;
    }
    function GetHoatDong_feedback(Request $request){
        $phong_trao_id = $request->phong_trao_id;
        $hoat_dong = DB::table('hoatdong')->join('phongtrao_hoatdong', 'hoatdong.id', '=', 'phongtrao_hoatdong.hoatdong_id')
        ->where('phongtrao_hoatdong.phongtrao_id', $phong_trao_id)->get();
        return $hoat_dong;
    }
    //CTSV
    //--Quản lý tiêu chí
    function GetBangDiem_quanlitieuchi(Request $request){
        $loai_bang_diem_id = $request->loai_bang_diem_id;
        $bang_diem = DB::table('bangdiem')->where('loaibangdiem_id', $loai_bang_diem_id)->get();
        return $bang_diem;
    }
    function GetTieuChi_quanlitieuchi(Request $request){
        $bang_diem_id = $request->bang_diem_id;
        $tieu_chi = DB::table('tieuchi')->where('bangdiem_id', $bang_diem_id)->get();
        return $tieu_chi;
    }
    //--Quản lý phong trào
    function GetBangDiem_quanliphongtrao(Request $request){
        $loai_bang_diem_id = $request->loai_bang_diem_id;
        $bang_diem = DB::table('bangdiem')->where('loaibangdiem_id', $loai_bang_diem_id)->get();
        return $bang_diem;
    }
    function GetTieuChi_quanliphongtrao(Request $request){
        $bang_diem_id = $request->bang_diem_id;
        $tieu_chi = DB::table('tieuchi')->where('bangdiem_id', $bang_diem_id)->get();
        return $tieu_chi;
    }
    function GetPhongTrao_quanliphongtrao(Request $request){
        $tieu_chi_id = $request->tieu_chi_id;
        $phong_trao = DB::table('phongtrao')->join('tieuchi_phongtrao', 'phongtrao.id', '=', 'tieuchi_phongtrao.phongtrao_id')
        ->where('tieuchi_phongtrao.tieuchi_id', $tieu_chi_id)->get();
        return $phong_trao;
    }

    function GetBangDiem_quanlihoatdong(Request $request){
        $loai_bang_diem_id = $request->loai_bang_diem_id;
        $bang_diem = DB::table('bangdiem')->where('loaibangdiem_id', $loai_bang_diem_id)->get();
        return $bang_diem;
    }
    function GetTieuChi_quanlihoatdong(Request $request){
        $bang_diem_id = $request->bang_diem_id;
        $tieu_chi = DB::table('tieuchi')->where('bangdiem_id', $bang_diem_id)->get();
        return $tieu_chi;
    }
    function GetPhongTrao_quanlihoatdong(Request $request){
        $tieu_chi_id = $request->tieu_chi_id;
        $phong_trao = DB::table('phongtrao')->join('tieuchi_phongtrao', 'phongtrao.id', '=', 'tieuchi_phongtrao.phongtrao_id')
        ->where('tieuchi_phongtrao.tieuchi_id', $tieu_chi_id)->get();
        return $phong_trao;
    }
    function GetHoatDong_quanlihoatdong(Request $request){
        $phong_trao_id = $request->phong_trao_id;
        $hoat_dong = DB::table('hoatdong')->join('phongtrao_hoatdong', 'hoatdong.id', '=', 'phongtrao_hoatdong.hoatdong_id')
        ->where('phongtrao_hoatdong.phongtrao_id', $phong_trao_id)->get();
        return $hoat_dong;
    }
     //--Quản lý cơ sở
     function GetCoSo_quanlicoso(Request $request){
        $doi_tuong_id = $request->doi_tuong_id;
        $co_so = DB::table('coso')->where('doituong_id', $doi_tuong_id)->get();
        return $co_so;
    }
    //--Quản lý sinhvien
    function GetCoSo_quanlisinhvien(Request $request){
        $doituong_id = $request->doituong_id;
        $co_so = DB::table('coso')->where('doituong_id', $doituong_id)->get();
        return $co_so;
    }
    function GetUsers_quanlisinhvien(Request $request){
        $coso_id = $request->coso_id;
        $users = DB::table('users')->join('sv_coso', 'users.id', '=', 'sv_coso.sv_id')
        ->where('sv_coso.coso_id', $coso_id)->get();
        return $users;
    }
    //--Xét duyệt hoạt động
    function GetHoatDong_duyethoatdong(Request $request){
        $bangdiem_id = $request->bangdiem_id;

        //attributes
        $tieu_chi_id = '';

        $tieuchi_id = DB::table('tieuchi')->where('bangdiem_id',$bangdiem_id)->get();
        
        foreach($tieuchi_id as $item)
        {
            $tieu_chi_id = $tieu_chi_id.$item->id.',';
        }
        $phong_trao_id = ''; 
        foreach(explode(',', $tieu_chi_id) as $item)
        {
            $phongtrao_id = DB::table('tieuchi_phongtrao')->where('tieuchi_id',$item)->get();
            foreach($phongtrao_id as $item)
            {
                $phong_trao_id = $phong_trao_id.$item->id.',';
               
            }  
        }
        $hoat_dong_id = ''; 
        foreach(explode(',', $phong_trao_id) as $item)
        {
            $hoatdong_id = DB::table('phongtrao_hoatdong')->where('phongtrao_id',$item)->get();
            
            foreach($hoatdong_id as $item)
            {
                $hoat_dong_id = $hoat_dong_id.$item->hoatdong_id.',';
               
            }  
        }
        
        foreach(explode(',', $hoat_dong_id) as $item)
        {
            $temp[] = DB::table('hoatdong')->where('id',$item)->where('status_clone',0)->get();
        }
        $current_hoatdong = array();
        foreach($temp as $key=>$value)
        {
            foreach($value as $row=>$i)
            {
                $current_hoatdong[] = $i;
            }
        }
        
        return $current_hoatdong;
        
    }
}
