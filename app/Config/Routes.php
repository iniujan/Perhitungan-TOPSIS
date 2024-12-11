<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Default route untuk dashboard
$routes->get('/dashboard', 'DashboardController::index');

// Rute untuk sistem TOPSIS
$routes->get('/', 'TopsisController::index'); // Menjadikan dashboard sebagai halaman default

$routes->group('topsis', function ($routes) {
    $routes->get('/', 'TopsisController::index'); // Dashboard TOPSIS
    $routes->get('kriteria', 'TopsisController::kriteria'); // Halaman Data Kriteria
    $routes->get('alternatif', 'TopsisController::alternatif'); // Halaman Data Alternatif
    $routes->get('matriks_keputusan', 'TopsisController::matriksKeputusan');
    $routes->get('normalisasi', 'TopsisController::normalisasi'); // Halaman Normalisasi
    $routes->get('normalisasi_terbobot', 'TopsisController::normalisasiTerbobot'); // Halaman Normalisasi
    $routes->get('jarak_ideal', 'TopsisController::nilaiIdeal'); // Halaman Normalisasi
    $routes->get('hasil_preferensi_ranking', 'TopsisController::preferensiRanking'); // Halaman Hasil Perankingan
});

// $routes->group('topsis', function ($routes) {
//     $routes->get('alternatif', 'TopsisController::alternatif');
//     $routes->get('kriteria', 'TopsisController::kriteria');
// });

// $routes->group('topsis', function ($routes) {
//     $routes->get('normalisasi', 'TopsisController::normalisasi');
// });

// $routes->group('topsis', function ($routes) {
//     $routes->get('matriks_keputusan', 'TopsisController::matriksKeputusan');
// });



