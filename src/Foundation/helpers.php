<?php

use Ionix\Foundation\App;

if ( ! function_exists('app')) {
    /**
     * Get app instance same like a singleton
     *
     * @param null $name
     * @return Ionix\Foundation\App
     */
    function app($name = null)
    {
        $app = App::getApp();

        if ($name) {
            return $app[$name];
        }

        return $app;
    }
}

if ( ! function_exists('view'))  {
    /**
     *  Make a new view
     *
     * @param null $name
     * @param array $data
     * @return mixed
     */
    function view($name = null, $data = [])
    {
        return app('view')->make($name, $data);
    }
}

if ( ! function_exists('group'))
{
    /**
     * Router group shortcut
     *
     * @param $data
     * @param null $callback
     * @return Ionix\Routing\Router
     */
    function group($data, $callback = null)
    {
        return app('router')->group($data, $callback);
    }
}

if ( ! function_exists('get')) {
    /**
     * Create a new route for get method
     *
     * @param $format
     * @param $callback
     * @return mixed
     */
    function get($format, $callback)
    {
        $router = app('router');
        return $router->get($format, $callback);
    }
}


if ( ! function_exists('post')) {
    /**
     * Create a new route for get method
     *
     * @param $format
     * @param $callback
     * @return mixed
     */
    function post($format, $callback)
    {
        $router = app('router');
        return $router->post($format, $callback);
    }
}