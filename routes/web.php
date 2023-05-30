<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('auth/login');
});

Auth::routes();




Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Auth::routes();

//Ruang Rapat
Route::get('/ruangRapat', [App\Http\Controllers\HomeController::class, 'ruangRapat'])->name('ruangRapat');
Route::post('/simpanRuangan', [App\Http\Controllers\HomeController::class, 'simpanRuangan'])->name('simpanRuangan');
Route::get('/editRuangan', 'App\Http\Controllers\HomeController@editRuangan')->name('editRuangan');
Route::post('/updateRuangan', 'App\Http\Controllers\HomeController@updateRuangan')->name('updateRuangan');
Route::get('/hapusRuangan{id}', 'App\Http\Controllers\HomeController@hapusRuangan');





//pegawai
Route::get('/pegawai', [App\Http\Controllers\HomeController::class, 'pegawai'])->name('pegawai');
Route::post('/simpanPegawai', 'App\Http\Controllers\HomeController@simpanPegawai',)->name('simpanPegawai');
Route::get('/editPegawai', 'App\Http\Controllers\HomeController@editPegawai')->name('editPegawai');
Route::post('/updatePegawai', [App\Http\Controllers\HomeController::class, 'updatePegawai'])->name('updatePegawai');
Route::get('/hapusPegawai{id}', 'App\Http\Controllers\HomeController@hapusPegawai');
Route::get('/lampiranPegawai', 'App\Http\Controllers\HomeController@lampiranPegawai')->name('lampiranPegawai');

//fasilitas  untuk Tambahan
// Route::get('/coba', [App\Http\Controllers\HomeController::class], 'coba')->name('coba');
Route::get('/fasilitas', 'App\Http\Controllers\HomeController@fasilitas')->name('fasilitas');
Route::post('/simpanFasilitas', 'App\Http\Controllers\HomeController@simpanFasilitas')->name('simpanFasilitas');
Route::get('/editFasilitas', 'App\Http\Controllers\HomeController@editFasilitas')->name('editFasilitas');
Route::post('/updatefasilitas', 'App\Http\Controllers\HomeController@updateFasilitas')->name('updateFasilitas');
Route::get('/hapusFasilitas{id}', 'App\Http\Controllers\HomeController@hapusFasilitas');

//fasilitas ruang rapat
Route::get('/fasilitas_baru', 'App\Http\Controllers\FasilitasController@index')->name('fasilitas_baru');
Route::post('/simpanFasilitas_baru', 'App\Http\Controllers\FasilitasController@simpanFasilitas_baru')->name('simpanFasilitas_baru');


//permohonan_rapat
Route::get('/permohonan_rapat', 'App\Http\Controllers\HomeController@permohonan_rapat')->name('permohonan_rapat');
Route::post('/simpanPermohonan', 'App\Http\Controllers\HomeController@simpanPermohonan')->name('simpanPermohonan');

Route::get('/editPermohonan', 'App\Http\Controllers\HomeController@editPermohonan')->name('editPermohonan');
Route::post('/statusTerima', 'App\Http\Controllers\HomeController@statusTerima')->name('statusTerima');
Route::get('/editStatus', 'App\Http\Controllers\HomeController@editStatus')->name('editStatus');

Route::get('/editTolak', 'App\Http\Controllers\HomeController@editTolak')->name('editTolak');
Route::post('/statusTolak', 'App\Http\Controllers\HomeController@statusTolak')->name('statusTolak');

Route::get('/editSelesai', 'App\Http\Controllers\HomeController@editSelesai')->name('editSelesai');
Route::post('/statusSelesai', 'App\Http\Controllers\HomeController@statusSelesai')->name('statusSelesai');

Route::post('/updateStatus', 'App\Http\Controllers\HomeController@updateStatus')->name('updateStatus');
Route::post('/updatePermohonan', 'App\Http\Controllers\HomeController@updatePermohonan')->name('updatePermohonan');

Route::get('/hapusPermohonan{id}', 'App\Http\Controllers\HomeController@hapusPermohonan');
Route::get('/detailPermohonan', 'App\Http\Controllers\HomeController@detailPermohonan')->name('detailPermohonan');


