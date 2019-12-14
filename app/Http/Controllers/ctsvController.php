<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use DB;




class ctsvController extends Controller
{	
//GET
    public function get_value_quanlibangdiem(){
        $loaibangdiem = DB::table('loaibangdiem')->get();
        $doituong = DB::table('doituong')->get();
        return view('ctsv.quanlibangdiem',[
            'loaibangdiem'=>$loaibangdiem,
            'doituong'=>$doituong,
            ]);
    }
    public function get_value_quanlitieuchi(){
        $loaibangdiem = DB::table('loaibangdiem')->get();
        $bangdiem = DB::table('bangdiem')->get();
        return view('ctsv.quanlitieuchi',[
            'loaibangdiem'=>$loaibangdiem,
            'bangdiem'=>$bangdiem,
        ]);
    }
    public function get_value_quanliphongtrao(){
        $loaibangdiem = DB::table('loaibangdiem')->get();
        $bangdiem = DB::table('bangdiem')->get();
        return view('ctsv.quanliphongtrao',[
            'loaibangdiem'=>$loaibangdiem,
            'bangdiem'=>$bangdiem,
        ]);
    }
    public function get_value_quanlihoatdong(){
        $loaibangdiem = DB::table('loaibangdiem')->get();
        $bangdiem = DB::table('bangdiem')->get();
        $data = DB::table('hoatdong')->orderBy('id','DESC')->limit(5)->get();
        return view('ctsv.quanlihoatdong',[
            'loaibangdiem'=>$loaibangdiem,
            'bangdiem'=>$bangdiem,
            'data' => $data
        ]);
    }

    public function get_value_quanlicoso(){
        $doituong = DB::table('doituong')->get();
        // dd($coso);
        return view('ctsv.quanlicoso',[
            'doituong'=>$doituong,
        ]);
    }

    public function get_value_quanlisinhvien(){
        $user = DB::table('users')->get();
        $doituong = DB::table('doituong')->get();
        $coso = DB::table('coso')->get();
        $data = DB::table('users')->orderBy('id','DESC')->limit(5)->get();
        return view('ctsv.quanlisinhvien',[
            'doituong'=>$doituong,
            'user'=>$user,
            'coso'=>$coso,
            'data'=>$data
        ]);
    }

    public function get_value_quanlitaikhoan(){
        $user = DB::table('users')->get();
        $role = DB::table('roles')->get();
        $user_role = DB::table('users')
            ->leftJoin('user_role','users.id','=','user_role.sv_id')
            ->leftJoin('roles','user_role.role_id','=','roles.id')
            ->select('users.id','users.name','users.email','user_role.role_id','roles.name as role')
            ->orderBy('users.id','DESC')
            ->get();
        return view('ctsv.quanlitaikhoan',[
            'role'=>$role,
            'user'=>$user,
            'user_role'=>$user_role
        ]);
    }

    public function get_value_duyethoatdong(){
        $hoatdong = DB::table('hoatdong')->get();
        $bangdiem = DB::table('bangdiem')->get();
        $user = DB::table('users')->get();
        return view('ctsv.duyethoatdong',[
            'hoatdong'=>$hoatdong,
            'user'=>$user,
            'bangdiem'=>$bangdiem,
        ]);
    }
    
