<?php
declare(strict_types=1);

use App\Core\Router;

session_start();

define('BASE_PATH', __DIR__);

if (PHP_SAPI === 'cli-server') {
    $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
    $filesystemPath = BASE_PATH . $requestPath;

    if ($requestPath !== '/' && is_file($filesystemPath)) {
        return false;
    }

    if ($requestPath !== '/' && is_dir($filesystemPath) && is_file($filesystemPath . '/index.php')) {
        require $filesystemPath . '/index.php';
        return;
    }
}

spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';

    if (!str_starts_with($class, $prefix)) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = BASE_PATH . '/app/' . str_replace('\\', '/', $relativeClass) . '.php';

    if (is_file($file)) {
        require $file;
    }
});

$appConfig = require BASE_PATH . '/config/app.php';
date_default_timezone_set($appConfig['timezone']);
require BASE_PATH . '/app/Core/helpers.php';

$router = new Router();

$router->get('/', 'DashboardController@index');
$router->get('/clientes', 'ClientController@index');
$router->post('/clientes', 'ClientController@store');
$router->get('/clientes/editar', 'ClientController@edit');
$router->post('/clientes/actualizar', 'ClientController@update');
$router->get('/servicios', 'ServiceController@index');
$router->post('/servicios', 'ServiceController@store');
$router->get('/servicios/editar', 'ServiceController@edit');
$router->post('/servicios/actualizar', 'ServiceController@update');
$router->get('/cotizaciones', 'QuoteController@index');
$router->post('/cotizaciones', 'QuoteController@store');
$router->get('/cotizaciones/editar', 'QuoteController@edit');
$router->post('/cotizaciones/actualizar', 'QuoteController@update');
$router->get('/eventos', 'EventController@index');
$router->post('/eventos', 'EventController@store');
$router->get('/eventos/editar', 'EventController@edit');
$router->post('/eventos/actualizar', 'EventController@update');
$router->get('/contabilidad', 'AccountingController@index');
$router->post('/contabilidad', 'AccountingController@store');
$router->get('/contabilidad/editar', 'AccountingController@edit');
$router->post('/contabilidad/actualizar', 'AccountingController@update');

$router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/');
