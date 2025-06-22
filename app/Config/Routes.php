<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

// group route surat
$routes->group('Surat', function ($routes) {
    $routes->get('/', 'Surat_keluar::SuratUser');
    $routes->get('detail/(:any)', 'Surat_keluar::detailUser/$1');
    $routes->get('preview/(:any)', 'Surat_keluar::previewUser/$1');
});

// group route disposisi
$routes->group('Disposisi', function ($routes) {
    $routes->get('/', 'Surat_masuk::suratUSer');
    $routes->get('detail/(:any)', 'Surat_masuk::detailUser/$1');
    $routes->post('Balasan', 'Surat_masuk::Balasan');
});
 
$routes->setAutoRoute(true);