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
                <div class="border mb-3">
                    <div class="m-1 h3">{{$value->mota}}</div>
                </div>
                @endforeach
                <input type="text" class="card border-secondary shadow h-100 py-2 col-6 mb-4">
                <button type="submit" class="btn btn-outline-secondary">Bình luận</button>
            </div>

        </div>
        <div class="row">
            <div class="col-1"></div>
            <div class="card border-secondary shadow col-10">
                <!-- danh sách trả lời -->
                <ul class="mb-4">
                    <li class="border-bottom border-top">
                        <div class="d-flex justify-content-between">
                            <div class="text-small">
                                <strong>Alex Steward</strong> - <strong>HTTT2019</strong>
                                <p class="last-message text-muted">không biết không biết không biết không biết không
                                    biết không biết</p>
                            </div>
                            <div class="chat-footer">
                                <p class="text-smaller text-muted mb-0">Yesterday</p>
                                <span class="text-muted float-right"><i class="fas fa-mail-reply"
                                        aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <a role="button" tabindex="0">Trả lời</a>
                    </li>

                    <li class="border-bottom border-top">
                        <div class="d-flex justify-content-between">
                            <div class="text-small">
                                <strong>Alex Steward</strong> - <strong>HTTT2019</strong>
                                <p class="last-message text-muted">không biết không biết không biết không biết không
                                    biết không biết không biết không biết không biết không biết không biết không biết
                                    không biết</p>
                            </div>
                            <div class="chat-footer">
                                <p class="text-smaller text-muted mb-0">Yesterday</p>
                                <span class="text-muted float-right"><i class="fas fa-mail-reply"
                                        aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <a role="button" tabindex="0">Trả lời</a>
                    </li>

                    <li class="border-bottom border-top">
                        <div class="d-flex justify-content-between">
                            <div class="text-small">
                                <strong>Alex Steward</strong> - <strong>HTTT2019</strong>
                                <p class="last-message text-muted">không biết</p>
                            </div>
                            <div class="chat-footer">
                                <p class="text-smaller text-muted mb-0">Yesterday</p>
                                <span class="text-muted float-right"><i class="fas fa-mail-reply"
                                        aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <a role="button" tabindex="0">Trả lời</a>
                    </li>
                </ul>
                <!-- input tra loi -->
                <div class="row m-4">
                    <input type="text" class="card border-secondary shadow col-10" />
                    <button type="button" class="btn btn-outline-secondary">Gửi</button>
                </div>
            </div>
            <div class="col-1"></div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>
@endsection