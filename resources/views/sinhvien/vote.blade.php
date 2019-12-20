
@extends('sinhvien.trangchu')

@section('sidebar')
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
            <li class="nav-item">
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
            <li class="nav-item active">
                <a class="nav-link" href="{{route('vote')}}">
                    <i class="fas fa-fw fa-vote-yea"></i>
                    <span>Bầu chọn</span></a>
            </li>


        </ul>
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
              <td><a href="">{{$value->name_cauhoi}}</a></td>
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