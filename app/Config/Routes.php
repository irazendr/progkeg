<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Admin\DashboardController::index');

// // route admin dashboard
// $routes->get('dashboard', 'Admin\DashboardController::index');
// $routes->get('dashboard/getAggregatedProgress/(:num)', 'Admin\DashboardController::getAggregatedProgress/$1');


// //route kegiatan
// $routes->get('daftar-kegiatan', 'Admin\KegiatanController::index');
// $routes->post('daftar-kegiatan/tambah', 'Admin\KegiatanController::store');
// $routes->put('daftar-kegiatan/ubah/(:num)', 'Admin\KegiatanController::update/$1');
// $routes->delete('daftar-kegiatan/hapus/', 'Admin\KegiatanController::destroy');
// $routes->post('daftar-kegiatan/tambah', 'Admin\KegiatanController::store');
// $routes->put('daftar-kegiatan/ubah/(:num)', 'Admin\KegiatanController::update/$1');
// $routes->get('input-progress', 'Admin\KegiatanController::input');
// $routes->post('input-progress/tambah', 'Admin\KegiatanController::progress');
// $routes->put('input-progress/ubah/(:num)', 'Admin\KegiatanController::up_progress/$1');
// $routes->delete('input-progress/hapus/', 'Admin\KegiatanController::destroy_progress');
// $routes->get('input-target', 'Admin\KegiatanController::input_target');
// $routes->post('input-target/tambah', 'Admin\KegiatanController::target');
// $routes->put('input-target/ubah/(:num)', 'Admin\KegiatanController::up_target/$1');
// $routes->delete('input-target/hapus/', 'Admin\KegiatanController::destroy_target');

// $routes->get('export-excel', 'Admin\KegiatanController::export_excel');

// $routes->post('input-progress/import', 'Admin\KegiatanController::import_progress');

// //route akun
// $routes->get('akun', 'Admin\AkunController::index', ['filter' => 'role:Admin']);
// $routes->delete('akun/hapus/', 'Admin\AkunController::destroy');
// $routes->put('akun/ubah/(:num)', 'Admin\AkunController::ubah/$1');

$routes->get('/', 'Admin\DashboardController::index');
$routes->get('dashboard', 'Admin\DashboardController::index');
$routes->get('dashboard/getAggregatedProgress/(:any)', 'Admin\DashboardController::getAggregatedProgress/$1');

// Daftar Kegiatan routes
$routes->group('daftar-kegiatan', function ($routes) {
    $routes->get('/', 'Admin\KegiatanController::index');
    $routes->post('tambah', 'Admin\KegiatanController::store');
    $routes->put('ubah/(:any)', 'Admin\KegiatanController::update/$1');
    $routes->delete('hapus/', 'Admin\KegiatanController::destroy');
});

// Input Progress routes
$routes->group('input-progress', function ($routes) {
    $routes->get('/', 'Admin\KegiatanController::input');
    $routes->post('tambah', 'Admin\KegiatanController::progress');
    $routes->post('getKelurahanByKecamatan', 'Admin\KegiatanController::getKelurahanByKecamatan');
    $routes->get('daftarKecamatan', 'Admin\KegiatanController::daftarKecamatan');
    $routes->put('ubah/(:any)', 'Admin\KegiatanController::up_progress/$1');
    $routes->delete('hapus/', 'Admin\KegiatanController::destroy_progress');
    $routes->post('import', 'Admin\KegiatanController::import_progress');
});

// Input Target routes
$routes->group('input-target', function ($routes) {
    $routes->get('/', 'Admin\KegiatanController::input_target');
    $routes->post('tambah', 'Admin\KegiatanController::target');
    $routes->put('ubah/(:any)', 'Admin\KegiatanController::up_target/$1');
    $routes->delete('hapus/', 'Admin\KegiatanController::destroy_target');
});

// Export to Excel route
$routes->get('export-excel', 'Admin\KegiatanController::export_excel');

// Daftar Kecamatan routes
$routes->group('kecamatan', ['filter' => 'role:Admin'], function ($routes) {
    $routes->get('/', 'Admin\KecamatanController::index');
    $routes->post('tambah', 'Admin\KecamatanController::store');
    $routes->put('ubah/(:any)', 'Admin\KecamatanController::update/$1');
    $routes->delete('hapus/', 'Admin\KecamatanController::destroy');
    $routes->post('import', 'Admin\KecamatanController::import_kecamatan');
});

// Daftar Kelurahan routes
$routes->group('kelurahan', ['filter' => 'role:Admin'], function ($routes) {
    $routes->get('/', 'Admin\KelurahanController::index');
    $routes->post('tambah', 'Admin\KelurahanController::store');
    $routes->put('ubah/(:any)', 'Admin\KelurahanController::update/$1');
    $routes->delete('hapus/', 'Admin\KelurahanController::destroy');
    $routes->post('import', 'Admin\KelurahanController::import_kelurahan');
});

// Daftar Mitra routes
$routes->group('mitra', ['filter' => 'role:Admin'], function ($routes) {
    $routes->get('/', 'Admin\MitraController::index');
    $routes->post('tambah', 'Admin\MitraController::store');
    $routes->put('ubah/(:any)', 'Admin\MitraController::update/$1');
    $routes->delete('hapus/', 'Admin\MitraController::destroy');
    $routes->post('import', 'Admin\MitraController::import_mitra');
});

// Akun routes
$routes->group('akun', ['filter' => 'role:Admin'], function ($routes) {
    $routes->get('/', 'Admin\AkunController::index');
    $routes->delete('hapus/', 'Admin\AkunController::destroy');
    $routes->put('ubah/(:any)', 'Admin\AkunController::ubah/$1');
});
