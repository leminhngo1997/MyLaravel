@extends('sinhvien.trangchu')
@section('sidebar')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
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
            <span>Tham gia hoạt động</span></a>
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
                            <hr/>
                            <div class="comment-content col-md-11 col-sm-10">
                                <h6 class="small comment-meta"><strong
                                        style="color: mediumslateblue">{{$value->user_name_comment}}</strong> Today,
                                    2:38</h6>
                                <div class="comment-body">
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
                            @foreach($replies as $item)
                            @foreach($item as $key=>$value)
                            <div class="comment-reply col-md-11 offset-md-1 col-sm-10 offset-sm-2">
                                <div class="row">
                                    <div class="comment-content col-md-11 col-sm-10 col-12">
                                    <h6 class="small comment-meta"><a href="#">{{$value->user_name_reply}}</a> Today, 12:31</h6>
                                        <div class="comment-body">
                                            <p>{{$value->reply_text}}<br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endforeach
                            <!-- /reply is indented -->
                        </form>

                        @endforeach

                        <!-- reply is indented -->

                    </div>

                    <!-- /comment -->
                    <div class="row pt-2">
                        <div class="col-12">
                            <a href="" class="btn btn-sm btn-primary">Add a Comment</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>

<script>
    function myFunction(key) {
        console.log(key);
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
@endsection