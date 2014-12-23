<?php namespace Ionix\Routing;

use Ionix\Foundation\App;

class Dispatcher {
    /**
     * @var App
     */
    protected $app;

    /**
     * @var string
     */
    protected $controller;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var array
     */
    protected $params = [];

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
            $response = $this->resolveAction($callback[0], $callback[1], $params);
        } else {
            $response = $this->resolveClosure($callback, $params);
        }

        return $response;
    }

    /**
     * Call callback with parameters and return the response.
     * @TODO: Add support for objects injection
     *
     * @param callable $callback
     * @param $params
     * @return mixed
     */
    public function resolveClosure(callable $callback, array $params = [])
    {
        return call_user_func_array($callback, $params);
    }

    /**
     * @param $controller
     * @param $action
     * @param array $params
     * @return string
     */
    public function resolveAction($controller, $action, array $params = [])
    {
        $controller = $this->resolveClassBinding($controller);

        $params = $this->resolveMethodBinding(new \ReflectionMethod($controller, $action), $params);

        return call_user_func_array([$controller, $action], $params);
    }

    /**
     * For a specific class injects objects in the constructor
     *
     * @param $class
     * @return mixed|object
     */
    public function resolveClassBinding($class)
    {
        if (isset($this->app[$class])) {
            return $this->app[$class];
        }

        $params = [];
        $class = new \ReflectionClass($class);

        if ($constructor = $class->getConstructor()) {
            $params = $this->resolveMethodBinding($class->getConstructor());
        }

        return $class->newInstanceArgs($params);
    }

    /**
     * For a given method returns params that shall be injected
     *
     * @param \ReflectionMethod $method
     * @param array $scalarParams
     * @return array
     */
    public function resolveMethodBinding(\ReflectionMethod $method, array $scalarParams = [])
    {
        $params = $method->getParameters();

        $resolvedParams = [];
        $i = 0;

        foreach ($params as $param)
        {
            if ($class = $param->getClass()) {
                $resolvedParams[] = $this->resolveClassBinding($class->getName());
            } else if (isset($scalarParams[$i])) {
                $resolvedParams[] = $scalarParams[$i++];
            }
        }

        return $resolvedParams;
    }
}