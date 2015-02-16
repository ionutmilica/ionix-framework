<?php namespace Ionix\Foundation;

class ClassLoader {

    /**
     * @var array
     */
    protected $directories = [];


    /**
     * Add new directories for auto-loader to search in.
     *
     * @param $directories
     */
    public function addDirectories($directories)
    {
        $this->directories = array_unique(array_merge($this->directories, $directories));
    }


    /**
     * Search and load a specific class. Used for auto-loader.
     *
     * @param $class
     * @return bool
     */
    public function load($class)
    {
        if ($class[0] == '\\') $class = substr($class, 1);
        $class = str_replace(array('\\', '_'), DIRECTORY_SEPARATOR, $class).'.php';

        foreach ($this->directories as $directory)
        {
            if (file_exists($path = $directory.DIRECTORY_SEPARATOR.$class))
            {
                require_once $path;
                return true;
            }
        }
        return false;
    }
}