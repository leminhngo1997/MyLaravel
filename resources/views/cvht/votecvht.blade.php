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
          <i class="fas fa-list-alt"></i>
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
        <h1 class="h3 mb-0 text-gray-800">Danh sách các cuộc bầu chọn</h1>
    </div>     
    <?php
    $message = Session::get('message');
    if($message){
        echo '<span style="color:red">' .$message. '</span>';
        Session::put('message',null);
        }
        ?>
    <div class="col-xl-10 col-md-12 col-sm-12 mb-4">
        <div class="card border-secondary shadow h-100 py-2 col-12">
          
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="check" id="checkAll">
                            </label>
                        </div>
                    </th>
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
                        <td>
                            <div class="checkbox">
                                <label>
                                    <input value="{{$value->id}}" name="check[]" type="checkbox" class="check">
                                </label>
                            </div>
                        </td>
                      <th scope="row">{{$key+1}}</th>
                      
                    <td><a href="{{URL::to('/ket-qua-bau-chon-cvht')}}/{{$value->id}}">{{$value->name_cauhoi}}</a></td>
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
            <!-- page navigation -->
           
        </div>
    </div>

    </div>
    <!-- /.container-fluid -->
    <script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>
    
    

@endsection
