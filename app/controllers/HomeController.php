<?php namespace App\Controllers;

use Ionix\Routing\Controller;

class HomeController extends Controller {

    public function __construct()
    {

    }

    public function indexAction()
    {
        $view = view('test');
        $view->current_date = date('D-m-Y H:i:s');

        return $view;
    }
}