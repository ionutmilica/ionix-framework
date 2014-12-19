<?php namespace Ionix\Router;

class RouteCollection {

    private $routes = [];

    /**
     * Add route to the collection
     *
     * @param $method
     * @param Route $route
     * @return Route
     */
    public function addRoute($method, Route $route)
    {
        return $this->routes[$method][] = $route;
    }

    /**
     * Find route for a specific method and requestUri
     *
     * @param $method
     * @param $requestUri
     * @return Route|null
     */
    public function find($method, $requestUri)
    {
        foreach ($this->routes[$method] as $route) {
            if ($route->matches($requestUri)) {
                return $route;
            }
        }

        return null;
    }
}