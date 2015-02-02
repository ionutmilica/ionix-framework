<?php namespace Ionix\View;

use Exception;
use Ionix\Support\Interfaces\Renderable;

class View implements Renderable {

    /**
     * View name
     *
     * @var
     */
    protected $name = null;

    /**
     * View data stored in
     *
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected static $global = [];

    /**
     * View path
     *
     * @var string
     */
    private $path;

    /**
     * @param $path
     * @param $name
     * @param array $data
     */
    public function __construct($path, $name, $data = [])
    {
        $this->name = $name;
        $this->data = $data;
        $this->path = $path;
    }

    /**
     * Add variable for all views
     *
     * @param $name
     * @param $value
     */
    public static function share($name, $value)
    {
        self::$global[$name] = $value;
    }

    /**
     * Bind value to the view
     *
     * @param $name
     * @param $value
     */
    public function bind($name, &$value)
    {
        $this->data[$name] =& $value;
    }

    /**
     * Add variable to the view file
     *
     * @param $name
     * @param $value
     */
    public function set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Get view variable
     *
     * @param $name
     * @return null
     */
    public function get($name)
    {
        return $this->has($name) ? $this->data[$name] : null;
    }

    /**
     * Check if the view has a variable
     *
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        return isset($this->data[$name]);
    }

    /**
     * Get variable from the view
     *
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

    /**
     * Add variable to the view file
     *
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * "Compile" the view
     *
     * @return string
     */
    public function render()
    {
        extract($this->data, EXTR_SKIP);
        extract(self::$global, EXTR_SKIP);

        try {
            include $this->path;
        } catch (Exception $e) {
            ob_end_clean();
        }

        return ob_get_clean();
    }
}