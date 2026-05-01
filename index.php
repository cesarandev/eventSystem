<?php
declare(strict_types=1);

use App\Core\Router;

session_start();

define('BASE_PATH', __DIR__);

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
$router->get('/servicios', 'ServiceController@index');
$router->post('/servicios', 'ServiceController@store');
$router->get('/cotizaciones', 'QuoteController@index');
$router->post('/cotizaciones', 'QuoteController@store');
$router->get('/eventos', 'EventController@index');
$router->post('/eventos', 'EventController@store');
$router->get('/contabilidad', 'AccountingController@index');
$router->post('/contabilidad', 'AccountingController@store');

$router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/');
