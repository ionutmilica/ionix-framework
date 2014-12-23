<?php

use Ionix\Routing\Controller;

class HomeController extends Controller {

    public function __construct(TestModel $model)
    {
        var_dump($model);
    }

    public function index()
    {
        echo 'Index: It works !';
    }

    public function a($x, $y, $z)
    {
        var_dump($x, $y, $z);
    }

    public function b($zz)
    {
        var_dump($zz);
    }

    public function c($t = null)
    {
        var_dump($t);
    }
}