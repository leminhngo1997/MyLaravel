@extends('ctsv.trangchu')

@section('sidebar')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion border-right" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a style="color: indianred; background-color: white" class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('quanlibangdiem')}}">
        <div class="sidebar-brand-icon">
            <img style="width: 60px; height: 60px" class="img-profile" src="{{asset('public/admin/img/uit.png')}}">
        </div>
        <div class="sidebar-brand-text mx-3">CTSV</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item dropdown">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <a class="nav-link dropdown-toggle" href="{{route('quanlitieuchi')}}" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Quản lý chung</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('quanlitieuchi')}}">Quản lý tiêu chí</a>
            <a class="dropdown-item" href="{{route('quanliphongtrao')}}">Quản lý phong trào</a>
            <a class="dropdown-item" href="{{route('quanlihoatdong')}}">Quản lý hoạt động</a>
            <a class="dropdown-item" href="{{route('duyethoatdong')}}">Xét duyệt hoạt động</a>
            <a class="dropdown-item" href="{{route('importsinhvienthamgiahoatdong')}}">Danh sách tham gia hoạt
                động</a>
            <a class="dropdown-item" href="{{route('phan-hoi-ctsv')}}">Phản hồi sinh viên</a>
        </div>
    </li>
    <!-- Nav Item - Bảng điểm -->
    <li class="nav-item active dropdown">
        <a class="nav-link dropdown-toggle" href="{{route('quanlibangdiem')}}" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Quản lý bảng điểm</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('quanlibangdiem')}}">Quản lý bảng điểm</a>
            <a class="dropdown-item" href="{{route('quanlixeploai')}}">Quản lý xếp loại</a>
        </div>
    </li>
    <!-- Nav Item - Cơ sở-Sinh viên -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="{{route('quanlicoso')}}" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Quản lý Lớp-Sinh viên</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('quanlicoso')}}">Quản lý lớp</a>
            <a class="dropdown-item" href="{{route('quanlisinhvien')}}">Quản lý sinh viên</a>
            <a class="dropdown-item" href="{{route('quanlitaikhoan')}}">Phân quyền tải khoản</a>
        </div>
    </li>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('thongkectsv')}}">
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
        <h1 class="h3 mb-0 text-gray-800">Chi tiết sinh viên</h1>
    </div>
    <!-- Content Row -->
    <div class="align-content-center col-12 row">
        <div class="col-2"></div>
        <div class="card border-secondary shadow py-2 col-8">
            <form method="GET" role="form" action="{{URL::to('/update-sinh-vien-quanlisinhvien')}}">
            <div class="card-body">
                @foreach ($sinh_vien as $item)
                <table class="mb-4" style="width: 100%; height: 100%;">
                    <!-- thông tin người viết -->
                    
                    <tr>
                        <td style="width: 35%">
                            <h4>Họ tên:</h4>
                        </td>
                        <td>
                            <div id="text_hoten" style="color: coral; display:block"><h4>{{$item->hoten}}</h4></div>
                            <input id="input_hoten" name = "input_hoten"
                            style="text; color: coral; display:none" 
                            value="{{$item->hoten}}" 
                            class="h4 card border-secondary shadow h-100"/>
                        </td>
                        <td>
                            <button type="button" id="btn_chinh_sua" class="btn btn-outline-secondary py-2 shadow" style="display:block" onclick="edit()">Chỉnh sửa</button>
                            <button type="submit" id="btn_cap_nhat" name="id" class="btn btn-info py-2 shadow" style="display:none" value="{{$ma_tai_khoan}}">Cập nhật</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h4>Mã số sinh viên:</h4>
                        </td>
                        <td>
                            <div id="text_mssv" style="color: darkgray; display:block">
                                <h4>
                                    <?php $mssv = explode('@',$item->email); echo $mssv[0];?>
                                </h4>
                            </div>
                            <input name="input_mssv"
                            id="input_mssv"
                            style="text; color: darkgrey; display:none" 
                            value="<?php $mssv = explode('@',$item->email); echo $mssv[0];?>" 
                            class="h4 card border-secondary shadow h-100"/>
                        </td>
                        <td>
                            <button type="button" id="btn_huy" class="btn btn-outline-secondary shadow" style="display:none" onclick="cancel()">Hủy</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h4>Khoa quản lý:</h4>
                        </td>
                        <td>
                            <div style="color: darkgrey"><h4>{{$item->khoa}}</h4></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h4>Khoá:</h4>
                        </td>
                        <td>
                            <div style="color: darkgrey"><h4>{{$item->khoa_k}}</h4></div>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <h4>Lớp:</h4>
                        </td>
                        <td>
                            <div id="text_lop" style="color: darkgray; display:block"><h4>{{$item->lop}}</h4></div>
                            <select style="color: darkgrey; display:none" name="input_lop"
                                id="input_lop"
                                class="card border-secondary shadow h4">
                                @foreach($lop as $key)
                                    @if ($item->lop === $key->name)
                                        <option value="{{$key->id}}" selected>{{$key->name}}</option>
                                    @else
                                        <option value="{{$key->id}}">{{$key->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div id="input_hocky" style="display:none">
                                    <h5>Chọn học kỳ bắt đầu áp dụng</h5>
                                    <select style="color: darkgrey;" name="input_hocky"
                                        class="card border-secondary shadow h4">
                                        @foreach($hoc_ky as $key)
                                            <option value="{{$key->id}}">{{$key->name}}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h4>Chức vụ:</h4>
                        </td>
                        <td>
                            <div id="text_chucvu" style="color: darkgray; display:block"><h4>{{$item->chucvu}}</h4></div>
                            <select style="color: darkgrey; display:none" name="input_chuc_vu"
                                id="input_chucvu"
                                class="card border-secondary shadow h4">
                                @foreach($chuc_vu as $key)
                                    @if ($item->chucvu === $key->name)
                                        <option value="{{$key->id}}" selected>{{$key->name}}</option>
                                    @else
                                        <option value="{{$key->id}}">{{$key->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
            
                </table>
                @endforeach
            </div>
        </form>
        </div>
        <div class="col-2"></div>
    </div>
    <?php
        $message = Session::get('message');
        if($message){
            echo '<span style="color:red">' .$message. '</span>';
            Session::put('message',null);
        }
    ?>
</div>
<script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>
<script>
    function edit(){
        //button
        document.getElementById('btn_chinh_sua').style.display = 'none';
        document.getElementById('btn_cap_nhat').style.display = 'block';
        document.getElementById('btn_huy').style.display = 'block';

        //họ tên
        document.getElementById('text_hoten').style.display = 'none';
        document.getElementById('input_hoten').style.display = 'block';

        //MSSV
        document.getElementById('text_mssv').style.display = 'none';
        document.getElementById('input_mssv').style.display = 'block';

        //Lớp
        document.getElementById('text_lop').style.display = 'none';
        document.getElementById('input_lop').style.display = 'block';
        document.getElementById('input_hocky').style.display = 'block';

        //Chức vụ
        document.getElementById('text_chucvu').style.display = 'none';
        document.getElementById('input_chucvu').style.display = 'block';
    }

    function cancel(){
        //button
        document.getElementById('btn_chinh_sua').style.display = 'block';
        document.getElementById('btn_cap_nhat').style.display = 'none';
        document.getElementById('btn_huy').style.display = 'none';

        //họ tên
        document.getElementById('text_hoten').style.display = 'block';
        document.getElementById('input_hoten').style.display = 'none';

        //MSSV
        document.getElementById('text_mssv').style.display = 'block';
        document.getElementById('input_mssv').style.display = 'none';

        //Lớp
        document.getElementById('text_lop').style.display = 'block';
        document.getElementById('input_lop').style.display = 'none';
        document.getElementById('input_hocky').style.display = 'none';

        //Chức vụ
        document.getElementById('text_chucvu').style.display = 'block';
        document.getElementById('input_chucvu').style.display = 'none';
    }
</script>
@endsection