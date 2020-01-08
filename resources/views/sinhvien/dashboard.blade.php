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
            <a class="nav-link" href="{{route('thongke')}}">
                <i class="fas fa-list-alt"></i>
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
        <h1 class="h3 mb-0 text-gray-800">Tổng quan</h1>
    </div>
    <!-- Content Row -->
    <div class="row h-100">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-8 col-md-12 col-sm-12 mb-4">
            <div class="col-12">
                <div class="card border-secondary shadow h-100 py-2">
                    <div class="row">
                        <div class="col-6">
                            <!-- Dropdown -->
                            <select class="btn btn-secondary dropdown-toggle ml-3" href="#" role="button"
                                id="drop-down-term" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @foreach($bangdiem_id as $key=>$value)
                                {
                                    @foreach($bangdiem as $key=>$value1)
                                    {
                                        @if($value1->id == $value->bangdiem_id)
                                        {
                                            <option value="{{$value1->id}}" selected>{{$value1->name}}</option>
                                        }
                                        @endif
                                    }
                                    @endforeach
                                }
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="chart-pie pt-4 pb-2" id="show-sum-bang-diem">
                                    <canvas id="myPieChart"></canvas>
                                    {{-- <h2 class="text-center">{{$sum}}</h2> --}}
                                </div>
                            </div>
                            <div class="col-8 border border-secondary">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">TIÊU CHÍ</th>
                                            <th scope="col" class="text-center">ĐIỂM ĐẠT</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show-tieu-chi">
                                        {{--  --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-md-12 col-sm-12 mt-3">
            <div class="col-12 border border-secondary">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">TRUNG BÌNH CHUNG</th>
                            <th scope="col" class="text-center">XẾP LOẠI</th>
                            <th scope="col" class="text-center">XẾP HẠNG</th>
                        </tr>
                        <tr class="border-bottom">
                        <th class="text-danger text-center" style="font-size: 20px;">{{round($chitietxephang['trung_binh'])}}<span style="font-size: 10px;"
                                    class="text-danger"> Điểm</span></th>
                                    <th class="text-danger text-center">{{$chitietxephang['xep_loai']}}</th>
                            <th class="text-center text-danger">{{$chitietxephang['xep_hang']}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-center">Lớp</th>
                            <th></th>
                            <th class="text-center">Sĩ Số</th>
                        </tr>
                        <tr>
                            <td class="text-center">{{$coso_name}}</td>
                            </td>
                            <td></td>
                            <td class="text-center">{{$siso}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-12 col-sm-12">
        <div class="card">
            <div class="row">
                <div class="col-7">
                    <h1 class="h4 m-2">Phản hồi gần đây</h1>
                </div>
                <div class="col-5">
                    <h2 class="h6 m-3 text-right"><a href="{{URL::to('feedback')}}">Xem tất cả</a></h2>
                </div>
            </div>
            <div class="card-body">
                @foreach ($current_posts_user as $key=>$value)
                <ul class="list-unstyled friend-list">

                    <li class="active grey lighten-3 p-2">
                    <a href="{{URL::to('/feedback/chitiet')}}/{{$value->id}}" class="d-flex justify-content-between">
                            <div class="col-12 text-small">
                            <strong>{{$value->name_hoatdong}}</strong>
                        </a>
                        <p class="grey">({{date('d-m-Y', strtotime($value->created_at))}})</p>
                        <p class="last-message text-muted">Mô tả: {{$value->mota}}</p>
                    </li>
                </ul>
                @endforeach
                
            </div>
            {{$current_posts_user->links()}}
        </div>
    </div>
    </div>
</div>
<script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var getSelected = $("#drop-down-term").children("option:selected").val();
        $.ajax({
            type: 'POST',

            url: "{{url('get-tieu-chi-dashboard')}}",

            data: {
                term: getSelected
            },

            success: function (data) {
                //console.log(data);
                $('.delete-row').remove();
                data.forEach(element => {
                    html = `<tr class = "delete-row" >
                            <td class="return-data"><a href = "{{URL::to('dashboard/chitiettieuchi')}}/`+ element.id +`">` + element.name + ` (` + element.maxtieuchi + `)</a></td>
                            <td class="return-data" class="text-center">` + element.sum_tieuchi + `</td>
                        </tr>`;
                    $('#show-tieu-chi').append(html);
                });
            }

        });
        //get-sum-bang-diem
        $.ajax({
            type: 'POST',

            url: "{{url('get-sum-bang-diem-dashboard')}}",

            data: {
                term: getSelected
            },

            success: function (data) {
    
                // debugger;
                console.log(data);
                $('.delete-sum-bang-diem').remove();
                html = `<h2 class="text-center delete-sum-bang-diem sum-bang-diem">` + data + `</h2>`;
                $('#show-sum-bang-diem').append(html);
                // Pie Chart 
                var ctx = document.getElementById("myPieChart");
                var myPieChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ["Tổng điểm học kỳ hiện tại",""],
                    datasets: [{
                    data: [data, 100-data],
                    backgroundColor: ['#4e73df', '#FFFFFF'],
                    hoverBackgroundColor: ['#2e59d9', '#FFFFFF'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    },
                    legend: {
                    display: false
                    },
                    cutoutPercentage: 80,
                },
                });
                            }

                        });
            
                    });

    $('#drop-down-term').change(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var getSelected = $(this).children("option:selected").val();
        $.ajax({
            type: 'POST',

            url: "{{url('get-tieu-chi-dashboard')}}",

            data: {
                term: getSelected
            },

            success: function (data) {
                $('.delete-row').remove();
                data.forEach(element => {
                    html = `<tr class = "delete-row" >
                        <td class="return-data"><a href = "#">` + element.name + ` (` + element.maxtieuchi + `)</a></td>
                        <td class="return-data" class="text-center">` + element.sum_tieuchi + `</td>
                    </tr>`;
                    $('#show-tieu-chi').append(html);
                    
                });
            }

        });
        //get-sum-bang-diem
        $.ajax({
            type: 'POST',

            url: "{{url('get-sum-bang-diem-dashboard')}}",

            data: {
                term: getSelected
            },

            success: function (data) {
                // debugger;
                // console.log(data);
                $('.delete-sum-bang-diem').remove();
                html = `<h2 class="text-center delete-sum-bang-diem sum-bang-diem">` + data + `</h2>`;
                $('#show-sum-bang-diem').append(html);
                // Pie Chart 
                var ctx = document.getElementById("myPieChart");
                var myPieChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ["Tổng điểm học kỳ hiện tại",""],
                    datasets: [{
                    data: [data, 100-data],
                    backgroundColor: ['#4e73df', '#FFFFFF'],
                    hoverBackgroundColor: ['#2e59d9', '#FFFFFF'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    },
                    legend: {
                    display: false
                    },
                    cutoutPercentage: 80,
                },
                });
                            }

                        });
                    });
</script>
 <!-- Bootstrap core JavaScript-->
 <script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>


 <!-- Core plugin JavaScript-->
 <script src="{{asset('public/admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

 <!-- Custom scripts for all pages-->
 <script src="{{asset('public/admin/js/sb-admin-2.min.js')}}"></script>

 <!-- Page level plugins -->
 <script src="{{asset('public/admin/vendor/chart.js/Chart.min.js')}}"></script>

 <!-- Page level custom scripts -->
 <script src="{{asset('public/admin/js/demo/chart-area-demo.js')}}"></script>
 <script src="{{asset('public/admin/js/demo/chart-pie-demo.js')}}"></script>


@endsection