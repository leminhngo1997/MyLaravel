@extends('ctsv.trangchu')

@section('sidebar')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('quanlibangdiem')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">UIT - CTSV</div>
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
            <a class="dropdown-item" href="{{route('importsinhvienthamgiahoatdong')}}">Import sinh viên tham gia hoạt
                động</a>
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
        </div>
    </li>
    <!-- Nav Item - Cơ sở-Sinh viên -->
    <li class="nav-item active dropdown">
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
        <h1 class="h3 mb-0 text-gray-800">Quản lý cơ sở</h1>
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
                                Tìm kiếm cơ sở
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">

                        <div class="card-body">
                            <!-- Core sheet type -->
                            <!-- collapse 1 content -->
                            <form method="POST" role="form" action="{{URL::to('/them-co-so-quanlicoso')}}">
                                <?php
                                    $message = Session::get('message');
                                    if($message){
                                        echo '<span style="color:red">' .$message. '</span>';
                                        Session::put('message',null);
                                        }
                                ?>
                                {{csrf_field()}}
                                <div class="card-body col-12 mb-4">
                                    <div class="mb-4">Chọn đối tượng</div>
                                    <select id="dropdown-doi-tuong-quanlicoso" name="input_doituong_id"
                                        class="card border-secondary shadow h-100 py-2 col-6 mb-4">
                                        @foreach($doituong as $key=>$value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>

                                    <div class="mb-4">Nhập tên cơ sở</div>
                                    <input name="input_name_coso" type="text"
                                        class="card border-secondary shadow h-100 py-2 col-6 mb-4" />
                                    <div class="mb-4">Nhập sĩ số</div>
                                    <input name="input_siso_coso" type="text"
                                        class="card border-secondary shadow h-100 py-2 col-6 mb-4" />
                                    <input type="submit" value="Thêm" class="btn btn-outline-secondary py-2 shadow">
                                </div>
                            </form>
                            <table class="border table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Mã cơ sở</th>
                                        <th scope="col">Tên cơ sở</th>
                                        <th scope="col">Sĩ số</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody id="show-co-so">
                                    {{--  --}}
                                </tbody>
                            </table>
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
    // get API cơ sở -- quản lí cơ sở
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var getSelected = $("#dropdown-doi-tuong-quanlicoso").children("option:selected").val();

        $.ajax({
            type: 'POST',

            url: "{{url('get-co-so-quanlicoso')}}",

            data: {
                doi_tuong_id: getSelected
            },

            success: function (data) {
                $('.delete-co-so').remove();
                data.forEach(element => {
                    html = `<tr class="delete-co-so">
        <td>` + element.id + `</td>
        <td class="return-data"><a href="#">` + element.name + `</a></td>
        <td class="return-data">` + element.siso + `</td>
        <td>
            <a onclick="return confirm('Bạn chắn chắc muốn xóa không ?')"
                href="{{URL::to('/delete-co-so-quanlicoso/` + element.id + `')}}}" class="active"
                ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
            </a>
        </td>
    </tr>`;
                    $('#show-co-so').append(html);
                });
            }

        });
    });
    //
    $('#dropdown-doi-tuong-quanlicoso').change(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var getSelected = $(this).children("option:selected").val();
        $.ajax({
            type: 'POST',

            url: "{{url('get-co-so-quanlicoso')}}",

            data: {
                doi_tuong_id: getSelected
            },

            success: function (data) {
                $('.delete-co-so').remove();
                data.forEach(element => {
                    html = `<tr class="delete-co-so">
        <td>` + element.id + `</td>
        <td class="return-data"><a href="#">` + element.name + `</a></td>
        <td class="return-data">` + element.siso + `</td>
        <td>
            <a onclick="return confirm('Bạn chắn chắc muốn xóa không ?')"
                href="{{URL::to('/delete-co-so-quanlicoso/` + element.id + `')}}}" class="active"
                ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
            </a>
        </td>
    </tr>`;
                    $('#show-co-so').append(html);
                });
            }

        });
    });
</script>
@endsection