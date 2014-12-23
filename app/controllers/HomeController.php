<?php

use Ionix\Http\Response;
use Ionix\Routing\Controller;

class HomeController extends Controller {

    public function __construct(Test $test)
    {
        echo 'Yay !';
        var_dump($test);
    }

    public function index(Test $sd)
    {
        return Response::make('<h1>Hello world !</h1>');
    }

    public function a( $x, $y, $z)
    {
        var_dump($x, $y, $z);
    }

    public function b(Test $mm, $zz)
    {
        var_dump($mm, $zz);
    }

    public function c(Test $zz, $t = null, Test $mm)
    {
        var_dump($t, $mm);
    }
}