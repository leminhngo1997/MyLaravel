@extends('sinhvien.trangchu')

@section('sidebar')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Sidebar -->
<script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>
<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion border-right" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a style="color: indianred; background-color: white" class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('quanlibangdiem')}}">
        <div class="sidebar-brand-icon">
            <img style="width: 60px; height: 60px" class="img-profile" src="{{asset('public/admin/img/uit.png')}}">
        </div>
        <div class="sidebar-brand-text mx-3">SINH VIÊN</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('thamgiahoatdong')}}">
            <i class="fas fa-fw fa-skating"></i>
            <span>Tạo hoạt động</span></a>
    </li>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('feedback')}}">
            <i class="fas fa-fw fa-comments"></i>
            <span>Phản hồi</span></a>
    </li>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('vote')}}">
            <i class="fas fa-fw fa-vote-yea"></i>
            <span>Bầu chọn</span></a>
    </li>
    {{-- thong ke - lop truong --}}
    <li class="nav-item" id="loptruong_only">
        <a class="nav-link" href="{{route('thongke')}} ">
            <i class="fas fa-list-alt"></i>
            <span>Thống kê</span></a>
    </li>

</ul>
<input type="text" id="sidebar-user-quyen" value={{$quyen}} hidden />
<script>
    //get user info
    var quyen = $('#sidebar-user-quyen').val();
    if (quyen === 'loptruong') {
        $('#loptruong_only').show();
    } else $('#loptruong_only').hide();
</script>

<!-- End of Sidebar -->
@endsection

@section('main_content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Bầu chọn</h1>
    </div>
    <!-- Content Row -->
    <div style="text-align: center">
        <strong style="color: brown">Câu hỏi</strong>
    </div>
    <form method="POST" role="form" action="{{URL::to('/them-tra-loi')}}">
        <?php
                                    $message = Session::get('message');
                                    if($message){
                                        echo '<span style="color:red">' .$message. '</span>';
                                        Session::put('message',null);
                                        }
                                ?>
        {{csrf_field()}}
        @foreach ($cau_hoi as $key=>$value)
        <h2 style="text-align: center">{{$value->name_cauhoi}}</h2>

        <br />
        <input value="{{$value->id}}" name="input_cauhoi_id" hidden>
        <input value="{{$value->suluachon_id}}" name="input_suluachon_id" hidden>
        {{-- <input value="{{$value->sv_id}}" name="input_sv_id" hidden> --}}
        <div class="text-danger">Lưu ý: <?php 
            if($value->suluachon_id ==1)
                echo "Bạn chỉ có 1 sự lựa chọn!";
            else {
                echo "Bạn có nhiều sự lựa chọn!";
            }
            ?></div>
        <br />
        <div class="text-info">Mời bạn chọn</div>
        <div class="card border-secondary shadow h-100 py-2 col-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="check" id="checkAll">
                                </label>
                            </div>
                        </th>
                        <th scope="col">Email</th>
                        <th scope="col">Tên ứng cử viên</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($users as $row)
                    @foreach($row as $key=>$value)
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label>
                                    <input value="{{$value->id}}" name="check[]" type="checkbox" class="check">
                                </label>
                            </div>
                        </td>
                        <td>{{$value->email}}</td>
                        <td>{{$value->name}}</td>
                    </tr>
                    @endforeach
                    @endforeach

                </tbody>

            </table>
        </div>
        <input type="submit" value="Chọn" class="btn btn-outline-secondary py-2 shadow mb-4" />
        @endforeach
    </form>

</div>


<!-- check all -->
<script>
    $("#checkAll").click(function () {
        $(".check").prop('checked', $(this).prop('checked'))
    });
</script>

@endsection