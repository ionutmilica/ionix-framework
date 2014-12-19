<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__ . DS);
define('APP', __DIR__ . '/app' . DS);
define('CORE',__DIR__ . '/Ionix' . DS);

require 'vendor/autoload.php';

$app = new Ionix\Foundation\App();

$app->setPaths([
    'path.root' => ROOT,
    'path.app'  => APP,
]);

$app->addDirectories([
    APP.'controllers',
    APP.'models',
]);

$app->init();

/*

$rfl = new ReflectionClass('HomeController');
$params = $rfl->getConstructor()->getParameters();
foreach ($params as $param)
{
    var_dump($param->getClass());
}

exit; */

$app['router']->pattern('name', '[0-9]+');
$app['router']->get('test/{id?}', 'HomeController@index')->where('id', '[0-9]+');
$app['router']->get('shop/{name}/{other}/{id}', 'HomeController@index');
$app['router']->get('shop/{name?}', 'HomeController@index');

echo $app->run();