<?php namespace Ionix\Validation\Rules;

use Ionix\Validation\Rule;

class NumericRule extends Rule {

    /**
     * Validate the rule against the value
     *
     * @return mixed
     */
    public function validate()
    {
        return is_numeric($this->getValue());
    }


    /**
     * Get error message in case of fail
     *
     * @return string
     */
    public function getMessage()
    {
        return sprintf('The field `%s` should contain only numbers!',
            $this->inputName);
    }
}