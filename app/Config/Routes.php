<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Admin\DashboardController::index');

// route admin dashboard
$routes->get('dashboard', 'Admin\DashboardController::index');

//route kegiatan
$routes->get('daftar-kegiatan', 'Admin\KegiatanController::index');
$routes->post('daftar-kegiatan/tambah', 'Admin\KegiatanController::store');
$routes->put('daftar-kegiatan/ubah/(:num)', 'Admin\KegiatanController::update/$1');
$routes->delete('daftar-kegiatan/hapus/', 'Admin\KegiatanController::destroy');
