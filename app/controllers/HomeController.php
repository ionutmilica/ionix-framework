<?php

use Ionix\Routing\Controller;

class HomeController extends Controller {

    public function index()
    {
        var_dump(func_get_args());
        echo 'It works !';
    }
}