<?php namespace Ionix\Routing;

use Closure;
use Ionix\Foundation\Container;

class ControllerDispatcher {
    /**
     * @var Container
     */
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Get and serve the controller
     *
     * @param Route $route
     * @return mixed
     * @throws \Exception
     */
    public function dispatch(Route $route)
    {
        $callback = $route->getCallback();
        $params     = array_values($route->getData());

        if ($callback instanceof Closure) {
            return $this->container->resolveClosure($callback, $params);
        }

        $class = $this->container->make($callback[0]);
        return $this->container->resolveMethod($class, $callback[1], $params);
    }

}