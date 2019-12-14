<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ImportExcelHoatdongController extends Controller
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
                        'doituong' => $value['doituong'],
                        'ngaybatdau' => $value['ngaybatdau'],
                        'ngayketthuc' => $value['ngayketthuc'],
                        'nguoitao' => $value['nguoitao'],
                        'nguoiduyet' => $value['nguoiduyet'],
                        'status_clone' => 0,
                    );
                    $phongtrao_id[] = $value['maphongtrao'];
                }
            }

            if(!empty($insert_hoatdong))
            {
                DB::table('hoatdong')->insert($insert_hoatdong);
            }
            else return back()->with('success', 'Excel Data Imported successfully.');
            
            $new_inserted_rows = DB::table('hoatdong')->orderBy('id', 'DESC')->take(count($insert_hoatdong))->get('id');
            foreach($new_inserted_rows as $key => $value)
            {
                foreach($value as $row => $item){
                    $hoatdong_id[] = $item;
                }
            }

            foreach($hoatdong_id as $key => $value){
                $insert_phongtrao_hoatdong[] = array(
                    'phongtrao_id' => $phongtrao_id[$key],
                    'hoatdong_id' => $value
                );
                
            }
            
            //DB::table('phongtrao_hoatdong')->insert($insert_phongtrao_hoatdong);

        }
        return back()->with('success', 'Excel Data Imported successfully.');
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
            foreach($data->toArray() as $key => $value)
            {
                //dd($value);
                    if($value['email']!==null){
                    $insert_sinhvien[] = array(
                        'name' => $value['name'],
                        'email' => $value['email'],
                        'password' => bcrypt($value['password']),
                    );
                }
               
            }
            if(!empty($insert_sinhvien))
            {
                DB::table('users')->insert($insert_sinhvien);   
            }
        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }
}
