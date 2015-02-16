<?php namespace Ionix\Routing;

use Ionix\Foundation\App;

class Dispatcher {
    /**
     * @var App
     */
    protected $app;

    /**
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Set the callback
     *
     * @param $callback
     * @param array $params
     * @return mixed
     */
    public function dispatch($callback, array $params = [])
    {
        if (is_array($callback)) {
            $class = $this->app->make($callback[0]);
            $response = $this->app->resolveMethod($class, $callback[1], $params);
        } else {
            $response = $this->app->resolveClosure($callback, $params);
        }

        return $response;
    }

}