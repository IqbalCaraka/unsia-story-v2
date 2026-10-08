<?php

/**
 * Entry point untuk cPanel.
 *
 * Berkas ini disalin oleh .cpanel.yml menjadi public_html/index.php.
 * Bedanya dengan public/index.php bawaan Laravel: kode aplikasi tidak berada
 * satu tingkat di atas web root, melainkan di folder terpisah di luar
 * public_html supaya tidak bisa dibuka lewat browser.
 *
 *   /home/user/
 *   |-- laravel/unsia-story-v2/   <- app, config, routes, storage, vendor, .env
 *   `-- public_html/              <- hanya isi folder public/
 *
 * Kalau APPPATH di .cpanel.yml diubah, sesuaikan juga baris $app_root di bawah.
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$app_root = __DIR__ . '/../laravel/unsia-story-v2';

if (! is_file($app_root . '/vendor/autoload.php')) {
    http_response_code(500);
    exit('Aplikasi belum siap: vendor/autoload.php tidak ditemukan. Jalankan "composer install" di ' . $app_root);
}

// Mode maintenance Laravel (php artisan down)...
if (file_exists($maintenance = $app_root . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Composer autoloader...
require $app_root . '/vendor/autoload.php';

// Bootstrap Laravel lalu tangani request...
/** @var Application $app */
$app = require_once $app_root . '/bootstrap/app.php';

$app->handleRequest(Request::capture());
