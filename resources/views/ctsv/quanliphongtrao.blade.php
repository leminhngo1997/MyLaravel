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
        <h1 class="h3 mb-0 text-gray-800">Quản lý phong trào</h1>
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
                                Tìm kiếm phong trào
                            </button>
                        </h5>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <form method="POST" role="form" action="{{URL::to('/them-phong-trao-quanliphongtrao')}}">
                                <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span style="color:red">' .$message. '</span>';
                                Session::put('message',null);
                                }
                        ?>
                                {{csrf_field()}}
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordion">
                                    <div class="card-body">
                                        <!-- Core sheet type -->
                                        <!-- collapse 1 content -->
                                        <div class="card-body col-12 mb-4">
                                            <div class="mb-4">Chọn loại bảng điểm</div>
                                            <select id="dropdown-loai-bang-diem-quanliphongtrao"
                                                class="card border-secondary shadow h-100 py-2 col-10 mb-4">
                                                @foreach($loaibangdiem as $key=>$value)
                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="mb-4">Chọn bảng điểm</div>
                                            <select id="dropdown-bang-diem-quanliphongtrao"
                                                class="card border-secondary shadow h-100 py-2 col-10 mb-4">
                                                {{-- @foreach($bangdiem as $key=>$value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                                @endforeach --}}
                                            </select>
                                            <div class="mb-4">Chọn tiêu chí</div>
                                            <select name="input_tieuchi_id" id="dropdown-tieu-chi-quanliphongtrao"
                                                class="card border-secondary shadow h-100 py-2 col-10 mb-4">
                                                {{-- <option value="1">Ý thức học tập</option> --}}
                                            </select>
                                            <div class="mb-4">Nhập tên phong trào</div>
                                            <input name="input_name_phongtrao" type="text"
                                                class="card border-secondary shadow h-100 py-2 col-10 mb-4" />
                                            <div class="mb-4">Nhập điểm phong trào tối đa</div>
                                            <input name="input_maxphongtrao_phongtrao" type="text"
                                                class="card border-secondary shadow h-100 py-2 col-10 mb-4" />

                                            <input type="submit" value="Thêm"
                                                class="btn btn-outline-secondary py-2 shadow">
                                        </div>


                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- import excel -->
                        <div class="card-body col-6 mb-4 border-left">
                            <div class="mb-4">Thêm hoạt động bằng Excel</div>
                                <div class="row">
                                    <form method="post" enctype="multipart/form-data"
                                        action="{{ url('/quanliphongtrao/import') }}">
                                        {{ csrf_field() }}

                                        <input type="file" name="select_file"
                                            class="btn btn-outline-secondary py-2 shadow" />
                                        <input type="submit" name="upload" value="Upload"
                                            class="btn btn-outline-secondary py-2 shadow" />
                                    </form>
                                    <form method="post" enctype="multipart/form-data"
                                        action="{{url('/quanliphongtrao/export_temp')}}">
                                        {{ csrf_field() }}
                                            <input type="text" class="btn btn-outline-secondary py-2 shadow" name="loai_quan_ly" value="phong_trao" hidden/>
                                            <input type="submit" class="btn btn-outline-secondary py-2 shadow ml-1" 
                                            value="Tải tập tin mẫu"/>
                                        </form>
                                </div>
                                    @if(count($errors) > 0)
                                    <div class="alert alert-danger">
                                        Upload validation errors<br><br>
                                        <ul>
                                            @foreach ($errors -> all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    @if($message = Session::get('success'))
                                    <div class="alert alert-success alert-block">
                                        <button type="button" class="close" data-dismiss="alert">X</button>
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @endif
                            <br><br>
                            <div class="mb-4">Danh sách thêm vào gần đây</div>
                            <table class="border table table-striped col-12">
                                <tr>
                                    <th>id</th>
                                    <th>Tên phong trào</th>
                                </tr>
                                @foreach ($data as $row)
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->name }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <table class="border table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Mã phong trào</th>
                                <th scope="col">Tên phong trào</th>
                                <th scope="col">Điểm tối đa</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="show-phong-trao">
                            {{--  --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>

<script>
    // get API bảng điểm -- quản lí phong trào
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var getSelected = $("#dropdown-loai-bang-diem-quanliphongtrao").children("option:selected").val();

        $.ajax({
            type: 'POST',

            url: "{{url('get-bang-diem-quanliphongtrao')}}",

            data: {
                loai_bang_diem_id: getSelected
            },

            success: function (data) {
                $('.delete-option-bang-diem').remove();
                data.forEach(element => {
                    option = `<option class = "delete-option-bang-diem" value="` + element
                        .id + `">` + element.name + `</option>`;
                    $('#dropdown-bang-diem-quanliphongtrao').append(option);
                });
            }

        });
    });

    $('#dropdown-loai-bang-diem-quanliphongtrao').change(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var getSelected = $(this).children("option:selected").val();
        $.ajax({
            type: 'POST',

            url: "{{url('get-bang-diem-quanliphongtrao')}}",

            data: {
                loai_bang_diem_id: getSelected
            },

            success: function (data) {
                $('.delete-option-bang-diem').remove();
                data.forEach(element => {
                    option = `<option class = "delete-option-bang-diem" value="` + element
                        .id + `">` + element.name + `</option>`;
                    $('#dropdown-bang-diem-quanliphongtrao').append(option);
                });
            }

        });
    });
    // get API tiêu chí -- quản lí phong trào
    $('#dropdown-bang-diem-quanliphongtrao').change(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var getSelected = $(this).children("option:selected").val();
        $.ajax({
            type: 'POST',

            url: "{{url('get-tieu-chi-quanliphongtrao')}}",

            data: {
                bang_diem_id: getSelected
            },

            success: function (data) {
                $('.delete-row').remove();
                data.forEach(element => {
                    option = `<option class ="delete-row" value="` + element
                        .id + `">` + element.name + `</option>`;
                    $('#dropdown-tieu-chi-quanliphongtrao').append(option);
                });
            }

        });
    });

    // get API phong trào -- quản lí phong trào


    $('#dropdown-tieu-chi-quanliphongtrao').change(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var getSelected = $(this).children("option:selected").val();
        $.ajax({
            type: 'POST',

            url: "{{url('get-phong-trao-quanliphongtrao')}}",

            data: {
                tieu_chi_id: getSelected
            },

            success: function (data) {
                $('.delete-row-phongtrao').remove();
                data.forEach(element => {
                    html = `<tr class = "delete-row-phongtrao">
                                    <td>` + element.id + `</td>    
                                    <td class="return-data"><a href = "#">` + element.name + `</a></td>
                                    <td class="return-data">` + element.maxphongtrao + `</td>
                                    <td > 
                                        <a onclick="return confirm('Bạn chắn chắc muốn xóa không ?')"
                                            href="{{URL::to('/delete-phong-trao-quanliphongtrao/` + element.id + `')}}" class="active"
                                            ui-toggle-class="">
                                            <i class="fa fa-times text-danger text"></i>
                                        </a>
                                    </td>
                                </tr>`;
                    $('#show-phong-trao').append(html);
                });
            }

        });
    });
</script>

@endsection