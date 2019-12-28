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
            <span>Quản lý chung</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('quanlitieuchi')}}">Quản lý tiêu chí</a>
            <a class="dropdown-item" href="{{route('quanliphongtrao')}}">Quản lý phong trào</a>
            <a class="dropdown-item" href="{{route('quanlihoatdong')}}">Quản lý hoạt động</a>
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
            <a class="dropdown-item" href="{{route('quanlibangdiem')}}">Quản lý bảng điểm</a>
            <a class="dropdown-item" href="{{route('quanlixeploai')}}">Quản lý xếp loại</a>
        </div>
    </li>
    <!-- Nav Item - Cơ sở-Sinh viên -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="{{route('quanlicoso')}}" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Quản lý Lớp-Sinh viên</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('quanlicoso')}}">Quản lý lớp</a>
            <a class="dropdown-item" href="{{route('quanlisinhvien')}}">Quản lý sinh viên</a>
            <a class="dropdown-item" href="{{route('quanlitaikhoan')}}">Phân quyền tải khoản</a>
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
    <!-- Content Row -->
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-12 col-md-12 col-sm-12 mb-4">
            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree"
                                aria-expanded="false" aria-controls="collapseThree">
                                Tạo mới bảng điểm
                            </button>
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        {{-- Form thêm bảng điểm --}}
                        <form method="POST" role="form" action="{{URL::to('/them-bang-diem')}}">
                            {{csrf_field()}}
                            <div class="card-body">
                                <!-- collapse 3 content -->
                                <div class="card-body col-12 mb-4">
                                    <div class="mb-4">Loại bảng điểm mới</div>
                                    <select name="input_loaibangdiem_id_bangdiem"
                                        class="card border-secondary shadow h-100 py-2 col-6 mb-4">
                                        @foreach($loaibangdiem as $key=>$value)
                                        {

                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        }
                                        @endforeach

                                    </select>

                                    <div class="mb-4">Tên bảng điểm mới</div>
                                    <input name="input_name_bangdiem" type="text"
                                        class="card border-secondary shadow h-100 py-2 col-6 mb-4">

                                    <div class="mb-4">Điểm tối đa của bảng điểm mới</div>
                                    <input name="input_maxbangdiem_bangdiem" type="text"
                                        class="card border-secondary shadow h-100 py-2 col-6 mb-4">

                                    <div class="mb-4">Ngày bắt đầu</div>
                                    <input name="input_ngaybatdau_bangdiem" type="date" placeholder="yyyy-mm-dd"
                                        class="form-custom border-secondary h-100 py-2 col-6 mb-4">

                                    <div class="mb-4">Ngày kết thúc</div>
                                    <input name="input_ngayketthuc_bangdiem" type="date" placeholder="yyyy-mm-dd"
                                        class="form-custom border-secondary h-100 py-2 col-6 mb-4">

                                    <div class="mb-4">Khóa học áp dụng</div>
                                    <table class="border table table-striped col-6">
                                        <thead>
                                            <tr>
                                                <th scope="col">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" class="check" id="checkAllKhoahoc2">
                                                        </label>
                                                    </div>
                                                </th>
                                                <th scope="col">Khóa học</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($doituong as $key=>$value)
                                            <tr>
                                                <td>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input name="doituong[]" value="{{$value->id}}"
                                                                type="checkbox" class="checkKhoahoc2">
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>{{$value->name}}</td>
                                            </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                    <input type="submit" value="Thêm" class="btn btn-outline-secondary py-2 shadow" />

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                                aria-expanded="false" aria-controls="collapseTwo">
                                Chỉnh sửa bảng điểm
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
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
                                                        <th scope="col">Điểm bảng điểm</th>
                                                        <th scope="col">Ngày bắt đầu</th>
                                                        <th scope="col">Ngày kết thúc</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($bang_diem as $key=>$value)  
                                                        <tr>
                                                            <td>{{$value->id}}</td>
                                                            <td><a href="{{URL::to('/update-bang-diem-ctsv')}}/{{$value->id}}">{{$value->name}}</a></td>
                                                            <td>{{$value->maxbangdiem}}</td>
                                                            <td>{{date('d-m-Y', strtotime($value->ngaybatdau))}}</td>
                                                            <td>{{date('d-m-Y', strtotime($value->ngayketthuc))}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
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