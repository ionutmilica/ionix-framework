<?php

require __DIR__.'/../vendor/autoload.php';

$app = new Ionix\Foundation\App();

$app->setPaths([
    'path.root' => __DIR__.'/../',
    'path.app'  => __DIR__.'/',
]);

$app->init();

require 'routes.php';
