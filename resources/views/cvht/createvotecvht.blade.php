@extends('cvht.trangchu')
@section('sidebar')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('phan-hoi-cvht')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">UIT - CVHT</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('phan-hoi-cvht')}}">
            <i class="fas fa-fw fa-comments"></i>
            <span>Phản hồi sinh viên</span></a>
    </li>
    <!-- Nav Item - Bảng điểm -->

    <!-- Nav Item - Cơ sở-Sinh viên -->

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-vote-yea"></i>
            <span>Thống kê - báo cáo</span></a>
    </li>
    <li class="nav-item active dropdown">
        <a class="nav-link dropdown-toggle" href="{{route('votecvht')}}" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Bầu chọn</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('create-vote-cvht')}}">Tạo bầu chọn</a>
            <a class="dropdown-item" href="{{route('votecvht')}}">Quản lí bầu chọn</a>
        </div>
    </li>
</ul>
<!-- End of Sidebar -->

@endsection


@section('main_content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tạo bầu chọn</h1>
    </div>

    <div class="mb-4">Chọn kiểu bầu chọn</div>
    <select class="card border-secondary shadow py-2 col-4 mb-4">
        @foreach($su_lua_chon as $key=>$value)
        <option value="{{$value->id}}">{{$value->name}}</option>
        @endforeach
    </select>
    <div class="mb-4">Nhập câu hỏi</div>
    <input name="input_name_hoatdong" type="text" class="card border-secondary shadow py-2 col-6 mb-4"/>

    <div class="mb-4">Ngày bắt đầu</div>
    <input name="input_name_hoatdong" type="text" class="card border-secondary shadow py-2 col-6 mb-4"/>
    <div class="mb-4">Ngày kết thúc</div>
    <input name="input_name_hoatdong" type="text" class="card border-secondary shadow py-2 col-6 mb-4"/>
    <div class="mb-4">Chọn ứng cử viên</div>
    <input name="input_name_hoatdong" type="text" class="card border-secondary shadow py-2 col-6 mb-4"/>
</div>
<!-- /.container-fluid -->
<script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>



@endsection