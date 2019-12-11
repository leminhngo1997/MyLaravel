<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

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
                
                    $insert_hoatdong[] = array(
                        'name' => $value['name'],
                        'diem' => $value['diem'],
                        'doituong' => $value['doituong'],
                        'ngaybatdau' => $value['ngaybatdau'],
                        'ngayketthuc' => $value['ngayketthuc'],
                        'nguoitao' => $value['nguoitao'],
                        'nguoiduyet' => $value['nguoiduyet'],
                        'status_clone' => $value['status_clone'],
                    );
               
            }

            if(!empty($insert_hoatdong))
            {
                DB::table('hoatdong')->insert($insert_hoatdong);
            }
            

        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }
}
