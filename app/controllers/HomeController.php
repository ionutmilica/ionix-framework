<?php namespace App\Controllers;

use Ionix\Foundation\App;
use Ionix\Http\Request;
use Ionix\Routing\Controller;

class HomeController extends Controller {

    public function __construct(App $app)
    {
        $validator = $app['validation']->make($_GET, [
            'test' => 'required|boolean',
        ]);

        var_dump($validator->passes());
    }

    public function index(Request $request)
    {
        var_dump($request->query->get('demo', 'Demo was not found in GET!'));
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