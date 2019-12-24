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
    public function AuthSV(){
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
        $user_role = DB::table('user_role')->where('sv_id', $auth_id)->first('role_id');
        $role = DB::table('roles')->where('id', $user_role->role_id)->first('name');
        if($role->name == "ctsv"){
            
		}else{
            Redirect::to('login')->send();
        }
    }

//GET
    public function get_value_quanlibangdiem(){
        $this->AuthSV(); 
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
        $loaibangdiem = DB::table('loaibangdiem')->get();
        $doituong = DB::table('doituong')->get();
        return view('ctsv.quanlibangdiem',[
            'loaibangdiem'=>$loaibangdiem,
            'doituong'=>$doituong,
            ]);
    }
    public function get_value_quanlitieuchi(){
        $this->AuthSV(); 
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
        $loaibangdiem = DB::table('loaibangdiem')->get();
        $bangdiem = DB::table('bangdiem')->get();
        return view('ctsv.quanlitieuchi',[
            'loaibangdiem'=>$loaibangdiem,
            'bangdiem'=>$bangdiem,
        ]);
    }
    public function get_value_quanliphongtrao(){
        $this->AuthSV(); 
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
        $loaibangdiem = DB::table('loaibangdiem')->get();
        $bangdiem = DB::table('bangdiem')->get();
        $data = DB::table('phongtrao')->orderBy('id','DESC')->limit(5)->get();
        return view('ctsv.quanliphongtrao',[
            'loaibangdiem'=>$loaibangdiem,
            'bangdiem'=>$bangdiem,
            'data'=>$data,
        ]);
    }
    public function get_value_quanlihoatdong(){
        $this->AuthSV(); 
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
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
        $this->AuthSV(); 
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
        $doituong = DB::table('doituong')->get();
        return view('ctsv.quanlicoso',[
            'doituong'=>$doituong,
        ]);
    }

    public function get_value_quanlisinhvien(){
        $this->AuthSV(); 
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
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
        $this->AuthSV(); 
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
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
    public function get_value_phanhoictsv(){
        $this->AuthSV(); 
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
        $doituong = DB::table('doituong')->get();
        return view('ctsv.phanhoictsv',[
            'doituong'=>$doituong,
            ]);
    }
    
    public function get_value_duyethoatdong(){
        $this->AuthSV(); 
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
        $hoatdong = DB::table('hoatdong')->get();
        $bangdiem = DB::table('bangdiem')->get();
        $user = DB::table('users')->get();
        return view('ctsv.duyethoatdong',[
            'hoatdong'=>$hoatdong,
            'user'=>$user,
            'bangdiem'=>$bangdiem,
        ]);
    }
    public function get_value_quanlixeploai(){
        $this->AuthSV(); 
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
        $loai_bang_diem = DB::table('loaibangdiem')->get();
        // dd($loai_bang_diem);
        return view('ctsv.quanlixeploai',[
            'loai_bang_diem'=>$loai_bang_diem]);
    }

    public function get_value_importsinhvienthamgiahoatdong(){
        $this->AuthSV(); 
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
        $bangdiem = DB::table('bangdiem')->get();
        return view('ctsv.importsinhvienthamgiahoatdong',[
            'bangdiem'=>$bangdiem,
            ]);
    }
    
    public function get_value_danhsachsinhvienthamgiahoatdong($id){
        $this->AuthSV(); 
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }

        if($id===null){
            $list_hoat_dong = array();
            $user_hoatdong = array();
        }
        else{
            $list_hoat_dong = DB::table('hoatdong')->where('id',$id)->get();
            $user_hoatdong = DB::table('user_hoatdong')->where('hoatdong_id',$id)->paginate(10);
        }
        return view('ctsv.danhsachsinhvienthamgiahoatdong',[
            'list_hoat_dong'=>$list_hoat_dong,
            'hoatdong_id' => $id,
            'user_hoatdong'=>$user_hoatdong,
        ]);
       
    }
    
    //POST
