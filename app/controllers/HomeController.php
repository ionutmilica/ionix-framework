<?php namespace App\Controllers;

use Ionix\Routing\Controller;

class HomeController extends Controller {

    public function __construct()
    {
        $app = app();
        $validator = $app['validation']->make($_GET, [
            'test' => 'required|boolean',
            'onion' => 'required'
        ]);

        var_dump($validator->passes());
        var_dump($validator->getMessage());
    }

    public function index()
    {
        //var_dump($request->query->get('demo', 'Demo was not found in GET!'));
        $view = view('test');
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