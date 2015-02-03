<?php namespace App\Controllers;

use Ionix\Foundation\App;
use Ionix\Foundation\Config;
use Ionix\Routing\Controller;

class Wtf {
    public function __construct()
    {
        echo 'Hello from WTF !';
    }
}

class HomeController extends Controller {

    public function __construct(Config $cfg, Wtf $wtf)
    {
        var_dump($cfg->get('app'), $wtf);
    }

    public function index()
    {
        $view = app('view')->make('test');
        $view->set('current_date', date('D-m-Y H:I'));
        return $view;
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