<?php namespace Core;

class Route {

    /**
     * Holds the callback for the current route
     *
     * @var callable
     */
    protected $callback;

    /**
     * The name of the route (regex)
     *
     * @var
     */
    protected $name;

    /**
     * @param $name
     * @param $callback
     */
    public function __construct($name, $callback)
    {
        $this->name = $name;
        $this->callback = $callback;
    }

    /**
     * Check if a route matches a given url
     *
     * @param $path
     * @return bool
     */
    public function matches($path)
    {
        if (preg_match('#'.$this->name.'#i', $path)) {
            return true;
        }

        return false;
    }

    /**
     * Get the route callback.
     * Creates one if we have a string controller: HomeController@test
     */
    public function getCallback()
    {
        if (is_callable($this->name)) {
            return $this->callback;
        }

        return $this->resolveCallback($this->callback);
    }

    /**
     * Resolve a string as a callback
     *
     * @param $callback
     * @return array
     */
    protected function resolveCallback($callback)
    {
        if (stripos($callback, '@') !== false) {
            list($controller, $action) = explode('@', $callback);
            return [
                new $controller,
                $action
            ];
        }

        return $callback;
    }

    /**
     * @var array
     */
    protected static $routes = [];

    /**
     * @param $name
     * @param $callback
     * @return mixed
     */
    public static function get($name, $callback)
    {
        return self::$routes[$name] = new Route($name, $callback);
    }

    /**
     * Get all created routes
     *
     * @return array
     */
    public static function all()
    {
        return self::$routes;
    }

}