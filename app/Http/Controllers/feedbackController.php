<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use DB;

class feedbackController extends Controller
{
    public function get_value_feedbackdetail($id){
          //get id user hiện tại
        if(Auth::user()!==NULL)
        {
            $auth_id = Auth::user()->id;
        }
        else
        {
            return view('Auth.login');
        }
        //get phân quyền
        $quyen_id = DB::table('user_role')->where('sv_id',$auth_id)->get('role_id');
        $quyen_id = end($quyen_id);
        $quyen_id = end($quyen_id);
        $quyen_id = end($quyen_id);

        switch($quyen_id)
        {
            case 1: $quyen = 'sinhvien'; break;
            case 2: $quyen = 'loptruong'; break;
            case 3: $quyen = 'ctsv'; break;
        }
        $posts = DB::table('posts')->where('id',$id)->get();
        $comments = DB::table('comments')->where('post_id',$id)->get();
        $user_name_comment = DB::table('users')->join('comments','users.id','=','comments.sv_id')->where('comments.post_id',$id)->get();
        $comment_id = array();
        $replies = array();
        $list_user_id_reply = array();
        $list_user_id = array();
        $list_user = array();
        foreach($comments as $key=>$value)
        {
            $replies[] = DB::table('replies')->where('comment_id',$value->id)->get();
            array_push($list_user_id_reply,DB::table('users')->join('replies','users.id','=','replies.sv_id')->where('replies.comment_id',$value->id)->select('sv_id','users.name')->get());
            
            foreach($user_name_comment as $row=>$item)
            {
                $value->user_name_comment = $item->name;
            }  
        }
        $count_dup = 0;
        $temp_arr = array();
        foreach($list_user_id_reply as $row => $value)
        {
            foreach($value as $key=>$item){   
                if($row === 0 && $key === 0)
                    {
                        $list_user[] = array(
                            'user_id' => $item->sv_id,
                            'user_name'=>$item->name
                        );

                        $temp_arr[] = $item->sv_id;
                    }
                else {
                        foreach($temp_arr as $index => $i){
                            if($item->sv_id===$i)
                            {
                                $count_dup ++;
                            }
                        }
                        if($count_dup===0){
                            $list_user[] = array(
                                'user_id' => $item->sv_id,
                                'user_name'=>$item->name
                            );
                            $temp_arr[] = $item->sv_id;
                        }
                    }
            }
        }
        return view('sinhvien.chitietphanhoi',[
            'post_id'=>$id,
            'posts'=>$posts,
            'comments'=>$comments,
            'replies'=>$replies,
            'list_user'=>$list_user,
            'quyen'=>$quyen,
            ]);
    }
       //--Thêm comments
       public function insert_comment(Request $request){
        //insert table comments
        $current_user = Auth::user()->id;
        $data_comment = array();
        $data_comment['comment_text'] = $request->input_comment;
        $data_comment['post_id'] = $request->input_post_id;
        $data_comment['sv_id'] = $current_user;
        DB::table('comments')->insert($data_comment);
        return back();
    }
        //--Thêm replies
        public function insert_reply(Request $request){
            //insert table replies
            $current_user = Auth::user()->id;
            $data_reply = array();
            $data_reply['reply_text'] = $request->input_reply_text;
            $data_reply['comment_id'] = $request->input_comment_id;
            $data_reply['sv_id'] = $current_user;
            DB::table('replies')->insert($data_reply);
            return back();
        }
        public function get_value_feedbackdetailctsv($id){
            
            $posts = DB::table('posts')->where('id',$id)->get();
            $comments = DB::table('comments')->where('post_id',$id)->get();
            $user_name_comment = DB::table('users')->join('comments','users.id','=','comments.sv_id')->where('comments.post_id',$id)->get();
            $comment_id = array();
            $replies = array();
            $list_user_id_reply = array();
            $list_user_id = array();
            $list_user = array();
            foreach($comments as $key=>$value)
            {
                $replies[] = DB::table('replies')->where('comment_id',$value->id)->get();
                array_push($list_user_id_reply,DB::table('users')->join('replies','users.id','=','replies.sv_id')->where('replies.comment_id',$value->id)->select('sv_id','users.name')->get());
                
                foreach($user_name_comment as $row=>$item)
                {
                    $value->user_name_comment = $item->name;
                }  
            }
            $count_dup = 0;
            $temp_arr = array();
            foreach($list_user_id_reply as $row => $value)
            {
                foreach($value as $key=>$item){   
                    if($row === 0 && $key === 0)
                        {
                            $list_user[] = array(
                                'user_id' => $item->sv_id,
                                'user_name'=>$item->name
                            );

                            $temp_arr[] = $item->sv_id;
                        }
                    else {
                            foreach($temp_arr as $index => $i){
                                if($item->sv_id===$i)
                                {
                                    $count_dup ++;
                                }
                            }
                            if($count_dup===0){
                                $list_user[] = array(
                                    'user_id' => $item->sv_id,
                                    'user_name'=>$item->name
                                );
                                $temp_arr[] = $item->sv_id;
                            }
                        }
                }
            }

            return view('ctsv.chitietphanhoictsv',[
                'post_id'=>$id,
                'posts'=>$posts,
                'comments'=>$comments,
                'replies'=>$replies,
                'list_user'=>$list_user
                ]);
        }
        public function get_value_feedbackdetailcvht($id){
            
            $posts = DB::table('posts')->where('id',$id)->get();
            $comments = DB::table('comments')->where('post_id',$id)->get();
            $user_name_comment = DB::table('users')->join('comments','users.id','=','comments.sv_id')->where('comments.post_id',$id)->get();
            $comment_id = array();
            $replies = array();
            $list_user_id_reply = array();
            $list_user_id = array();
            $list_user = array();
            foreach($comments as $key=>$value)
            {
                $replies[] = DB::table('replies')->where('comment_id',$value->id)->get();
                array_push($list_user_id_reply,DB::table('users')->join('replies','users.id','=','replies.sv_id')->where('replies.comment_id',$value->id)->select('sv_id','users.name')->get());
                
                foreach($user_name_comment as $row=>$item)
                {
                    $value->user_name_comment = $item->name;
                }  
            }
            $count_dup = 0;
            $temp_arr = array();
            foreach($list_user_id_reply as $row => $value)
            {
                foreach($value as $key=>$item){   
                    if($row === 0 && $key === 0)
                        {
                            $list_user[] = array(
                                'user_id' => $item->sv_id,
                                'user_name'=>$item->name
                            );

                            $temp_arr[] = $item->sv_id;
                        }
                    else {
                            foreach($temp_arr as $index => $i){
                                if($item->sv_id===$i)
                                {
                                    $count_dup ++;
                                }
                            }
                            if($count_dup===0){
                                $list_user[] = array(
                                    'user_id' => $item->sv_id,
                                    'user_name'=>$item->name
                                );
                                $temp_arr[] = $item->sv_id;
                            }
                        }
                }
            }

            return view('cvht.chitietphanhoicvht',[
                'post_id'=>$id,
                'posts'=>$posts,
                'comments'=>$comments,
                'replies'=>$replies,
                'list_user'=>$list_user
                ]);
        }
}
