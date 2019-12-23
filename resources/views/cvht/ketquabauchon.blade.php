@extends('cvht.trangchu')
@section('sidebar')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion border-right" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a style="color: indianred; background-color: white" class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('quanlibangdiem')}}">
        <div class="sidebar-brand-icon">
            <img style="width: 60px; height: 60px" class="img-profile" src="{{asset('public/admin/img/uit.png')}}">
        </div>
        <div class="sidebar-brand-text mx-3">CVHT</div>
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
        <a class="nav-link" href="{{route('thongke-cvht')}}">
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


    <div class="col-xl-10 col-md-12 col-sm-12 mb-4">
        <div class="card-body">
            <div style="text-align: center"><strong>KẾT QUẢ BẦU CHỌN</strong></div>
        </div>
        @foreach ($list_cauhoi as $key=>$value)
    <label>Câu hỏi:<strong style="color: darkblue"> {{$value->name_cauhoi}}</strong> </label>
        @endforeach
        <div class="card border-secondary shadow h-100 py-2 col-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">TOP</th>
                        <th scope="col">Email</th>
                        <th scope="col">Tên ứng cử viên</th>
                        <th scope="col">Số phiếu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ungcuvien_id as $key=> $value)
                    <tr>
                    <td scope="row">{{$key+1}}</td>
                    <td scope="row">{{$value['email']}}</td>
                    <td scope="row">{{$value['user_name']}}</td>
                    <td scope="row">{{$value['count']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>



@endsection