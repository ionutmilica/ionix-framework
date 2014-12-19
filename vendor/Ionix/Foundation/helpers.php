<?php

use Ionix\Foundation\App;

if ( ! function_exists('app')) {
    /**
     * Get app instance same like a singleton
     *
     * @param null $name
     * @return mixed
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