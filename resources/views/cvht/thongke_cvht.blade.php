@extends('cvht.trangchu')
@section('sidebar')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('phan-hoi-cvht')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">UIT - CVHT</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('phan-hoi-cvht')}}">
            <i class="fas fa-fw fa-comments"></i>
            <span>Phản hồi sinh viên</span></a>
    </li>
    <!-- Nav Item - Bảng điểm -->
  
    <!-- Nav Item - Cơ sở-Sinh viên -->
  
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('thongke-cvht')}}">
            <i class="fas fa-fw fa-comments"></i>
            <span>Thống kê báo cáo</span></a>
    </li>
    <li class="nav-item active dropdown">
        <a class="nav-link dropdown-toggle" href="{{route('votecvht')}}" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Bầu chọn</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{route('create-vote-cvht')}}">Tạo bầu chọn</a>
            <a class="dropdown-item" href="{{route('votecvht')}}">Quản lí bầu chọn</a>
        </div>
    </li>
</ul>

<!-- End of Sidebar -->

@endsection
@section('main_content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thống kê</h1>
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
                                Thống kê
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <!-- Core sheet type -->
                            <!-- collapse 1 content -->
                            <div class="row">
                                <form method="post" enctype="multipart/form-data"
                                        action="{{ url('/thongke/export_diem') }}">
                                        {{ csrf_field() }}
                                <select class="btn btn-secondary dropdown-toggle ml-3 mb-4" href="#" role="button"
                                    id="drop-down-term" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" name="bang_diem_id">
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
                                <input type="submit" class="btn btn-success mb-4 ml-5 align-self-center" value="Export Excel">
                                </form>
                            </div>
                            <table class="border table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Mã sinh viên</th>
                                        <th scope="col">Tên sinh viên</th>
                                        <th scope="col">Tổng điểm</th>
                                        <th scope="col">Xếp loại</th>
                                    </tr>
                                </thead>
                                <tbody id="show-thong-ke">
                                   {{--  --}}
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                                aria-expanded="false" aria-controls="collapseTwo">
                                Chỉnh sửa bảng điểm
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            <!-- collapse 2 content -->
                  
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree"
                                aria-expanded="false" aria-controls="collapseThree">
                                Tạo mới bảng điểm
                            </button>
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        {{-- Form thêm bảng điểm --}}
                            <div class="card-body">
                                <!-- collapse 3 content -->
 
                            </div>
                    </div>
                </div>
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
            url: "{{url('get-thong-ke-thongkeloptruong')}}",
            data: {
                term_id: getSelected
            },
            success: function (data) {
                $('.delete-row-thong-ke').remove();
                
                data.forEach(element => {
                    html = `<tr class="delete-row-thong-ke">
                                <td>`+element.mssv+`</td>
                                <td>`+element.name+`</td>
                                <td>`+element.diem+`</td>
                                <td>`+element.xeploai+`</td>
                            </tr>`;
                    $('#show-thong-ke').append(html);
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
            url: "{{url('get-thong-ke-thongkeloptruong')}}",
            data: {
                term_id: getSelected
            },
            success: function (data) {
                $('.delete-row-thong-ke').remove();
                
                data.forEach(element => {
                    html = `<tr class="delete-row-thong-ke">
                                <td>`+element.mssv+`</td>
                                <td>`+element.name+`</td>
                                <td>`+element.diem+`</td>
                                <td>`+element.xeploai+`</td>
                            </tr>`;
                    $('#show-thong-ke').append(html);
                });
            }
        });
    });
</script>
@endsection