<?php

use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/get-petani', 'ApiController@getPetaniWeb')->name("get.petani");


	// menampilkan master tanaman
Route::get('v1/jenis_tanaman', 'ApiController@getJenisTanaman');

// menampilkan semua data tanaman di tb_tanaman
Route::get('v1/tanaman', 'ApiController@getTanaman');

// menampilkan daftar - daftar notif dari tb_notification
Route::get('v1/notif', 'ApiController@getNotif');

// menampilkan keadaan status tanaman dengan menggunakan parameter id_channel
Route::get('v1/notification/{id}', 'ApiController@getNotifWithId');

// history id_petani
Route::get('v1/history/{id}', 'ApiController@getHistoryWithId');

// menggunakan id_petani
Route::post('v1/edit_akun/{id}', 'ApiController@editAkun');

// menampilkan tanaman tanman milik petani dengan id petani
Route::get('v1/kebunku/{id}', 'ApiController@getKebunkuWithId');

// penjadwalan dengan id_petani
Route::get('v1/penjadwalan/{id}', 'ApiController@getPerawatan');

// menampilkan master tanaman
Route::get('v1/tentang_tanaman', 'ApiController@getTentangTanaman');

// menampilkan data profile petani menggunakan id_user
Route::get('v1/profile/{id}', 'ApiController@getProfile');

// menampilkan data device yang berstatus 0 atau belum terpakai
Route::get('v1/device/{id}', 'ApiController@getDevice');

// mengambildata dari pihak tengah middleware
// id sementara cuma 1 = 530651
Route::get('v1/data/{id}', 'ApiController@getFromStation');

// mengambil data status tanaman berdasarkan id_tanaman
Route::get('v1/chart/{id}', 'ApiController@getChart');

// proses pengkondisian status tanaman dan mengirim hasil ke tb_status_notif dengan parameter id_channel
Route::get('v1/teye/{id}', 'ApiController@teye');

// proses kapan waktu pemupukan parameter berdasarkan id_petani
Route::get('v1/pupuk/{id}', 'ApiController@getPemupukanWithId');

// proses kapan waktu pemupukan parameter berdasarkan id_petani
Route::get('v1/siram/{id}', 'ApiController@getPenyiramanWithId');

// get deskripsi hama dan penyakit
Route::get('v1/penyakit', 'ApiController@penyakitHama');

// untuk percobaan
Route::get('v1/coba/{id}', 'ApiController@coba');

// revisi
Route::get('v1/revisi/{id}', 'ApiController@revisi');


// method POST
Route::post('v1/register', 'ApiController@postRegister');
Route::post('v1/login', 'ApiController@postLogin');
Route::post('v1/tambah_kebunku', 'ApiController@postTanaman');

