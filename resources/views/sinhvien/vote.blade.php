
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
            <li class="nav-item active">
                <a class="nav-link" href="{{route('vote')}}">
                    <i class="fas fa-fw fa-vote-yea"></i>
                    <span>Bầu chọn</span></a>
            </li>


        </ul>
        <!-- End of Sidebar -->
@endsection

@section('main_content')
<!-- Begin Page Content -->
<div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Bầu chọn</h1>
        </div>
        <!-- Content Row -->
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Tên tiêu chí</th>
                <th scope="col">Bắt đầu</th>
                <th scope="col">Kết thúc</th>
                <th scope="col">Lựa chọn</th>
                <th scope="col">Tình trạng</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>Vote ĐRL cộng cho thành viên</td>
                <td>11/06/2019</td>
                <td>11/07/2019</td>
                <td>Nhiều</td>
                <td>Đang mở</td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>Vote bầu ban cán sự lớp</td>
                <td>30/04/2019</td>
                <td>30/05/2019</td>
                <td>Một</td>
                <td>Đang mở</td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>Vote bầu thủ lĩnh sinh viên</td>
                <td>30/03/2019</td>
                <td>30/04/2019</td>
                <td>Một</td>
                <td>Đã đóng</td>
              </tr>
            </tbody>
          </table>
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
@endsection