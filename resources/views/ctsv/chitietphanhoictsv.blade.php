@extends('sinhvien.trangchu')
@section('sidebar')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion border-right" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a style="color: indianred; background-color: white"
        class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('quanlibangdiem')}}">
        <div class="sidebar-brand-icon">
            <img style="width: 60px; height: 60px" class="img-profile" src="{{asset('public/admin/img/uit.png')}}">
        </div>
        <div class="sidebar-brand-text mx-3">CTSV</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active dropdown">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <a class="nav-link dropdown-toggle" href="{{route('quanlitieuchi')}}" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Quản lý chung</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('quanlitieuchi')}}">Quản lý tiêu chí</a>
            <a class="dropdown-item" href="{{route('quanliphongtrao')}}">Quản lý phong trào</a>
            <a class="dropdown-item" href="{{route('quanlihoatdong')}}">Quản lý hoạt động</a>
            <a class="dropdown-item" href="{{route('duyethoatdong')}}">Xét duyệt hoạt động</a>
            <a class="dropdown-item" href="{{route('importsinhvienthamgiahoatdong')}}">Import sinh viên tham gia hoạt
                động</a>
            <a class="dropdown-item" href="{{route('phan-hoi-ctsv')}}">Phản hồi sinh viên</a>
        </div>
    </li>
    <!-- Nav Item - Bảng điểm -->
    <li class="nav-item active dropdown">
        <a class="nav-link dropdown-toggle" href="{{route('quanlibangdiem')}}" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Bảng điểm</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('quanlibangdiem')}}">Quản lý bảng điểm</a>
            <a class="dropdown-item" href="{{route('quanlixeploai')}}">Quản lý xếp loại</a>
        </div>
    </li>
    <!-- Nav Item - Cơ sở-Sinh viên -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="{{route('quanlicoso')}}" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Quản lý Lớp-Sinh viên</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('quanlicoso')}}">Quản lý lớp</a>
            <a class="dropdown-item" href="{{route('quanlisinhvien')}}">Quản lý sinh viên</a>
            <a class="dropdown-item" href="{{route('quanlitaikhoan')}}">Phân quyền tải khoản</a>
        </div>
    </li>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('thongkectsv')}}">
            <i class="fas fa-fw fa-vote-yea"></i>
            <span>Thống kê - báo cáo</span></a>
    </li>
</ul>
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
                            <hr />
                            <div class="comment-content col-md-11 col-sm-10 dropdown_comment_id">
                                <h6 class="small comment-meta"><strong
                                        style="color: mediumslateblue">{{$value->user_name_comment}}</strong> Today,
                                    2:38</h6>
                                {{-- {{dd($comments)}}; --}}
                                <div value="{{$value->id}}" class="comment-body dropdown_comment_id_{{$value->id}}">
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

                            <div id="show-replies-{{$value->id}}"
                                class="comment-reply col-md-11 offset-md-1 col-sm-10 offset-sm-2">
                                @foreach ($replies as $row)
                                @foreach ($row as $i => $v)


                                @if ($v->comment_id===$value->id)


                                <div class="row delete-row-reply">
                                    <div class="comment-content col-md-11 col-sm-10 col-12">
                                        <h6 class="small comment-meta"><strong style="color: mediumslateblue">
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

@endsection