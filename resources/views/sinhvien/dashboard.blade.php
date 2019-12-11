@extends('sinhvien.trangchu')

@section('sidebar')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Sidebar -->
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
                    <span>Tham gia hoạt động</span></a>
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

        </ul>
        <!-- End of Sidebar -->
@endsection

@section('main_content')

<div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tổng quan</h1>
        </div>
        <!-- Content Row -->
        <div class="row">
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
                                <h6 class="h6 m-3 text-right">Đã cập nhập một ngày trước</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                        <h2 class="text-center">81</h2>
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
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-12 col-sm-12 mb-4 ">
                <div class="col-12 border border-secondary">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">TỔNG ĐIỂM</th>
                                <th scope="col" class="text-center">XẾP HẠNG</th>
                            </tr>
                            <tr class="border-bottom">
                                <th class="text-danger" style="font-size: 20px;">81 <span style="font-size: 10px;" class="text-danger">Điểm</span></th>
                                <th class="text-center text-danger">23</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Lớp</td>
                                <td class="text-center">Sĩ Số</td>
                            </tr>
                            <tr>
                                <td>{{$coso_name}}</td></td>
                                <td class="text-center">{{$siso}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="row">
                            <div class="col-7">
                                <h1 class="h4 m-2 text-gray-800">Phản hồi gần đây</h1>
                            </div>
                            <div class="col-5">
                                <h6 class="h6 m-3 text-right">Xem tất cả</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled friend-list">
                                <li class="active grey lighten-3 p-2">
                                    <a href="#" class="d-flex justify-content-between">
                                        <div class="text-small">
                                            <strong>John Doe</strong>
                                            <p class="last-message text-muted">Hello, Are you there?</p>
                                        </div>
                                        <div class="chat-footer">
                                            <p class="text-smaller text-muted mb-0">Just now</p>
                                            <span class="badge badge-danger float-right">1</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="p-2">
                                    <a href="#" class="d-flex justify-content-between">
                                        <div class="text-small">
                                            <strong>Danny Smith</strong>
                                            <p class="last-message text-muted">Lorem ipsum dolor sit.</p>
                                        </div>
                                        <div class="chat-footer">
                                            <p class="text-smaller text-muted mb-0">5 min ago</p>
                                            <span class="text-muted float-right"><i class="fas fa-mail-reply" aria-hidden="true"></i></span>
                                        </div>
                                    </a>
                                </li>
                                <li class="p-2">
                                    <a href="#" class="d-flex justify-content-between">
                                        <div class="text-small">
                                            <strong>Alex Steward</strong>
                                            <p class="last-message text-muted">Lorem ipsum dolor sit.</p>
                                        </div>
                                        <div class="chat-footer">
                                            <p class="text-smaller text-muted mb-0">Yesterday</p>
                                            <span class="text-muted float-right"><i class="fas fa-mail-reply" aria-hidden="true"></i></span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
</div>
<script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>

<script>

$(document).ready(function(){
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var getSelected = $("#drop-down-term").children("option:selected").val();

$.ajax({
   type:'POST',

   url:"{{url('get-tieu-chi-dashboard')}}",

   data:{term: getSelected},

   success:function(data){
       $('.delete-row').remove();
       data.forEach(element => {
            html = `<tr class = "delete-row" >
                        <td class="return-data"><a href = "#">`+element.name +` (`+element.maxtieuchi+`)</a></td>
                        <td class="return-data" class="text-center">20</td>
                    </tr>`;
           $('#show-tieu-chi').append(html);
           console.log(data);
       });
   }

});
});

$('#drop-down-term').change(function(e){
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
e.preventDefault();
var getSelected = $(this).children("option:selected").val();
$.ajax({
   type:'POST',

   url:"{{url('get-tieu-chi-dashboard')}}",

   data:{term: getSelected},

   success:function(data){
       $('.delete-row').remove();
       data.forEach(element => {
            html = `<tr class = "delete-row" >
                        <td class="return-data"><a href = "#">`+element.name +` (`+element.maxtieuchi+`)</a></td>
                        <td class="return-data" class="text-center">20</td>
                    </tr>`;
           $('#show-tieu-chi').append(html);
           console.log(data);
       });
   }

});
});
</script>
@endsection






