<?php

namespace App\Http\Controllers;

use ArrayObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ExportExcel extends Controller
{
    public function export_diem(Request $request){
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }

        $coso_id = DB::table('sv_coso')->where('sv_id', $auth_id)->first('coso_id')->coso_id;
        $term_id = $request->bang_diem_id;

         //danh sach sinh vien
         $sinhvien_chuyen_lop = DB::table('users')
         ->join('sinhvien_bangdiem_coso','users.id','=','sinhvien_bangdiem_coso.sv_id')
         ->where([
             ['sinhvien_bangdiem_coso.bangdiem_id','=',$term_id],
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
            ->select('xeploai.name','cantren','canduoi')->get()->toArray();

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

            $danhsachdiem[] = collect(['mssv' => 'MSSV','name' => 'Tên','diem'=>'Điểm','xeploai'=>'Xếp loại'])->toArray();
            foreach($sinhvien as $key => $value){
                $mssv = explode('@',$value->email);
                $diem_to_string = strval($diem[$key]);
                $danhsachdiem[] = collect([
                    'mssv' => $mssv[0],
                    'name' => $value->name,
                    'diem' => $diem_to_string,
                    'xeploai'=> $xeploaisinhvien[$key]
                ])->toArray();
            }
     
            Excel::create('data', function($excel) use ($danhsachdiem)
            {
                $excel->sheet('data', function($sheet) use ($danhsachdiem){
                    $sheet->fromArray($danhsachdiem,null,'A1',false,false);
                });
            })->export('xlsx');
        }
    }
    public function export_diem_ctsv(Request $request){

        if(empty($request->co_so_id)||empty($request->bang_diem_id)){
            return back();
        }

        $coso_id = $request->co_so_id;
        $term_id = $request->bang_diem_id;

         //danh sach sinh vien
         //danh sach sinh vien
         $sinhvien_chuyen_lop = DB::table('users')
         ->join('sinhvien_bangdiem_coso','users.id','=','sinhvien_bangdiem_coso.sv_id')
         ->where([
             ['sinhvien_bangdiem_coso.bangdiem_id','=',$term_id],
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
            ->select('xeploai.name','cantren','canduoi')->get()->toArray();

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

            $danhsachdiem[] = collect(['mssv' => 'MSSV','name' => 'Tên','diem'=>'Điểm','xeploai'=>'Xếp loại'])->toArray();
            foreach($sinhvien as $key => $value){
                $mssv = explode('@',$value->email);
                $diem_to_string = strval($diem[$key]);
                $danhsachdiem[] = collect([
                    'mssv' => $mssv[0],
                    'name' => $value->name,
                    'diem' => $diem_to_string,
                    'xeploai'=> $xeploaisinhvien[$key]
                ])->toArray();
            }
     
            Excel::create('data', function($excel) use ($danhsachdiem)
            {
                $excel->sheet('data', function($sheet) use ($danhsachdiem){
                    $sheet->fromArray($danhsachdiem,null,'A1',false,false);
                });
            })->export('xlsx');
        }
    }
    public function export_diem_khoa_ctsv(Request $request){

        if(empty($request->input_khoa_id)||empty($request->bang_diem_id)){
            return back();
        }

        $khoa_id = $request->input_khoa_id;
        $term_id = $request->bang_diem_id;

         //danh sach sinh vien
        $sinhvien_chuyenlop = DB::table('users')
        ->join('sinhvien_bangdiem_coso','users.id','=','sinhvien_bangdiem_coso.sv_id')
        ->join('coso','sinhvien_bangdiem_coso.coso_id','=','coso.id')
        ->join('khoa','coso.khoa_id','=','khoa.id')
        ->where([
            ['khoa.id','=',$khoa_id],
            ['sinhvien_bangdiem_coso.bangdiem_id',$term_id]
        ])->select('users.id','users.name','users.email');
        $sinhvien = DB::table('users')
        ->join('sv_coso','users.id','=','sv_coso.sv_id')
        ->join('user_role','users.id','=','user_role.sv_id')
        ->join('coso','sv_coso.coso_id','=','coso.id')
        ->join('khoa','coso.khoa_id','=','khoa.id')
        ->where([
            ['khoa.id','=',$khoa_id],
            ['user_role.role_id','<',3]
        ])
        ->select('users.id','users.name','users.email')
        ->union($sinhvien_chuyenlop)
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
                $sum;
                $diem[] = $sum;
            }
        

            //xep loai
            $xeploaidiem = DB::table('bangdiem')
            ->join('loaibangdiem','bangdiem.loaibangdiem_id','=','loaibangdiem.id')
            ->join('xeploai','loaibangdiem.id','=','xeploai.loaibangdiem_id')
            ->where('bangdiem.id',$term_id)
            ->select('xeploai.name','cantren','canduoi')->get()->toArray();

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

            $danhsachdiem[] = collect(['mssv' => 'MSSV','name' => 'Tên','diem'=>'Điểm','xeploai'=>'Xếp loại'])->toArray();
            foreach($sinhvien as $key => $value){
                $mssv = explode('@',$value->email);
                $diem_to_string = strval($diem[$key]);
                $danhsachdiem[] = collect([
                    'mssv' => $mssv[0],
                    'name' => $value->name,
                    'diem' => $diem_to_string,
                    'xeploai'=> $xeploaisinhvien[$key]
                ])->toArray();
            }
     
            Excel::create('data', function($excel) use ($danhsachdiem)
            {
                $excel->sheet('data', function($sheet) use ($danhsachdiem){
                    $sheet->fromArray($danhsachdiem,null,'A1',false,false);
                });
            })->export('xlsx');
        }
    }
    public function export_diem_truong_ctsv(Request $request){

        if(empty($request->bang_diem_id)){
            return back();
        }

        $term_id = $request->bang_diem_id;

         //danh sach sinh vien
        $sinhvien = DB::table('users')
        ->join('user_role','users.id','=','user_role.sv_id')
        ->where([
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
            ->select('xeploai.name','cantren','canduoi')->get()->toArray();

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

            $danhsachdiem[] = collect(['mssv' => 'MSSV','name' => 'Tên','diem'=>'Điểm','xeploai'=>'Xếp loại'])->toArray();
            foreach($sinhvien as $key => $value){
                $mssv = explode('@',$value->email);
                $diem_to_string = strval($diem[$key]);
                $danhsachdiem[] = collect([
                    'mssv' => $mssv[0],
                    'name' => $value->name,
                    'diem' => $diem_to_string,
                    'xeploai'=> $xeploaisinhvien[$key]
                ])->toArray();
            }

            Excel::create('data', function($excel) use ($danhsachdiem)
            {
                $excel->sheet('data', function($sheet) use ($danhsachdiem){
                    $sheet->fromArray($danhsachdiem,null,'A1',false,false);
                });
            })->export('xlsx');
        }

    }
    public function export_temp(Request $request){

        if(empty($request->loai_quan_ly)){
            return back();
        }

        $loai_quan_ly = $request->loai_quan_ly;
        
        switch($loai_quan_ly){
            case "phong_trao":
                // tập mẫu phong trào
                $file_temp = array();
                $file_temp[] = collect(['PHONGTRAO' => 'PHONGTRAO','DIEMTOIDA' => 'DIEMTOIDA','MATIEUCHI'=>'MATIEUCHI'])->toArray();
        
                Excel::create('mau_import_phong_trao', function($excel) use ($file_temp)
                {
                    $excel->sheet('mau_import_phong_trao', function($sheet) use ($file_temp){
                        $sheet->fromArray($file_temp,null,'A1',false,false);
                    });
                })->export('xlsx');
            break;
            case "hoat_dong":
                // tập mẫu phong trào
                $file_temp = array();
                $file_temp[] = collect(['HOATDONG' => 'HOATDONG','DIEMTOIDA' => 'DIEMTOIDA','DOITUONG'=>'DOITUONG','NGAYBATDAU'=>'NGAYBATDAU','NGAYKETTHUC'=>'NGAYKETTHUC','NGUOITAO'=>'NGUOITAO','NGUOIDUYET'=>'NGUOIDUYET','MAPHONGTRAO'=>'MAPHONGTRAO'])->toArray();

                Excel::create('mau_import_hoat_dong', function($excel) use ($file_temp)
                {
                    $excel->sheet('mau_import_hoat_dong', function($sheet) use ($file_temp){
                        $sheet->fromArray($file_temp,null,'A1',false,false);
                    });
                })->export('xlsx');
            break;
            case "sinh_vien":
                // tập mẫu phong trào
                $file_temp = array();
                $file_temp[] = collect(['HOTEN' => 'HOTEN','MSSV' => 'MSSV','PASSWORD'=>'PASSWORD','COSO'=>'COSO'])->toArray();

                Excel::create('mau_import_sinh_vien', function($excel) use ($file_temp)
                {
                    $excel->sheet('mau_import_sinh_vien', function($sheet) use ($file_temp){
                        $sheet->fromArray($file_temp,null,'A1',false,false);
                    });
                })->export('xlsx');
            break;
            case "tham_gia":
                // tập mẫu phong trào
                $file_temp = array();
                $file_temp[] = collect(['STT' => 'STT', 'MSSV' => 'MSSV', 'HOTEN' => 'HOTEN','HESOTHAMGIA'=>'HESOTHAMGIA','CHUTHICH'=>'CHUTHICH'])->toArray();

                Excel::create('mau_import_tham_gia', function($excel) use ($file_temp)
                {
                    $excel->sheet('mau_import_tham_gia', function($sheet) use ($file_temp){
                        $sheet->fromArray($file_temp,null,'A1',false,false);
                    });
                })->export('xlsx');
            break;
        }

    }
    public function export_diem_sinh_vien($id){

        if(empty($id)){
            return back();
        }

         //danh sach sinh vien
         $sinhvien_chuyenlop = DB::table('users')
         ->join('sinhvien_bangdiem_coso','users.id','=','sinhvien_bangdiem_coso.sv_id')
         ->join('coso','sinhvien_bangdiem_coso.coso_id','=','coso.id')
         ->where([
             ['users.id','=',$id],
         ])->select('users.id','users.name','users.email','coso.name as lop');
         $sinhvien = DB::table('users')
         ->join('sv_coso','users.id','=','sv_coso.sv_id')
         ->join('user_role','users.id','=','user_role.sv_id')
         ->join('coso','sv_coso.coso_id','=','coso.id')
         ->join('khoa','coso.khoa_id','=','khoa.id')
         ->where([
            ['users.id','=',$id],
         ])
         ->select('users.id','users.name','users.email', 'coso.name as lop')
         ->union($sinhvien_chuyenlop)
         ->get();

         // bang diem
         $bangdiem_sinhvien=DB::table('users')
        ->join('sv_coso','users.id','=','sv_coso.sv_id')
        ->join('coso','sv_coso.coso_id','=','coso.id')
        ->join('doituong','coso.doituong_id','=','doituong.id')
        ->join('bangdiem_doituong','doituong.id','=','bangdiem_doituong.doituong_id')
        ->join('bangdiem','bangdiem_doituong.bangdiem_id','=','bangdiem.id')
        ->where('users.id',$id)
        ->select('bangdiem_doituong.bangdiem_id as bangdiem_id','bangdiem.name as bangdiem')->get();
        
        //tong diem tung sinh vien
        $diem = array();
        if(count($sinhvien)>0){
            foreach($bangdiem_sinhvien as $i => $bd){
                foreach($sinhvien as $index => $sv){
                    $sum = 0;
                    $max_bangdiem_tieuchi_id = DB::table('tieuchi')->where('bangdiem_id',$bd->bangdiem_id)->select('tieuchi.id','tieuchi.maxtieuchi')->get();
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
                    $sum;
                $diem[] = $sum;
            }
        

            //xep loai
            $xeploaidiem = DB::table('bangdiem')
            ->join('loaibangdiem','bangdiem.loaibangdiem_id','=','loaibangdiem.id')
            ->join('xeploai','loaibangdiem.id','=','xeploai.loaibangdiem_id')
            ->where('bangdiem.id',$bd->bangdiem_id)
            ->select('xeploai.name','cantren','canduoi')->get()->toArray();
        }
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

            $danhsachdiem[] = collect(['mssv' => 'MSSV','name' => 'Tên','hocky'=>'Học kỳ','diem'=>'Điểm','xeploai'=>'Xếp loại'])->toArray();
            foreach($bangdiem_sinhvien as $item => $row){
            foreach($sinhvien as $key => $value){
                $mssv = explode('@',$value->email);
                $diem_to_string = strval($diem[$key]);
                $danhsachdiem[] = collect([
                    'mssv' => $mssv[0],
                    'name' => $value->name,
                    'hocky'=> $row->bangdiem,
                    'diem' => $diem_to_string,
                    'xeploai'=> $xeploaisinhvien[$key]
                ])->toArray();
            }
        }

            Excel::create('data', function($excel) use ($danhsachdiem)
            {
                $excel->sheet('data', function($sheet) use ($danhsachdiem){
                    $sheet->fromArray($danhsachdiem,null,'A1',false,false);
                });
            })->export('xlsx');
        }

    }
}
