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
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">



    <!-- Nav Item - Dashboard -->
    <li class="nav-item active dropdown">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Bảng điểm</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('quanlibangdiem')}}">Quản lí bảng điểm</a>
            <a class="dropdown-item" href="{{route('quanlitieuchi')}}">Quản lí tiêu chí</a>
            <a class="dropdown-item" href="{{route('quanliphongtrao')}}">Quản lí phong trào</a>
            <a class="dropdown-item" href="{{route('quanlihoatdong')}}">Quản lí hoạt động</a>
        </div>
    </li>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-skating"></i>
            <span>Hoạt động</span></a>
    </li>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-comments"></i>
            <span>Đoàn-Hội</span></a>
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
        <h1 class="h3 mb-0 text-gray-800">Quản lý hoạt động</h1>
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
                                Tìm kiếm hoạt động
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <!-- Core sheet type -->
                            <!-- collapse 1 content -->
                            <div class="">
                                <div class="card-body col-12 mb-4">
                                    <div class="mb-4">Chọn loại bảng điểm</div>
                                    <select id="dropdown-loai-bang-diem-quanlihoatdong" class="card border-secondary shadow h-100 py-2 col-6 mb-4">
                                        @foreach($loaibangdiem as $key=>$value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="mb-4">Chọn bảng điểm</div>
                                    <select id="dropdown-bang-diem-quanlihoatdong" class="card border-secondary shadow h-100 py-2 col-6 mb-4">
                                        {{--  --}}
                                    </select>
                                    <div class="mb-4">Chọn tiêu chí</div>
                                    <select id="dropdown-tieu-chi-quanlihoatdong" class="card border-secondary shadow h-100 py-2 col-6 mb-4">
                                    {{--  --}}
                                    </select>
                                    <div class="mb-4">Chọn phong trào</div>
                                    <select id="dropdown-phong-trao-quanlihoatdong" class="card border-secondary shadow h-100 py-2 col-6 mb-4">
                                        {{-- <option value="1">hoạt động 1</option>
                                        <option value="2">hoạt động 2</option> --}}
                                    </select>
                                    <div class="mb-4">Nhập tên hoạt động</div>
                                    <input type="text" class="card border-secondary shadow h-100 py-2 col-6 mb-4" />
                                    <div class="mb-4">Nhập điểm hoạt động</div>
                                    <input type="text" class="card border-secondary shadow h-100 py-2 col-6 mb-4" />
                                    <input type="submit" value="Thêm" class="btn btn-outline-secondary py-2 shadow" />
                                </div>
                            </div>

                            <table class="border table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="check" id="checkAll">
                                                </label>
                                            </div>
                                        </th>
                                        <th scope="col">Mã hoạt động</th>
                                        <th scope="col">Tên hoạt động</th>
                                        <th scope="col">Điểm cộng</th>
                                    </tr>
                                </thead>
                                <tbody id="show-hoat-dong">
                                    {{-- <tr>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="check">
                                                </label>
                                            </div>
                                        </td>
                                        <td>2019-2020-1</td>
                                        <td>Ý thức tham gia học tập</td>
                                        <td>20</td>
                                    </tr> --}}
                                </tbody>
                            </table>
                            <div class="mb-4">
                                <input type="submit" value="Xóa" class="btn btn-outline-secondary py-2 shadow">
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

<script>
     // get API bảng điểm -- quản lí hoạt động
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var getSelected = $("#dropdown-loai-bang-diem-quanlihoatdong").children("option:selected").val();

        $.ajax({
            type: 'POST',

            url: "{{url('get-bang-diem-quanlihoatdong')}}",

            data: {
                loai_bang_diem_id: getSelected
            },

            success: function (data) {
                $('.delete-option-bang-diem').remove();
                data.forEach(element => {
                    option = `<option class = "delete-option-bang-diem" value="` + element
                        .id + `">` + element.name + `</option>`;
                    $('#dropdown-bang-diem-quanlihoatdong').append(option);
                });
            }

        });
    });

    $('#dropdown-loai-bang-diem-quanlihoatdong').change(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var getSelected = $(this).children("option:selected").val();
        $.ajax({
            type: 'POST',

            url: "{{url('get-bang-diem-quanlihoatdong')}}",

            data: {
                loai_bang_diem_id: getSelected
            },

            success: function (data) {
                $('.delete-option-bang-diem').remove();
                data.forEach(element => {
                    option = `<option class = "delete-option-bang-diem" value="` + element
                        .id + `">` + element.name + `</option>`;
                    $('#dropdown-bang-diem-quanlihoatdong').append(option);
                });
            }

        });
    });
     // get API tiêu chí -- quản lí hoạt động
    $('#dropdown-bang-diem-quanlihoatdong').change(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var getSelected = $(this).children("option:selected").val();
        $.ajax({
            type: 'POST',

            url: "{{url('get-tieu-chi-quanlihoatdong')}}",

            data: {
                bang_diem_id: getSelected
            },

            success: function (data) {
                $('.delete-row').remove();
                data.forEach(element => {
                    option = `<option class ="delete-row" value="` + element
                        .id + `">` + element.name + `</option>`;
                    $('#dropdown-tieu-chi-quanlihoatdong').append(option);
                });
            }

        });
    });
    // get API phong trào -- quản lí hoạt động
    $('#dropdown-tieu-chi-quanlihoatdong').change(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var getSelected = $(this).children("option:selected").val();
        $.ajax({
            type: 'POST',

            url: "{{url('get-phong-trao-quanlihoatdong')}}",

            data: {
                tieu_chi_id: getSelected
            },

            success: function (data) {
                $('.delete-row-phong-trao').remove();
                data.forEach(element => {
                    option = `<option class ="delete-row-phong-trao" value="` + element
                        .id + `">` + element.name + `</option>`;
                    $('#dropdown-phong-trao-quanlihoatdong').append(option);
                });
            }

        });
    });

    //get API hoạt động - quản lí hoạt động
    $('#dropdown-phong-trao-quanlihoatdong').change(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var getSelected = $(this).children("option:selected").val();
        $.ajax({
            type: 'POST',

            url: "{{url('get-hoat-dong-quanlihoatdong')}}",

            data: {
                phong_trao_id: getSelected
            },

            success: function (data) {
                $('.delete-row-hoat-dong').remove();
                data.forEach(element => {
                    html = `<tr class = "delete-row-hoat-dong">
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" class="check">
                                            </label>
                                        </div>
                                    </td>
                                    <td>` + element.id + `</td>    
                                    <td class="return-data"><a href = "#">` + element.name + `</a></td>
                                    <td class="return-data">` + element.diem + `</td>
                                </tr>`;
                    $('#show-hoat-dong').append(html);
                });
            }

        });
    });
</script>


@endsection