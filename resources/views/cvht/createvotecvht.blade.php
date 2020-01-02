@extends('cvht.trangchu')
@section('sidebar')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion border-right" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a style="color: indianred; background-color: white" class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('quanlibangdiem')}}">
        <div class="sidebar-brand-icon">
            <img style="width: 60px; height: 60px" class="img-profile" src="{{asset('public/admin/img/uit.png')}}">
        </div>
        <div class="sidebar-brand-text mx-3">CVHT</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('phan-hoi-cvht')}}">
            <i class="fas fa-fw fa-comments"></i>
            <span>Phản hồi sinh viên</span></a>
    </li>
    <!-- Nav Item - Bảng điểm -->
  
    <!-- Nav Item - Cơ sở-Sinh viên -->
  
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('thongke-cvht')}}">
            <i class="fas fa-list-alt"></i>
            <span>Thống kê báo cáo</span></a>
    </li>
    <li class="nav-item active dropdown">
        <a class="nav-link dropdown-toggle" href="{{route('votecvht')}}" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Bầu chọn</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('create-vote-cvht')}}">Tạo bầu chọn</a>
            <a class="dropdown-item" href="{{route('votecvht')}}">Quản lí bầu chọn</a>
        </div>
    </li>
</ul>

<!-- End of Sidebar -->

@endsection


@section('main_content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tạo bầu chọn</h1>
    </div>
    <form method="POST" role="form" action="{{URL::to('/tao-bau-chon-cvht')}}">
        <?php
        $message = Session::get('message');
        if($message){
            echo '<span style="color:red">' .$message. '</span>';
            Session::put('message',null);
            }
?>

        <div class="mb-4">Chọn kiểu bầu chọn</div>
        <select id="get_value_suluachon"  class="card border-secondary shadow py-2 col-4 mb-4" onclick="get_value()"  name="input_suluachon">
            @foreach($su_lua_chon as $key=>$value)
            <option value="{{$value->id}}">{{$value->name}}</option>
            @endforeach
        </select>

        <div style="display: none" id="input_label" class="mb-4">Giới hạn tối đa</div>
        <input style="display: none" id="input_gioihan" name="input_gioihantoida_vote" class="card border-secondary shadow py-2 col-4 mb-4">
        
        <div class="mb-4">Nhập câu hỏi</div>
        <input name="input_cauhoi" type="text" class="card border-secondary shadow py-2 col-6 mb-4" />

        <div class="mb-4">Ngày bắt đầu</div>
        <input name="input_ngaybatdau_vote" type="date" placeholder="yyyy-mm-dd"
            class="form-custom border-secondary py-2 col-6 mb-4">
        <div class="mb-4">Ngày kết thúc</div>
        <input name="input_ngayketthuc_vote" type="date" placeholder="yyyy-mm-dd"
            class="form-custom border-secondary py-2 col-6 mb-4">
        <div class="mb-4">Chọn ứng cử viên</div>

        <div>Tìm kiếm theo tên sinh viên</div>
        <input type="text" class="form-control col-6 mb-4" id="myInput" onkeyup="myFunction()">
        <table class="border table table-striped data-table" id="myTable">
           
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
                    <th scope="col">MSSV</th>
                    <th scope="col">Tên sinh viên</th>
                </tr>
            </thead>
            <tbody id="show-bau-chon">
               @foreach($list_user as $item)
                    @foreach($item as $key=>$value)
                    <tr class = "delete-row-hoat-dong">
                        <td>
                            <div class="checkbox">
                                <label>
                                <input value="{{$value->id}}" name="check[]" type="checkbox" class="check">
                                </label>
                            </div>
                        </td>
                        
                        <td class="return-data"><?php
                        $x = explode('@gm.uit.edu.vn',$value->email);
                        echo $x[0];
                         ?></td>    
                        <td class="return-data"><a href = "#">{{$value->name}}</a></td>
                    </tr>
                    @endforeach
                @endforeach
       
              
            </tbody>
        </table>
        <input type="submit" value="Tạo bầu chọn" class="btn btn-outline-secondary py-2 shadow">
    </form>
</div>
<!-- /.container-fluid -->
<script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>

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

<script>
    function get_value(){
        input = document.getElementById("get_value_suluachon");
        x = document.getElementById("input_gioihan");
        y = document.getElementById("input_label");
        if (input.value === "1") {
            x.style.display = "none";
            y.style.display = "none";
        } else {
            x.style.display = "block";
            y.style.display = "block";
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