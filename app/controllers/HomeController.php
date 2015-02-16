<?php namespace App\Controllers;

use Ionix\Http\Request;
use Ionix\Routing\Controller;
use Ionix\Routing\Router;

class HomeController extends Controller {

    public function __construct(Request $request)
    {
        var_dump($request);
    }

    public function indexAction(Router $router)
    {
        var_dump($router);
        $view = view('test');
        $view->current_date = date('D-m-Y H:i:s');

        return $view;
    }
}