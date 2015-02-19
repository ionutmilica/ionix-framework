<?php namespace Ionix\Routing;

use Ionix\Http\Request;

class Router {

    /**
     * @var RouteCollection
     */
    protected $collection;

    /**
     * @var ControllerDispatcher
     */
    private $dispatcher;

    /**
     * Route prefix
     *
     * @var array
     */
    private $prefix = [];

    /**
     * @param ControllerDispatcher $dispatcher
     */
    public function __construct(ControllerDispatcher $dispatcher)
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
        return $this->addRoute('GET', $route, $callback);
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
        return $this->addRoute('POST', $route, $callback);
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
        return $this->addRoute('DELETE', $route, $callback);
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

        return $this->dispatcher->dispatch($route);
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