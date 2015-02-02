<?php namespace App\Controllers;

use Ionix\Http\Response;
use Ionix\Routing\Controller;
use Ionix\View\View;

class HomeController extends Controller {

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