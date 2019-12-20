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
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chi tiết điểm trong tiêu chí</h1>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-12 col-md-12 col-sm-12 mb-4">
            <div class="col-12">
                <div class="card border-secondary shadow h-100 py-2">
                    <div class="card-body">
                            <div class="col-12 border border-secondary">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr style="width: 100%">
                                            <th scope="col" style="text-align: center">PHONG TRÀO<br>[hoạt động]</th>
                                            <th scope="col" style="text-align: end; padding-right: 5%">ĐIỂM ĐẠT</th>
                                        </tr>
                                    </thead>
                                    <div class="accordion" id="collapsePhongtrao">
                                        <tbody id="show-tieu-chi">
                                            <!-- table body -->
                                            @if (count($phongtrao_list)>0)
                                                @foreach ($phongtrao_list as $i => $item)
                                                    <tr style="width: 100%">
                                                        <td colspan="2" class="col-12">
                                                            <div class="card">
                                                                <!-- header 1 -->
                                                                <div class="card-header" id="phongtrao_header_{{$i}}">
                                                                    <h2 class="mb-0">
                                                                        <button class="btn btn-link col-12" type="button" data-toggle="collapse" data-target="#phongtrao_content_{{$i}}" aria-expanded="true" aria-controls="phongtrao_content_{{$i}}">
                                                                            <div class="row justify-content-between col-12">
                                                                                <div>{{$item['phongtrao_name']}}</div>
                                                                                <div>
                                                                                    <?php
                                                                                        $sum=0;
                                                                                        foreach($hoatdong_list as $index=>$value){
                                                                                            if ($value['phongtrao_id']===$item['phongtrao_id']) {
                                    
                                                                                                $sum += intval($value['diem']) * floatval($value['heso']);
                                                                                            }
                                                                                        }
                                                                                        echo $sum;
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </button>
                                                                    </h2>
                                                                </div>

                                                                <!-- content 1 -->
                                                                <div id="phongtrao_content_{{$i}}" class="collapse show" aria-labelledby="phongtrao_header_{{$i}}" data-parent="#collapsePhongtrao">
                                                                    @foreach ($hoatdong_list as $index => $value)
                                                                        @if ($value['phongtrao_id'] === $item['phongtrao_id'])
                                                                            <div class="row justify-content-between col-12">
                                                                                <div class="m-4">{{$value['hoatdong_name']}}</div>
                                                                                <div class="m-4">
                                                                                    <?php
                                                                                        $diem = intval($value['diem'])*floatval($value['heso']);
                                                                                        echo $diem;
                                                                                    ?>
                                                                                </div>
                                                                            </div>  
                                                                        @endif                                            
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>             
                                                @endforeach
                                            @endif
                                     
                                        </tbody>
                                    </div>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection