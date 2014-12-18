<?php namespace Ionix\Router;

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
     * @param $requestUri
     * @return bool
     */
    public function matches($requestUri)
    {
        if (preg_match('#'.preg_quote($this->name, '#').'#i', $requestUri, $out)) {
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
        if (is_callable($this->callback)) {
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

}