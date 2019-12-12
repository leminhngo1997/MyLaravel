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
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">



    <!-- Nav Item - Dashboard -->
    <li class="nav-item active dropdown">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Bảng điểm</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Quản lí cơ sở</a>
            <a class="dropdown-item" href="#">Quản lí sinh viên</a>
        </div>
    </li>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-skating"></i>
            <span>Hoạt động</span></a>
    </li>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-comments"></i>
            <span>Đoàn-Hội</span></a>
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

@section('main_content')
    <!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý sinh viên</h1>
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
                                Quản lí sinh viên
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">

                        <div class="card-body">
                            <!-- Core sheet type -->
                            <!-- collapse 1 content -->
                            <div class="row">
                                <div class="card-body col-6 mb-4">
                            <form method="POST" role="form" action="{{URL::to('/them-tieu-chi-quanlitieuchi')}}">
                                <?php
                                    $message = Session::get('message');
                                    if($message){
                                        echo '<span style="color:red">' .$message. '</span>';
                                        Session::put('message',null);
                                        }
                                ?>
                                {{csrf_field()}}
                                <div class="card-body col-12 mb-4">
                                    <div class="mb-4">Chọn đối tượng</div>
                                    <select id="dropdown-loai-bang-diem-quanlitieuchi"
                                        class="card border-secondary shadow h-100 py-2 col-12 mb-4">
                                        {{-- @foreach($loaibangdiem as $key=>$value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach --}}
                                    </select>
                                    
                                    <div class="mb-4">Chọn cơ sở</div>
                                    <select id="dropdown-loai-bang-diem-quanlitieuchi"
                                        class="card border-secondary shadow h-100 py-2 col-12 mb-4">
                                        {{-- @foreach($loaibangdiem as $key=>$value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach --}}
                                    </select>

                                    <div class="mb-4">Nhập tên sinh viên</div>
                                    <input name="input_name_coso" type="text" class="card border-secondary shadow h-100 py-2 col-12 mb-4" />
                                    
                                    <div class="mb-4">Nhập email</div>
                                    <input name="input_name_coso" type="text" class="card border-secondary shadow h-100 py-2 col-12 mb-4" />

                                    <div class="mb-4">Nhập password</div>
                                    <input name="input_name_coso" type="text" class="card border-secondary shadow h-100 py-2 col-12 mb-4" />

                                    <input type="submit" value="Thêm" class="btn btn-outline-secondary py-2 shadow">
                                </div>
                            </form>
                                </div>
                                <div class="card-body col-6 mb-4 border-left">
                                        <div class="mb-4">Thêm tài khoản bằng Excel</div>                           
                                            <form method="post" enctype="multipart/form-data" action="{{ url('/quanlisinhvien/import') }}">
                                                {{ csrf_field() }}
                                        
                                                <input type="file" name="select_file" class="btn btn-outline-secondary py-2 shadow"/>
                                                <input type="submit" name="upload" value="Upload" class="btn btn-outline-secondary py-2 shadow"/>
                                            </form>
                                            @if(count($errors) > 0)
                                                <div class="alert alert-danger">
                                                    Upload validation errors<br><br>
                                                    <ul>
                                                        @foreach ($errors -> all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                    
                                            @if($message = Session::get('success'))
                                                <div class="alert alert-success alert-block">
                                                    <button type="button" class="close" data-dismiss="alert">X</button>
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @endif
                                            <br><br>
                                            <div class="mb-4">Danh sách thêm vào gần đây</div> 
                                            <table class="border table table-striped col-12">
                                                    <tr>
                                                        <th>id</th>
                                                        <th>name</th>
                                                        <th>email</th>
                                                    </tr>
                                                    @foreach ($data as $row)
                                                        <tr>
                                                            <td>{{ $row->id }}</td>
                                                            <td>{{ $row->name }}</td>
                                                            <td>{{ $row->email }}</td>
                                                        </tr>
                                                    @endforeach
                                            </table>
                                        </div>
                            </div>
                            <table class="border table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Mã tài khoản</th>
                                        <th scope="col">Tên sinh viên</th>
                                        <th scope="col">Email</th>
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

</div>
<!-- /.container-fluid -->
@endsection