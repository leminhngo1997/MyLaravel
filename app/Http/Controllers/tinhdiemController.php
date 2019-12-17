<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class tinhdiemController extends Controller
{
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
