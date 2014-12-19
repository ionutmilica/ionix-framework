<?php

use Ionix\Routing\Controller;

class HomeController extends Controller {

    public function __construct(TestModel $model)
    {
        var_dump($model);
    }

    public function index()
    {
        echo 'It works !';
    }
}