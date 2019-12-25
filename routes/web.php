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
Route::get('vote',['as'=>'vote','uses'=>'sinhvienController@get_value_vote']);
Route::get('vote-chi-tiet/{id}',['as'=>'vote-chi-tiet','uses'=>'sinhvienController@get_value_vote_chitiet']);
Route::post('/them-tra-loi','sinhvienController@insert_traloi_vote');
//-- -- --Thêm bầu chọn
Route::post('/tao-bau-chon-cvht','cvhtController@insert_cauhoi_vote');
Route::get('ket-qua-bau-chon-cvht/{id}',['as'=>'ket-qua-bau-chon-cvht','uses'=>'cvhtController@get_ketqua_bauchon_cvht']);


//--lop truong thong ke
Route::get('thongke',['as'=>'thongke','uses'=>'sinhvienController@thongke_loptruong']);
// -- export
Route::post('/thongke/export_diem','ExportExcel@export_diem' );


//CTSV
//--Quản lý bảng điểm

//-- get quyen --
Route::get('getQuyen','ctsvController@getQuyen');
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
Route::post('/xoa-user-quanlisinhvien','ctsvController@delete_users_quanlisinhvien');

//-- --FEEDBACK
//-- -- --Thêm feedback
Route::post('/them-feedback',['as'=>'them-feedback','uses'=>'sinhvienController@insert_feedback']);
//-- -- --Thêm feedback
Route::post('/them-comment',['as'=>'them-comment','uses'=>'feedbackController@insert_comment']);
//-- -- --Thêm reply
Route::post('/them-reply',['as'=>'them-reply','uses'=>'feedbackController@insert_reply']);

//-- --Quản lý tiêu chí
Route::get('quanlitieuchi',['as'=>'quanlitieuchi','uses'=>'ctsvController@get_value_quanlitieuchi']);
//-- --Quản lý phong trào
Route::get('quanliphongtrao',['as'=>'quanliphongtrao','uses'=>'ctsvController@get_value_quanliphongtrao']);
//-- --Quản lý hoạt động
Route::get('quanlihoatdong',['as'=>'quanlihoatdong','uses'=>'ctsvController@get_value_quanlihoatdong']);
//-- --CVHT
//-- --Phản hồi sinh viên
Route::get('phan-hoi-cvht',['as'=>'phan-hoi-cvht','uses'=>'cvhtController@get_value_phanhoicvht']);
//-- --Quản lí vote
Route::get('votecvht',['as'=>'votecvht','uses'=>'cvhtController@get_value_votecvht']);
//-- --Tạo vote
Route::get('create-vote-cvht',['as'=>'create-vote-cvht','uses'=>'cvhtController@get_value_create_vote_cvht']);
// -- -- thống kê báo cáo 
Route::get('thongke-cvht',['as'=>'thongke-cvht','uses'=>'cvhtController@get_value_thongkecvht']);

//TEST Route
// Route::get('test', 'TestController@index');
Route::get('get-user', 'TestController@GetUser');

//API Controller

//SINHVIEN
//--DASHBOARD
//-- --Get tiêu chí 
Route::post('get-tieu-chi-dashboard', 'APIController@GetTieuChi_dashboard');
Route::post('get-sum-bang-diem-dashboard', 'APIController@GetSumBangDiem_dashboard');
Route::get('dashboard/chitiettieuchi/{id}', 'sinhvienController@chitietTieuchi');


//--THAM GIA HOẠT ĐỘNG
//-- --Get phong trào
Route::post('get-phong-trao-thamgiahoatdong','APIController@GetPhongTrao_thamgiahoatdong');

//--FEEDBACK
//-- --Get phong trào
Route::post('get-phong-trao-feedback', 'APIController@GetPhongTrao_feedback');
//-- --Get hoạt động
Route::post('get-hoat-dong-feedback', 'APIController@GetHoatDong_feedback');
Route::post('get-feedback-ctsv','APIController@GetFeedbackCtsv_phanhoictsv');



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
//-- FEEDBACK
Route::post('get-comment-id-feedback','APIController@GetComment_Id_feedback');
Route::get('phan-hoi-ctsv',['as'=>'phan-hoi-ctsv','uses'=>'ctsvController@get_value_phanhoictsv']);
//-- --THỐNG KÊ BÁO CÁO
Route::post('get-thong-ke-thongkeloptruong','APIController@GetThongKe_thongkeloptruong');
Route::post('get-co-so-thongkectsv','APIController@GetCoSo_thongkectsv');
Route::post('get-thong-ke-thongkectsv','APIController@GetThongKe_thongkectsv');

Route::post('get-co-so-phanhoictsv','APIController@GetCoSo_phanhoictsv');
//-- -- --import
    //import hoạt động
Route::post('quanlihoatdong/import','ImportExcelController@importHoatdong');
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
//-- -- --Xóa user-hoatdong
Route::post('/xoa-user-hoatdong-danhsachsinhvienthamgiahoatdong','ctsvController@delete_user_hoat_dong_danhsachsinhvienthamgiahoatdong');

// -- -- -- Quản lí tài khoản
Route::get('quanlitaikhoan',['as'=>'quanlitaikhoan','uses'=>'ctsvController@get_value_quanlitaikhoan']);
Route::post('/quanlitaikhoan/phanquyen','ctsvController@update_quanlitaikhoan');


// -- -- -- Quản lí phản hồi
Route::get('/feedback/chitiet/{id}',['as'=>'feedback/chitiet','uses'=>'feedbackController@get_value_feedbackdetail']);
Route::get('/feedbackctsv/chitiet/{id}',['as'=>'feedbackctsv/chitiet','uses'=>'feedbackController@get_value_feedbackdetailctsv']);
Route::get('/feedbackcvht/chitiet/{id}',['as'=>'feedbackcvht/chitiet','uses'=>'feedbackController@get_value_feedbackdetailcvht']);

//--lop truong thong ke
Route::get('thongkectsv',['as'=>'thongkectsv','uses'=>'ctsvController@thongke_ctsv']);
// -- export
Route::post('/thongkectsv/export_diem','ExportExcel@export_diem_ctsv' );
Route::post('/quanliphongtrao/export_temp','ExportExcel@export_temp' );
Route::post('/quanlisinhvien/export_diem','ExportExcel@export_diem_ctsv' );
Route::post('/quanlihoatdong/export_temp','ExportExcel@export_temp' );
Route::post('/danhsachsinhvienthamgiahoatdong/export_temp','ExportExcel@export_temp' );