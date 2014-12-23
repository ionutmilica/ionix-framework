<?php namespace Ionix\Http;

class ParamBag implements \Countable {

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Get value for a specific parameter
     *
     * @param $name
     * @param null $default
     * @return null
     */
    public function get($name, $default = null)
    {
        return $this->has($name) ? $this->params[$name] : $default;
    }

    /**
     * Override parameter value
     *
     * @param $name
     * @param $value
     */
    public function set($name, $value)
    {
        $this->params[$name] = $value;
    }

    /**
     * Check if a specific parameter exists
     *
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        return isset($this->params[$name]);
    }

    /**
     * Count parameters
     *
     * @return int
     */
    public function count()
    {
        return count($this->params);
    }
}