<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) . DS);
define('APP', ROOT . 'app' . DS);
define('CORE', ROOT . 'Core' . DS);

require CORE . 'Ionix.php';

$app = new Core\Ionix();

$app->addDirectories([
    ROOT,
    APP.'controllers',
    APP.'models',
]);

$app->register();

$route = Core\Route::get('test/(.*?)/x', 'HomeController@index');
var_dump($route->matches('test/22/x'));
var_dump($route->getCallBack());