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
// import excel
Route::get('/import_excel', 'ImportExcelController@index');
Route::post('/import_excel/import', 'ImportExcelController@import');

