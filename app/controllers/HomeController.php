<?php

use Ionix\Routing\Controller;

class HomeController extends Controller {

    public function __construct(TestModel $model)
    {
        var_dump($model);
    }

    public function index($t, \Ionix\Foundation\App $a1, $r, $s, \Ionix\Foundation\App $a2)
    {
        var_dump($t, $a1, $r, $s, $a2);
        echo 'It works !';
    }
}