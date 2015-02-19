<?php namespace Ionix\Validation\Rules;

use Ionix\Validation\Rule;

class AlphaNumRule extends Rule {

    /**
     * Validate the rule against the value
     *
     * @return mixed
     */
    public function validate()
    {
        return preg_match('/^[\pL\pM\pN]+$/u', $this->getValue());
    }


    /**
     * Get error message in case of fail
     *
     * @return string
     */
    public function getMessage()
    {
        return sprintf('The field `%s` should contain only alpha-numeric characters!', $this->inputName);
    }
}