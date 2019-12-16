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
    <!-- Nav Item - Bảng điểm -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="{{route('quanlibangdiem')}}" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Bảng điểm</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('quanlibangdiem')}}">Quản lí bảng điểm</a>
            <a class="dropdown-item" href="{{route('quanlixeploai')}}">Quản lí xếp loại</a>
            <a class="dropdown-item" href="{{route('importsinhvienthamgiahoatdong')}}">Import sinh viên tham gia hoạt
                động</a>
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
<!-- main content -->
@section('main_content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Phân quyền tài khoản</h1>
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
                                Danh sách tài khoản
                            </button>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <!-- Core sheet type -->
                            <!-- collapse 1 content -->

                            <!-- danh sach tai khoan -->
                            <div class="card-body col-12 mb-4">
                                 <!-- bảng hiển thị danh sách tài khoản -->
                                    <table class="border table table-striped" id="userTable">
                                            <thead>
                                                <tr class="clickable-row">
                                                    <th scope="col">Mã tài khoản</th>
                                                    <th scope="col">Tên người dùng</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Loại tài khoản</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    @foreach ($user_role as $row)
                                                    <tr class="clickable-row" onclick="setRole()">
                                                        <td>{{ $row->id }}</td>
                                                        <td><a role="button" tabindex="0">{{ $row->name }}</a></td>
                                                        <td>{{ $row->email }}</td>
                                                        <td>{{ $row->role }}</td>
                                                    </tr>
                                                    </a>
                                                @endforeach
                                            </tbody>
                                        </table>
                                <?php
                                    $message = Session::get('message');
                                    if($message){
                                        echo '<span style="color:red">' .$message. '</span>';
                                        Session::put('message',null);
                                        }
                                ?>
                                {{csrf_field()}}
                                <div class="card-body col-12 mb-4">
                                        <form method="POST" role="form" action="{{URL::to('/quanlitaikhoan/phanquyen')}}">
                                        <div class="mb-4" style="color: red">*Nhấn vào hàng trên bảng dữ liệu để lấy thông tin</div>
                                        <table class="col-8 mb-4">
                                            <tr>
                                                <td>
                                                    <div>Mã tài khoản</div>
                                                </td>
                                                <td>
                                                    <div>Email khoản</div>
                                                </td>
                                                <td>
                                                    <div>Chọn đối tượng</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input name="input_user_id" type="text"
                                                    class="card border-secondary shadow h-100 py-2 col-8" id="user_id"/>
                                                </td>
                                                <td>
                                                    <input name="input_email_user" type="text"
                                                    class="card border-secondary shadow h-100 py-2 col-8" id="user_email"/>
                                                </td>
                                                <td>
                                                    <select id="dropdown-role" name="select_role_name"
                                                    class="card border-secondary shadow h-100 py-2 col-12">
                                                    @foreach($role as $key=>$value)
                                                    <option name="role_id" value="{{$value->id}}">{{$value->name}}</option>
                                                    @endforeach
                                                    </select>
                                                </td>
                                            </tr>    
                                        </table>
                                        <?php
                                                $message = Session::get('message');
                                                if($message){
                                                    echo '<span style="color:red">' .$message. '</span>';
                                                    Session::put('message',null);
                                                    }
                                            ?>
                                        {{csrf_field()}}
                                        
                                        <input type="submit" value="Phân quyền" class="btn btn-outline-secondary py-2 shadow">
                                    </form>                                   
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
function setRole() {
    var table = document.getElementById("userTable");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
      var currentRow = table.rows[i];
      var createClickHandler = function(row) {
        return function() {
            var cell_id = row.getElementsByTagName("td")[0];   
            var id = cell_id.innerHTML;
            var cell_email = row.getElementsByTagName("td")[2];
            var email = cell_email.innerHTML;
            $("#user_id").val(id);
            $("#user_email").val(email);
        };
      };
      currentRow.onclick = createClickHandler(currentRow);
    }
  }
</script>
@endsection