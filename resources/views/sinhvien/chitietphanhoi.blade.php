@extends('sinhvien.trangchu')
@section('sidebar')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Sidebar -->
    <script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>
    <ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion border-right" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a style="color: indianred; background-color: white" class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('quanlibangdiem')}}">
            <div class="sidebar-brand-icon">
                <img style="width: 60px; height: 60px" class="img-profile" src="{{asset('public/admin/img/uit.png')}}">
            </div>
            <div class="sidebar-brand-text mx-3">SINH VIÊN</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="{{route('dashboard')}}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('thamgiahoatdong')}}">
                <i class="fas fa-fw fa-skating"></i>
                <span>Tạo hoạt động</span></a>
        </li>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('feedback')}}">
                <i class="fas fa-fw fa-comments"></i>
                <span>Phản hồi</span></a>
        </li>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('vote')}}">
                <i class="fas fa-fw fa-vote-yea"></i>
                <span>Bầu chọn</span></a>
        </li>
        {{-- thong ke - lop truong --}}
        <li class="nav-item" id="loptruong_only">
            <a class="nav-link" href="{{route('thongke')}} " >
                <i class="fas fa-fw fa-thongke"></i>
                <span>Thống kê</span></a>
        </li>

    </ul>
    <input type="text" id = "sidebar-user-quyen" value={{$quyen}} hidden/>
    <script>
        //get user info
        var quyen = $('#sidebar-user-quyen').val();
        if(quyen==='loptruong'){
            $('#loptruong_only').show();
        }
        else $('#loptruong_only').hide();
    </script>

    <!-- End of Sidebar -->
@endsection
@section('main_content')
<div class="row col-md-12">
    <div class="col-md-2"></div>
    <div class="col-md-8 col-sm-12 mb-4">
        <div class="card border-secondary shadow py-2 col-12">
            <h1 class="h4 m-2 text-gray-800">Chi tiết phản hồi</h1>
            <div class="card-body">
                @foreach ($posts as $key=>$value)
                    <div class="mb-4">
                        <!-- thông tin người viết -->
                        <strong style="color: coral">*{{$value->name_hoatdong}}</strong>
                        <div>
                            <span style="color: darkgray">-TC: {{$value->name_tieuchi}}</span>
                        </div>
                        <div>
                            <span style="color: darkgrey">-PT: {{$value->name_phongtrao}}</span>
                        </div>

                        <!-- nội dung thắc mắc -->
                        {{-- <p class="text-smaller text-muted mb-0">Just now</p> --}}
                    </div>
                    <strong style="color: mediumblue" class="m-1 h3">{{$value->mota}}</strong>
                @endforeach
                <br />
                <br />
                <br />
                <form method="post" enctype="multipart/form-data" action="{{ url('/them-comment') }}">
                    {{ csrf_field() }}
                    <input name="input_comment" type="text" placeholder="Bình luận...."
                        class="card border-secondary shadow h-100 py-2 col-8 mb-4" />
                    <button name="input_post_id" type="submit" value="{{$post_id}}"
                        class="btn btn-outline-secondary py-2 shadow">Gửi</button>
                </form>


            </div>

        </div>
        <br />
        <div class="container py-2">
            <div class="row">
                <div class="comments col-md-9" id="comments">
                    <h3 class="mb-4 font-weight-light">Bình luận</h3>
                    <!-- comment -->
                    <div class="comment mb-2">

                        @foreach ($comments as $key=>$value)
                            <form method="POST" role="form" action="{{URL::to('/them-reply')}}">
                                {{ csrf_field() }}
                                <hr/>
                                <div class="comment-content col-md-11 col-sm-10 dropdown_comment_id">
                                    <h6 class="small comment-meta"><strong
                                            style="color: mediumslateblue">{{$value->user_name_comment}}</strong> Today,
                                        2:38</h6>
                                        {{-- {{dd($comments)}}; --}}
                                    <div  value="{{$value->id}}" class="comment-body dropdown_comment_id_{{$value->id}}">
                                        <p>{{$value->comment_text}}<br>
                                            <a onclick="myFunction({{$key}})" role="button" tabindex="0"
                                                class="text-right small"><i class="ion-reply"></i> Reply</a>
                                            <div class="row">
                                                <input id="myInput_{{$key}}" placeholder="Trả lời..."
                                                    name="input_reply_text" style="display: none"
                                                    class="card border-secondary shadow h-100 py-2 col-8" type="text">
                                                <button id="myButton_{{$key}}" class="btn btn-info" style="display: none"
                                                    type="submit" name="input_comment_id"
                                                    value="{{$value->id}}">Gửi</button>
                                            </div>
                                        </p>
                                    </div>
                                </div>
 
                            <div id="show-replies-{{$value->id}}" class="comment-reply col-md-11 offset-md-1 col-sm-10 offset-sm-2">
                                    @foreach ($replies as $row)
                                        @foreach ($row as $i => $v)
                                            
                                        
                                            @if ($v->comment_id===$value->id)
                                                
                                            
                                            <div class="row delete-row-reply">
                                                <div class="comment-content col-md-11 col-sm-10 col-12">
                                                    <h6 class="small comment-meta"><strong
                                                        style="color: mediumslateblue">
                                                        @foreach ($list_user as $ls)
                                                            @if ($v->sv_id===$ls['user_id'])
                                                                
                                                                {{$ls['user_name']}}
    
                                                            @endif
                                                        @endforeach
                                                        </strong> Today,
                                                    2:38</h6>
                                                    <div class="comment-body">
                                                        <p>{{$v->reply_text}}<br>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            @endif
                                        @endforeach
                                    @endforeach
                            </div>
                                
                                <!-- /reply is indented -->
                            </form>
                        @endforeach


                        <!-- reply is indented -->

                    </div>

                    <!-- /comment -->
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>

<script>
    function myFunction(key) {
        var x = document.getElementById("myInput_" + key);
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
        var y = document.getElementById("myButton_" + key);
        if (y.style.display === "none") {
            y.style.display = "block";
        } else {
            y.style.display = "none";
        }
    }
</script>
<script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>
{{-- <script>
     $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
      
        // var allListElements = $( "div" );   
        var x = $("div.dropdown_comment_id").children("div");
        var getSelected = [];
        for (var i = 0; i< x.length;i++)
        {
            getSelected.push(x[i].attributes[0].value);
        }    
        $.ajax({
            
            type: 'POST',
            url: "{{url('get-comment-id-feedback')}}",
            data: {
                comment_id: getSelected
            },
            success: function (data) {
                data.forEach(element => {
                    html = ` <div class="row delete-row-reply">
                                    <div class="comment-content col-md-11 col-sm-10 col-12">
                                    <h6 class="small comment-meta"><a href="#">`+element.user_name_reply+`</a> Today, 12:31</h6>
                                        <div class="comment-body">
                                            <p>`+element.reply_text+`<br>
                                            </p>
                                        </div>
                                    </div>
                                </div> `;
                var show_replies_id = '#show-replies-'+element.comment_id;
                debugger;
                console.log(show_replies_id);
                $(show_replies_id).append(html);
                });
            }
        });
    });
</script> --}}
@endsection