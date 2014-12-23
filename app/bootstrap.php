<?php

require ROOT.'vendor/autoload.php';

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

require 'routes.php';
