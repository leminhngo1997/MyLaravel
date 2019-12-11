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
              <a class="dropdown-item" href="{{route('quanlibangdiem')}}">Quản lí bảng điểm</a>
              <a class="dropdown-item" href="{{route('quanlitieuchi')}}">Quản lí tiêu chí</a>
              <a class="dropdown-item" href="{{route('quanliphongtrao')}}">Quản lí phong trào</a>
              <a class="dropdown-item" href="{{route('quanlihoatdong')}}">Quản lí hoạt động</a>
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
            <h1 class="h3 mb-0 text-gray-800">Quản lý hoạt động</h1>
        </div>
        <!-- Content Row -->
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-12 col-md-12 col-sm-12 mb-4">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Tìm kiếm hoạt động
                            </button>
                        </h5>
                        </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <!-- Core sheet type -->
                        <!-- collapse 1 content -->
                        <div class="card-body col-12 mb-4">
                            <div class="mb-4">Chọn loại bảng điểm</div>
                            <select class="card border-secondary shadow h-100 py-2 col-6 mb-4">
                                @foreach($loaibangdiem as $key=>$value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                            <div class="mb-4">Chọn bảng điểm</div>
                            <select class="card border-secondary shadow h-100 py-2 col-6 mb-4">
                                @foreach($bangdiem as $key=>$value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                            <div class="mb-4">Chọn tiêu chí</div>
                            <select class="card border-secondary shadow h-100 py-2 col-6 mb-4">
                                <option value="1">Ý thức học tập</option>

                            </select>
                             <div class="mb-4">Chọn hoạt động</div>
                              <select class="card border-secondary shadow h-100 py-2 col-6 mb-4">
                                <option value="1">hoạt động 1</option>
                                <option value="2">hoạt động 2</option>
                             </select>
                        </div>
                     
                            <table class="border table table-striped">
                                                <thead>
                                                <tr>
                                                    <th scope="col">
                                                        <div class="checkbox">
                                                            <label>
                                                            <input type="checkbox" class="check" id="checkAll">
                                                            </label>
                                                        </div>
                                                    </th>
                                                    <th scope="col">Mã hoạt động</th>
                                                    <th scope="col">Tên hoạt động</th>
                                                    <th scope="col">Điểm tối đa</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="checkbox">
                                                            <label>
                                                            <input type="checkbox" class="check">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>2019-2020-1</td>                                    
                                                    <td>Ý thức tham gia học tập</td>
                                                    <td>20</td>
                                                </tr>
                                                
                                                </tbody>
                                            </table>
                                            <div class="mb-4">
                                                <input type="submit" value="Xóa" class="btn btn-outline-secondary py-2 shadow">
                                            </div>
                                                        </form>
            <!-- create new -->
            <!-- collapse two -->
            <div id="accordion2">
                                            <div class="card">
                                                    <div class="card-header" id="headingThree">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                        Tạo mới tiêu chí
                                                        </button>
                                                    </h5>
                                                    </div>
                                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion2">
                                                    <div class="card-body">
                                                        <!-- collapse 2 content -->
                                                        <form>
                                                <div class="col-xl-6 border col-md-12 col-sm-12">
                                                    <div class="col-12">
                                                                <div class="col-12">
                                                                    <h1 class="h4 ml-3 text-gray-800">Thêm mới hoạt động</h1>
                                                                </div>
                                                            <div class="card-body col-12 mb-4">
                                                            <div class="mb-4">Chọn tiêu chí</div>
                                                            <select class="card border-secondary shadow h-100 py-2 col-12 mb-4">
                                                                <option value="1">Tiêu chí 1</option>
                                                                <option value="2">Tiêu chí 2</option>
                                                            </select>
                                                            <div class="mb-4">Chọn phong trào</div>
                                                            <select class="card border-secondary shadow h-100 py-2 col-12 mb-4">
                                                                <option value="1">phong trào 1</option>
                                                                <option value="2">phong trào 2</option>
                                                            </select>
                                                                <div class="mb-4">Nhập tên hoạt động</div>
                                                                <input type="text" class="card border-secondary shadow h-100 py-2 col-12 mb-4"/>               
                                                                <div class="mb-4">Nhập điểm hoạt động</div>
                                                                <input type="text" class="card border-secondary shadow h-100 py-2 col-12 mb-4"/> 
                                                                <input type="submit" value="Thêm" class="btn btn-outline-secondary py-2 shadow"/>
                                                            </div>                                
                                                    </div>
                                                </div>
                                            </form>
                                                    </div>
                                                </div>
            <!-- end collapse two -->
                                                    </div>
                    </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-12 col-sm-12 mb-4 ">
                <div class="col-12">
                    
                </div>
                <div class="col-12 mt-3">
                    
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>
@endsection




