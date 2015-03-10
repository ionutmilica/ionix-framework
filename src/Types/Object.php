<?php namespace Ionix\Types;

class Object {

    protected $value;

    /**
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Creates a new object
     *
     * @param $value
     * @return static
     */
    public static function make($value)
    {
        return new static($value);
    }

    /**
     * Convert to string
     *
     * @return string
     */
    public function toString()
    {
        return (string) $this->value;
    }
}