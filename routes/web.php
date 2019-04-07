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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', 'LandingController@index')->name('landing');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/data_master/dapil/hapus/{id?}','DapilController@destroy');
Route::resource('/data_master/dapil','DapilController');
Route::get('/data_master/kecamatan/hapus/{id?}','KecamatanController@destroy');
Route::resource('/data_master/kecamatan','KecamatanController');
Route::get('/data_master/desa/hapus/{id?}','DesaController@destroy');
Route::resource('/data_master/desa','DesaController');
Route::get('/data_master/tps/hapus/{id?}','TPSController@destroy');
Route::resource('/data_master/tps','TPSController');
Route::get('/data_master/partai/hapus/{id?}','PartaiController@destroy');
Route::resource('/data_master/partai','PartaiController');
Route::get('/data_master/calonDPR/hapus/{id?}','CalonDPRController@destroy');
Route::resource('/data_master/calonDPR','CalonDPRController');

Route::get('/pemilu/suara_terkumpul','PemungutanSuaraController@read')
	->name('suara_terkumpul');
Route::get('/pemilu/suara_terkumpul/dapil/{dapil?}','PemungutanSuaraController@detailDapil');
Route::get('/pemilu/suara_terkumpul/{lokasi?}','PemungutanSuaraController@detail');
Route::resource('/pemilu/pemungutan_suara','PemungutanSuaraController');
Route::resource('/pemilu/pemungutan_suara_partai','PemungutanSuaraPartaiController');
Route::get('/pemilu/token','TokenController@index')->name('token_akses');

Route::get('/api/', function() {return [];})->name('api');
Route::get('/api/get/kecamatan/{idDapil?}','AjaxController@getKecamatan');
Route::get('/api/get/desa/{idKec?}','AjaxController@getDesa');
Route::get('/api/get/tps/{idDesa?}','AjaxController@getTPS');
Route::get('/api/get/data_suara/{idTPS?}','AjaxController@getDataSuara');
Route::post('/api/submit/token','AjaxController@submitToken');
Route::post('/api/submit/data_suara','AjaxController@submitSuara');
Route::get('/api/token/generate_token','AjaxController@generateToken');

Route::get('/cetak/{berkas?}','CetakController@index')->name("cetak");