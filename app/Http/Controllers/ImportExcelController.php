<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use phpDocumentor\Reflection\Types\Integer;

class ImportExcelController extends Controller
{
    function importHoatdong(Request $request)
    {
        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx'
        ]);
        
        $path = $request->file('select_file')->getRealPath();
        
        $data = Excel::load($path)->get();
        $error_row = array();
        if($data->count() > 0)
        {
            foreach($data->toArray() as $key => $value)
            {
                

                if(($value['hoatdong']!==null)
                    &&($value['diem'])!==null
                    &&($value['doituong'])!==null
                    &&($value['nguoitao'])!==null 
                    &&($value['nguoiduyet'])!==null
                    &&($value['maphongtrao'])!==null
                    ){
                    $insert_hoatdong[] = array(
                        'name' => $value['hoatdong'],
                        'diem' => $value['diem'],
                        'doituong' => $value['doituong'],
                        'ngaybatdau' => $value['ngaybatdau'],
                        'ngayketthuc' => $value['ngayketthuc'],
                        'nguoitao' => $value['nguoitao'],
                        'nguoiduyet' => $value['nguoiduyet'],
                        'status_clone' => 1,

                    );    
                    //lấy tên cơ sở và mã phong trào
                    $phongtrao_id[] = $value['maphongtrao'];
                }
                else $error_row[] = $key+2;
            }


            if(!empty($insert_hoatdong))
            { 
                $count = 0;
                foreach($phongtrao_id as $key => $value){
                        //insert hoạt động
                        DB::table('hoatdong')->insert($insert_hoatdong[$key]);

                        //insert phongtrao_hoatdong
                        $hoatdong_id = DB::table('hoatdong')->orderBy('id','DESC')->limit(1)->get('id')->toArray();
                        if(count($hoatdong_id)>0){
                            $hoatdong_id = end($hoatdong_id);
                            $hoatdong_id = end($hoatdong_id);
                            DB::table('phongtrao_hoatdong')->insert([
                                'phongtrao_id' =>$value,
                                'hoatdong_id' =>$hoatdong_id,
                                'status' => 1
                            ]);
                            

                            //insert coso_hoatdong
                            if($insert_hoatdong[$key]['doituong']==='ALL'){
                                //doi tuong = all
                                $allCoso_id = DB::table('coso')->get('id')->toArray();
                                foreach($allCoso_id as $item => $row){
                                    DB::table('coso_hoatdong')->insert([
                                        'coso_id'=>$row->id,
                                        'hoatdong_id'=> $hoatdong_id
                                    ]);
                                }
                                $count ++;
                            }
                            else
                            {
                                $data_hoatdong_coso = explode('-',$insert_hoatdong[$key]['doituong']);
                                foreach($data_hoatdong_coso as $key=>$value){
                                    $coso_id = DB::table('coso')->where('name',$value)->get('id')->toArray();
                                    if(count($coso_id)>0){
                                        DB::table('coso_hoatdong')->insert([
                                            'coso_id'=>$coso_id->id,
                                            'hoatdong_id'=> $hoatdong_id
                                        ]);
                                    }
                                }
                                $count ++;
                
                            }
                        }
                

                }

                return back()->with('success', 'Hoàn thành import với '.$count.' dòng thành công');
                
            }
            else {
      
                return back()->with('success', 'Hoàn thành import với 0 dòng');
            }

        }
        else{
            return back()->with('success', 'Hoàn thành import với 0 dòng');
        }
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
                $count = 0;
                foreach($insert_sinhvien as $key => $value){
                    DB::table('users')->updateOrInsert(
                        ['email'=>$value['email']],
                        [
                            'name' => $value['name'],
                            'password' => $value['password']
                        ]
                    );
                    $count++;
                }
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
                            DB::table('sv_coso')->updateOrInsert(
                                ['sv_id' => $user_id[$index]],
                                ['coso_id' => $row->id]                
                            );
                        }
                    }
                }

                // insert user_role
                foreach($user_id as $value){
                    DB::table('user_role')->updateOrInsert(
                        ['sv_id' => $value],
                        ['role_id' => 1]
                    );
                }
                
            }
        }
        return back()->with('success', 'Imported sinh viên thành công với: '.$count.' dòng');
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
                // dd($value);
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
                foreach($insert_thamgia as $key => $value)
                DB::table('user_hoatdong')->updateOrInsert(
                    [
                    'hoatdong_id' => $value['hoatdong_id']
                    ],
                    [
                        'sv_id' => $value['sv_id'],
                        'heso' => $value['heso'],
                        'chuthich' => $value['chuthich']
                    ]
                );
            }

        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }

    function importPhongtrao(Request $request)
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
                    if($value['tenphongtrao']!==null
                    &&$value['matieuchi']!==null
                    &&$value['diemtoida']!==null){
                   
                        $insert_phongtrao[] = array(
                            'name' => $value['tenphongtrao'],
                            'maxphongtrao' => $value['diemtoida'],
                        );

                        $tieuchi_id[] = $value['matieuchi'];

                    }
                    else
                    {
                        $error_row[] = $key+2;
                    }

            }
            
            
            if(!empty($insert_phongtrao))
            {   
                $count = 0;
                // check max điểm tiêu chí
                foreach($insert_phongtrao as $key=>$value){

                        // insert phong trao
                        DB::table('phongtrao')->insert($insert_phongtrao[$key]);
                        
                        // lấy mã phong trào vừa thêm vào
                        $phongtrao_id = DB::table('phongtrao')->orderBy('id','DESC')->limit(1)->get('id')->toArray();
                        //dd($phongtrao_id);
                        if(count($phongtrao_id)>0){
                            $phongtrao_id = end($phongtrao_id);
                            $phongtrao_id = end($phongtrao_id);
                            DB::table('tieuchi_phongtrao')->insert([
                                'phongtrao_id' =>$phongtrao_id,
                                'tieuchi_id' =>$tieuchi_id[$key],
                            ]);
                            $count ++;
                        }
                    
                }
                return back()->with('success', 'Hoàn thành import với '.$count.' dòng thành công');
            }
            else
            {
                return back()->with('success', 'Hoàn thành import với 0 dòng thành công');
            }

        
        }
        else{
        return back()->with('success', 'Hoàn thành import với 0 dòng thành công');
        }
    }
}
