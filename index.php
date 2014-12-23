<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__ . DS);
define('APP', __DIR__ . '/app' . DS);
define('CORE',__DIR__ . '/Ionix' . DS);

class Test {
    public  function __construct() {

    }
}

require APP.'bootstrap.php';

$app->run();