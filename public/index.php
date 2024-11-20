<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$_SESSION['user'] = [
    'id' => 1,
    'name' => 'John Doe'
];

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Helpers/Mail.php';

use Cloudstorage\Core\Router;
use Cloudstorage\Core\Route;
use Cloudstorage\App\Debugger\Debugger;
use Cloudstorage\Core\CacheManager;
use Cloudstorage\Core\FileCache;
use Cloudstorage\Core\ProcessorManager;
use Cloudstorage\App\Processors\InputProcessor;

Debugger::init();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$cache = new FileCache(__DIR__ . '/../storage/cache');
CacheManager::init($cache);

$router = new Router();
Route::setRouter($router);

ProcessorManager::registerProcessor("input", new InputProcessor());

$routesPath = __DIR__ . '/../routes/';
foreach (glob($routesPath . '*.php') as $routeFile) {
    require_once $routeFile;
}

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

$requestUri = parse_url($requestUri, PHP_URL_PATH);
$router->dispatch($requestUri, $requestMethod);
