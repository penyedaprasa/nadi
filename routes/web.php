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

Route::get('/haha', function () {
    return view('AuthAdmin.login2');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('get/data', 'TanamanController@getFromStation')->name('data');


use App\User;
use App\Petani;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

	Route::get('get_tanggal', 'TanamanController@umurTanaman');


Route::group(['prefix' => 'admin'], function() {

	Route::get('api/user/home', 'UsersController@apiindex');


	Route::get('/login', 'AuthAdmin\LoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'AuthAdmin\LoginController@Login')->name('admin.login.submit');
	Route::get('/', 'AdminController@index')->name('admin.home');
	
	Route::resource('/users', 'UsersController');
	Route::get('api/users', 'UsersController@apiUsers')->name('api.users');

	Route::resource('tanaman', 'TanamanController');
	Route::get('detail_status/{id}', 'TanamanController@detailStatus')->name('tanaman.detail_status');
	Route::get('history_tanaman/{id}', 'TanamanController@history')->name('history');

	Route::resource('device', 'DeviceController');
	
	Route::resource('jenis_tanaman', 'JenisTanamanController');

	

	
	// tambah mmanual
	Route::get('addpetani', function(){
		$tani = petani::create([
			'id_user'=> '2',
			'nama_petani'=> 'Joli',
			'alamat'=> 'bebeas', 
			'no_hp'=> '0979796896589', 
			'id_device'=> '123'
		]);
	});

	// tambah relasi
	Route::get('addpetanione', function()
	{
		$user = User::find(2);
		$petani = new Petani([
			'nama_petani'=> 'Give Up',
			'alamat'=> 'asfafw',
			'no_hp'=> '08986858',
			'id_device'=> '123'

			]);
		$user->petani()->save($petani);
		return $user;
	});

	Route::get('join', function(){
		$users = DB::table('tb_users')->join('tb_petani', 'id_user', '=', 'tb_petani.id_user');
		return $users;
	});


	Route::get('readuser', function() {
		

		$b = Auth::id();

		$user = User::find(2);

		$data = [
			'email' => $user->email,
			'nama_petani' => $user->petani->nama_petani,
			'alamat' => $user->petani->alamat
		];

		return $user->petani->alamat;
		// return print($b);

	});



});

use App\Administrator;

Route::get('addadmin', function()
{
		$user = User::find(2);
		$admin = new Administrator([
			'nama_admin'=> 'jumanji'
			]);
		$user->administrator()->save($admin);
		return $user;
});
