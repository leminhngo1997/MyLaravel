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
    <li class="nav-item active dropdown">
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
        <h1 class="h3 mb-0 text-gray-800">Quản lý sinh viên</h1>
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
                                Quản lý sinh viên
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">

                        <div class="card-body">
                            <!-- Core sheet type -->
                            <!-- collapse 1 content -->
                            <div class="row">
                                <div class="card-body col-6 mb-4">
                                    <form method="POST" role="form" action="{{URL::to('/them-users-quanlisinhvien')}}">
                                        <?php
                                    $message = Session::get('message');
                                    if($message){
                                        echo '<span style="color:red">' .$message. '</span>';
                                        Session::put('message',null);
                                        }
                                        ?>
                                        {{csrf_field()}}
                                        <div class="card-body col-12 mb-4">
                                            <div class="mb-4">Chọn khóa học</div>
                                            <select id="dropdown-doi-tuong-quanlisinhvien"
                                                class="card border-secondary shadow h-100 py-2 col-12 mb-4">
                                                @foreach($doituong as $key=>$value)
                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                                @endforeach
                                            </select>

                                            <div class="mb-4">Chọn lớp</div>
                                            <select id="dropdown-co-so-quanlisinhvien" name="input_name_co_so"
                                                class="card border-secondary shadow h-100 py-2 col-12 mb-4">
                                                {{--  --}}
                                            </select>

                                            <div class="mb-4">Nhập tên sinh viên</div>
                                            <input name="input_name_users" type="text"
                                                class="card border-secondary shadow h-100 py-2 col-12 mb-4" />

                                            <div class="mb-4">Nhập email</div>
                                            <input name="input_email_users" type="text"
                                                class="card border-secondary shadow h-100 py-2 col-12 mb-4" />

                                            <div class="mb-4">Nhập password</div>
                                            <input name="input_password_users" type="text"
                                                class="card border-secondary shadow h-100 py-2 col-12 mb-4" />

                                            <input type="submit" value="Thêm"
                                                class="btn btn-outline-secondary py-2 shadow">
                                        </div>
                                    </form>
                                </div>
                                <!-- import excel -->
                                <div class="card-body col-6 mb-4 border-left">
                                    <div class="mb-4">Thêm tài khoản bằng Excel</div>
                                    <div class="row">
                                    <form method="post" enctype="multipart/form-data"
                                        action="{{ url('/quanlisinhvien/import') }}">
                                        {{ csrf_field() }}

                                        <input type="file" name="select_file"
                                            class="btn btn-outline-secondary py-2 shadow" />
                                        <input type="submit" name="upload" value="Upload"
                                            class="btn btn-outline-secondary py-2 shadow" />
                                    </form>
                                    <form method="post" enctype="multipart/form-data"
                                        action="{{url('/quanlisinhvien/export_temp')}}">
                                        {{ csrf_field() }}
                                            <input type="text" class="btn btn-outline-secondary py-2 shadow" name="loai_quan_ly" value="sinh_vien" hidden/>
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
                                            <th>ID</th>
                                            <th>Tên sinh viên</th>
                                            <th>MSSV</th>
                                        </tr>
                                        @foreach ($data as $row)
                                        <tr>
                                            <td>{{ $row->id }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td><?php  
                                                foreach (explode('@gm.uit.edu.vn',$row->email) as $x => $y) {
                                                    echo $y;
                                                 }  ?></td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <form method="POST" role="form" action="{{URL::to('/xoa-user-quanlisinhvien')}}">
                                <div>Tìm kiếm theo mã sinh viên</div>
                                <input type="text" class="form-control col-6 mb-4" id="myInput" onkeyup="myFunction()">
                                <table class="border table table-striped" id="myTable">
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
                                            <th scope="col">Mã tài khoản</th>
                                            <th scope="col">Tên sinh viên</th>
                                            <th scope="col">MSSV</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show-users">
                                        {{--  --}}
                                    </tbody>
                                    <input type="submit" value="Xóa" class="btn btn-outline-secondary py-2 shadow">
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
        var getSelected = $("#dropdown-doi-tuong-quanlisinhvien").children("option:selected").val();

        $.ajax({
            type: 'POST',

            url: "{{url('get-co-so-quanlisinhvien')}}",

            data: {
                doituong_id: getSelected
            },

            success: function (data) {
                $('.delete-option-co-so').remove();
                data.forEach(element => {
                    option = `<option class = "delete-option-co-so" value="` + element
                        .id + `">` + element.name + `</option>`;
                    $('#dropdown-co-so-quanlisinhvien').append(option);
                });
            }

        });
    });

    $('#dropdown-doi-tuong-quanlisinhvien').change(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var getSelected = $(this).children("option:selected").val();
        $.ajax({
            type: 'POST',

            url: "{{url('get-co-so-quanlisinhvien')}}",

            data: {
                doituong_id: getSelected
            },

            success: function (data) {
                $('.delete-option-co-so').remove();
                data.forEach(element => {
                    option = `<option class = "delete-option-co-so" value="` + element
                        .id + `">` + element.name + `</option>`;
                    $('#dropdown-co-so-quanlisinhvien').append(option);
                });
            }

        });
    });
    //
    $('#dropdown-co-so-quanlisinhvien').change(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var getSelected = $(this).children("option:selected").val();
        $.ajax({
            type: 'POST',

            url: "{{url('get-users-quanlisinhvien')}}",

            data: {
                coso_id: getSelected
            },

            success: function (data) {
                $('.delete-users').remove();
                data.forEach(element => {
                    var email = element.email;
                    var MSSV = email.split("@");
                    console.log(MSSV);
                    html = `<tr class="delete-users">
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input value="` + element.id + `" name="check[]" type="checkbox" class="check">
                                        </label>
                                    </div>
                                </td>
                                <td>` + element.id + `</td>
                                <td class="return-data"><a href="{{URL::to('/quanlisinhvien/` + element.id + `')}}">` + element.name + `</a></td>
                                <td class="return-data">`+ MSSV[0] +`</td>
                                
                            </tr>`;
                    $('#show-users').append(html);
                });
            }

        });
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
    td = tr[i].getElementsByTagName("td")[3];
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


<!-- check all -->
<script>
    $("#checkAll").click(function () {
        $(".check").prop('checked', $(this).prop('checked'))
    });
</script>
@endsection