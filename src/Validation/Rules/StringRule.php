<?php namespace Ionix\Validation\Rules;

use Ionix\Validation\Rule;

class StringRule extends Rule {

    /**
     * Validate the rule against the value
     *
     * @return mixed
     */
    public function validate()
    {
        return is_string($this->getValue());
    }


    /**
     * Get error message in case of fail
     *
     * @return string
     */
    public function getMessage()
    {
        return sprintf('The field `%s` should contain a a string!',
            $this->inputName);
    }
}