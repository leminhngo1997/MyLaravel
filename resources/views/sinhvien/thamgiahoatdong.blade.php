@extends('sinhvien.trangchu')

@section('sidebar')
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
            <li class="nav-item">
                <a class="nav-link" href="{{route('dashboard')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
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
        Hoạt động
    </div>
    <!-- Content Row -->
    <ul class="nav nav-tabs" id="eventTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="activity-tab" data-toggle="tab" href="#activity" role="tab" aria-controls="activity" aria-selected="true">Hoạt động</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="create-activity-tab" data-toggle="tab" href="#create-activity" role="tab" aria-controls="create-activity" aria-selected="false">Tạo mới</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="registered-activity-tab" data-toggle="tab" href="#registered-activity" role="tab" aria-controls="registered-activity" aria-selected="false">Đã đăng ký</a>
        </li>
        </ul>
        <div class="tab-content" id="eventTabContent">
        <!-- Activity-list tab -->
        <div class="tab-pane fade show active" id="activity" role="tabpanel" aria-labelledby="activity-tab">
                <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Đăng ký</th>
                    <th scope="col">Tên tiêu chí</th>
                    <th scope="col">Tên hoạt động</th>
                    <th scope="col">Điểm cộng</th>
                    <th scope="col">Bắt đầu</th>
                    <th scope="col">Kết thúc</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="registration-Check1">
                            <label class="custom-control-label" for="registration-Check1"></label>
                        </div>
                    </td>
                    <td>Tiêu chí 1</td>                                    
                    <td>Bán hoa</td>
                    <td>5</td>
                    <td>11/06/2019</td>
                    <td>11/07/2019</td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="registration-Check2">
                            <label class="custom-control-label" for="registration-Check2"></label>
                        </div>
                    </td>
                    <td>Tiêu chí 2</td>                                  
                    <td>Nhổ cỏ</td>
                    <td>3</td>
                    <td>30/04/2019</td>
                    <td>30/05/2019</td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="registration-Check3">
                            <label class="custom-control-label" for="registration-Check3"></label>
                        </div>
                    </td>
                    <td>Tiêu chí 3</td>                                   
                    <td>Hiến máu</td>
                    <td>5</td>
                    <td>30/03/2019</td>
                    <td>30/04/2019</td>
                </tr>
                </tbody>
            </table>
            <div class="mb-4">
                <button type="button" class="btn btn-outline-secondary py-2 shadow">Đăng ký</button>
            </div>
            <!-- /.container-fluid -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4 align-items-end">
                <!-- page navigation -->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                        </ul>
                    </nav>
                </div>  
        </div>
        <!-- Create-activity tab -->
        <div class="tab-pane fade" id="create-activity" role="tabpanel" aria-labelledby="create-activity-tab">
            <label class="text-danger">Hoạt động sau khi tạo sẽ được phòng CTSV kiểm duyệt</label>
            <div class="row">
                <div class="col-xl-6 col-md-12 col-sm-12 mb-4">
                    <div class="col-12">
                        <div class="border-secondary h-100 py-2 col-12">
                            <div class="col-12 mb-4">
                                <div class="mb-4">Tiêu chí</div>
                                <select class="card border-secondary shadow h-100 py-2 col-12 mb-4" id="dropdown-tieu-chi-thamgiahoatdong">
                                    @foreach($tieuchi as $key =>$value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                                <div class="mb-4">Tên hoạt động</div>
                                <input type=text class="card border-secondary shadow h-100 py-2 col-12 mb-4"/>
                                <div class="mb-4">Ngày bắt đầu</div>
                                <input id="date_start" type="date" placeholder="yyyy-mm-dd" class="form-custom border-secondary shadow h-100 py-2 col-12 mb-4"/>
                                <div class="mb-4">Mô tả</div>
                                <textarea class="col-12 mb-4" rows="4"></textarea>
                                <button type="button" class="btn btn-outline-secondary py-2 shadow">Tạo mới</button>
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
                                <select class="card border-secondary shadow h-100 py-2 col-12 mb-4" id='dropdown-phong-trao-thamgiahoatdong'>
                                    {{-- option phong trào --}}
                                </select>
                                <div class="mb-4">Điểm cộng</div>
                                <input type=text class="card border-secondary shadow h-100 py-2 col-12 mb-4"/>
                                <div class="mb-4">Ngày kết thúc</div>
                                <input id="date_end" type="date" placeholder="yyyy-mm-dd" class="form-custom border-secondary shadow h-100 py-2 col-12 mb-4"/>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Registered-activity tab -->
        <div class="tab-pane fade" id="registered-activity" role="tabpanel" aria-labelledby="registered-activity-tab">
        <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Hủy đăng ký</th>
                    <th scope="col">Tên tiêu chí</th>
                    <th scope="col">Tên hoạt động</th>
                    <th scope="col">Điểm cộng</th>
                    <th scope="col">Bắt đầu</th>
                    <th scope="col">Kết thúc</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="cancel-registration-Check1">
                            <label class="custom-control-label" for="cancel-registration-Check1"></label>
                        </div>
                    </td>
                    <td>Tiêu chí 1</td>                                    
                    <td>Bán hoa</td>
                    <td>5</td>
                    <td>11/06/2019</td>
                    <td>11/07/2019</td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="cancel-registration-Check2">
                            <label class="custom-control-label" for="cancel-registration-Check2"></label>
                        </div>
                    </td>
                    <td>Tiêu chí 2</td>                                  
                    <td>Nhổ cỏ</td>
                    <td>3</td>
                    <td>30/04/2019</td>
                    <td>30/05/2019</td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="cancel-registration-Check3">
                            <label class="custom-control-label" for="cancel-registration-Check3"></label>
                        </div>
                    </td>
                    <td>Tiêu chí 3</td>                                   
                    <td>Hiến máu</td>
                    <td>5</td>
                    <td>30/03/2019</td>
                    <td>30/04/2019</td>
                </tr>
                </tbody>
            </table>
            <div class="mb-4">
                <button type="button" class="btn btn-outline-secondary py-2 shadow">Hủy</button>
            </div>
            <!-- /.container-fluid -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4 align-items-end">
                <!-- page navigation -->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                        </ul>
                    </nav>
                </div>  
        </div>
        </div>
</div>
<script src="{{asset('public/admin/vendor/jquery/jquery.min.js')}}"></script>
{{-- Auto call get phongtrao api --}}
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var getSelected = $("#dropdown-tieu-chi-thamgiahoatdong").children("option:selected").val();
            $.ajax({
            type:'POST',
            url:"{{url('get-phong-trao-thamgiahoatdong')}}",
            data:{tieu_chi_id: getSelected},
            success:function(data){
                $('.delete-option-phong-trao').remove();
                data.forEach(element => {
                    option = `<option class = "delete-option-phong-trao" value="`+element.id+`">`+element.name+`</option>`;
                    $('#dropdown-phong-trao-thamgiahoatdong').append(option);
                });
            }
            });
    });

    $('#dropdown-tieu-chi-thamgiahoatdong').change(function(e){
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }   
        });
        e.preventDefault();
        var getSelected = $(this).children("option:selected").val();
        $.ajax({
            type:'POST',

            url:"{{url('get-phong-trao-feedback')}}",

            data:{tieu_chi_id: getSelected},

            success:function(data){
                $('.delete-option-phong-trao').remove();
                data.forEach(element => {
                        option = `<option class = "delete-option-phong-trao" value="`+element.id+`">`+element.name+`</option>`;
                        $('#dropdown-phong-trao-thamgiahoatdong').append(option);
                    });
                }
            });
    });

</script>
@endsection

