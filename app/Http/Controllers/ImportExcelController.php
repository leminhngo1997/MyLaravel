<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use phpDocumentor\Reflection\Types\Integer;

class ImportExcelController extends Controller
{
    function import(Request $request)
    {
        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx'
        ]);
        
        $path = $request->file('select_file')->getRealPath();
        
        $data = Excel::load($path)->get();

        if($data->count() > 0)
        {
            foreach($data->toArray() as $key => $value)
            {
                //dd($value);

                if(($value['hoatdong']!==null)&&($value['maphongtrao'])!==null){
                    $insert_hoatdong[] = array(
                        'name' => $value['hoatdong'],
                        'diem' => $value['diem'],
                        'doituong' => $value['coso'],
                        'ngaybatdau' => $value['ngaybatdau'],
                        'ngayketthuc' => $value['ngayketthuc'],
                        'nguoitao' => $value['nguoitao'],
                        'nguoiduyet' => $value['nguoiduyet'],
                        'status_clone' => 0,
                    );
                    
                    //lấy tên cơ sở và mã phong trào
                    $coso_name[] = $value['coso'];
                    $phongtrao_id[] = $value['maphongtrao'];
                }
            }

            if(!empty($insert_hoatdong))
            {
                DB::table('hoatdong')->insert($insert_hoatdong);
            }
            else return back()->with('success', 'Excel Data Imported Completely.');
            
            // xử lí insert phongtrao_hoatdong
            // lấy hoạt động id vừa insert
            $new_inserted_rows = DB::table('hoatdong')->orderBy('id', 'DESC')->take(count($insert_hoatdong))->get('id');
            foreach($new_inserted_rows as $key => $value)
            {
                foreach($value as $row => $item){
                    $hoatdong_id[] = $item;
                }
            }
            sort($hoatdong_id); //hoat dong id


            foreach($hoatdong_id as $key => $value){
                $insert_phongtrao_hoatdong[] = array(
                    'phongtrao_id' => $phongtrao_id[$key],
                    'hoatdong_id' => $value,
                    'status' => 0
                );
            }
            DB::table('phongtrao_hoatdong')->insert($insert_phongtrao_hoatdong);

            // Xử lí insert coso

                // lấy danh sách cơ sở
                $temp = array();
                $danhsachcoso = array();
                $temp = DB::table('coso')->get(['id','name']);
                $danhsachcoso = array();
                foreach($temp as $key => $item)
                {
                    $danhsachcoso[] = $item;        //(id, name)
                }

                // Xử lí input cơ sở
                foreach($coso_name as $index => $value){
                    if ($value==='ALL'){
                        foreach ($danhsachcoso as $row){
                            DB::table('coso_hoatdong')->insert([
                                'coso_id' => $row->id,
                                'hoatdong_id' => $hoatdong_id[$index]
                            ]);
                        }
                    }
                    else {
                        $cosoapdung = explode("-",$value);
                        foreach ($cosoapdung as $index => $value){
                            foreach($danhsachcoso as $row)
                            {
                                if($value===$row->name) // tìm cơ sở trong danh sách cơ sở
                                {
                                    DB::table('coso_hoatdong')->insert([
                                        'coso_id' => $row->id,
                                        'hoatdong_id' => $hoatdong_id[$index]
                                    ]);
                                }
                            }
                        }
                        
                    }
                    
                }

        }
        return back()->with('success', 'Excel Data Imported Completely.');
    }


    function importSinhvien(Request $request)
    {
        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx'
        ]);
        
        $path = $request->file('select_file')->getRealPath();
        
        $data = Excel::load($path)->get();
        
        if($data->count() > 0)
        {
            
            $coso_name = array();
            foreach($data->toArray() as $key => $value)
            {
                //dd($value);
                    if($value['mssv']!==null){
                        $insert_sinhvien[] = array(
                            'name' => $value['name'],
                            'email' => $value['mssv'].'@gm.uit.edu.vn',
                            'password' => bcrypt($value['password']),
                        );

                        //tên cơ sở
                        $coso_name[] = $value['coso'];
                    }
            }
            //dd($coso_name);
            // insert
            if(!empty($insert_sinhvien))
            {
                DB::table('users')->insert($insert_sinhvien);

                // lấy sinh viên id vừa insert
                $new_inserted_rows = DB::table('users')->orderBy('id', 'DESC')->take(count($insert_sinhvien))->get('id');
                $user_id = array();
                foreach($new_inserted_rows as $key => $value)
                {
                    foreach($value as $row => $item){
                        $user_id[] = $item;
                    }
                }
                sort($user_id); //hoat dong id
                
                // xử lí insert cơ sở
                // lấy danh sách cơ sở
                $temp = array();
                $danhsachcoso = array();
                $temp = DB::table('coso')->get(['id','name']);
                $danhsachcoso = array();
                foreach($temp as $key => $item)
                {
                    $danhsachcoso[] = $item;        //(id, name)
                }

                // insert sv_cs
                foreach ($coso_name as $index => $value){
                    foreach($danhsachcoso as $row)
                    {
                        if($value===$row->name) // tìm cơ sở trong danh sách cơ sở
                        {
                            DB::table('sv_coso')->insert([
                                'sv_id' => $user_id[$index],
                                'coso_id' => $row->id                
                            ]);
                        }
                    }
                }

                // insert user_role
                foreach($user_id as $value){
                    DB::table('user_role')->insert([
                        'sv_id' => $value,
                        'role_id' => 1,
                    ]);
                }
                
            }
        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }

    function importThamgia(Request $request)
    {
        $id_hoatdong = $request->hoatdong_id;
        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx'
        ]);
        
        $path = $request->file('select_file')->getRealPath();
        
        $data = Excel::load($path)->get();
        
        if($data->count() > 0)
        {
            
            foreach($data->toArray() as $key => $value)
            {
                    if($value['masosinhvien']!==null){
                        // mã số sinh viên
                        $temp = array();
                        $email_sinhvien = null;
                        $sv_id = null;
                        $email_sinhvien = $value['masosinhvien'].'@gm.uit.edu.vn';
                        $temp = DB::table('users')->where('email',$email_sinhvien)->get('id');
                        foreach($temp as $item){
                            $sv_id = $item->id;
                        }
                        
                        $insert_thamgia[] = array(
                            'sv_id' => $sv_id,
                            'hoatdong_id' => intval($id_hoatdong),
                            'heso' => $value['hesothamgia'],
                            'chuthich' => $value['chuthich'],
                        );
                    }

            }
            
            // lấy danh sách mã tài khoản
            if(!empty($insert_thamgia))
            {    
                DB::table('user_hoatdong')->insert($insert_thamgia);
            }

        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }
}
