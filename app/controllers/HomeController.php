<?php namespace App\Controllers;

use Ionix\Http\Response;
use Ionix\Routing\Controller;

class HomeController extends Controller {

    public function index()
    {
        return app('view')->make('test', []);
    }

    public function a( $x, $y, $z)
    {
        var_dump($x, $y, $z);
    }

    public function b($zz)
    {
        var_dump('B:'.$zz);
    }

    public function c($t = null)
    {
        var_dump('C:'.$t);
        return ['Test', 'Adsa'];
    }
}