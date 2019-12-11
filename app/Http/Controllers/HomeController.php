<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        
		$auth_id = Auth::user()->id;
		$user_role = DB::table('user_role')->where('sv_id', $auth_id)->first('role_id');
        $role = DB::table('roles')->where('id', $user_role->role_id)->first('name');
		if($role->name == "sinh viên"){
			return redirect()->route('dashboard');
		}
		elseif ($role->name == "lớp trưởng"){
			return redirect()->route('dashboard');
        }
        elseif ($role->name == "ctsv"){
			return redirect()->route('quanlibangdiem');
		}
		else{
            return view('home');
		}
    }
}
