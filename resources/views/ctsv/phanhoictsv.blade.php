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
     <li class="nav-item active dropdown">
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
        <h1 class="h3 mb-0 text-gray-800">Phản hồi</h1>
    </div>
    <!-- Content Row -->
    <div class="card-body col-12 mb-4">
        <div class="mb-4">Chọn khóa sinh viên</div>
        <select id="dropdown-doituong-phanhoictsv"
            class="card border-secondary shadow py-2 col-4 mb-4">
            @foreach ($doituong as $key=>$value)
                <option value="{{$value->id}}">{{$value->name}}</option>
            @endforeach
        </select>
        <div class="mb-4">Chọn cơ sở</div>
        <select id="dropdown-coso-phanhoictsv"
            class="card border-secondary shadow py-2 col-4 mb-4">
            {{--  --}}
        </select>
    </div>
        
       
    <div class="col-xl-8 col-md-12 col-sm-12 mb-4">
        <div class="card border-secondary shadow h-100 py-2 col-12">
            <div class="row">
                <div class="col-7">
                    <h1 class="h4 m-2 text-gray-800">Danh sách phản hồi</h1>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-unstyled friend-list" id="show-list-feedback">
                   
                   
                </ul>
            </div>
            <!-- page navigation -->
           
        </div>
    </div>

    </div>
    <!-- /.container-fluid -->
    <script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>
    <script>
        $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var getSelected = $("#dropdown-doituong-phanhoictsv").children("option:selected").val();

        $.ajax({
            type: 'POST',

            url: "{{url('get-co-so-phanhoictsv')}}",

            data: {
                doituong_id: getSelected
            },

            success: function (data) {
                $('.delete-coso-phanhoictsv').remove();
                data.forEach(element => {
                    option = `<option class = "delete-coso-phanhoictsv" value="` + element
                        .id + `">` + element.name + `</option>`;
                    $('#dropdown-coso-phanhoictsv').append(option);
                });
            }

        });
    });
    $('#dropdown-doituong-phanhoictsv').change(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var getSelected = $(this).children("option:selected").val();
        $.ajax({
            type: 'POST',

            url: "{{url('get-co-so-phanhoictsv')}}",

            data: {
                doituong_id: getSelected
            },

            success: function (data) {
                $('.delete-coso-phanhoictsv').remove();
                data.forEach(element => {
                    option = `<option class = "delete-coso-phanhoictsv" value="` + element
                        .id + `">` + element.name + `</option>`;
                    $('#dropdown-coso-phanhoictsv').append(option);
                });
            }

        });
    });
    //////
    $('#dropdown-coso-phanhoictsv').change(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var getSelected = $(this).children("option:selected").val();
        $.ajax({
            type: 'POST',
            url: "{{url('get-feedback-ctsv')}}",
            data: {
                coso_id: getSelected
            },
            success: function (data) {
                $('.delete-row-feedbackctsv').remove();
                data.forEach(element => {
                    html = `<li class="active grey lighten-3 p-2 delete-row-feedbackctsv">
                            <div class="text-small">
                            <a href="{{URL::to('/feedbackctsv/chitiet')}}/`+element.id+`" class="d-flex justify-content-between">
                                    <strong>`+element.name_hoatdong+`</strong>
                                </a>
                                <p>`+element.mota+`</p>
                            </div>
                        </li>`;
                    $('#show-list-feedback').append(html);
                });
            }
        });
    });
    </script>

    

@endsection
