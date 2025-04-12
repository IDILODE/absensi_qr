<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rute untuk autentikasi
$routes->get('auth/login', 'AuthController::login');
$routes->post('auth/authenticate', 'AuthController::authenticate');
$routes->get('auth/logout', 'AuthController::logout');
$routes->get('auth/googleLogin', 'AuthController::google');
$routes->get('auth/googleCallback', 'AuthController::googleCallback');
$routes->get('auth/register', 'AuthController::register');
$routes->post('auth/createAccount', 'AuthController::createAccount');
$routes->get('auth/forgot', 'AuthController::forgot');
$routes->post('auth/reset_password', 'AuthController::reset_password');
$routes->get('auth/reset_password_form', 'AuthController::reset_password_form');
$routes->post('auth/update_password', 'AuthController::update_password');

// Rute untuk halaman utama dan lainnya
$routes->get('/', 'Admin\Dashboard::index');

// Route untuk halaman absen masuk
$routes->get('scan/absen_masuk', 'Scan\AbsenMasukController::index');
$routes->post('scan/absen_masuk/processQR', 'Scan\AbsenMasukController::processQR');

// Route untuk halaman absen pulang
$routes->get('scan/absen_pulang', 'Scan\AbsenPulangController::index');
$routes->post('scan/absen_pulang/processQR', 'Scan\AbsenPulangController::processQR');

// Rute untuk pengaturan
$routes->get('/pengaturan', 'Admin\Pengaturan::index');
$routes->post('pengaturan/update', 'Admin\Pengaturan::update');

// Rute lainnya yang mungkin diperlukan
$routes->get('/absensi_siswa', 'Absensi\AbsensiSiswa::index');
$routes->post('absensi_siswa/edit/(:num)', 'Absensi\AbsensiSiswa::edit/$1');
$routes->post('absensi_siswa/tambah', 'Absensi\AbsensiSiswa::tambah');

$routes->get('/absensi_guru', 'Absensi\AbsensiGuru::index');
$routes->post('absensi_guru/edit/(:num)', 'Absensi\AbsensiGuru::edit/$1');
$routes->post('absensi_guru/tambah', 'Absensi\AbsensiGuru::tambah');

// Rute untuk data siswa
$routes->get('/data_siswa', 'Data\DataSiswa::index');
$routes->get('data_siswa/tambah', 'Data\DataSiswa::tambah');
$routes->post('data_siswa/simpan', 'Data\DataSiswa::simpan');
$routes->get('data_siswa/import', 'Data\DataSiswa::import');
$routes->post('data_siswa/importData', 'Data\DataSiswa::importData');
$routes->get('downloadTemplate/(:segment)', 'Data\DataSiswa::downloadTemplate/$1');
$routes->get('data_siswa/edit/(:num)', 'Data\DataSiswa::edit/$1');
$routes->post('data_siswa/update/(:num)', 'Data\DataSiswa::update/$1');
$routes->get('data_siswa/delete/(:num)', 'Data\DataSiswa::delete/$1');
$routes->get('data_siswa/generate_qr/(:num)', 'Data\DataSiswa::generate_qr/$1');
$routes->post('data_siswa/delete_selected', 'Data\DataSiswa::delete_selected');

// Rute untuk data guru
$routes->get('data_guru', 'Data\DataGuru::index');
$routes->get('data_guru/tambah', 'Data\DataGuru::tambah');
$routes->post('data_guru/simpan', 'Data\DataGuru::simpan');
$routes->get('data_guru/edit/(:num)', 'Data\DataGuru::edit/$1');
$routes->post('data_guru/update/(:num)', 'Data\DataGuru::update/$1');
$routes->get('data_guru/delete/(:num)', 'Data\DataGuru::delete/$1');
$routes->get('data_guru/generate_qr/(:num)', 'Data\DataGuru::generate_qr/$1');
$routes->post('data_guru/saveSuara/(:num)', 'Data\DataGuru::saveSuara/$1');


// Rute untuk data kelas
$routes->get('/data_kelas', 'Data\DataKelas::index');
$routes->get('data_kelas/tambah', 'Data\DataKelas::tambah');
$routes->post('data_kelas/simpan', 'Data\DataKelas::simpan');
$routes->get('data_kelas/edit/(:num)', 'Data\DataKelas::edit/$1');
$routes->post('data_kelas/update/(:num)', 'Data\DataKelas::update/$1');
$routes->get('data_kelas/delete/(:num)', 'Data\DataKelas::delete/$1');

// Rute untuk data petugas
$routes->get('/data_petugas', 'Data\DataPetugas::index');

// Rute untuk generate QR
$routes->get('/generate_qr', 'Laporan\GenerateQR::index');
$routes->get('generate_qr/generate_all_siswa', 'Laporan\GenerateQR::generate_all_siswa');
$routes->get('generate_qr/download_all_siswa', 'Laporan\GenerateQR::download_all_siswa');
$routes->get('generate_qr/generate_per_kelas', 'Laporan\GenerateQR::generate_per_kelas');
$routes->get('generate_qr/download_per_kelas', 'Laporan\GenerateQR::download_per_kelas');
$routes->get('generate_qr/generate_all_guru', 'Laporan\GenerateQR::generate_all_guru');
$routes->get('generate_qr/download_all_guru', 'Laporan\GenerateQR::download_all_guru');

// Rute untuk generate laporan
$routes->get('/generate_laporan', 'Laporan\GenerateLaporan::index');
$routes->get('generate_laporan/generate_guru_pdf', 'Laporan\GenerateLaporan::generate_guru_pdf');
$routes->get('generate_laporan/generate_guru_doc', 'Laporan\GenerateLaporan::generate_guru_doc');
$routes->get('generate_laporan/generate_siswa_pdf', 'Laporan\GenerateLaporan::generate_siswa_pdf');
$routes->get('generate_laporan/generate_siswa_doc', 'Laporan\GenerateLaporan::generate_siswa_doc');

// Rute untuk data jurusan
$routes->get('/jurusan', 'Data\DataKelas::index'); // Jika kamu ingin menggunakan data kelas di halaman jurusan
$routes->get('data_jurusan/edit/(:num)', 'Data\JurusanController::edit/$1');
$routes->post('data_jurusan/update/(:num)', 'Data\JurusanController::update/$1');
$routes->get('data_jurusan/delete/(:num)', 'Data\JurusanController::delete/$1');
$routes->get('data_jurusan/tambah', 'Data\JurusanController::tambah');
$routes->post('data_jurusan/simpan', 'Data\JurusanController::simpan');

// Rute untuk pengaturan lainnya
$routes->post('pengaturan/update', 'PengaturanController::update');
