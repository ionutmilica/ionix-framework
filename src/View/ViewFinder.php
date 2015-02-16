<?php namespace Ionix\View;

class ViewFinder {

    /**
     * @var array
     */
    protected $locations = [];

    public function __construct()
    {

    }

    /**
     * Search for the view and return the path
     *
     * @param $view
     * @return bool|string
     */
    public function find($view)
    {
        $view = str_replace('.', DIRECTORY_SEPARATOR, $view) . '.php';

        foreach ($this->locations as $location)
        {
            if (is_file($path = $location.'/'.$view)) {
                return $path;
            }
        }

        return false;
    }

    /**
     * Add location(s) for the view to search for
     *
     * @param $location
     * @return $this
     */
    public function addLocation($location)
    {
        if (is_array($location)) {
            $this->locations = array_merge($this->locations, $location);
        } else {
            $this->locations[] = $location;
        }

        return $this;
    }
}