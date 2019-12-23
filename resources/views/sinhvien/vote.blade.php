
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
<!-- Begin Page Content -->
<div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Bầu chọn</h1>
        </div>
        <!-- Content Row -->
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên bầu chọn</th>
                <th scope="col">Bắt đầu</th>
                <th scope="col">Kết thúc</th>
                <th scope="col">Lựa chọn</th>
                <th scope="col">Tình trạng</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($list_cauhoi as $key=>$value)
              <tr>
                <th scope="row">{{$key+1}}</th>
              <td><a href="{{URL::to('/vote-chi-tiet')}}/{{$value->id}}">{{$value->name_cauhoi}}</a></td>
                <td>{{$value->ngaybatdau}}</td>
                <td>{{$value->ngayketthuc}}</td>
                <td><?php
                  if($value->suluachon_id == 1)
                    echo "Một";
                  else {
                    echo "Nhiều";
                  }
                ?></td>
                <td><?php 
                if($value->ngayketthuc < date('Y-m-d'))
                {
                  echo "<div style='color: red'>Hết hạn</div>";
                }
                else {
                  echo "<div style='color: blue'>Đang mở</div>";
                }
                ?></td>
              </tr>
              @endforeach
              
             
            </tbody>
          </table>
      
    </div>
@endsection