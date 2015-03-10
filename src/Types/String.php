<?php namespace Ionix\Types;

class String extends Object {

    /**
     * Get the length of the string
     *
     * @return int
     */
    public function length()
    {
        return mb_strlen($this->value);
    }

    /**
     * Get substring from the current string
     *
     * @param int $start
     * @param null $length
     * @return \Ionix\Types\String
     */
    public function substr($start, $length = null)
    {
        $str = mb_substr($this->value, $start, $length);

        return static::make($str);
    }

    /**
     * Transform the current string chars from lowercase to uppercase
     *
     * @return \Ionix\Types\String
     */
    public function toUpper()
    {
        $str = mb_strtoupper($this->value);

        return static::make($str);
    }
}