@extends('admin.trangchu')
@section('sidebar')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion border-right" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a style="color: indianred; background-color: white"
        class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('quanlitaikhoan-admin')}}">
        <div class="sidebar-brand-icon">
            <img style="width: 60px; height: 60px" class="img-profile" src="{{asset('public/admin/img/uit.png')}}">
        </div>
        <div class="sidebar-brand-text mx-3">ADMIN</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    
    <li class="nav-item active">
        <a class="nav-link" href="{{route('quanlitaikhoan-admin')}}">
            <i class="fas fa-fw fa-vote-yea"></i>
            <span>Phân quyền tài khoản</span></a>
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

                            <div class="card-body col-12 mb-4">
                                <!-- bảng hiển thị danh sách tài khoản -->
                                <?php
                                    $message = Session::get('message');
                                    if($message){
                                        echo '<span style="color:red">' .$message. '</span>';
                                        Session::put('message',null);
                                        }
                                ?>
                                {{csrf_field()}}
                                <div>Tìm kiếm theo mssv</div>
                                <input type="text" class="form-control col-6 mb-4" id="myInput" onkeyup="myFunction()">
                                <table class="border table table-striped" id="myTable">
                                    <thead>
                                        <tr class="clickable-row">
                                            <th scope="col">Mã tài khoản</th>
                                            <th scope="col">Tên người dùng</th>
                                            <th scope="col">MSSV</th>
                                            <th scope="col">Loại tài khoản</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user_role as $row)
                                        <tr class="clickable-row" onclick="setRole()">
                                            <td>{{ $row->id }}</td>
                                            <td><a role="button" tabindex="0">{{ $row->name }}</a></td>
                                            <td><?php  
                                            foreach (explode('@gm.uit.edu.vn',$row->email) as $x => $y) {
                                                echo $y;
                                             }  ?></td>
                                            <td>{{ $row->role }}</td>
                                        </tr>

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
                                    <form method="POST" role="form" action="{{URL::to('/quanlitaikhoan-admin/phanquyen')}}">
                                        <div class="mb-4" style="color: red">*Nhấn vào hàng trên bảng dữ liệu để lấy
                                            thông tin</div>
                                        <table class="col-8 mb-4">
                                            <tr>
                                                <td>
                                                    <div>Mã tài khoản</div>
                                                </td>
                                                <td>
                                                    <div>MSSV</div>
                                                </td>
                                                <td>
                                                    <div>Chọn đối tượng</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input name="input_user_id" type="text"
                                                        class="card border-secondary shadow h-100 py-2 col-8"
                                                        id="user_id" readonly />
                                                </td>
                                                <td>
                                                    <input name="input_email_user" type="text"
                                                        class="card border-secondary shadow h-100 py-2 col-8"
                                                        id="user_email" readonly />
                                                </td>
                                                <td>
                                                    <select id="dropdown-role" name="select_role_name"
                                                        class="card border-secondary shadow h-100 py-2 col-12">
                                                        @foreach($role as $key=>$value)
                                                        <option name="role_id" value="{{$value->id}}">{{$value->name}}
                                                        </option>
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

                                        <input type="submit" value="Phân quyền"
                                            class="btn btn-outline-secondary py-2 shadow">
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
        var table = document.getElementById("myTable");
        var rows = table.getElementsByTagName("tr");
        for (i = 0; i < rows.length; i++) {
            var currentRow = table.rows[i];
            var createClickHandler = function (row) {
                return function () {
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