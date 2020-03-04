<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class APIController extends Controller
{	//SINHVIEN
    //--DASHBOARD
    function GetTieuChi_dashboard(Request $request){
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }

        $term = $request->term;
        $tieu_chi = DB::table('tieuchi')->where('bangdiem_id', $term)->get();
        $max_bangdiem_tieuchi_id = DB::table('tieuchi')->where('bangdiem_id',$term)->select('tieuchi.id','tieuchi.maxtieuchi')->get();
        $max_bangdiem_tieuchi_id = end($max_bangdiem_tieuchi_id);
        $diem_tieuchi = array();
        foreach ($max_bangdiem_tieuchi_id as $key => $value){
            
            // lấy max phong trào trong từng phong trào có mã tiêu chí hiện tại.
            $diemphongtrao = array();
            $maxphongtrao = DB::table('phongtrao')
            ->join('tieuchi_phongtrao','phongtrao.id','=','tieuchi_phongtrao.phongtrao_id')
            ->where('tieuchi_phongtrao.tieuchi_id',$value->id)
            ->select('phongtrao.id','phongtrao.maxphongtrao')->get()->toArray();
            
            foreach($maxphongtrao as $item => $row){

                $diemcong = DB::table('phongtrao')
                ->join('phongtrao_hoatdong','phongtrao.id','=','phongtrao_hoatdong.phongtrao_id')
                ->join('hoatdong','phongtrao_hoatdong.hoatdong_id','=','hoatdong.id')
                ->join('user_hoatdong','hoatdong.id','=','user_hoatdong.hoatdong_id')
                ->where([
                        ['phongtrao.id','=',$row->id],
                        ['user_hoatdong.sv_id', '=', $auth_id],
                        ['hoatdong.status_clone','=',1],
                        ['user_hoatdong.heso', '=', 1],
                        ])
                ->sum('hoatdong.diem');
                
                $diemtru = DB::table('phongtrao')
                ->join('phongtrao_hoatdong','phongtrao.id','=','phongtrao_hoatdong.phongtrao_id')
                ->join('hoatdong','phongtrao_hoatdong.hoatdong_id','=','hoatdong.id')
                ->join('user_hoatdong','hoatdong.id','=','user_hoatdong.hoatdong_id')
                ->where([
                        ['phongtrao.id','=',$row->id],
                        ['user_hoatdong.sv_id', '=', $auth_id],
                        ['hoatdong.status_clone','=',1],
                        ['user_hoatdong.heso', '=', -1],
                        ])
                ->sum('hoatdong.diem');
                $sum_hoatdong = 0;
                $sum_hoatdong = intval($diemcong)-intval($diemtru);
                if($sum_hoatdong>$row->maxphongtrao)
                {
                    $sum_hoatdong = $row->maxphongtrao;
                }

                $diemphongtrao[] = array(
                    'phongtrao_id' => $row->id,
                    'diem' => $sum_hoatdong
                );
            }

            // check max tiêu chí.
            $sum_phongtrao = 0;
            foreach($diemphongtrao as $item => $row){
                $sum_phongtrao += intval($row['diem']);
                
            }

            if($sum_phongtrao>$value->maxtieuchi){
                $sum_phongtrao = $value->maxtieuchi;
            }
            
            $diem_tieuchi[] = $sum_phongtrao;
        }

        $temp = array();
        foreach($tieu_chi as $key=>$value)
        {
            $temp[] = array(
                'id'=>$value->id,
                'name'=>$value->name,
                'maxtieuchi'=>$value->maxtieuchi,
                'sum_tieuchi'=>$diem_tieuchi[$key]
            );
        }
       
        return $temp;
    }

    function GetSumBangDiem_dashboard(Request $request){

        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }

        $term = $request->term;
        $max_bangdiem_tieuchi_id = DB::table('tieuchi')->where('bangdiem_id',$term)->select('tieuchi.id','tieuchi.maxtieuchi')->get();
        $max_bangdiem_tieuchi_id = end($max_bangdiem_tieuchi_id);
        $diem_tieuchi = array();
        foreach ($max_bangdiem_tieuchi_id as $key => $value){
            
            // lấy max phong trào trong từng phong trào có mã tiêu chí hiện tại.
            $diemphongtrao = array();
            $maxphongtrao = DB::table('phongtrao')
            ->join('tieuchi_phongtrao','phongtrao.id','=','tieuchi_phongtrao.phongtrao_id')
            ->where('tieuchi_phongtrao.tieuchi_id',$value->id)
            ->select('phongtrao.id','phongtrao.maxphongtrao')->get()->toArray();
            
            foreach($maxphongtrao as $item => $row){

                $diemcong = DB::table('phongtrao')
                ->join('phongtrao_hoatdong','phongtrao.id','=','phongtrao_hoatdong.phongtrao_id')
                ->join('hoatdong','phongtrao_hoatdong.hoatdong_id','=','hoatdong.id')
                ->join('user_hoatdong','hoatdong.id','=','user_hoatdong.hoatdong_id')
                ->where([
                        ['phongtrao.id','=',$row->id],
                        ['user_hoatdong.sv_id', '=', $auth_id],
                        ['hoatdong.status_clone','=',1],
                        ['user_hoatdong.heso', '=', 1],
                        ])
                ->sum('hoatdong.diem');
                
                $diemtru = DB::table('phongtrao')
                ->join('phongtrao_hoatdong','phongtrao.id','=','phongtrao_hoatdong.phongtrao_id')
                ->join('hoatdong','phongtrao_hoatdong.hoatdong_id','=','hoatdong.id')
                ->join('user_hoatdong','hoatdong.id','=','user_hoatdong.hoatdong_id')
                ->where([
                        ['phongtrao.id','=',$row->id],
                        ['user_hoatdong.sv_id', '=', $auth_id],
                        ['hoatdong.status_clone','=',1],
                        ['user_hoatdong.heso', '=', -1],
                        ])
                ->sum('hoatdong.diem');
                $sum_hoatdong = 0;
                $sum_hoatdong = intval($diemcong)-intval($diemtru);
                if($sum_hoatdong<0) 
                {
                    $sum_hoatdong=0;
                }
                if($sum_hoatdong>$row->maxphongtrao)
                {
                    $sum_hoatdong = $row->maxphongtrao;
                }

                $diemphongtrao[] = array(
                    'phongtrao_id' => $row->id,
                    'diem' => $sum_hoatdong
                );
            }

            // check max tiêu chí.
            $sum_phongtrao = 0;
            foreach($diemphongtrao as $item => $row){
                $sum_phongtrao += intval($row['diem']);
                
            }

            if($sum_phongtrao>$value->maxtieuchi){
                $sum_phongtrao = $value->maxtieuchi;
            }
            
            $diem_tieuchi[] = $sum_phongtrao;
        }
        $sum = 0;
        foreach ($diem_tieuchi as $key => $value)
        {
            $sum += $value;
        }
        return $sum;
    }

    function GetCoSo_dashboard(Request $request){
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
        //get si_so
        $coso_id = DB::table('sv_coso')->where('sv_id', $auth_id)->first('coso_id')->coso_id;
        $siso = DB::table('coso')->where('id', $coso_id)->first('siso')->siso;
        $coso_name = DB::table('coso')->where('id', $coso_id)->first('name')->name;
        //doituong_id của user hiện tại
        $doituong_id = DB::table('coso')->where('id',$coso_id)->first('doituong_id')->doituong_id;
        //các bảng điểm thuộc doituong_id
        $bangdiem_id = $request->term;;
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
                $loai = '';
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
                        if($sum<0){$sum=0;}
                }
                $avr = $sum / count($bangdiem_id);
                $avr = round($avr,2);
                // lấy xếp loại
                foreach($bangdiem_id as $key => $value){
                    $xeploai = DB::table('xeploai')
                    ->join('loaibangdiem','xeploai.loaibangdiem_id','=','loaibangdiem.id')
                    ->join('bangdiem','loaibangdiem.id','=','bangdiem.loaibangdiem_id')
                    ->where('bangdiem.id',$value->bangdiem_id)->select('xeploai.name','cantren','canduoi')->get();
                }
                foreach($xeploai as $key => $value){
                    if($avr < $value->cantren && $avr >= $value->canduoi){
                        $loai = $value->name;
                    }
                }
                if($loai === ''){
                    $max = 0;
                    $min = 0;
                    foreach($xeploai as $key => $value){
                        if($key === 0){
                            $max = $value->cantren;
                            $min = $value->canduoi;
                        }
                        else{
                            if($max<$value->cantren) $max = $value->cantren;
                            if($min>$value->canduoi) $min = $value->canduoi; 
                        }
                    }
                    if($avr > $max) $loai = 'Xuất sắc';
                    if($avr < $min) $loai = 'Kém';
                }
                $xephang[] = array('id'=>$item->id,'xep_loai'=>$loai,'trung_binh'=>$avr);
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
                    'xep_loai'=>$value['xep_loai'],
                    'trung_binh' => $value['trung_binh'],
                    'xep_hang'=>$hang
                    );
                }
            }
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
        ->where([['phongtrao_hoatdong.phongtrao_id', $phong_trao_id],['hoatdong.status_clone',1]])->get();
        return $hoat_dong;
    }
    //Replies
    function GetComment_Id_feedback(Request $request){
        $comment_id[] = $request->comment_id;
        foreach($comment_id as $item)
        {
            $replies = DB::table('replies')->where('comment_id',$item)->get();
        }
        return $replies;
    }
    //CTSV
    //--Quản lý tiêu chí
    function GetBangDiem_quanlitieuchi(Request $request){
        $loai_bang_diem_id = $request->loai_bang_diem_id;
        $bang_diem = DB::table('bangdiem')->where('loaibangdiem_id', $loai_bang_diem_id)->get();
        return $bang_diem;
    }
    function GetCoSo_phanhoictsv(Request $request){
        $doituong_id = $request->doituong_id;
        $co_so = DB::table('coso')->where('doituong_id', $doituong_id)->get();
        return $co_so;
    }
    //
     function GetFeedbackCtsv_phanhoictsv(Request $request){
        $coso_id = $request->coso_id;
        // $coso_id = 1;
        $x = array();
        $sv_coso = DB::table('sv_coso')->where('coso_id',$coso_id)->get();
        foreach($sv_coso as $key=>$value)
        {
            $posts[] = DB::table('posts')
            ->join('users','posts.sv_id','=','users.id')->where('posts.sv_id',$value->sv_id)
            ->select('posts.*','users.email')->get();
        }
        foreach($posts as $item){
            foreach($item as $key=>$value)
            {

                array_push($x,$value);
            }
        }
        
        return $x;
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
    function GetThongKe_thongkeloptruong(Request $request){
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }

        $coso_id = DB::table('sv_coso')->where('sv_id', $auth_id)->first('coso_id')->coso_id;
        $term = $request->term_id;

         //danh sach sinh vien
        $sinhvien_chuyen_lop = DB::table('users')
        ->join('sinhvien_bangdiem_coso','users.id','=','sinhvien_bangdiem_coso.sv_id')
        ->where([
            ['sinhvien_bangdiem_coso.bangdiem_id','=',$term],
            ['sinhvien_bangdiem_coso.coso_id','=',$coso_id]
        ])
        ->select('users.id','users.name','users.email');

        $sinhvien = DB::table('users')
        ->join('sv_coso','users.id','=','sv_coso.sv_id')
        ->join('user_role','users.id','=','user_role.sv_id')
        ->where([
            ['sv_coso.coso_id','=',$coso_id],
            ['user_role.role_id','<',3]
        ])
        ->select('users.id','users.name','users.email')
        ->union($sinhvien_chuyen_lop)
        ->get();

        
        
        //tong diem tung sinh vien
        if(count($sinhvien)>0){
           
            foreach($sinhvien as $index => $id){
                $max_bangdiem_tieuchi_id = DB::table('tieuchi')->where('bangdiem_id',$term)->select('tieuchi.id','tieuchi.maxtieuchi')->get();
                $max_bangdiem_tieuchi_id = end($max_bangdiem_tieuchi_id);
                $diem_tieuchi = array();
                foreach ($max_bangdiem_tieuchi_id as $key => $value){
                    
                    // lấy max phong trào trong từng phong trào có mã tiêu chí hiện tại.
                    $diemphongtrao = array();
                    $maxphongtrao = DB::table('phongtrao')
                    ->join('tieuchi_phongtrao','phongtrao.id','=','tieuchi_phongtrao.phongtrao_id')
                    ->where('tieuchi_phongtrao.tieuchi_id',$value->id)
                    ->select('phongtrao.id','phongtrao.maxphongtrao')->get()->toArray();
                    
                    foreach($maxphongtrao as $item => $row){

                        $diemcong = DB::table('phongtrao')
                        ->join('phongtrao_hoatdong','phongtrao.id','=','phongtrao_hoatdong.phongtrao_id')
                        ->join('hoatdong','phongtrao_hoatdong.hoatdong_id','=','hoatdong.id')
                        ->join('user_hoatdong','hoatdong.id','=','user_hoatdong.hoatdong_id')
                        ->where([
                                ['phongtrao.id','=',$row->id],
                                ['user_hoatdong.sv_id', '=', $id->id],
                                ['hoatdong.status_clone','=',1],
                                ['user_hoatdong.heso', '=', 1],
                                ])
                        ->sum('hoatdong.diem');
                        
                        $diemtru = DB::table('phongtrao')
                        ->join('phongtrao_hoatdong','phongtrao.id','=','phongtrao_hoatdong.phongtrao_id')
                        ->join('hoatdong','phongtrao_hoatdong.hoatdong_id','=','hoatdong.id')
                        ->join('user_hoatdong','hoatdong.id','=','user_hoatdong.hoatdong_id')
                        ->where([
                                ['phongtrao.id','=',$row->id],
                                ['user_hoatdong.sv_id', '=', $id->id],
                                ['hoatdong.status_clone','=',1],
                                ['user_hoatdong.heso', '=', -1],
                                ])
                        ->sum('hoatdong.diem');
                        $sum_hoatdong = 0;
                        $sum_hoatdong = intval($diemcong)-intval($diemtru);
                        if($sum_hoatdong<0){$sum_hoatdong=0;}
                        if($sum_hoatdong>$row->maxphongtrao)
                        {
                            $sum_hoatdong = $row->maxphongtrao;
                        }
                        
                        $diemphongtrao[] = array(
                            'phongtrao_id' => $row->id,
                            'diem' => $sum_hoatdong
                        );
                    }

                    

                    // check max tiêu chí.
                    $sum_phongtrao = 0;
                    foreach($diemphongtrao as $item => $row){
                        $sum_phongtrao += intval($row['diem']);
                        
                    }

                    if($sum_phongtrao>$value->maxtieuchi){
                        $sum_phongtrao = $value->maxtieuchi;
                    }
                    
                    $diem_tieuchi[] = $sum_phongtrao;
                }
                
                $sum = 0;
                foreach ($diem_tieuchi as $key => $value)
                {
                    $sum += $value;
                }
                $diem[] = $sum;
                
            }
            
        
            //xep loai
            $xeploaidiem = DB::table('bangdiem')
            ->join('loaibangdiem','bangdiem.loaibangdiem_id','=','loaibangdiem.id')
            ->join('xeploai','loaibangdiem.id','=','xeploai.loaibangdiem_id')
            ->where('bangdiem.id',$term)
            ->select('xeploai.name','cantren','canduoi')->get();
            
            if(count($diem)>0){
                foreach($diem as $index => $value){
                    $xeploai = '';
                    foreach($xeploaidiem as $key => $item){
                        if($value<=$item->cantren && $value>=$item->canduoi){
                            $xeploai = $item->name;
                        }
                    }
                    if($xeploai === ''){
                        $max = 0;
                        $min = 0;
                        foreach($xeploaidiem as $key => $item){
                            if($key === 0){
                                $max = $item->cantren;
                                $min = $item->canduoi;
                            }
                            else{
                                if($max<$item->cantren) $max = $item->cantren;
                                if($min>$item->canduoi) $min = $item->canduoi; 
                            }
                        }
                        if($value > $max) $xeploai = 'Xuất sắc';
                        if($value < $min) $xeploai = 'Kém';
                    }
                    $xeploaisinhvien[] = $xeploai;
                }
            }

            foreach($sinhvien as $key => $value){
                $mssv = explode('@',$value->email);
                $danhsachdiem[] = collect([
                    'id' => $value->id,
                    'name' => $value->name,
                    'mssv' => $mssv[0],
                    'diem' => $diem[$key],
                    'xeploai'=> $xeploaisinhvien[$key]
                ]);
            }
        }
        return $danhsachdiem;
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
        $users = DB::table('users')
        ->join('sv_coso', 'users.id', '=', 'sv_coso.sv_id')
        ->join('user_role','users.id','user_role.sv_id')
        ->where([['sv_coso.coso_id', $coso_id],
                ['user_role.role_id','<',3]])->get();
        return $users;
    }
    function Load_Account_quanlisinhvien(Request $request){
        $co_so_id = $request->co_so_id;
        $users = DB::table('users')->join('sv_coso', 'users.id', '=', 'sv_coso.sv_id')
        ->where('sv_coso.coso_id', $co_so_id)->get();
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
            $temp[] = DB::table('hoatdong')
            ->join('users','hoatdong.nguoitao','=','users.id')
            ->where('hoatdong.id',$item)->where('status_clone',0)
            ->select('hoatdong.*','users.email')
            ->get();
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
     //--Import danh sách sinh viên tham gia hoạt động
     function GetHoatDong_importsinhvienthamgiahoatdong(Request $request){
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
            $temp[] = DB::table('hoatdong')->where('id',$item)->where('status_clone',1)->get();
        }
        $current_hoatdong = array();
        foreach($temp as $key=>$value)
        {
            foreach($value as $row=>$i)
            {
                $phongtrao_name = DB::table('phongtrao')->join('phongtrao_hoatdong', 'phongtrao.id','=','phongtrao_hoatdong.phongtrao_id')
                ->where('phongtrao_hoatdong.hoatdong_id',$i->id)->get();
                foreach($phongtrao_name as $key=>$value){
                    $i->phongtrao_name = $value->name;
                }
                $current_hoatdong[] = $i;
            }
        }
        
        return $current_hoatdong;
    }

    function GetXepLoai_quanlixeploai(Request $request){
        $loai_bang_diem_id = $request->loai_bang_diem_id;
        $xep_loai = DB::table('xeploai')->where('loaibangdiem_id', $loai_bang_diem_id)->get();
        return $xep_loai;
    }
    

    function GetCoSo_thongkectsv(Request $request){
        $term_id = $request->term_id;
        $co_so = DB::table('coso')
        ->join('doituong','coso.doituong_id','=','doituong.id')
        ->join('bangdiem_doituong','doituong.id','=','bangdiem_doituong.doituong_id')
        ->where('bangdiem_doituong.bangdiem_id',$term_id)->select('coso.name','coso.id')->get();
        return $co_so;
    }

    function GetThongKe_thongkectsv(Request $request){
        

        $coso_id = $request->co_so_id;
        $term_id = $request->bangdiem_id;

         //danh sach sinh vien
        $sinhvien = DB::table('users')
        ->join('sv_coso','users.id','=','sv_coso.sv_id')
        ->join('user_role','users.id','=','user_role.sv_id')
        ->where([
            ['sv_coso.coso_id','=',$coso_id],
            ['user_role.role_id','<',3]
        ])
        ->select('users.id','users.name','users.email')
        ->get();

        
        //tong diem tung sinh vien
        $diem = array();
        if(count($sinhvien)>0){
            foreach($sinhvien as $index => $sv){
                $sum = 0;
                $max_bangdiem_tieuchi_id = DB::table('tieuchi')->where('bangdiem_id',$term_id)->select('tieuchi.id','tieuchi.maxtieuchi')->get();
                $max_bangdiem_tieuchi_id = end($max_bangdiem_tieuchi_id);
                $diem_tieuchi = array();
                foreach ($max_bangdiem_tieuchi_id as $key => $value){
                    
                    // lấy max phong trào trong từng phong trào có mã tiêu chí hiện tại.
                    $diemphongtrao = array();
                    $maxphongtrao = DB::table('phongtrao')
                    ->join('tieuchi_phongtrao','phongtrao.id','=','tieuchi_phongtrao.phongtrao_id')
                    ->where('tieuchi_phongtrao.tieuchi_id',$value->id)
                    ->select('phongtrao.id','phongtrao.maxphongtrao')->get()->toArray();
                    
                    foreach($maxphongtrao as $item => $row){

                        $diemcong = DB::table('phongtrao')
                        ->join('phongtrao_hoatdong','phongtrao.id','=','phongtrao_hoatdong.phongtrao_id')
                        ->join('hoatdong','phongtrao_hoatdong.hoatdong_id','=','hoatdong.id')
                        ->join('user_hoatdong','hoatdong.id','=','user_hoatdong.hoatdong_id')
                        ->where([
                                ['phongtrao.id','=',$row->id],
                                ['user_hoatdong.sv_id', '=', $sv->id],
                                ['hoatdong.status_clone','=',1],
                                ['user_hoatdong.heso', '=', 1],
                                ])
                        ->sum('hoatdong.diem');
                        
                        $diemtru = DB::table('phongtrao')
                        ->join('phongtrao_hoatdong','phongtrao.id','=','phongtrao_hoatdong.phongtrao_id')
                        ->join('hoatdong','phongtrao_hoatdong.hoatdong_id','=','hoatdong.id')
                        ->join('user_hoatdong','hoatdong.id','=','user_hoatdong.hoatdong_id')
                        ->where([
                                ['phongtrao.id','=',$row->id],
                                ['user_hoatdong.sv_id', '=', $sv->id],
                                ['hoatdong.status_clone','=',1],
                                ['user_hoatdong.heso', '=', -1],
                                ])
                        ->sum('hoatdong.diem');
                        $sum_hoatdong = 0;
                        $sum_hoatdong = intval($diemcong)-intval($diemtru);
                        if($sum_hoatdong<0) 
                        {
                            $sum_hoatdong=0;
                        }
                        if($sum_hoatdong>$row->maxphongtrao)
                        {
                            $sum_hoatdong = $row->maxphongtrao;
                        }

                        $diemphongtrao[] = array(
                            'phongtrao_id' => $row->id,
                            'diem' => $sum_hoatdong
                        );
                    }

                    // check max tiêu chí.
                    $sum_phongtrao = 0;
                    foreach($diemphongtrao as $item => $row){
                        $sum_phongtrao += intval($row['diem']);
                        
                    }

                    if($sum_phongtrao>$value->maxtieuchi){
                        $sum_phongtrao = $value->maxtieuchi;
                    }
                    
                    $diem_tieuchi[] = $sum_phongtrao;
                }
                $sum = 0;
                foreach ($diem_tieuchi as $key => $value)
                {
                    $sum += $value;
                }
                
                $diem[] = $sum;
            }
        

            //xep loai
            $xeploaidiem = DB::table('bangdiem')
            ->join('loaibangdiem','bangdiem.loaibangdiem_id','=','loaibangdiem.id')
            ->join('xeploai','loaibangdiem.id','=','xeploai.loaibangdiem_id')
            ->where('bangdiem.id',$term_id)
            ->select('xeploai.name','cantren','canduoi')->get();
            
            if(count($diem)>0){
                foreach($diem as $index => $value){
                    $xeploai = '';
                    foreach($xeploaidiem as $key => $item){
                        if($value<=$item->cantren && $value>=$item->canduoi){
                            $xeploai = $item->name;
                        }
                    }
                    if($xeploai === ''){
                        $max = 0;
                        $min = 0;
                        foreach($xeploaidiem as $key => $item){
                            if($key === 0){
                                $max = $item->cantren;
                                $min = $item->canduoi;
                            }
                            else{
                                if($max<$item->cantren) $max = $item->cantren;
                                if($min>$item->canduoi) $min = $item->canduoi; 
                            }
                        }
                        if($value > $max) $xeploai = 'Xuất sắc';
                        if($value < $min) $xeploai = 'Kém';
                    }
                    $xeploaisinhvien[] = $xeploai;
                }
            }

            foreach($sinhvien as $key => $value){
                $mssv = explode('@',$value->email);
                $danhsachdiem[] = collect([
                    'id' => $value->id,
                    'name' => $value->name,
                    'mssv' => $mssv[0],
                    'diem' => $diem[$key],
                    'xeploai'=> $xeploaisinhvien[$key]
                ]);
            }
        }
        return $danhsachdiem;
    }
}
