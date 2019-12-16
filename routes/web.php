<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//auth
Route::get('logout', 'Auth\LoginController@logout');

//Sinhvien
//--dashboard
Route::get('dashboard',['as'=>'dashboard','uses'=>'sinhvienController@get_value_dashboard']);

//--tham gia hoat dong
Route::get('thamgiahoatdong',['as'=>'thamgiahoatdong','uses'=>'sinhvienController@get_value_hoatdong']);
//-- -- --Thêm hoạt động
Route::post('/them-hoat-dong-thamgiahoatdong','sinhvienController@insert_hoat_dong_thamgiahoatdong');


//--feedback
Route::get('feedback',['as'=>'feedback','uses'=>'sinhvienController@get_value_feedback']);

//--vote
Route::get('vote',['as'=>'vote',function(){
    return view('sinhvien.vote');
}]);

//CTSV
//--Quản lý bảng điểm

//-- --Quản lý bảng điểm
Route::get('quanlibangdiem',['as'=>'quanlibangdiem','uses'=>'ctsvController@get_value_quanlibangdiem']);
//-- -- --Thêm loại bảng điểm
Route::post('/them-loai-bang-diem','ctsvController@insert_loai_bang_diem');
//-- -- --Xóa loại bảng điểm
Route::get('/delete-loai-bang-diem/{id}','ctsvController@delete_loai_bang_diem' );
//-- -- --Thêm bảng điểm
Route::post('/them-bang-diem','ctsvController@insert_bang_diem');

//-- --Quản lý tiêu chí
//-- -- --Thêm tiêu chí
Route::post('/them-tieu-chi-quanlitieuchi','ctsvController@insert_tieu_chi_quanlitieuchi');
//-- -- --Xóa tiêu chí
Route::get('/delete-tieu-chi-quanlitieuchi/{id}','ctsvController@delete_tieu_chi_quanlitieuchi' );

//-- --Quản lý phong trào
//-- -- --Thêm phong trào
Route::post('/them-phong-trao-quanliphongtrao','ctsvController@insert_phong_trao_quanliphongtrao');
//-- -- --Xóa phong trào
Route::get('/delete-phong-trao-quanliphongtrao/{id}','ctsvController@delete_phong_trao_quanliphongtrao' );

//-- --Quản lý hoạt động
//-- -- --Thêm hoạt động
Route::post('/them-hoat-dong-quanlihoatdong','ctsvController@insert_hoat_dong_quanlihoatdong');
//-- -- --Xóa hoạt động
Route::post('/xoa-hoat-dong-quanlihoatdong','ctsvController@delete_hoat_dong_quanlihoatdong');
//-- --Quản lý cơ sở
//-- -- --Thêm cơ sở
Route::post('/them-co-so-quanlicoso','ctsvController@insert_co_so_quanlicoso');
//-- -- --Xóa cơ sở
Route::get('/delete-co-so-quanlicoso/{id}','ctsvController@delete_co_so_quanlicoso' );
//-- --Quản lý sinh viên
//-- -- --Thêm tiêu chí
Route::post('/them-users-quanlisinhvien','ctsvController@insert_users_quanlisinhvien');
//-- -- --Xóa sinh viên
Route::get('/delete-users-quanlisinhvien/{id}','ctsvController@delete_users_quanlisinhvien' );

//-- --Quản lý tiêu chí
Route::get('quanlitieuchi',['as'=>'quanlitieuchi','uses'=>'ctsvController@get_value_quanlitieuchi']);
//-- --Quản lý phong trào
Route::get('quanliphongtrao',['as'=>'quanliphongtrao','uses'=>'ctsvController@get_value_quanliphongtrao']);
//-- --Quản lý hoạt động
Route::get('quanlihoatdong',['as'=>'quanlihoatdong','uses'=>'ctsvController@get_value_quanlihoatdong']);


//TEST Route
// Route::get('test', 'TestController@index');
Route::get('get-user', 'TestController@GetUser');

//API Controller

//SINHVIEN
//--DASHBOARD
//-- --Get tiêu chí 
Route::post('get-tieu-chi-dashboard', 'APIController@GetTieuChi_dashboard');

//--THAM GIA HOẠT ĐỘNG
//-- --Get phong trào
Route::post('get-phong-trao-thamgiahoatdong','APIController@GetPhongTrao_thamgiahoatdong');

//--FEEDBACK
//-- --Get phong trào
Route::post('get-phong-trao-feedback', 'APIController@GetPhongTrao_feedback');
//-- --Get hoạt động
Route::post('get-hoat-dong-feedback', 'APIController@GetHoatDong_feedback');


