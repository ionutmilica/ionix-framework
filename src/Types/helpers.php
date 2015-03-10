<?php

use Ionix\Types\String;

/**
 * An helper for the new string type
 *
 * @param $str
 * @return Ionix\Types\String
 */
function s($str)
{
    return String::make($str);
}