@extends('sinhvien.trangchu')
@section('sidebar')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Sidebar -->
    <script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>
    <ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
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
        <li class="nav-item">
            <a class="nav-link" href="{{route('vote')}}">
                <i class="fas fa-fw fa-vote-yea"></i>
                <span>Bầu chọn</span></a>
        </li>
        {{-- thong ke - lop truong --}}
        <li class="nav-item" id="loptruong_only">
            <a class="nav-link" href="{{route('thongke')}} " >
                <i class="fas fa-fw fa-thongke"></i>
                <span>Thống kê</span></a>
        </li>

    </ul>
    <input type="text" id = "sidebar-user-quyen" value={{$quyen}} hidden/>
    <script>
        //get user info
        var quyen = $('#sidebar-user-quyen').val();
        if(quyen==='loptruong'){
            $('#loptruong_only').show();
        }
        else $('#loptruong_only').hide();
    </script>

    <!-- End of Sidebar -->
@endsection
@section('main_content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Phản hồi</h1>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-12 col-sm-12 mb-4">
            <div class="col-12">
                <div class="card border-secondary shadow h-100 py-2 col-12">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1 class="h3 ml-3 text-gray-800">Thắc mắc / Ý kiến</h1>
                        </div>
                    </div>
                    <form method="POST" role="form" action="{{URL::to('/them-feedback')}}">
                        <div>
                            <?php
                        $message = Session::get('message');
                        if($message){
                            echo '<span style="color:red">' .$message. '</span>';
                            Session::put('message',null);
                            }
                    ?>
                        </div>

                        {{csrf_field()}}
                        <div class="card-body col-12 mb-4">
                            <div class="mb-4">Tiêu chí</div>
                            <select class="card border-secondary shadow h-100 py-2 col-12 mb-4"
                                id="dropdown-tieu-chi-feedback" name="input_name_tieuchi">
                                @foreach($tieuchi as $key =>$value)
                                <!-- max bangdiem_id -->
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                            <div class="mb-4">Phong trào</div>
                            <select class="card border-secondary shadow h-100 py-2 col-12 mb-4"
                                id="dropdown-phong-trao-feedback" name="input_name_phongtrao">
                                {{-- option dropdown phong trao --}}
                            </select>
                            <div class="mb-4">Hoạt động</div>
                            <select class="card border-secondary shadow h-100 py-2 col-12 mb-4"
                                id="dropdown-hoat-dong-feedback" name="input_name_hoatdong">
                                {{-- option dropdown hoạt động --}}
                            </select>
                            <div class="mb-4">Mô tả</div>
                            <textarea class="col-12 mb-4" rows="4" name="input_mota"></textarea>
                            <button type="submit" class="btn btn-outline-secondary py-2 shadow">Gửi</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <!-- Page break -->
        <!-- card -->
        <div class="col-xl-8 col-md-12 col-sm-12 mb-4">
            <div class="card border-secondary shadow h-100 py-2 col-12">
                <div class="row">
                    <div class="col-7">
                        <h1 class="h4 m-2 text-gray-800">Danh sách phản hồi</h1>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled friend-list" id="show-list-feedback">
                        <!-- Feedback list -->
                        @foreach ($posts as $key=>$value)
                        <li class="active grey lighten-3 p-2">
                            <div class="text-small">
                            <a href="{{URL::to('/feedback/chitiet')}}/{{$value->id}}" class="d-flex justify-content-between">
                                    <strong>{{$value->name_hoatdong}}</strong>
                                </a>
                                <p>{{$value->mota}}</p>
                            </div>
                            {{-- <div class="chat-footer">
                                <p class="text-smaller text-muted mb-0">Just now</p>
                                <span class="badge badge-danger float-right">1</span>
                            </div> --}}

                        </li>
                        @endforeach
                    </ul>
                </div>
                <!-- page navigation -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
</div>
<script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>

{{-- Auto call get-phong-trao api --}}
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var getSelected = $("#dropdown-tieu-chi-feedback").children("option:selected").val();
        $.ajax({
            type: 'POST',

            url: "{{url('get-phong-trao-feedback')}}",

            data: {
                tieu_chi_id: getSelected
            },

            success: function (data) {
                $('.delete-option-phong-trao').remove();
                data.forEach(element => {
                    option = `<option class = "delete-option-phong-trao" value="` + element
                        .id + `">` + element.name + `</option>`;
                    $('#dropdown-phong-trao-feedback').append(option);
                });
            }

        });
    });

    // 
    $('#dropdown-tieu-chi-feedback').change(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var getSelected = $(this).children("option:selected").val();
        $.ajax({
            type: 'POST',

            url: "{{url('get-phong-trao-feedback')}}",

            data: {
                tieu_chi_id: getSelected
            },

            success: function (data) {
                $('.delete-option-phong-trao').remove();
                data.forEach(element => {
                    option = `<option class = "delete-option-phong-trao" value="` + element
                        .id + `">` + element.name + `</option>`;
                    $('#dropdown-phong-trao-feedback').append(option);
                });
            }
        });
    });

    //
    $('#dropdown-phong-trao-feedback').change(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var getSelected = $(this).children("option:selected").val();
        $.ajax({
            type: 'POST',

            url: "{{url('get-hoat-dong-feedback')}}",

            data: {
                phong_trao_id: getSelected
            },

            success: function (data) {
                $('.delete-option-hoat-dong').remove();
                data.forEach(element => {
                    option = `<option class = "delete-option-hoat-dong" value="` + element
                        .id + `">` + element.name + `</option>`;
                    $('#dropdown-hoat-dong-feedback').append(option);
                });
            }
        });
    });
</script>
@endsection