<?php namespace Ionix\Routing;

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
    protected $format;

    /**
     * @var
     */
    protected $regex;

    /**
     * @var array
     */
    protected $wheres = [];

    /**
     * @param $name
     * @param $callback
     */
    public function __construct($name, $callback)
    {
        $this->regex = $this->format = $name;
        $this->callback = $callback;
    }

    /**
     * Compile route
     *
     * @return mixed|string
     */
    public function compile()
    {
        preg_match_all('#{(.*?)}#i', $this->format, $out);

        $compiled = $this->format;

        foreach ($out[0] as $i => $var) {
            $format = '(?P<%s>%s)%s';
            $name   = str_replace('?', '', $out[1][$i]);
            $regex  = isset($this->wheres[$name]) ? $this->wheres[$name] : '.*';
            $opt    = '';

            if (substr($var, -2, 1)) {
                $opt = '?';
                $compiled = str_replace('/'.$var, '/?'.$var, $compiled);
            }

            $compiled = str_replace($var, sprintf($format, $name, $regex, $opt), $compiled);
        }

        return $compiled;
    }

    /**
     * @param $name
     * @param $regex
     */
    public function where($name, $regex)
    {
        $this->wheres[$name] = $regex;
    }

    /**
     * Check if a route matches a given url
     *
     * @param $requestUri
     * @return bool
     */
    public function matches($requestUri)
    {
        $regex = $this->compile();

        if (preg_match('#^'.$regex.'$#i', $requestUri, $out)) {
            var_dump($out);
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