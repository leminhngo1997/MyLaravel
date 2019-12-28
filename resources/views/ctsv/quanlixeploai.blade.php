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
        <h1 class="h3 mb-0 text-gray-800">Quản lí xếp loại</h1>
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
                                Danh sách xếp loại
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">

                        <div class="card-body">
                            <form method="POST" role="form" action="{{URL::to('/them-xep-loai-quanlixeploai')}}">
                                <?php
                                    $message = Session::get('message');
                                    if($message){
                                        echo '<span style="color:red">' .$message. '</span>';
                                        Session::put('message',null);
                                        }
                                ?>
                                {{csrf_field()}}
                                <!-- Core sheet type -->
                                <!-- collapse 1 content -->
                                <div class="mb-4">Loại bảng điểm</div>
                                <select id="dropdown-loai-bang-diem-quanlixeploai" name="input_id_loai_bang_diem_xeploai"
                                    class="card border-secondary shadow h-100 py-2 col-4 mb-4">
                                    @foreach($loai_bang_diem as $key=>$value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach

                                </select>
                                <div class="mb-4">Tên xếp loại</div>
                                <input name="input_name_xeploai" type="text"
                                    class="card border-secondary shadow h-100 py-2 col-4 mb-4" />
                                <div class="mb-4">Nhập cận dưới(>=)</div>
                                <input name="input_canduoi_xeploai" type="text"
                                    class="card border-secondary shadow h-100 py-2 col-4 mb-4" />
                                <div class="mb-4">Nhập cận trên(<)</div>
                                <input name="input_cantren_xeploai" type="text"
                                    class="card border-secondary shadow h-100 py-2 col-4 mb-4" />
                                <input type="submit" value="Thêm" class="btn btn-outline-secondary py-2 shadow">
                                <table class="border table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Tên xếp loại</th>
                                            <th scope="col">Cận dưới</th>
                                            <th scope="col">Cận trên</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="show-xep-loai">
                                        {{--  --}}
                                    </tbody>
                                </table>


                            </form>


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
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var getSelected = $("#dropdown-loai-bang-diem-quanlixeploai").children("option:selected").val();

        $.ajax({
            type: 'POST',

            url: "{{url('get-xep-loai-quanlixeploai')}}",

            data: {
                loai_bang_diem_id: getSelected
            },
            success: function (data) {
                $('.delete-xep-loai').remove();
                data.forEach(element => {
                    html = `<tr class="delete-xep-loai">
                            <td class="return-data">` + element.name + `</td>
                            <td class="return-data">` + element.canduoi + `</td>
                            <td class="return-data">` + element.cantren + `</td>
                            <td>
                                <a onclick="return confirm('Bạn chắn chắc muốn xóa không ?')"
                                    href="{{URL::to('/delete-xep-loai-quanlixeploai/` + element.id + `')}}}" class="active"
                                    ui-toggle-class="">
                                    <i class="fa fa-times text-danger text"></i>
                                </a>
                            </td>
                        </tr>`;
                    $('#show-xep-loai').append(html);
                });
            }

        });
    });
    $('#dropdown-loai-bang-diem-quanlixeploai').change(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var getSelected = $(this).children("option:selected").val();
        $.ajax({
            type: 'POST',

            url: "{{url('get-xep-loai-quanlixeploai')}}",

            data: {
                loai_bang_diem_id: getSelected
            },
            success: function (data) {
                $('.delete-xep-loai').remove();
                data.forEach(element => {
                    html = `<tr class="delete-xep-loai">
                            <td class="return-data">` + element.name + `</td>
                            <td class="return-data">` + element.canduoi + `</td>
                            <td class="return-data">` + element.cantren + `</td>
                            <td>
                                <a onclick="return confirm('Bạn chắn chắc muốn xóa không ?')"
                                    href="{{URL::to('/delete-xep-loai-quanlixeploai/` + element.id + `')}}}" class="active"
                                    ui-toggle-class="">
                                    <i class="fa fa-times text-danger text"></i>
                                </a>
                            </td>
                        </tr>`;
                    $('#show-xep-loai').append(html);
                });
            }

        });
    });
</script>

@endsection