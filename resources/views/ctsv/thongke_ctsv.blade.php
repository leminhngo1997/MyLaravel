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
        <h1 class="h3 mb-0 text-gray-800">Thống kê</h1>
    </div>
    <!-- Content Row -->
    <div class="card">
            <div class="card-body">
                <!-- Core sheet type -->
                <!-- collapse 1 content -->
                <div class="row col-12">
                    <form method="post" enctype="multipart/form-data"
                            action="{{url('/thongkectsv/export_diem')}}"> {{-- url('/thongkectsv/export_diem') --}}
                            {{ csrf_field() }}
                        <select class="btn btn-secondary dropdown-toggle ml-3 mb-4 col-6" href="#" role="button"
                            id="drop-down-term" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" name="bang_diem_id">
                            @foreach($bangdiem as $key=>$value)
                            {
                
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                   
                            }
                            @endforeach
                        </select>
                        <input type="submit" class="btn btn-success mb-4 ml-5 col-4" value="Export Excel"/>
                        <select class="btn btn-secondary dropdown-toggle ml-3 mb-4 col-6" href="#" role="button"
                            id="drop-down-co_so" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" name="co_so_id">
                            {{--  --}}
                        </select>
                        
                    </form>
                </div>
                <table class="border table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Mã sinh viên</th>
                            <th scope="col">Tên sinh viên</th>
                            <th scope="col">Tổng điểm</th>
                            <th scope="col">Xếp loại</th>
                        </tr>
                    </thead>
                    <tbody id="show-thong-ke">
                       {{--  --}}
                    </tbody>
                </table>

            </div>
        
    </div>
</div>
<script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>


<script>
     $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var getSelected = $("#drop-down-term").children("option:selected").val();
        
        
        $.ajax({
            type: 'POST',
            url: "{{url('get-co-so-thongkectsv')}}",
            data: {
                term_id: getSelected
            },
            success: function (data) {
                $('.delete-option-term').remove();
                data.forEach(element => {
                    option = `<option class = "delete-option-term" value="` + element
                        .id + `" selected>` + element.name + `</option>`;
                    $('#drop-down-co_so').append(option);
                });
            }
        });
    });

    $('#drop-down-term').change(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var getSelected = $(this).children("option:selected").val();
        $.ajax({
            type: 'POST',
            url: "{{url('get-co-so-thongkectsv')}}",
            data: {
                term_id: getSelected,
            },
            success: function (data) {
                $('.delete-option-term').remove();
                data.forEach(element => {
                    option = `<option class = "delete-option-term" value="` + element
                        .id + `">` + element.name + `</option>`;
                    $('#drop-down-co_so').append(option);
                });
            }
        });
    });

    
  
   $('#drop-down-co_so').change(function (e) {
    $('.delete-row-thong-ke').remove();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var getSelected = $('#drop-down-co_so').children("option:selected").val();
        var getSelected_bangdiem = $("#drop-down-term").children("option:selected").val();
        $.ajax({
            type: 'POST',
            url: "{{url('get-thong-ke-thongkectsv')}}",
            data: {
                co_so_id: getSelected,
                bangdiem_id: getSelected_bangdiem
            },
            success: function (data) {
                
                
                data.forEach(element => {
                    html = `<tr class="delete-row-thong-ke">
                                <td>`+element.mssv+`</td>
                                <td>`+element.name+`</td>
                                <td>`+element.diem+`</td>
                                <td>`+element.xeploai+`</td>
                            </tr>`;
                    $('#show-thong-ke').append(html);
                });
            }
        });
    });
</script>
@endsection