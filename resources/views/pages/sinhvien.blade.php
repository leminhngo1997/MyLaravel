@extends('layouts.index')
@section('admin_content')
<!-- Page Heading -->
<div id="content-hidden">
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
                            <h1 class="h3 ml-3 text-gray-800">HK1 2019-2020</h1>
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
                                    <tbody>
                                        <a href="#">
                                        <tr>
                                                <td><a href="#">Tiêu chí 1(20 điểm)</a></td>
                                                <td class="text-center">10</td>
                                            
                                        </tr>
                                    </a>
                                        <tr>
                                            <td>Tiêu chí 1(20 điểm)</td>
                                            <td class="text-center">10</td>
                                        </tr>
                                        <tr>
                                            <td>Tiêu chí 1(20 điểm)</td>
                                            <td class="text-center">10</td>
                                        </tr>
                                        <tr>
                                            <td>Tiêu chí 1(20 điểm)</td>
                                            <td class="text-center">10</td>
                                        </tr>
                                        <tr>
                                            <td>Tiêu chí 1(20 điểm)</td>
                                            <td class="text-center">10</td>
                                        </tr>
                                        <tr>
                                            <td>Tiêu chí 1(20 điểm)</td>
                                            <td class="text-center">10</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{-- @foreach($data as $value)
<p>{{$value->MaxPhongTrao}}</p>;
@endforeach --}}
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
                            <td>HTCL</td>
                            <td class="text-center">60</td>
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
{{-- <script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>
<script>
var role = {!! json_encode($role->name) !!};
switch(role){
    case "sinh viên":
        $('#content-hidden').remove();
        break;
    case ""
}
</script> --}}
@endsection