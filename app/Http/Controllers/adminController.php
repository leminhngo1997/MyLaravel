<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use DB;

class adminController extends Controller
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
        if($role->name == "admin"){
            
		}else{
            Redirect::to('login')->send();
        }
    }

    public function get_value_quanlitaikhoan_admin(){
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
        unset($user_role['0']);
        // dd($user_role);
        unset($role['4']);//role admin
        return view('admin.quanlitaikhoan-admin',[
            'role'=>$role,
            'user'=>$user,
            'user_role'=>$user_role
        ]);
    }

    // -- Tài khoản
    // phân quyền
    public function update_quanlitaikhoan_admin(Request $request){
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
            Session::put('message','Phân quyền thành công');
        return back();
    }
}
