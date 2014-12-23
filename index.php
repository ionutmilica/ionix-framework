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

$app['loader']->addDirectories([
    APP.'controllers',
    APP.'models',
]);

$app->init();

require APP . 'routes.php';

echo $app->run();