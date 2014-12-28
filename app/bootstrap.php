<?php

require ROOT.'vendor/autoload.php';

$app = new Ionix\Foundation\App();

$app->setPaths([
    'path.root' => ROOT,
    'path.app'  => APP,
]);

$app->init();

require 'routes.php';
