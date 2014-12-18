<?php

use Ionix\Route;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__ . DS);
define('APP', __DIR__ . '/app' . DS);
define('CORE',__DIR__ . '/Ionix' . DS);

require 'vendor/autoload.php';

$app = new Ionix\App();

$app->addDirectories([
    ROOT,
    APP.'controllers',
    APP.'models',
]);

$app->register();


$router = new \Ionix\Router\Router();
$router->get('test', 'HomeController@index');
$router->get('/', function () {
    echo '<h1>Home !</h1>';
});

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);