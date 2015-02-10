<?php namespace Ionix\Validation\Rules;

use Ionix\Validation\Rule;

class RequiredRule extends Rule {

    /**
     * Validate the rule against the value
     *
     * @return mixed
     */
    public function validate()
    {
        return isset($this->input[$this->inputName]);
    }
}