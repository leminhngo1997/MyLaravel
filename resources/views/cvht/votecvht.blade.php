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
    <li class="nav-item active">
        <a class="nav-link" href="{{route('feedback')}}">
            <i class="fas fa-fw fa-comments"></i>
            <span>Thống kê báo cáo</span></a>
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
        <h1 class="h3 mb-0 text-gray-800">VOTE</h1>
    </div>     
       
    <div class="col-xl-10 col-md-12 col-sm-12 mb-4">
        <div class="card border-secondary shadow h-100 py-2 col-12">
            <div class="row">
                <div class="col-7">
                    <h1 class="h4 m-2 text-gray-800">Danh sách phản hồi</h1>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-unstyled friend-list">
                  
                </ul>
            </div>
            <!-- page navigation -->
           
        </div>
    </div>

    </div>
    <!-- /.container-fluid -->
    <script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>
    
    

@endsection
