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
                    foreach($xeploaidiem as $key => $item){
                        if($value<=$item->canduoi && $value>=$item->canduoi){
                            $xeploaisinhvien[] = $item->name;
                        }
                    }
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
}
