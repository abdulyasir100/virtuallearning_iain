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

//General
Route::get('/', 'HomeController@index');
Route::get('/login', 'HomeController@index');
Route::post('/loginPost', 'HomeController@loginPost');
Route::get('/logout', 'HomeController@logout');
//zoom foto
Route::get('foto/{loc}/{foto}', 'HomeController@zoomfoto');
//download
Route::get('download/{loc}/{path}', 'HomeController@download');

//Dosen
Route::get('/dosen', 'DosenController@index');
//Menuju halaman profil dosen
Route::get('/dosen/profildosen', 'DosenController@profildosen');
//trigger proses logika edit dosen
Route::put('/dosen/editdosenput/{username}', 'DosenController@editdosenPut');

//dosen KELAS
//dosen logika tambah kelas
Route::post('/{kodedosen}/tambahkelasPost', 'DosenController@buatkelasPost');
//dosen menuju kelas
Route::get('/dosen/kelas/{kodekelas}', 'DosenController@indexkelas');
//dosen menuju lihat member kelas
Route::get('/dosen/member/{kodekelas}', 'DosenController@indexmember');
//Menuju halaman edit kelas
Route::get('/dosen/editkelas/{kodekelas}', 'DosenController@editkelas');
//trigger proses logika edit kelas
Route::put('/dosen/editkelasPut/{kodekelas}', 'DosenController@editkelasPut');

//dosen Pengumuman
//dosen logika tambah pengumuman
Route::post('/dosen/pengumumanpost/{kodekelas}', 'DosenController@pengumumanPost');
//trigger proses logika edit pengumuman
Route::put('/dosen/pengumumanput', 'DosenController@pengumumanPut');

//dosen Materi
//Menuju halaman bagi materi
Route::get('/dosen/bagimateri/{kodekelas}', 'DosenController@bagimateri');
//trigger proses logika tambah materi
Route::post('/dosen/bagimateripost/{kodekelas}', 'DosenController@bagimateriPost');
//Menuju halaman detail materi
Route::get('/dosen/editmateri/{idmateri}', 'DosenController@editmateri');
//trigger proses logika edit kelas
Route::put('/dosen/editmateriPut/{idmateri}', 'DosenController@editmateriPut');

//dosen Tugas
//Menuju halaman bagi tugas
Route::get('/dosen/bagitugas/{kodekelas}', 'DosenController@bagitugas');
//trigger proses logika tambah tugas
Route::post('/dosen/bagitugaspost/{kodekelas}', 'DosenController@bagitugasPost');
//Menuju halaman detail tugas
Route::get('/dosen/edittugas/{idtugas}', 'DosenController@edittugas');
//trigger proses logika edit tugas
Route::put('/dosen/edittugasPut/{idtugas}', 'DosenController@edittugasPut');

//dosen Penilaian
//Menuju halaman daftar tugas
Route::get('/dosen/listtugas', 'DosenController@listtugas');
//Menuju halaman daftar nilai
Route::get('/dosen/daftarnilai/{idtugas}', 'DosenController@listnilai');
//Menuju halaman penilaian
Route::get('/dosen/penilaian/{idjawaban}', 'DosenController@nilai');
//trigger proses logika edit tugas
Route::put('/dosen/nilaiPut/{idjawaban}', 'DosenController@nilaiPut');

//Mahasiswa
Route::get('/mahasiswa', 'MahasiswaController@index');
//Menuju halaman profil mahasiswa
Route::get('/mahasiswa/profilmahasiswa', 'MahasiswaController@profilmahasiswa');
//trigger proses logika edit mahasiswa
Route::put('/mahasiswa/editmahasiswaput', 'MahasiswaController@editmahasiswaput');

//Mahasiswa Materi
//Menuju halaman detail materi
Route::get('/mahasiswa/materi/{idmateri}', 'MahasiswaController@detailmateri');

//Tugas
//Menuju halaman detail tugas
Route::get('/mahasiswa/tugas/{idtugas}', 'MahasiswaController@detailtugas');
//trigger proses logika submit tugas
Route::post('/mahasiswa/submitjawabanpost/{idtugas}', 'MahasiswaController@submitjawabanPost');
//trigger proses logika edit tugas
Route::put('/mahasiswa/editjawabanPut/{idjawaban}', 'MahasiswaController@editjawabanPut');
//Menuju halaman list tugas
Route::get('/mahasiswa/listtugas', 'MahasiswaController@listtugas');

//mahasiswa kelas
Route::post('/{NIM}/confirmmasukkelas', 'MahasiswaController@confirmkelas');
Route::post('/mahasiswa/masukkelasPost/{kodekelas}', 'MahasiswaController@masukkelasPost');
Route::get('/mahasiswa/kelas/{kodekelas}', 'MahasiswaController@indexkelas');
//mahasiswa menuju lihat member kelas
Route::get('/mahasiswa/member/{kodekelas}', 'MahasiswaController@indexmember');

//admin login session
Route::get('/loginadmin', 'AdminController@login');
Route::post('/loginadminPost', 'AdminController@loginPost');
Route::get('/logoutadmin', 'AdminController@logout');

//beranda admin
Route::get('/admin', 'AdminController@index');

//crud dosen for admin
//Menuju halaman tambah dosen
Route::get('/admin/tambahdosen', 'AdminController@tambahdosen');
//trigger proses logika tambah dosen
Route::post('/tambahdosenpost', 'AdminController@tambahdosenPost');
//Menuju halaman edit dosen
Route::get('/admin/profildosen/{kodedosen}', 'AdminController@editdosen');
//trigger proses logika edit dosen
Route::put('/editdosenput/{kodedosen}/{username}', 'AdminController@editdosenPut');
//hapus akun dosen
Route::delete('/admin/hapusdosen/{kodedosen}', 'AdminController@hapusdosen');


//crud for mahasiswa
//Menuju halaman tambah mahasiswa
Route::get('/admin/tambahmahasiswa', 'AdminController@tambahmahasiswa');
//trigger proses logika tambah mahasiswa
Route::post('/tambahmahasiswapost', 'AdminController@tambahmahasiswaPost');
//Menuju halaman edit mahasiswa
Route::get('/admin/profilmahasiswa/{kodemahasiswa}', 'AdminController@editmahasiswa');
//trigger proses logika edit mahasiswa
Route::put('/editmahasiswaput/{kodemahasiswa}', 'AdminController@editmahasiswaput');
//hapus akun mahasiswa
Route::delete('/admin/hapusmahasiswa/{kodemahasiswa}', 'AdminController@hapusmahasiswa');

