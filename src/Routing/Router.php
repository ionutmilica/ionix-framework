<?php namespace Ionix\Routing;

use Ionix\Foundation\App;
use Ionix\Http\Request;
use Ionix\Http\Response;

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
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * Route prefix
     *
     * @var array
     */
    private $prefix = [];

    /**
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->collection = new RouteCollection();
        $this->dispatcher = $dispatcher;
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
        return $this->addRoute(self::GET, $route, $callback);
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
        return $this->addRoute(self::POST, $route, $callback);
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
        return $this->addRoute(self::DELETE, $route, $callback);
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
     * Create group of routes
     *
     * @param $data
     * @param null $callback
     */
    public function group($data, $callback = null)
    {
        if (is_callable($data)) {
            $callback = $data;
            $data = null;
        }

        if ($data) {
            $this->prefix[] = $data;
        }

        call_user_func($callback, $this);

        if ($data) {
            array_pop($this->prefix);
        }
    }

    /**
     * For a specific method and uri, dispatch the route.
     *
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public function dispatch(Request $request)
    {
        $pathInfo = $request->getPathInfo();
        $method   = $request->getMethod();

        $route = $this->collection->find($method, $pathInfo);

        if ( ! $route) {
            throw new \Exception('Route not found !');
        }

        $callback = $route->getCallback();
        $data     = array_values($route->getData());

        if ( ! is_callable($callback)) {
            throw new \Exception(sprintf('%s::%s does not exist!', $callback[0], $callback[1]));
        }

        return $this->dispatcher->dispatch($callback, $data);
    }

    /**
     * Add a route to the collection
     *
     * @param $flag
     * @param $route
     * @param $callback
     * @return Route
     */
    protected function addRoute($flag, $route, $callback)
    {
        $route = $this->preparePrefix($route);

        return $this->collection->addRoute($flag, new Route(
            $route,
            $callback
        ));
    }

    /**
     * Append the prefix parts
     *
     * @param $path
     * @return string
     */
    protected function preparePrefix($path)
    {
        $path = implode('/',$this->prefix) . '/' . $path;
        return str_replace('//', '/', $path);
    }

}