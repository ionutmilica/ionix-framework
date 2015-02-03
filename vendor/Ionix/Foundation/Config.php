<?php namespace Ionix\Foundation;

use Exception;
use Ionix\Support\Arr;

class Config {

    protected $hints = [];

    protected $data = [];

    public function __construct()
    {

    }

    /**
     * Add hint for config search
     *
     * @param $hint
     */
    public function addHint($hint)
    {
        $this->hints[] = $hint;
    }

    public function loadData($loc)
    {
        foreach ($this->hints as $hint)
        {
            if (is_file($file = $hint . $loc . '.php')) {
                $this->data[$loc] = require $file;
            }
        }
    }

    /**
     * Get config option
     *
     * @param $name
     * @param null $default
     * @return mixed
     * @throws Exception
     */
    public function get($name, $default = null)
    {
        $parts = explode('.', $name);
        $partsSize = count($parts);

        if ($partsSize < 1) {
            throw new Exception('Invalid config::get format !');
        }

        $this->loadData($parts[0]);

        if ($partsSize == 1) {
            return $this->data[$parts[0]];
        }

        $path = implode('.', array_slice($parts, 1, $partsSize));

        return Arr::get($this->data[$parts[0]], $path, $default);
    }
}