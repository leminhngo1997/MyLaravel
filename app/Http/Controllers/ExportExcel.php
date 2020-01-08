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
            foreach($sinhvien as $key => $value){
                $sum = 0;
                $diemcong = DB::table('tieuchi')
                ->Join('tieuchi_phongtrao', 'tieuchi.id', '=', 'tieuchi_phongtrao.tieuchi_id')
                ->Join('phongtrao', 'tieuchi_phongtrao.phongtrao_id', '=', 'phongtrao.id')
                ->Join('phongtrao_hoatdong','phongtrao.id', '=', 'phongtrao_hoatdong.phongtrao_id')
                ->Join('hoatdong', 'phongtrao_hoatdong.hoatdong_id', '=', 'hoatdong.id')
                ->Join('user_hoatdong', 'hoatdong.id', '=', 'user_hoatdong.hoatdong_id')
                ->where([
                            ['tieuchi.bangdiem_id', '=', $term_id],
                            ['user_hoatdong.sv_id', '=', $value->id],
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
                            ['tieuchi.bangdiem_id', '=', $term_id],
                            ['user_hoatdong.sv_id', '=', $value->id],
                            ['hoatdong.status_clone','=',1],
                            ['user_hoatdong.heso', '=', -1],
                        ])->sum('hoatdong.diem');
                $sum = intval($diemcong)-intval($diemtru);
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
            foreach($sinhvien as $key => $value){
                $sum = 0;
                $diemcong = DB::table('tieuchi')
                ->Join('tieuchi_phongtrao', 'tieuchi.id', '=', 'tieuchi_phongtrao.tieuchi_id')
                ->Join('phongtrao', 'tieuchi_phongtrao.phongtrao_id', '=', 'phongtrao.id')
                ->Join('phongtrao_hoatdong','phongtrao.id', '=', 'phongtrao_hoatdong.phongtrao_id')
                ->Join('hoatdong', 'phongtrao_hoatdong.hoatdong_id', '=', 'hoatdong.id')
                ->Join('user_hoatdong', 'hoatdong.id', '=', 'user_hoatdong.hoatdong_id')
                ->where([
                            ['tieuchi.bangdiem_id', '=', $term_id],
                            ['user_hoatdong.sv_id', '=', $value->id],
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
                            ['tieuchi.bangdiem_id', '=', $term_id],
                            ['user_hoatdong.sv_id', '=', $value->id],
                            ['hoatdong.status_clone','=',1],
                            ['user_hoatdong.heso', '=', -1],
                        ])->sum('hoatdong.diem');
                $sum = intval($diemcong)-intval($diemtru);
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
            ['sinhvien_bangdiem_coso.bang_diem_id',$term_id]
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
            foreach($sinhvien as $key => $value){
                $sum = 0;
                $diemcong = DB::table('tieuchi')
                ->Join('tieuchi_phongtrao', 'tieuchi.id', '=', 'tieuchi_phongtrao.tieuchi_id')
                ->Join('phongtrao', 'tieuchi_phongtrao.phongtrao_id', '=', 'phongtrao.id')
                ->Join('phongtrao_hoatdong','phongtrao.id', '=', 'phongtrao_hoatdong.phongtrao_id')
                ->Join('hoatdong', 'phongtrao_hoatdong.hoatdong_id', '=', 'hoatdong.id')
                ->Join('user_hoatdong', 'hoatdong.id', '=', 'user_hoatdong.hoatdong_id')
                ->where([
                            ['tieuchi.bangdiem_id', '=', $term_id],
                            ['user_hoatdong.sv_id', '=', $value->id],
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
                            ['tieuchi.bangdiem_id', '=', $term_id],
                            ['user_hoatdong.sv_id', '=', $value->id],
                            ['hoatdong.status_clone','=',1],
                            ['user_hoatdong.heso', '=', -1],
                        ])->sum('hoatdong.diem');
                $sum = intval($diemcong)-intval($diemtru);
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
            foreach($sinhvien as $key => $value){
                $sum = 0;
                $diemcong = DB::table('tieuchi')
                ->Join('tieuchi_phongtrao', 'tieuchi.id', '=', 'tieuchi_phongtrao.tieuchi_id')
                ->Join('phongtrao', 'tieuchi_phongtrao.phongtrao_id', '=', 'phongtrao.id')
                ->Join('phongtrao_hoatdong','phongtrao.id', '=', 'phongtrao_hoatdong.phongtrao_id')
                ->Join('hoatdong', 'phongtrao_hoatdong.hoatdong_id', '=', 'hoatdong.id')
                ->Join('user_hoatdong', 'hoatdong.id', '=', 'user_hoatdong.hoatdong_id')
                ->where([
                            ['tieuchi.bangdiem_id', '=', $term_id],
                            ['user_hoatdong.sv_id', '=', $value->id],
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
                            ['tieuchi.bangdiem_id', '=', $term_id],
                            ['user_hoatdong.sv_id', '=', $value->id],
                            ['hoatdong.status_clone','=',1],
                            ['user_hoatdong.heso', '=', -1],
                        ])->sum('hoatdong.diem');
                $sum = intval($diemcong)-intval($diemtru);
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
                $file_temp[] = collect(['TENPHONGTRAO' => 'TENPHONGTRAO','DIEMTOIDA' => 'DIEMTOIDA','MATIEUCHI'=>'MATIEUCHI'])->toArray();
        
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
                $file_temp[] = collect(['hoatdong' => 'hoatdong','diem' => 'diem','doituong'=>'doituong','ngaybatdau'=>'ngaybatdau','ngayketthuc'=>'ngayketthuc','nguoitao'=>'nguoitao','nguoiduyet'=>'nguoiduyet','maphongtrao'=>'maphongtrao'])->toArray();

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
                $file_temp[] = collect(['name' => 'name','mssv' => 'mssv','password'=>'password','coso'=>'coso'])->toArray();

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
                $file_temp[] = collect(['masosinhvien' => 'masosinhvien','tensinhvien' => 'tensinhvien','hesothamgia'=>'hesothamgia','chuthich'=>'chuthich'])->toArray();

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
            foreach($bangdiem_sinhvien as $item => $row){
                foreach($sinhvien as $key => $value){
                $sum = 0;
                $diemcong = DB::table('tieuchi')
                ->Join('tieuchi_phongtrao', 'tieuchi.id', '=', 'tieuchi_phongtrao.tieuchi_id')
                ->Join('phongtrao', 'tieuchi_phongtrao.phongtrao_id', '=', 'phongtrao.id')
                ->Join('phongtrao_hoatdong','phongtrao.id', '=', 'phongtrao_hoatdong.phongtrao_id')
                ->Join('hoatdong', 'phongtrao_hoatdong.hoatdong_id', '=', 'hoatdong.id')
                ->Join('user_hoatdong', 'hoatdong.id', '=', 'user_hoatdong.hoatdong_id')
                ->where([
                            ['tieuchi.bangdiem_id', '=', $row->bangdiem_id],
                            ['user_hoatdong.sv_id', '=', $value->id],
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
                            ['tieuchi.bangdiem_id', '=', $row->bangdiem_id],
                            ['user_hoatdong.sv_id', '=', $value->id],
                            ['hoatdong.status_clone','=',1],
                            ['user_hoatdong.heso', '=', -1],
                        ])->sum('hoatdong.diem');
                $sum = intval($diemcong)-intval($diemtru);
                $diem[] = $sum;
            }
        

            //xep loai
            $xeploaidiem = DB::table('bangdiem')
            ->join('loaibangdiem','bangdiem.loaibangdiem_id','=','loaibangdiem.id')
            ->join('xeploai','loaibangdiem.id','=','xeploai.loaibangdiem_id')
            ->where('bangdiem.id',$row->bangdiem_id)
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
