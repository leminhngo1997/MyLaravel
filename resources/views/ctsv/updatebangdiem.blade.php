@extends('ctsv.trangchu')

@section('sidebar')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion border-right" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a style="color: indianred; background-color: white" class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('quanlibangdiem')}}">
        <div class="sidebar-brand-icon">
            <img style="width: 60px; height: 60px" class="img-profile" src="{{asset('public/admin/img/uit.png')}}">
        </div>
        <div class="sidebar-brand-text mx-3">CTSV</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item dropdown">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <a class="nav-link dropdown-toggle" href="{{route('quanlitieuchi')}}" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Quản lý hoạt động</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('quanlitieuchi')}}">Tiêu chí</a>
            <a class="dropdown-item" href="{{route('quanliphongtrao')}}">Phong trào</a>
            <a class="dropdown-item" href="{{route('quanlihoatdong')}}">Hoạt động</a>
            <a class="dropdown-item" href="{{route('duyethoatdong')}}">Xét duyệt hoạt động</a>
            <a class="dropdown-item" href="{{route('importsinhvienthamgiahoatdong')}}">Danh sách tham gia hoạt
                động</a>
            <a class="dropdown-item" href="{{route('phan-hoi-ctsv')}}">Phản hồi sinh viên</a>
        </div>
    </li>
    <!-- Nav Item - Bảng điểm -->
    <li class="nav-item active dropdown">
        <a class="nav-link dropdown-toggle" href="{{route('quanlibangdiem')}}" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Quản lý bảng điểm</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('quanlibangdiem')}}">Bảng điểm</a>
            <a class="dropdown-item" href="{{route('quanlixeploai')}}">Xếp loại</a>
        </div>
    </li>
    <!-- Nav Item - Cơ sở-Sinh viên -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="{{route('quanlicoso')}}" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Quản lý sinh viên</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('quanlicoso')}}">Lớp học</a>
            <a class="dropdown-item" href="{{route('quanlisinhvien')}}">Sinh viên</a>
            <a class="dropdown-item" href="{{route('quanlitaikhoan')}}">Tài khoản</a>
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
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý bảng điểm</h1>
    </div>

    <div class="card-body">
        <!-- collapse 2 content -->
        <div class="col-xl-12 col-md-12 col-sm-12 mb-4">
            <div class="col-12">
                <div class="shadow h-100 py-2 col-12">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1 class="h3 ml-3 text-gray-800">Chỉnh sửa bảng điểm</h1>
                        </div>
                        <table class="border table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Mã bảng điểm</th>
                                    <th scope="col">Tên bảng điểm</th>
                                    <th scope="col">Loại bảng điểm</th>
                                    <th scope="col">Điểm bảng điểm</th>
                                    <th scope="col">Ngày bắt đầu</th>
                                    <th scope="col">Ngày kết thúc</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bang_diem as $key=>$value)

                                <tr>
                                    <td>{{$value->id}}</td>
                                    <td>{{$value->name}}</td>
                                    <td>{{$value->loaibangdiem_id}}</td>
                                    <td>{{$value->maxbangdiem}}</td>
                                    <td>{{date('d-m-Y', strtotime($value->ngaybatdau))}}</td>
                                    <td>{{date('d-m-Y', strtotime($value->ngayketthuc))}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <form method="POST" role="form" action="{{URL::to('/sua-bang-diem-ctsv')}}">
                        <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span style="color:red">' .$message. '</span>';
                                Session::put('message',null);
                                }
                        ?>
                        {{csrf_field()}}
                        <input type="text" hidden name="input_id_bangdiem" value="{{$value->id}}" class="card border-secondary shadow h-100 py-2 col-6 mb-4">
                        @foreach ($bang_diem as $key=>$value)
                        <div class="card-body col-12 mb-4">
                            <div class="mb-4">Tên bảng điểm mới</div>
                        <input type="text" name="input_name_bangdiem" value="{{$value->name}}" class="card border-secondary shadow h-100 py-2 col-6 mb-4">
    
                            <div class="mb-4">Điểm tối đa của bảng điểm mới</div>
                            <input type="text" name="input_maxbangdiem_bangdiem" value="{{$value->maxbangdiem}}" class="card border-secondary shadow h-100 py-2 col-6 mb-4">
                            
                            <div class="mb-4">Loại bảng điểm</div>
                            <input type="text" name="input_loaibangdiem_id_bangdiem" value="{{$value->loaibangdiem_id}}" class="card border-secondary shadow h-100 py-2 col-6 mb-4">
                            
                            <div class="mb-4">Ngày bắt đầu</div>
                            <input type="date" name="input_ngaybatdau_bangdiem" value="{{$value->ngaybatdau}}" placeholder="yyyy-mm-dd"
                                class="form-custom border-secondary h-100 py-2 col-6 mb-4">
    
                            <div class="mb-4">Ngày kết thúc</div>
                            <input type="date" name="input_ngayketthuc_bangdiem" value="{{$value->ngayketthuc}}" placeholder="yyyy-mm-dd"
                                class="form-custom border-secondary h-100 py-2 col-6 mb-4">
                            
                        </div>
                        <input type="submit" value="Sửa bảng điểm"
                                class="btn btn-outline-secondary py-2 shadow" />
                        @endforeach
                    </form>
                   
                </div>
            </div>
        </div>

        <!-- Content Row -->

    </div>
    <!-- /.container-fluid -->

    <!-- check all -->
    <script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>
    <script>
        $("#checkAllBangdiem").click(function () {
            $(".checkBangdiem").prop('checked', $(this).prop('checked'))
        });
    </script>

    <script>
        $("#checkAllKhoahoc").click(function () {
            $(".checkKhoahoc").prop('checked', $(this).prop('checked'))
        });
    </script>

    <script>
        $("#checkAllKhoahoc2").click(function () {
            $(".checkKhoahoc2").prop('checked', $(this).prop('checked'))
        });
    </script>


    @endsection