//--Thêm loại bảng điểm
    public function insert_loai_bang_diem(Request $request){
        $this->AuthSV(); 
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }

        //check input
        if(empty($request->input_loaibangdiem))
        {
            Session::put('message','Nhập tên bảng điểm');
            return back();
        };


        $data = array();
        $data['name'] = $request->input_loaibangdiem;
        DB::table('loaibangdiem')->insert($data);
        Session::put('message','Thêm loại bảng điểm thành công.');
        return Redirect::to('quanlibangdiem');
    }
//--Xóa loại bảng điểm
    public function delete_loai_bang_diem($id){
        $this->AuthSV(); 
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }

        //kiểm tra tồn tại
        $kiemtra = DB::table('bangdiem')->where('loaibangdiem_id',$id)->get();

        if(count($kiemtra)>0){
            Session::put('message','Loại bảng điểm đã sử dụng, không thể xóa!');
            return back();
        }

        DB::table('loaibangdiem')->where('id',$id)->delete();
        Session::put('message','Xóa loại bảng điểm thành công.');
        return Redirect::to('quanlibangdiem');
    }
//--Thêm bảng điểm
    public function insert_bang_diem(Request $request){
        $this->AuthSV(); 
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
        

        //check input
        if(empty($request->input_name_bangdiem))
        {
            Session::put('message','Nhập tên bảng điểm');
            return back();
        };
        if(empty($request->input_loaibangdiem_id_bangdiem))
        {
            Session::put('message','Chọn loại bảng điểm');
            return back();
        }
        if(empty($request->input_maxbangdiem_bangdiem))
        {
            Session::put('message','Nhập max bảng điểm');
            return back();
        }
        if(empty($request->input_ngaybatdau_bangdiem))
        {
            Session::put('message','Chọn ngày bắt đầu');
            return back();
        }
        if(empty($request->input_ngayketthuc_bangdiem))
        {
            Session::put('message','Chọn ngày kết thúc');
            return back();
        }
        if(empty($request->doituong))
        {
            Session::put('message','Chọn đối tượng');
            return back();
        }



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
        return back();
    }    
//--Thêm tiêu chí
    public function insert_tieu_chi_quanlitieuchi(Request $request){
        $this->AuthSV(); 
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }

        if(empty($request->input_name_tieuchi))
        {
            Session::put('message','Nhập tên tiêu chí');
            return back();
        };
        if(empty($request->input_bangdiem_id_tieuchi))
        {
            Session::put('message','Chọn bảng điểm');
            return back();
        };
        if(empty($request->input_maxtieuchi_tieuchi))
        {
            Session::put('message','Nhập điểm tối đa');
            return back();
        };

        $maxbangdiem = DB::table('bangdiem')->where('id',$request->input_bangdiem_id_tieuchi)->select('maxbangdiem')->get()->toArray();
        $maxbangdiem = end($maxbangdiem);
        $maxbangdiem = end($maxbangdiem);

        $sumMaxTieuChi_beforeInsert = DB::table('tieuchi')
                                ->where('tieuchi.bangdiem_id',$request->input_bangdiem_id_tieuchi)
                                ->sum('maxtieuchi');
        $sumMaxTieuchi_afterInsert = 0;
        $sumMaxtieuchi_afterInsert = intval($sumMaxTieuChi_beforeInsert)+intval($request->input_maxtieuchi_tieuchi);

        if($sumMaxtieuchi_afterInsert>intval($maxbangdiem)){
            $chenhlech = intval($maxbangdiem) - intval($sumMaxTieuChi_beforeInsert);
            Session::put('message','Tổng max tiêu chí vượt quá max bảng điểm. Chênh lệch còn: '.$chenhlech);
            return back();
        }

        //insert table tieuchi
        $data = array();
        $data['name'] = $request->input_name_tieuchi;
        $data['bangdiem_id'] = $request->input_bangdiem_id_tieuchi;
        $data['maxtieuchi'] = $request->input_maxtieuchi_tieuchi;
        DB::table('tieuchi')->insert($data);
        Session::put('message','Thêm tiêu chí thành công.');
        return back();
    }