//Jadwal ruangan
Route::get('/agenda', 'App\Http\Controllers\HomeController@agenda')->name('agenda');

//absen
// Route::get('/absen', [App\Http\Controllers\HomeController::class, 'absen'])->name('absen');
Route::post('/simpanAbsen', 'App\Http\Controllers\HomeController@simpanAbsen')->name('simpanAbsen');

// Route::post('/absen', 'App\Http\Controllers\HomeController@absen')->name('absen');
Route::post('/absen', 'App\Http\Controllers\HomeController@absen')->name('absen');

// Route::post('/', 'App\Http\Controllers\HomeController@absen');
Route::get('/rekapAbsen{id}', 'App\Http\Controllers\HomeController@rekapAbsen')->name('rekapAbsen');

// pdf
Route::get('/pdf_rapat{id}', 'App\Http\Controllers\HomeController@pdf_rapat')->name('pdf_rapat');
Route::get('/pdf_permohonan', 'App\Http\Controllers\HomeController@pdf_permohonan')->name('pdf_rapat');
Route::get('/pdf_permohonan2', 'App\Http\Controllers\HomeController@pdf_permohonan2')->name('pdf_rapat2');


// Import Exel
Route::get('/export_excel', 'App\Http\Controllers\HomeController@export_excel');
Route::get('/export_excel2', 'App\Http\Controllers\HomeController@export_excel2');



//divisi

Route::get('/divisi', 'App\Http\Controllers\HomeController@divisi')->name('divisi');
Route::post('/simpanDivisi', 'App\Http\Controllers\HomeController@simpanDivisi')->name('simpanDivisi');
Route::get('/editDivisi', 'App\Http\Controllers\HomeController@editDivisi')->name('editDivisi');
Route::post('/updateDivisi', 'App\Http\Controllers\HomeController@updateDivisi')->name('updateDivisi');
Route::get('/hapusDivisi{id}', 'App\Http\Controllers\HomeController@hapusDivisi');

// Upload Notulen
Route::post('/uploadNotulen', 'App\Http\Controllers\HomeController@uploadNotulen')->name('uploadNotulen');
// lihat notulen
Route::get('/TampilLampiran', 'App\Http\Controllers\HomeController@TampilLampiran')->name('TampilLampiran');

//home
//looping table in ajax
//ruangrapat
Route::get('/tampilruang', 'App\Http\Controllers\TampilRuangRapatController@tampilruang')->name('tampilruang');
Route::get('/ruangan_terpakai', 'App\Http\Controllers\TampilRuangRapatController@ruangan_terpakai')->name('ruangan_terpakai');
Route::get('/ruangan_tersedia', 'App\Http\Controllers\TampilRuangRapatController@ruangan_tersedia')->name('ruangan_tersedia');
Route::get('/ruangan_dibooking', 'App\Http\Controllers\TampilRuangRapatController@ruangan_dibooking')->name('ruangan_dibooking');


//json
Route::get('/jsonAbsen', 'App\Http\Controllers\HomeController@jsonAbsen')->name('jsonAbsen');

//Data pegawai
Route::get('/dataPegawai', 'App\Http\Controllers\DataPegawaiController@dataPegawai')->name('dataPegawai');
Route::post('/tambahPegawai', 'App\Http\Controllers\DataPegawaiController@tambahPegawai')->name('tambahPegawai');
Route::get('/editDataPegawai', 'App\Http\Controllers\DataPegawaiController@editDataPegawai')->name('editDataPegawai');
Route::post('/updateDataPegawai', 'App\Http\Controllers\DataPegawaiController@updateDataPegawai')->name('updateDataPegawai');
Route::get('/hapusDataPegawai{id}', 'App\Http\Controllers\DataPegawaiController@hapusDataPegawai');


Route::get('/update_status_baca', 'App\Http\Controllers\HomeController@update_status_baca')->name('update_status_baca');

// ditolak
Route::get('/editBaca', 'App\Http\Controllers\HomeController@editBaca')->name('editBaca');
Route::post('/updateBaca', 'App\Http\Controllers\HomeController@updateBaca')->name('updateBaca');


























//jangan lupa harus ada id dari row yang akan d hapus
