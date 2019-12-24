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
        <li class="nav-item active">
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

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        Hoạt động
    </div>
    <!-- Content Row -->
    <!-- begin tab title -->
    <ul class="nav nav-tabs" id="eventTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="activity-tab" data-toggle="tab" href="#activity" role="tab"
                aria-controls="activity" aria-selected="true">Tạo mới</a>
        </li>
    </ul>
    <!-- end tab title -->
    <!-- begin tab content -->
    <div class="tab-content" id="eventTabContent">
        <!-- begin tab hoạt động -->
        <div class="tab-pane fade show active" id="activity" role="tabpanel" aria-labelledby="activity-tab">
            <form method="POST" role="form" action="{{URL::to('/them-hoat-dong-thamgiahoatdong')}}">
                <label class="text-danger">Hoạt động sau khi tạo sẽ được phòng CTSV kiểm duyệt</label>
                <br>
                <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span style="color:red">' .$message. '</span>';
                                Session::put('message',null);
                                }
                        ?>
                {{csrf_field()}}
                <div class="row">
                    <div class="col-xl-6 col-md-12 col-sm-12 mb-4">
                        <div class="col-12">
                            <div class="border-secondary h-100 py-2 col-12">
                                <div class="col-12 mb-4">
                                    <div class="mb-4">Tiêu chí</div>
                                    <select class="card border-secondary shadow h-100 py-2 col-12 mb-4"
                                        id="dropdown-tieu-chi-thamgiahoatdong">
                                        @foreach($tieuchi as $key =>$value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="mb-4">Tên hoạt động</div>
                                    <input name="input_name_hoatdong" type=text
                                        class="card border-secondary shadow h-100 py-2 col-12 mb-4" />
                                    <div class="mb-4">Ngày bắt đầu</div>
                                    <input name="input_ngaybatdau_hoatdong" id="date_start" type="date"
                                        placeholder="yyyy-mm-dd"
                                        class="form-custom border-secondary shadow h-100 py-2 col-12 mb-4" />
                                    <div class="mb-4">Mô tả</div>
                                    <textarea name="input_mota_hoatdong" class="col-12 mb-4" rows="4"></textarea>
                                    <button type="supmit" class="btn btn-outline-secondary py-2 shadow">Tạo
                                        mới</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 col-sm-12 mb-4">
                        <div class="col-12">
                            <div class="border-secondary h-100 py-2 col-12">
                                <div class="row">
                                </div>
                                <div class="col-12 mb-4">
                                    <div class="mb-4">Phong trào</div>
                                    <select name="input_id_phongtrao" class="card border-secondary shadow h-100 py-2 col-12 mb-4"
                                        id='dropdown-phong-trao-thamgiahoatdong'>
                                        {{-- option phong trào --}}
                                    </select>
                                    <div class="mb-4">Điểm cộng</div>
                                    <input name="input_diem_hoatdong" type=text
                                        class="card border-secondary shadow h-100 py-2 col-12 mb-4" />
                                    <div class="mb-4">Ngày kết thúc</div>
                                    <input name="input_ngayketthuc_hoatdong" id="date_end" type="date"
                                        placeholder="yyyy-mm-dd"
                                        class="form-custom border-secondary shadow h-100 py-2 col-12 mb-4" />

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- end tab hoạt động -->       
    </div>
    <!-- end tab content -->
</div>
<script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>
{{-- Auto call get phongtrao api --}}
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var getSelected = $("#dropdown-tieu-chi-thamgiahoatdong").children("option:selected").val();
        $.ajax({
            type: 'POST',
            url: "{{url('get-phong-trao-thamgiahoatdong')}}",
            data: {
                tieu_chi_id: getSelected
            },
            success: function (data) {
                $('.delete-option-phong-trao').remove();
                data.forEach(element => {
                    option = `<option class = "delete-option-phong-trao" value="` + element
                        .id + `">` + element.name + `</option>`;
                    $('#dropdown-phong-trao-thamgiahoatdong').append(option);
                });
            }
        });
    });

    $('#dropdown-tieu-chi-thamgiahoatdong').change(function (e) {
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
                    $('#dropdown-phong-trao-thamgiahoatdong').append(option);
                });
            }
        });
    });
</script>
@endsection