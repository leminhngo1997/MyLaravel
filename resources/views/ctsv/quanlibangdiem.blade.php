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
            <a class="nav-link dropdown-toggle" href="{{route('quanlibangdiem')}}" id="navbardrop" data-toggle="dropdown">
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
@endsection

@section('main_content')
     <!-- Begin Page Content -->
     <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Quản lý bảng điểm</h1>
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
                            Loại bảng điểm
                            </button>
                        </h5>
                        </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <!-- Core sheet type -->
                        <!-- collapse 1 content -->
                        <form>
                            <table class="border table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Mã loại bảng điểm</th>
                                        <th scope="col">Tên loại bảng điểm</th>
                                    </tr>
                                </thead>
                                <tbody>         
                                    @foreach($loaibangdiem as $key=>$value)
                                    <tr>
                                        <td>{{$value->id}}</td>
                                        <td>{{$value->name}}</td>
                                        <td > 
                                            <a onclick="return confirm('Bạn chắn chắc muốn xóa không ?')"
                                                href="{{URL::to('/delete-loai-bang-diem/'.$value->id)}}}" class="active"
                                                ui-toggle-class="">
                                                <i class="fa fa-times text-danger text"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach          
                                </tbody>
                            </table>
                        </form>
                                                        <!-- create new type -->
                            <form method="POST" role="form" action="{{URL::to('/them-loai-bang-diem')}}">
                                <?php
                                    $message = Session::get('message');
                                    if($message){
                                        echo '<span style="color:red">' .$message. '</span>';
                                        Session::put('message',null);
                                        }
                                ?>
                                {{csrf_field()}}
                                <div class="col-xl-6 border col-md-12 col-sm-12">
                                    <div class="col-12">
                                        <div class="col-12">
                                            <h1 class="h4 ml-3 text-gray-800">Thêm mới</h1>
                                        </div>
                                        <div class="card-body col-12 mb-4">          
                                            <div class="mb-4">Tên loại bảng điểm</div>
                                            <input name="input_loaibangdiem" type="text" class="card border-secondary shadow h-100 py-2 col-12 mb-4"/> 
                                            <input type="submit" value="Thêm" class="btn btn-outline-secondary py-2 shadow"/>
                                        </div>                                
                                    </div>
                                </div>
                            </form>

                        </div>
            </div>
        </div>
                                                <div class="card">
                                                    <div class="card-header" id="headingTwo">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        Chỉnh sửa bảng điểm
                                                        </button>
                                                    </h5>
                                                    </div>
                                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <!-- collapse 2 content -->
                                                    <div class="col-xl-12 col-md-12 col-sm-12 mb-4">
                                                        <div class="col-12">
                                                            <div class="shadow h-100 py-2 col-12">
                                                                <div class="row">
                                                                    <div class="col-12 text-center">
                                                                        <h1 class="h3 ml-3 text-gray-800">Chỉnh sửa bảng điểm</h1>
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
                                                                            <th scope="col">Mã bảng điểm</th>
                                                                            <th scope="col">Tên bảng điểm</th>
                                                                            <th scope="col">Điểm bảng điểm</th>
                                                                            <th scope="col">Loại bảng điểm</th>
                                                                            <th scope="col">Ngày bắt đầu</th>
                                                                            <th scope="col">Ngày kết thúc</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="checkbox">
                                                                                    <label>
                                                                                    <input type="checkbox" class="checkKH">
                                                                                    </label>
                                                                                </div>
                                                                            </td>
                                                                            <td>DV-2014-2015</td>                                    
                                                                            <td>ĐV-2014-2015</td>
                                                                            <td>100</td>                                    
                                                                            <td>DV</td>
                                                                            <td>2014-06-01</td>                                    
                                                                            <td>2015-05-31</td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="card-body col-12 mb-4">
                                                                    <div class="mb-4">Loại bảng điểm mới</div>
                                                                    <select class="card border-secondary shadow h-100 py-2 col-6 mb-4">
                                                                            @foreach($loaibangdiem as $key=>$value)
                                                                            {
                                                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                                                            }
                                                                            @endforeach
                                                                            
                                                                            
                                                                        </select>

                                                                    <div class="mb-4">Tên bảng điểm mới</div>
                                                                    <input type="text" class="card border-secondary shadow h-100 py-2 col-6 mb-4">
                                                                
                                                                    <div class="mb-4">Điểm tối đa của bảng điểm mới</div>
                                                                    <input type="text" class="card border-secondary shadow h-100 py-2 col-6 mb-4">

                                                                    <div class="mb-4">Ngày bắt đầu</div>
                                                                    <input type="date" placeholder="yyyy-mm-dd" class="form-custom border-secondary h-100 py-2 col-6 mb-4">

                                                                    <div class="mb-4">Ngày kết thúc</div>
                                                                    <input type="date" placeholder="yyyy-mm-dd" class="form-custom border-secondary h-100 py-2 col-6 mb-4">

                                                                    <div class="mb-4">Khóa học áp dụng</div>
                                                                    <table class="border table table-striped col-6">
                                                                        <thead>
                                                                        <tr>
                                                                            <th scope="col">
                                                                                <div class="checkbox">
                                                                                    <label>
                                                                                    <input type="checkbox" class="check" id="checkAllKH">
                                                                                    </label>
                                                                                </div>
                                                                            </th>
                                                                            <th scope="col">Khóa học</th>
                                                                          
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($doituong as $key=>$value)
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="checkbox">
                                                                                            <label>
                                                                                            <input type="checkbox" class="checkKH">
                                                                                            </label>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>{{$value->name}}</td> 
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>

                                                                    <button type="button" class="btn btn-outline-secondary py-2 shadow">Chỉnh sửa</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header" id="headingThree">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                        Tạo mới bảng điểm
                                                        </button>
                                                    </h5>
                                                    </div>
                                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                                    {{-- Form thêm bảng điểm --}}
                                                    <form method="POST" role="form" action="{{URL::to('/them-bang-diem')}}">
                                                        {{csrf_field()}}
                                                        <div class="card-body">
                                                        <!-- collapse 3 content -->
                                                        <div class="card-body col-12 mb-4">
                                                            <div class="mb-4">Loại bảng điểm mới</div>
                                                            <select name="input_loaibangdiem_id_bangdiem" class="card border-secondary shadow h-100 py-2 col-6 mb-4">
                                                                @foreach($loaibangdiem as $key=>$value)
                                                                {
                    
                                                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                                                }
                                                                @endforeach
                                                                    
                                                            </select>

                                                            <div class="mb-4">Tên bảng điểm mới</div>
                                                            <input name="input_name_bangdiem" type="text" class="card border-secondary shadow h-100 py-2 col-6 mb-4">
                                                        
                                                            <div class="mb-4">Điểm tối đa của bảng điểm mới</div>
                                                            <input name="input_maxbangdiem_bangdiem" type="text" class="card border-secondary shadow h-100 py-2 col-6 mb-4">

                                                            <div class="mb-4">Ngày bắt đầu</div>
                                                            <input name="input_ngaybatdau_bangdiem" type="date" placeholder="yyyy-mm-dd" class="form-custom border-secondary h-100 py-2 col-6 mb-4">

                                                            <div class="mb-4">Ngày kết thúc</div>
                                                            <input name="input_ngayketthuc_bangdiem" type="date" placeholder="yyyy-mm-dd" class="form-custom border-secondary h-100 py-2 col-6 mb-4">

                                                            <div class="mb-4">Khóa học áp dụng</div>
                                                            <table class="border table table-striped col-6">
                                                                <thead>
                                                                <tr>
                                                                    <th scope="col">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                            <input  type="checkbox" class="check" id="checkAllTM">
                                                                            </label>
                                                                        </div>
                                                                    </th>
                                                                    <th scope="col">Khóa học</th>
                                                                
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach ($doituong as $key=>$value)
                                                                    <tr>
                                                                        <td>
                                                                            <div class="checkbox">
                                                                                <label>
                                                                                <input name="doituong[]" value="{{$value->id}}" type="checkbox" class="checkTM">
                                                                                </label>
                                                                            </div>
                                                                        </td>
                                                                    <td>{{$value->name}}</td>    
                                                                    </tr> 
                                                                @endforeach
                                                                
                                                                
                                                                </tbody>
                                                            </table>
                                                            <input type="submit" value="Thêm" class="btn btn-outline-secondary py-2 shadow"/>
                                                            
                                                        </div>
                                                    </div>
                                                    </form>
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

      <!-- check all -->
      <script>
        $("#checkAll").click(function () {
            $(".check").prop('checked', $(this).prop('checked'))
        });
    </script>

    <script>
        $("#checkAllKH").click(function () {
            $(".checkKH").prop('checked', $(this).prop('checked'))
        });
    </script>

    <script>
        $("#checkAllTM").click(function () {
            $(".checkTM").prop('checked', $(this).prop('checked'))
        });
    </script>


@endsection





