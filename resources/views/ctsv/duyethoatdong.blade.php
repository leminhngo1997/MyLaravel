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
    <li class="nav-item">
        <a class="nav-link" href="{{route('quanlibangdiem')}}">
            <i class="fas fa-fw fa-skating"></i>
            <span>Bảng điểm</span></a>
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
        <h1 class="h3 mb-0 text-gray-800">Xét duyệt hoạt động</h1>
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
                                Danh sách cần xét duyệt
                            </button>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <!-- Core sheet type -->
                            <!-- collapse 1 content -->
                            
                            <div class="card-body col-12 mb-4">
                                <div class="mb-4">Chọn bảng điểm</div>
                                <select id="dropdown-bang-diem-xetduyethoatdong"
                                    class="card border-secondary shadow py-2 col-2 mb-4">
                                    @foreach($bangdiem as $key=>$value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>

                                <!-- bảng hiển thị danh sách hoạt động -->


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
                                            <th scope="col">Tên hoạt động</th>
                                            <th scope="col">Điểm cộng</th>
                                            <th scope="col">Đối tượng</th>
                                            <th scope="col">Số lượng tham gia</th>
                                            <th scope="col">Người tạo</th>
                                            <th scope="col">Người duyệt</th>
                                            <th scope="col">Trạng thái</th>
                                            <th scope="col">Mô tả</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show-hoat-dong-xetduyethoatdong">
                                        {{--  --}}
                                    </tbody>
                                </table>
                                <div class="mb-4">Lý do hủy hoạt động</div>
                                <textarea class="col-4 mb-4" rows="3"></textarea><br>
                                <input type="submit" value="Hủy" class="btn btn-outline-secondary py-2 shadow">
                                <input type="submit" value="Duyệt" class="btn btn-outline-secondary py-2 shadow" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>

<script>
    // get API cơ sở -- quản lí cơ sở
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var getSelected = $("#dropdown-bang-diem-xetduyethoatdong").children("option:selected").val();

        $.ajax({
            type: 'POST',

            url: "{{url('get-hoat-dong-duyethoatdong')}}",

            data: {
                bangdiem_id: getSelected
            },

            success: function (data) {
                $('.delete-row-hoatdong-chuaduyet').remove();
                data.forEach(element => {
                    html = `<tr class="delete-row-hoatdong-chuaduyet">
                                <td>` + element.id + `</td>
                                <td class="return-data"><a href="#">` + element.name + `</a></td>
                                <td class="return-data">` + element.status_clone + `</td>
                            </tr>`;
                    $('#show-hoat-dong-xetduyethoatdong').append(html);
                });
            }

        });
    });
    //
    $('#dropdown-bang-diem-xetduyethoatdong').change(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var getSelected = $(this).children("option:selected").val();
        $.ajax({
            type: 'POST',

            url: "{{url('get-hoat-dong-duyethoatdong')}}",

            data: {
                bangdiem_id: getSelected
            },

            success: function (data) {
                $('.delete-row-hoatdong-chuaduyet').remove();
                data.forEach(element => {
                    html = `<tr class="delete-row-hoatdong-chuaduyet">
                                <td>` + element.id + `</td>
                                <td class="return-data"><a href="#">` + element.name + `</a></td>
                                <td class="return-data">` + element.status_clone + `</td>
                            </tr>`;
                    $('#show-hoat-dong-xetduyethoatdong').append(html);
                });
            }

        });
    });
</script>

<!-- check all -->
<script>
    $("#checkAll").click(function () {
        $(".check").prop('checked', $(this).prop('checked'))
    });
</script>

@endsection