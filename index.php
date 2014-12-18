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

$route = Route::get('test/(.*?)/x', 'HomeController@index');
var_dump($route->matches('test/22/x'));
var_dump($route->getCallBack());
