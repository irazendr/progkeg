<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Admin\DashboardController::index');

// route admin dashboard
$routes->get('dashboard', 'Admin\DashboardController::index');
$routes->get('dashboard/getAggregatedProgress/(:num)', 'Admin\DashboardController::getAggregatedProgress/$1');


//route kegiatan
$routes->get('daftar-kegiatan', 'Admin\KegiatanController::index');
$routes->post('daftar-kegiatan/tambah', 'Admin\KegiatanController::store');
$routes->put('daftar-kegiatan/ubah/(:num)', 'Admin\KegiatanController::update/$1');
$routes->delete('daftar-kegiatan/hapus/', 'Admin\KegiatanController::destroy');
$routes->post('daftar-kegiatan/tambah', 'Admin\KegiatanController::store');
$routes->put('daftar-kegiatan/ubah/(:num)', 'Admin\KegiatanController::update/$1');
$routes->get('input-progress', 'Admin\KegiatanController::input');
$routes->post('input-progress/tambah', 'Admin\KegiatanController::progress');
$routes->put('input-progress/ubah/(:num)', 'Admin\KegiatanController::up_progress/$1');
$routes->delete('input-progress/hapus/', 'Admin\KegiatanController::destroy_progress');
$routes->get('input-target', 'Admin\KegiatanController::input_target');
$routes->post('input-target/tambah', 'Admin\KegiatanController::target');
$routes->put('input-target/ubah/(:num)', 'Admin\KegiatanController::up_target/$1');
$routes->delete('input-target/hapus/', 'Admin\KegiatanController::destroy_target');

$routes->get('export-excel', 'Admin\KegiatanController::export_excel');


//route akun
$routes->get('akun', 'Admin\AkunController::index', ['filter' => 'role:Admin']);
$routes->delete('akun/hapus/', 'Admin\AkunController::destroy');
$routes->put('akun/ubah/(:num)', 'Admin\AkunController::ubah/$1');
