<?php

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
$router->get('test/{id?}', 'HomeController@index')->where('id', '[0-9]+');
$router->get('shop/{name?}', 'HomeCOntroller@index');
$router->get('shop/{name}/{other}/{id}', 'HomeCOntroller@index');

$router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));