//--Xóa tiêu chí
    public function delete_tieu_chi_quanlitieuchi($id){
        $this->AuthSV(); 
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
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
        $this->AuthSV(); 
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
          
        //check input
        if(empty($request->input_tieuchi_id))
        {
            Session::put('message','Chọn tiêu chí');
            return Redirect::to('quanliphongtrao');
        };
        if(empty($request->input_name_phongtrao))
        {
            Session::put('message','Nhập tên phong trào');
            return Redirect::to('quanliphongtrao');
        }
        if(empty($request->input_maxphongtrao_phongtrao))
        {
            Session::put('message','Nhập max phong trào');
            return Redirect::to('quanliphongtrao');
        }

        //insert table phongtrao
        $data = array();
        $data['name'] = $request->input_name_phongtrao;
        $data['maxphongtrao'] = $request->input_maxphongtrao_phongtrao;
        //check max tiêu chí
        $tieuchi_id = $request->input_tieuchi_id;

        $maxtieuchi = DB::table('tieuchi')->where('id',$tieuchi_id)->select('maxtieuchi')->get()->toArray();
        $maxtieuchi = end($maxtieuchi);
        
        $sumMaxPhongtrao_beforeInsert = DB::table('phongtrao')
                                ->join('tieuchi_phongtrao','phongtrao.id','=','tieuchi_phongtrao.phongtrao_id')
                                ->where('tieuchi_phongtrao.tieuchi_id',$tieuchi_id)
                                ->sum('phongtrao.maxphongtrao');
        $sumMaxtieuchi_afterInsert = 0;
        $sumMaxtieuchi_afterInsert = intval($sumMaxPhongtrao_beforeInsert)+intval($data['maxphongtrao']);
        
        //dd($sumMaxtieuchi_afterInsert);
        if($sumMaxtieuchi_afterInsert<=intval($maxtieuchi->maxtieuchi))
        {
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
        else{
            $chenhlech = intval($maxtieuchi->maxtieuchi) - intval($sumMaxPhongtrao_beforeInsert);
            Session::put('message','Tổng max phong trào vượt quá max tiêu chí. Chênh lệch còn: '.$chenhlech);
            return Redirect::to('quanliphongtrao');
        }
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

        // catch đăng nhập
        if(Auth::user()!==NULL)
        {
            $current_user_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }

        // catch input tên
        if(empty($request->input_name_hoatdong)){
            Session::put('message','Nhập tên hoạt động');
            return Redirect::to('quanlihoatdong');
        }
        // catch input điểm
        if(empty($request->input_diem_hoatdong)){
            Session::put('message','Nhập điểm hoạt động');
            return Redirect::to('quanlihoatdong');
        }
        // catch đối tượng
        if(empty($request->input_doituong_hoatdong)){
            Session::put('message','Chọn đối tượng hoạt động');
            return Redirect::to('quanlihoatdong');
        }

        // catch ngày tháng
        if(empty($request->input_ngaybatdau_hoatdong)){
            Session::put('message','Chọn ngày bắt đầu hoạt động');
            return Redirect::to('quanlihoatdong');
        }
        if(empty($request->input_ngayketthuc_hoatdong)){
            Session::put('message','Chọn ngày kết thúc hoạt động');
            return Redirect::to('quanlihoatdong');
        }
        if($request->input_ngaybatdau_hoatdong>$request->input_ngayketthuc_hoatdong){
            Session::put('message','Sai ngày kết thúc hoạt động');
            return Redirect::to('quanlihoatdong');
        }

        // catch phong trào
        if(empty($request->input_phongtrao_id_hoatdong)){
            Session::put('message','Chọn phong trào');
            return Redirect::to('quanlihoatdong');
        }
        // catch bảng điểm
        if(empty($request->current_id_bangdiem)){
            Session::put('message','Chọn bảng điểm');
            return Redirect::to('quanlihoatdong');
        }

        // check max phong trao

        $maxPhongtrao = DB::table('phongtrao')
        ->where('id',$request->input_phongtrao_id_hoatdong)
        ->select('maxphongtrao')->get()->toArray();

        $maxPhongtrao = end($maxPhongtrao);

        $sumHoatdong_beforeInsert = DB::table('hoatdong')
                                        ->join('phongtrao_hoatdong','hoatdong.id','=','phongtrao_hoatdong.phongtrao_id')
                                        ->sum('hoatdong.diem');
        $sumHoatdong_afterInsert = intval($sumHoatdong_beforeInsert)+intval($request->input_diem_hoatdong);
        if($sumHoatdong_afterInsert>$maxPhongtrao->maxphongtrao)
        {       
                $chenhlech = intval($maxPhongtrao->maxphongtrao) - intval($sumHoatdong_beforeInsert);
                Session::put('message','Tổng điểm hoạt động vượt quá max phong trào. Chênh lệch còn: '.$chenhlech);
                return Redirect::to('quanlihoatdong');
        }
        else{
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
        $current_doituong_id = DB::table('bangdiem_doituong')->where('bangdiem_id',$current_id_bangdiem)->get('doituong_id');
       
        foreach($current_doituong_id as $item){
            $doi_tuong_id[] = $item->doituong_id;
        }
        foreach($doi_tuong_id as $item){
            $current_coso_id[] = DB::table('coso')->where('doituong_id',$item)->get('id')->toArray();
        }
        //insert coso_hoat dong
        foreach($data_hoatdong_coso as $key=>$value){
            if($value==='ALL'){
                //doi tuong = all
                $allCoso_id = DB::table('coso')->get('id')->toArray();
                foreach($allCoso_id as $item => $row){
                    DB::table('coso_hoatdong')->insert([
                        'coso_id'=>$row->id,
                        'hoatdong_id'=> $current_hoat_dong_id
                    ]);
                }
                Session::put('message','Thêm hoạt động thành công.');
                return Redirect::to('quanlihoatdong');
            }
            else
            {
                foreach($data_hoatdong_coso as $key=>$value){
                    $coso_id = DB::table('coso')->where('name',$value)->get('id')->toArray();
                    if(count($coso_id)>0){
                        DB::table('coso_hoatdong')->insert([
                            'coso_id'=>$coso_id->id,
                            'hoatdong_id'=> $current_hoat_dong_id
                        ]);
                    }
                }

            }
        }
        
        Session::put('message','Thêm hoạt động thành công.');
        return Redirect::to('quanlihoatdong');
        }
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
        foreach($check as $key => $value){
            DB::table('coso_hoatdong')->where('hoatdong_id',$value)->delete();
            DB::table('phongtrao_hoatdong')->where('hoatdong_id',$value)->delete();
            DB::table('hoatdong')->where('id',$value)->delete();
        }
        Session::put('message','Xóa hoạt động thành công.');
        return Redirect::to('quanlihoatdong');
    }    
//--Thêm cơ sở
    public function insert_co_so_quanlicoso(Request $request){
        //insert table coso

        if(empty($request->input_name_coso)){
            Session::put('message','Nhập tên cơ sở');
            return Redirect::to('quanlicoso');
        }
        if(empty($request->input_doituong_id)){
            Session::put('message','Chọn đối tượng');
            return Redirect::to('quanlicoso');
        }
        if(empty($request->input_siso_coso)){
            Session::put('message','Nhập sĩ số');
            return Redirect::to('quanlicoso');
        }

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

        if(empty($request->input_name_users)){
            Session::put('message','Nhập tên người dùng');
            return back();
        }
        if(empty($request->input_email_users)){
            Session::put('message','Nhập email người dùng');
            return back();
        }
        if(empty($request->input_password_users)){
            Session::put('message','Nhập mật khẩu');
            return back();
        }
        if(empty($request->input_name_co_so)){
            Session::put('message','Chọn cơ sở');
            return back();
        }

        //insert table users
        $data_users = array();
        $data_users['name'] = $request->input_name_users;
        $data_users['email'] = $request->input_email_users;
        $data_users['password'] = bcrypt($request->input_password_users);
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


// -- Tài khoản
    // phân quyền
    public function update_quanlitaikhoan(Request $request){
        if(empty($request->input_user_id)){
            Session::put('message','Nhập mã tài khoản');
            return back();
        }

        $user_id = $request->input_user_id;
        $role_id = $request->select_role_name;
        //check user db
        $isExist = DB::table('users')->where('id','=',$user_id)->get();
        if(count($isExist)===0){
            Session::put('message','Tài khoản không tồn tại.');
            return back();
        }

        DB::table('user_role')->updateOrInsert(
            [
                'sv_id' => $user_id
            ],
            [
                'role_id' => $role_id
            ]);
        return back();
    }

    //delete hoat dong
    public function xoa_duyet_hoat_dong(Request $request){

        if(empty($request->array_hoat_dong))
        {
            Session::put('message','Chọn hoạt động cần xóa.');
            return back();
        }
        if(empty($request->action)){
            Session::put('message','action null');
            return back(); 
        }

        $list_hoat_dong = $request->array_hoat_dong;

        if(count($list_hoat_dong)===0){
            Session::put('message','Chọn hoạt động cần xóa.');
            return back(); 
        }

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
//--quản lí sinh viên
//--Xóa hoạt động
public function delete_users_quanlisinhvien(Request $request){
    if($request->check == null)
    {
        Session::put('message','Lỗi: Check hoạt động cần xóa');
        return Redirect::to('quanlisinhvien');
    }
    //delete 2 table phongtrao_hoatdong & hoatdong
    $check = $request->check;
    foreach($check as $key => $value){
        DB::table('sv_coso')->where('sv_id',$value)->delete();
        DB::table('user_role')->where('sv_id',$value)->delete();
        DB::table('users')->where('id',$value)->delete();
    }
    Session::put('message','Xóa user thành công.');
    return Redirect::to('quanlisinhvien');
}
//--quản lí xếp loại
  //--Xóa xếp loại
  public function delete_xep_loai_quanlixeploai($id){
    // delete table xeploai
    DB::table('xeploai')->where('id',$id)->delete();
    Session::put('message','Xóa xếp loại thành công.');
    return Redirect::to('quanlixeploai');
    }
//--Thêm xếp loại
    public function insert_xep_loai_quanlixeploai(Request $request){
        //insert table xeploai

        if(empty($request->input_name_xeploai)){
            Session::put('message','Nhập tên xếp loại');
            return Redirect::to('quanlixeploai');
        }
        if(empty($request->input_id_loai_bang_diem_xeploai)){
            Session::put('message','Chọn loại bảng điểm');
            return Redirect::to('quanlixeploai');
        }
        if(empty($request->input_canduoi_xeploai)){
            Session::put('message','Nhập cận dưới');
            return Redirect::to('quanlixeploai');
        }
        if(empty($request->input_cantren_xeploai)){
            Session::put('message','Nhập cận trên');
            return Redirect::to('quanlixeploai');
        }


        $data = array();
        $data['name'] = $request->input_name_xeploai;
        $data['loaibangdiem_id'] = $request->input_id_loai_bang_diem_xeploai;
        $data['canduoi'] = $request->input_canduoi_xeploai;
        $data['cantren'] = $request->input_cantren_xeploai;
        DB::table('xeploai')->insert($data);
        Session::put('message','Thêm xếp loại thành công.');
        return Redirect::to('quanlixeploai');
    }

    //-- --Danh sách sinh viên tham gia
    //--Xóa sinh viên tham gia
    public function delete_user_hoat_dong_danhsachsinhvienthamgiahoatdong(Request $request){
        if($request->check == null)
        {
            Session::put('message','Lỗi: Check hoạt động cần xóa');
            return Redirect::to('quanlihoatdong');
        }
        //delete 2 table phongtrao_hoatdong & hoatdong
        $check = $request->check;
        foreach($check as $key => $value){
            DB::table('user_hoatdong')->where('id',$value)->delete();
        }
        Session::put('message','Xóa sinh viên tham gia hoạt động thành công.');
        return back();
    }
    
    
//thống kê
public function thongke_ctsv(){
    //get id user hiện tại  
    if(Auth::user()!==NULL)
    {
        $auth_id = Auth::user()->id;
    }
    else
    {
        return view('Auth.login');
    }
    

    //get si_so
    $bangdiem = DB::table('bangdiem')->select('id','name')->get();

    return view('ctsv.thongke_ctsv',[
        'bangdiem' => $bangdiem
    ]);
}
}