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
    <li class="nav-item dropdown">
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
                            <div class="row ">

                                <!-- tim kiem hoat dong -->
                                <div class="card-body col-6 mb-4">
                                    <form method="POST" role="form"
                                        action="{{URL::to('/them-hoat-dong-quanlihoatdong')}}">
                                        <?php
                                    $message = Session::get('message');
                                    if($message){
                                        echo '<span style="color:red">' .$message. '</span>';
                                        Session::put('message',null);
                                        }
                                ?>
                                        {{csrf_field()}}
                                        <div class="card-body col-12 mb-4">
                                            <div class="mb-4">Chọn loại bảng điểm</div>
                                            <select id="dropdown-loai-bang-diem-quanlihoatdong"
                                                class="card border-secondary shadow py-2 col-8 mb-4">
                                                @foreach($loaibangdiem as $key=>$value)
                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="mb-4">Chọn bảng điểm</div>
                                            <select id="dropdown-bang-diem-quanlihoatdong" name="current_id_bangdiem"
                                                class="card border-secondary shadow py-2 col-8 mb-4">
                                                {{--  --}}
                                            </select>
                                            <div class="mb-4">Chọn tiêu chí</div>
                                            <select id="dropdown-tieu-chi-quanlihoatdong"
                                                class="card border-secondary shadow py-2 col-8 mb-4">
                                                {{--  --}}
                                            </select>
                                            <div class="mb-4">Chọn phong trào</div>
                                            <select name="input_phongtrao_id_hoatdong"
                                                id="dropdown-phong-trao-quanlihoatdong"
                                                class="card border-secondary shadow py-2 col-8 mb-4">
                                                {{-- <option value="1">hoạt động 1</option>
                                        <option value="2">hoạt động 2</option> --}}
                                            </select>
                                            <div>Chọn cơ sở áp dụng</div>
                                            <div style="color: red">( Mặc định là ALL, tất cả)
                                                VD: Nếu nhiều lớp thì HTTT2010-MTT2010-CNPM2010...</div>
                                            <input name="input_doituong_hoatdong" value="ALL" type="text"
                                                class="card border-secondary shadow py-2 col-8 mb-4" />
                                            <div class="mb-4">Nhập tên hoạt động</div>
                                            <input name="input_name_hoatdong" type="text"
                                                class="card border-secondary shadow py-2 col-8 mb-4" />
                                            <div class="mb-4">Mô tả</div>
                                            <textarea name="input_mota_hoatdong" class="col-12 mb-4"
                                                rows="4"></textarea>
                                            <div class="mb-4">Nhập điểm hoạt động</div>
                                            <input name="input_diem_hoatdong" type="text"
                                                class="card border-secondary shadow py-2 col-8 mb-4" />
                                            <div class="mb-4">Ngày bắt đầu</div>
                                            <input name="input_ngaybatdau_hoatdong" type="date" placeholder="yyyy-mm-dd"
                                                class="form-custom border-secondary py-2 col-8 mb-4">
                                            <div class="mb-4">Ngày kết thúc</div>
                                            <input name="input_ngayketthuc_hoatdong" type="date"
                                                placeholder="yyyy-mm-dd"
                                                class="form-custom border-secondary py-2 col-8 mb-4"><br>
                                            <input type="submit" value="Thêm"
                                                class="btn btn-outline-secondary py-2 shadow mb-4" />
                                        </div>
                                    </form>
                                </div>

                                <!-- import excel (hoat dong) -->
                                <div class="card-body col-6 mb-4 border-left">
                                    <div class="mb-4">Thêm hoạt động bằng Excel</div>
                                    <div class="row">
                                    <form method="post" enctype="multipart/form-data"
                                        action="{{ url('/quanlihoatdong/import') }}">
                                        {{ csrf_field() }}

                                        <input type="file" name="select_file"
                                            class="btn btn-outline-secondary py-2 shadow" />
                                        <input type="submit" name="upload" value="Upload"
                                            class="btn btn-outline-secondary py-2 shadow" />
                                    </form>
                                    <form method="post" enctype="multipart/form-data"
                                        action="{{url('/quanlihoatdong/export_temp')}}">
                                        {{ csrf_field() }}
                                            <input type="text" class="btn btn-outline-secondary py-2 shadow" name="loai_quan_ly" value="hoat_dong" hidden/>
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
                                            <th>Tên hoạt động</th>
                                            <th>Đối tượng tham gia</th>
                                            <th>Điểm</th>
                                        </tr>
                                        @foreach ($data as $row)
                                        <tr>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->doituong }}</td>
                                            <td>{{ $row->diem }}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>

                            <!-- bảng hiển thị danh sách hoạt động -->

                            <form method="POST" role="form" action="{{URL::to('/xoa-hoat-dong-quanlihoatdong')}}">
                                <div>Tìm kiếm theo tên hoạt động</div>
                                <input type="text" class="form-control col-6 mb-4" id="myInput" onkeyup="myFunction()">
                                <table class="border table table-striped data-table" id="myTable">
                                    <?php
                                            $message = Session::get('message');
                                            if($message){
                                                echo '<span style="color:red">' .$message. '</span>';
                                                Session::put('message',null);
                                                }
                                        ?>
                                    {{csrf_field()}}
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
                                        {{--  --}}
                                    </tbody>
                                </table>
                                <input type="submit" value="Xóa" class="btn btn-outline-secondary py-2 shadow">
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
                                                <input value="` + element.id + `" name="check[]" type="checkbox" class="check">
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

<!-- check all -->
<script>
    $("#checkAll").click(function () {
        $(".check").prop('checked', $(this).prop('checked'))
    });
</script>

{{-- add datatable --}}
<script src="{{asset('public/admin/vendor/datatables/jquery.dataTables.js')}}"></script>
<script>
    function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>

@endsection