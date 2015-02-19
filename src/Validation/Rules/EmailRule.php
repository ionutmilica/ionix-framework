<?php namespace Ionix\Validation\Rules;

use Ionix\Validation\Rule;

class EmailRule extends Rule {

    /**
     * Validate the rule against the value
     *
     * @return mixed
     */
    public function validate()
    {
        return filter_var($this->getValue(), FILTER_VALIDATE_EMAIL) !== false;
    }


    /**
     * Get error message in case of fail
     *
     * @return string
     */
    public function getMessage()
    {
        return sprintf('The field `%s` should be a valid email!', $this->inputName);
    }
}