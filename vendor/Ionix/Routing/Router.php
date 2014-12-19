<?php namespace Ionix\Routing;

class Router {

    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const PATCH = 'PATCH';
    const DELETE = 'DELETE';

    protected $collection;

    public function __construct()
    {
        $this->collection = new RouteCollection();
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
        return $this->collection->addRoute(self::GET, new Route(
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
        return $this->collection->addRoute(self::POST, new Route(
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
        return $this->collection->addRoute(self::DELETE, new Route(
            $route,
            $callback
        ));
    }

    /**
     * Set a pattern to the routes
     *
     * @param $name
     * @param $value
     */
    public function pattern($name, $value)
    {
        Route::pattern($name, $value);
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

        $route = $this->collection->find($method, $requestUri);

        if ( ! $route) {
            return false;
        }

        return call_user_func_array($route->getCallBack(), $route->getData());
    }
}