//CTSV
//--Bảng điểm
//-- --Quản lí tiêu chí
//-- -- --Get bảng điểm
Route::post('get-bang-diem-quanlitieuchi','APIController@GetBangDiem_quanlitieuchi');
Route::post('get-bang-diem-quanliphongtrao','APIController@GetBangDiem_quanliphongtrao');
//-- -- --Get tiêu chí
Route::post('get-tieu-chi-quanlitieuchi','APIController@GetTieuChi_quanlitieuchi');
Route::post('get-tieu-chi-quanliphongtrao','APIController@GetTieuChi_quanliphongtrao');
//-- -- --Get phong trào
Route::post('get-phong-trao-quanliphongtrao','APIController@GetPhongTrao_quanliphongtrao');

Route::post('get-bang-diem-quanlihoatdong','APIController@GetBangDiem_quanlihoatdong');
Route::post('get-tieu-chi-quanlihoatdong','APIController@GetTieuChi_quanlihoatdong');
Route::post('get-phong-trao-quanlihoatdong','APIController@GetPhongTrao_quanlihoatdong');
Route::post('get-hoat-dong-quanlihoatdong','APIController@GetHoatDong_quanlihoatdong');

//-- --Xét duyệt hoạt động
//-- -- --load hoạt động/hủy hoạt động
Route::post('get-hoat-dong-duyethoatdong','APIController@GetHoatDong_duyethoatdong');

//-- -- --import
    //import hoạt động
Route::post('quanlihoatdong/import','ImportExcelController@import');
    //import sinh viên
Route::post('quanlisinhvien/import','ImportExcelController@importSinhvien');
    //import phong trao
Route::post('quanliphongtrao/import','ImportExcelController@importPhongtrao');




// -- -- -- Quản lí cơ sở
Route::get('quanlicoso',['as'=>'quanlicoso','uses'=>'ctsvController@get_value_quanlicoso']);
Route::post('get-co-so-quanlicoso','APIController@GetCoSo_quanlicoso');
// -- -- -- Quản lí sinh viên
Route::get('quanlisinhvien',['as'=>'quanlisinhvien','uses'=>'ctsvController@get_value_quanlisinhvien']);
Route::post('get-co-so-quanlisinhvien','APIController@GetCoSo_quanlisinhvien');
Route::post('get-users-quanlisinhvien','APIController@GetUsers_quanlisinhvien');


// -- -- -- Duyệt hoạt động
Route::get('duyethoatdong',['as'=>'duyethoatdong','uses'=>'ctsvController@get_value_duyethoatdong']);
Route::post('xoa-duyet-hoat-dong','ctsvController@xoa_duyet_hoat_dong');

// -- -- -- Quản lí xếp loại
Route::get('quanlixeploai',['as'=>'quanlixeploai','uses'=>'ctsvController@get_value_quanlixeploai']);
Route::post('get-xep-loai-quanlixeploai','APIController@GetXepLoai_quanlixeploai');
//-- -- --Thêm xếp loại
Route::post('/them-xep-loai-quanlixeploai','ctsvController@insert_xep_loai_quanlixeploai');
//-- -- -- Xóa xếp loại
Route::get('/delete-xep-loai-quanlixeploai/{id}','ctsvController@delete_xep_loai_quanlixeploai' );

// -- -- -- Import sinh viên tham gia hoạt động
Route::get('importsinhvienthamgiahoatdong',['as'=>'importsinhvienthamgiahoatdong','uses'=>'ctsvController@get_value_importsinhvienthamgiahoatdong']);
Route::post('get-hoat-dong-importsinhvienthamgiahoatdong','APIController@GetHoatDong_importsinhvienthamgiahoatdong');
Route::get('danhsachsinhvienthamgiahoatdong/{id}',['as'=>'danhsachsinhvienthamgiahoatdong','uses'=>'ctsvController@get_value_danhsachsinhvienthamgiahoatdong']);
Route::post('danhsachsinhvienthamgiahoatdong/import','ImportExcelController@importThamgia');

// -- -- -- Quản lí tài khoản
Route::get('quanlitaikhoan',['as'=>'quanlitaikhoan','uses'=>'ctsvController@get_value_quanlitaikhoan']);
Route::post('/quanlitaikhoan/phanquyen','ctsvController@update_quanlitaikhoan');


// -- -- -- Quản lí phản hồi
Route::get('feedback/chitiet',['as'=>'feedback/chitiet','uses'=>'feedbackController@get_value_feedbackdetail']);