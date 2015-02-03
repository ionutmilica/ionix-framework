<?php namespace Ionix\Validation;

class Factory {

    public function make($data, $rules)
    {
        return new Validator($data, $rules);
    }
}