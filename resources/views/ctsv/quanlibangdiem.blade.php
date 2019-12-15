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
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('quanlibangdiem')}}">
            <i class="fas fa-fw fa-skating"></i>
            <span>Bảng điểm</span></a>
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
        <h1 class="h3 mb-0 text-gray-800">Quản lý bảng điểm</h1>
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
                                Loại bảng điểm
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <!-- Core sheet type -->
                            <!-- collapse 1 content -->
                            <form>
                                <table class="border table table-striped col-10">
                                    <thead>
                                        <tr>
                                            <th scope="col">Mã loại bảng điểm</th>
                                            <th scope="col">Tên loại bảng điểm</th>
                                            <th>Xoá</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($loaibangdiem as $key=>$value)
                                        <tr>
                                            <td>{{$value->id}}</td>
                                            <td>{{$value->name}}</td>
                                            <td>
                                                <a onclick="return confirm('Bạn chắn chắc muốn xóa không ?')"
                                                    href="{{URL::to('/delete-loai-bang-diem/'.$value->id)}}}"
                                                    class="active" ui-toggle-class="">
                                                    <i class="fa fa-times text-danger text"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                            <!-- create new type -->
                            <form method="POST" role="form" action="{{URL::to('/them-loai-bang-diem')}}">
                                <?php
                                    $message = Session::get('message');
                                    if($message){
                                        echo '<span style="color:red">' .$message. '</span>';
                                        Session::put('message',null);
                                        }
                                ?>
                                {{csrf_field()}}
                                <div class="col-xl-6 border col-md-12 col-sm-12">
                                    <div class="col-12">
                                        <div class="col-12">
                                            <h1 class="h4 ml-3 text-gray-800">Thêm mới</h1>
                                        </div>
                                        <div class="card-body col-12 mb-4">
                                            <div class="mb-4">Tên loại bảng điểm</div>
                                            <input name="input_loaibangdiem" type="text"
                                                class="card border-secondary shadow h-100 py-2 col-12 mb-4" />
                                            <input type="submit" value="Thêm"
                                                class="btn btn-outline-secondary py-2 shadow" />
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
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
                                                        <th scope="col">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" class="check"
                                                                        id="checkAllBangdiem">
                                                                </label>
                                                            </div>
                                                        </th>
                                                        <th scope="col">Mã bảng điểm</th>
                                                        <th scope="col">Tên bảng điểm</th>
                                                        <th scope="col">Điểm bảng điểm</th>
                                                        <th scope="col">Loại bảng điểm</th>
                                                        <th scope="col">Ngày bắt đầu</th>
                                                        <th scope="col">Ngày kết thúc</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" class="checkBangdiem">
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>DV-2014-2015</td>
                                                        <td>ĐV-2014-2015</td>
                                                        <td>100</td>
                                                        <td>DV</td>
                                                        <td>2014-06-01</td>
                                                        <td>2015-05-31</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-body col-12 mb-4">
                                            <div class="mb-4">Loại bảng điểm mới</div>
                                            <select class="card border-secondary shadow h-100 py-2 col-6 mb-4">
                                                @foreach($loaibangdiem as $key=>$value)
                                                {
                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                                }
                                                @endforeach


                                            </select>

                                            <div class="mb-4">Tên bảng điểm mới</div>
                                            <input type="text"
                                                class="card border-secondary shadow h-100 py-2 col-6 mb-4">

                                            <div class="mb-4">Điểm tối đa của bảng điểm mới</div>
                                            <input type="text"
                                                class="card border-secondary shadow h-100 py-2 col-6 mb-4">

                                            <div class="mb-4">Ngày bắt đầu</div>
                                            <input type="date" placeholder="yyyy-mm-dd"
                                                class="form-custom border-secondary h-100 py-2 col-6 mb-4">

                                            <div class="mb-4">Ngày kết thúc</div>
                                            <input type="date" placeholder="yyyy-mm-dd"
                                                class="form-custom border-secondary h-100 py-2 col-6 mb-4">

                                            <div class="mb-4">Khóa học áp dụng</div>
                                            <table class="border table table-striped col-6">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" class="check"
                                                                        id="checkAllKhoahoc">
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
                                                                    <input type="checkbox" class="checkKhoahoc">
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>{{$value->name}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            <button type="button" class="btn btn-outline-secondary py-2 shadow">Chỉnh
                                                sửa</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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