    //POST
//--Thêm loại bảng điểm
    public function insert_loai_bang_diem(Request $request){
        $data = array();
        $data['name'] = $request->input_loaibangdiem;
        DB::table('loaibangdiem')->insert($data);
        Session::put('message','Thêm loại bảng điểm thành công.');
        return Redirect::to('quanlibangdiem');
    }
//--Xóa loại bảng điểm
    public function delete_loai_bang_diem($id){
        DB::table('loaibangdiem')->where('id',$id)->delete();
        Session::put('message','Xóa loại bảng điểm thành công.');
        return Redirect::to('quanlibangdiem');
    }
//--Thêm bảng điểm
    public function insert_bang_diem(Request $request){
        //insert table bangdiem
        $data_bangdiem = array();
        $data_bangdiem['name'] = $request->input_name_bangdiem;
        $data_bangdiem['loaibangdiem_id'] = $request->input_loaibangdiem_id_bangdiem;
        $data_bangdiem['maxbangdiem'] = $request->input_maxbangdiem_bangdiem;
        $data_bangdiem['ngaybatdau'] = $request->input_ngaybatdau_bangdiem;
        $data_bangdiem['ngayketthuc'] = $request->input_ngayketthuc_bangdiem;
        DB::table('bangdiem')->insert($data_bangdiem);
        //insert table bangdiem_doituong
        $current_bangdiem = DB::table('bangdiem')->orderBy('id','DESC')->first()->id;
        $doituong = $request->doituong;
        //dd($doituong);
        foreach($doituong as $key=>$value){
            DB::table('bangdiem_doituong')->insert(array(
                //insert nhiều dòng 
                array('bangdiem_id'=> $current_bangdiem, 'doituong_id'=> $value)
            ));
        }
        Session::put('message','Thêm bảng điểm thành công.');
        return Redirect::to('quanlibangdiem');
    }    
//--Thêm tiêu chí
    public function insert_tieu_chi_quanlitieuchi(Request $request){
        //insert table tieuchi
        // $data = array();
        // $data['name'] = $request->input_name_tieuchi;
        // $data['bangdiem_id'] = $request->input_bangdiem_id_tieuchi;
        // $data['maxtieuchi'] = $request->input_maxtieuchi_tieuchi;
        // DB::table('tieuchi')->insert($data);

        $tieuchi_id = DB::table('tieuchi')->where('bangdiem_id',11)->get();
        foreach($tieuchi_id as $item)
        {
            $phongtrao_id[] = DB::table('tieuchi_phongtrao')->where('tieuchi_id',$item->id)->get('phongtrao_id');
        }
        foreach($phongtrao_id as $item)
        {
            foreach($item as $key=>$value)
            {
                $hoatdong_id[] = DB::table('phongtrao_hoatdong')->where('phongtrao_id',$value->phongtrao_id)->get('hoatdong_id');                   
            }
            
        }
       
        foreach($hoatdong_id as $item){
            foreach($item as $key=>$value)
            {
                $hoat_dong_id_chua_duyet[] = $value->hoatdong_id;
            
            }
            
        }    
        foreach($hoat_dong_id_chua_duyet as $item) {
                $hoatdong_chuaduyet[] = DB::table('hoatdong')->where('id',$item)->get();
        }
         foreach($hoatdong_chuaduyet as $key => $value)
        {
            foreach($value as $row => $i)
            {
                $current_id_hoatdong_chuaduyet[] = $i->id;
            }
        }
     
        foreach($current_id_hoatdong_chuaduyet as $key=>$value)
        {
            $hoat_dong_status_0[] = DB::table('hoatdong')->where('id',$value)->get();
        }
        
        $temp = array();
        foreach($hoat_dong_status_0 as $key=>$value)
        {
            foreach($value as $row=>$i)
            {
                $temp[] = $i;
            }
           
        }
        dd($temp);
        
        

        Session::put('message','Thêm tiêu chí thành công.');
        return Redirect::to('quanlitieuchi');
    }
//--Xóa tiêu chí
    public function delete_tieu_chi_quanlitieuchi($id){
        //lấy phongtrao_id từ tieuchi_id
        $tieuchi_phongtrao = DB::table('tieuchi_phongtrao')->where('tieuchi_id',$id)->get();
        $phongtrao_hoatdong = array();
        $phongtrao_id = array();
        $hoatdong_id = array();

        //tìm phongtrao_id từ tieuchi_hoatdong
        foreach($tieuchi_phongtrao as $key => $value){
            $phongtrao_id[] = $value->phongtrao_id;
            //xóa tieuchi_phongtrao có phongtrao_id vừa tìm được
            DB::table('tieuchi_phongtrao')->where('phongtrao_id',$value->phongtrao_id)->delete();
        }

        //lấy hoatdong_id từ phongtrao_id
        foreach($phongtrao_id as $key => $value){

            $phongtrao_hoatdong = DB::table('phongtrao_hoatdong')->where('phongtrao_id',$value)->get();

            //tìm hoatdong_id
            foreach($phongtrao_hoatdong as $row => $item)
            {               
                //lấy hoatdong_id
                $hoatdong_id[] = $item->hoatdong_id;
                //xóa phongtrao_hoatdong có hoatdong_id vừa tìm thấy
                DB::table('phongtrao_hoatdong')->where('hoatdong_id',$item->hoatdong_id)->delete();
            }
        }

        //xóa hoạt động
        foreach($hoatdong_id as $key => $value)
        {
            DB::table('hoatdong')->where('id',$value)->delete();
        }
        
        //xóa phong trào
        foreach($phongtrao_id as $key => $value)
        {
            DB::table('phongtrao')->where('id',$value)->delete();
        } 
        //xóa tiêu chí
        DB::table('tieuchi')->where('id',$id)->delete();
        Session::put('message','Xóa tiêu chí thành công.');
        return Redirect::to('quanlitieuchi');
    }
//--Thêm phong trào
    public function insert_phong_trao_quanliphongtrao(Request $request){
        //insert table phongtrao
        $data = array();
        $data['name'] = $request->input_name_phongtrao;
        $data['maxphongtrao'] = $request->input_maxphongtrao_phongtrao;
        DB::table('phongtrao')->insert($data);
        //insert table tieuchi_phongtrao
        $data_tieuchi_phongtrao = array();
        $current_phongtrao_id = DB::table('phongtrao')->orderBy('id','DESC')->first()->id;
        $data_tieuchi_phongtrao['phongtrao_id'] = $current_phongtrao_id;
        $data_tieuchi_phongtrao['tieuchi_id'] = $request->input_tieuchi_id;
        DB::table('tieuchi_phongtrao')->insert($data_tieuchi_phongtrao);
        Session::put('message','Thêm phong trào thành công.');
        return Redirect::to('quanliphongtrao');
    }
//--Xóa phong trào
    public function delete_phong_trao_quanliphongtrao($id){
        
        // lấy hoatdong_id từ mã phong trào $id
        $hoatdong_id = array();
        $phongtrao_hoatdong = DB::table('phongtrao_hoatdong')->where('phongtrao_id',$id)->get('hoatdong_id');
        foreach($phongtrao_hoatdong as $key => $row)
        {
            // lấy hoatdong_id
            $hoatdong_id[] = $row->hoatdong_id;
            // xóa phongtrao_hoatdong có hoatdong_id vừa lấy
            DB::table('phongtrao_hoatdong')->where('hoatdong_id',$row->hoatdong_id)->delete();
        }
        
        // xóa hoạt động
        foreach($hoatdong_id as $key => $value)
        {
            DB::table('hoatdong')->where('id',$value)->delete();
        } 
        // xóa tieuchi_phongtrao
        DB::table('tieuchi_phongtrao')->where('phongtrao_id',$id)->delete();
        // xóa phong trào
        DB::table('phongtrao')->where('id',$id)->delete();
        Session::put('message','Xóa phong trào thành công.');
        return Redirect::to('quanliphongtrao');
    }
//--Thêm hoạt động
    public function insert_hoat_dong_quanlihoatdong(Request $request){
        //insert table hoatdong
        
        $data_hoatdong = array();
        $nguoi_tao_duyet = Auth::user()->name;
        $data_hoatdong['name'] = $request->input_name_hoatdong;
        $data_hoatdong['mota'] = $request->input_mota_hoatdong;
        $data_hoatdong['diem'] = $request->input_diem_hoatdong;
        $data_hoatdong['doituong'] = $request->input_doituong_hoatdong;
        // tách chuỗi
        $data_hoatdong_coso = explode("-",$data_hoatdong['doituong']);
        $data_hoatdong['ngaybatdau'] = $request->input_ngaybatdau_hoatdong;
        $data_hoatdong['ngayketthuc'] = $request->input_ngayketthuc_hoatdong;
        $data_hoatdong['nguoitao'] = $nguoi_tao_duyet;
        $data_hoatdong['nguoiduyet'] = $nguoi_tao_duyet;
        $data_hoatdong['status_clone'] = 1;
        DB::table('hoatdong')->insert($data_hoatdong);
        //insert table phongtrao_hoatdong
        $data_phongtrao_hoatdong = array();
        $current_hoat_dong_id = DB::table('hoatdong')->orderBy('id','DESC')->first()->id;
        $data_phongtrao_hoatdong['phongtrao_id'] = $request->input_phongtrao_id_hoatdong;
        $data_phongtrao_hoatdong['hoatdong_id'] = $current_hoat_dong_id;
        $data_phongtrao_hoatdong['status'] = 1;
        $data_phongtrao_hoatdong['nguoiduyet'] = $nguoi_tao_duyet;
        //dd($data_phongtrao_hoatdong);
        DB::table('phongtrao_hoatdong')->insert($data_phongtrao_hoatdong);
        //insert table coso_hoatdong
        $data_coso_hoatdong = array();
        $current_id_bangdiem = $request->current_id_bangdiem;
        // dd($current_id_bangdiem);
        $current_doituong_id = DB::table('bangdiem_doituong')->where('bangdiem_id',$current_id_bangdiem)->get('doituong_id');
        // dd($current_doituong_id);
       
        foreach($current_doituong_id as $item){
            $doi_tuong_id[] = $item->doituong_id;
        }
        // dd($doi_tuong_id);
        foreach($doi_tuong_id as $item){
            $current_coso_id[] = DB::table('coso')->where('doituong_id',$item)->get();
        }
        foreach($data_hoatdong_coso as $key=>$value){
            if($value==='TẤT CẢ'){
                foreach($current_coso_id as $item){
                    foreach($item as $key=>$value){
                        $data_coso_hoatdong['coso_id'] = $value->id;
                        $data_coso_hoatdong['hoatdong_id'] = $current_hoat_dong_id;
                        DB::table('coso_hoatdong')->insert($data_coso_hoatdong);
                    }
                    
                }
                Session::put('message','Thêm hoạt động thành công.');
                return Redirect::to('quanlihoatdong');
            }
        }
        // lay co so
        $coso_id = array();
        foreach($data_hoatdong_coso as $key=>$value){
                $coso[] = DB::table('coso')->where('name',$value)->get('id');
           }
        //tim id co so
        foreach($coso as $row){
            foreach($row as $item){
                $coso_id[] = $item->id;
            }
        }
        // insert coso_hoatdong
        foreach($coso_id as $key){
            $data_coso_hoatdong['coso_id'] = $key;
            $data_coso_hoatdong['hoatdong_id'] = $current_hoat_dong_id;
            DB::table('coso_hoatdong')->insert($data_coso_hoatdong);
        }
        Session::put('message','Thêm hoạt động thành công.');
        return Redirect::to('quanlihoatdong');
    }
//--Xóa hoạt động
    public function delete_hoat_dong_quanlihoatdong(Request $request){
        if($request->check == null)
        {
            Session::put('message','Lỗi: Check hoạt động cần xóa');
            return Redirect::to('quanlihoatdong');
        }
        //delete 2 table phongtrao_hoatdong & hoatdong
        $check = $request->check;
        //dd($check);
        foreach($check as $key => $value){
            //dd($value);
            DB::table('phongtrao_hoatdong')->where('hoatdong_id',$value)->delete();
            DB::table('hoatdong')->where('id',$value)->delete();
        }
        Session::put('message','Xóa hoạt động thành công.');
        return Redirect::to('quanlihoatdong');
    }    
//--Thêm cơ sở
    public function insert_co_so_quanlicoso(Request $request){
        //insert table coso
        $data = array();
        $data['name'] = $request->input_name_coso;
        $data['doituong_id'] = $request->input_doituong_id;
        $data['siso'] = $request->input_siso_coso;
        DB::table('coso')->insert($data);
        Session::put('message','Thêm cơ sở thành công.');
        return Redirect::to('quanlicoso');
    }
//--Xóa cơ sở
    public function delete_co_so_quanlicoso($id){
        DB::table('coso')->where('id',$id)->delete();
        Session::put('message','Xóa cơ sở thành công.');
        return Redirect::to('quanlicoso');
    }
    //--users
    public function insert_users_quanlisinhvien(Request $request){
        //insert table users
        $data_users = array();
        $data_users['name'] = $request->input_name_users;
        $data_users['email'] = $request->input_email_users;
        $data_users['password'] = bcrypt('{{$request->input_password_users}}');
        DB::table('users')->insert($data_users);
        //insert table sv_coso
        $current_user_id = DB::table('users')->orderBy('id','DESC')->first()->id;
        $data_sv_coso = array();
        $data_sv_coso['sv_id'] = $current_user_id;
        $data_sv_coso['coso_id'] = $request->input_name_co_so;
        DB::table('sv_coso')->insert($data_sv_coso);
        Session::put('message','Thêm sinh viên thành công.');
        return Redirect::to('quanlisinhvien');
    }
    //--Xóa users
    public function delete_users_quanlisinhvien($id){
        DB::table('sv_coso')->where('sv_id',$id)->delete();
        DB::table('user_role')->where('sv_id',$id)->delete();
        DB::table('users')->where('id',$id)->delete();
        Session::put('message','Xóa users thành công.');
        return Redirect::to('quanlisinhvien');
    }

// -- Tài khoản
    // phân quyền
    public function update_quanlitaikhoan(Request $request){
        $user_id = $request->input_user_id;
        $role_id = $request->select_role_name;

        DB::table('user_role')->updateOrInsert([
            'sv_id' => $user_id,
            'role_id' => $role_id
        ]);
        return back();
    }

    //delete hoat dong
    public function xoa_duyet_hoat_dong(Request $request){
        $list_hoat_dong = $request->array_hoat_dong;
        $action = $request->action;
        if($action == 'delete'){
            foreach($list_hoat_dong as $item){
                DB::table('coso_hoatdong')->where('hoatdong_id',$item)->delete();
                DB::table('phongtrao_hoatdong')->where('hoatdong_id',$item)->delete();
                DB::table('hoatdong')->where('id',$item)->delete();
            }
            return response()->json(['message' => 'Hủy thành công!', 'data'=>$list_hoat_dong]);
        }
        elseif($action == 'update'){
            foreach($list_hoat_dong as $item){
                DB::table('hoatdong')->where('id',$item)->update(['status_clone'=>1]);
            }
            return response()->json(['message' => 'Duyệt thành công!', 'data'=>$list_hoat_dong]);
        }
        else{
            return back();
        }
    }

  
    
}