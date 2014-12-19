<?php namespace Ionix\Routing;

class Router {

    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const PATCH = 'PATCH';
    const DELETE = 'DELETE';

    protected $routes;

    public function __construct()
    {
        // Dependency injection in the future
        $this->routes = new RouteCollection();
    }

    /**
     * Create route for get request
     *
     * @param $route
     * @param $callback
     * @return Route
     */
    public function get($route, $callback)
    {
        return $this->routes->addRoute(self::GET, new Route(
            $route,
            $callback
        ));
    }

    /**
     * Create route for post request
     *
     * @param $route
     * @param $callback
     * @return Route
     */
    public function post($route, $callback)
    {
        return $this->routes->addRoute(self::POST, new Route(
            $route,
            $callback
        ));
    }

    /**
     * Create route for get request
     *
     * @param $route
     * @param $callback
     * @return Route
     */
    public function delete($route, $callback)
    {
        return $this->routes->addRoute(self::DELETE, new Route(
            $route,
            $callback
        ));
    }

    /**
     * For a specific method and uri, dispatch the route.
     *
     * @param $method
     * @param $requestUri
     * @return bool
     */
    public function dispatch($method, $requestUri)
    {
        $requestUri = trim($requestUri, '/');

        $route = $this->routes->find($method, $requestUri);

        if ( ! $route) {
            return false;
        }

        call_user_func_array($route->getCallBack(), $route->getData());
    }
}