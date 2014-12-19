<?php namespace Ionix\Routing;

use Ionix\Foundation\App;

class Router {

    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const PATCH = 'PATCH';
    const DELETE = 'DELETE';

    /**
     * @var RouteCollection
     */

    protected $collection;
    /**
     * @var App
     */
    protected $app;

    public function __construct(App $app)
    {
        $this->app = $app;
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

        $callback = $route->getCallback();
        $data     = array_values($route->getData());

        if (is_array($callback)) {
            $reflClass = new \ReflectionClass($callback[0]);
            $params = $reflClass->getConstructor()->getParameters();
            $paramList = [];
            foreach ($params as $param) {
                $class = $param->getClass();
                if ($class) {
                    $paramList[] = $this->getFromContainer($this->app, $class->getName());
                }
            }

            $callback[0] = $reflClass->newInstanceArgs($paramList);
            // Injection on methods
            $method = $reflClass->getMethod($callback[1]);

            $params = $method->getParameters();
            $paramList = [];
            $i = 0;
            foreach ($params as $param) {
                $class = $param->getClass();
                if ($class) {
                    $paramList[] = $this->getFromContainer($this->app, $class->getName());
                } else {
                    $paramList[] = $data[$i++];
                }
            }
            return $method->invokeArgs($callback[0], $paramList);
        }

        return call_user_func_array($callback, $route->getData());
    }

    /**
     * Search in container for a specific type or create a new class.
     * More validation to be done
     *
     * @param App $app
     * @param $type
     * @return mixed
     */
    public function getFromContainer(App $app, $type)
    {
        foreach ($app as $obj) {
            if (($obj instanceof $type) !== false) {
                return $obj;
            }
        }
        return new $type;
    }
}