@extends('ctsv.trangchu')

@section('sidebar')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">CTSV - UIT<sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item dropdown">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <a class="nav-link dropdown-toggle" href="{{route('quanlitieuchi')}}" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Đoàn hội</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('quanlitieuchi')}}">Quản lí tiêu chí</a>
            <a class="dropdown-item" href="{{route('quanliphongtrao')}}">Quản lí phong trào</a>
            <a class="dropdown-item" href="{{route('quanlihoatdong')}}">Quản lí hoạt động</a>
            <a class="dropdown-item" href="{{route('duyethoatdong')}}">Xét duyệt hoạt động</a>
        </div>
    </li>
    <!-- Nav Item - Bảng điểm -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="{{route('quanlibangdiem')}}" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Bảng điểm</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('quanlibangdiem')}}">Quản lí bảng điểm</a>
            <a class="dropdown-item" href="{{route('quanlixeploai')}}">Quản lí xếp loại</a>
            <a class="dropdown-item" href="{{route('importsinhvienthamgiahoatdong')}}">Import sinh viên tham gia hoạt
                động</a>
        </div>
    </li>
    <!-- Nav Item - Cơ sở-Sinh viên -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="{{route('quanlicoso')}}" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Cơ sở-Sinh viên</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('quanlicoso')}}">Quản lí cơ sở</a>
            <a class="dropdown-item" href="{{route('quanlisinhvien')}}">Quản lí sinh viên</a>
            <a class="dropdown-item" href="{{route('quanlitaikhoan')}}">Phân quyền tải khoản</a>
        </div>
    </li>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="#">
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
        <h1 class="h3 mb-0 text-gray-800">Quản lí tham gia hoạt động</h1>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-12 col-md-12 col-sm-12 mb-4">
            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
                                aria-expanded="true" aria-controls="collapseOne">
                                Hoạt động đã chọn
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">

                        <div class="card-body">
                            <!-- Core sheet type -->
                            <!-- collapse 1 content -->

                            <table class="border table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Mã hoạt động</th>
                                        <th scope="col">Tên hoạt động</th>
                                        <th scope="col">Điểm</th>
                                    </tr>
                                </thead>
                                <tbody id="show-hoat-dong">
                                    @foreach($list_hoat_dong as $key=>$value)
                                    <td>{{$value->id}}</td>
                                    <td>{{$value->name}}</td>
                                    <td>{{$value->diem}}</td>
                                    @endforeach
                                </tbody>
                            </table>


                            <div class="card-body col-12 mb-4">

                                <div class="mb-4" style="color:brown">Hệ số
                                    0 là đăng kí nhưng không tham gia </div>
                                <div class="mb-4" style="color:brown">Hệ số
                                    1 là đã tham gia</div>
                                <div class="mb-4" style="color:brown">Hệ số
                                    -1 là không đăng ký</div>
                                <table class="border table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Mã sinh viên</th>
                                            <th scope="col">Tên sinh viên</th>
                                            <th scope="col">Hệ số tham gia</th>
                                            <th scope="col">Chú thích</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show-hoat-dong">
                                        {{--  --}}
                                    </tbody>
                                </table>
                                <div>Upload file danh sách tham gia (xls, xlsx)</div>
                                <form method="post" enctype="multipart/form-data"
                                    action="{{ url('/quanlihoatdong/import') }}">
                                    {{ csrf_field() }}

                                    <input type="file" name="select_file"
                                        class="btn btn-outline-secondary py-2 shadow" />
                                    <input type="submit" name="upload" value="Upload"
                                        class="btn btn-outline-secondary py-2 shadow" />
                                </form>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>



@endsection