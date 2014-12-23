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
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public function dispatch(Request $request)
    {
        $pathInfo = rtrim($request->getPathInfo(), '/');
        $method   = $request->getMethod();

        $route = $this->collection->find($method, $pathInfo);

        if ( ! $route) {
            throw new \Exception('Route not found !');
        }

        $callback = $route->getCallback();
        $data     = array_values($route->getData());

        if ( ! is_callable($callback)) {
            throw new \Exception(sprintf('Class %s has no method %s !', $callback[0], $callback[1]));
        }

        return $this->dispatcher->dispatch($callback, $data);
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