<?php namespace Ionix\Validation\Rules;

use Ionix\Validation\Rule;

class InRule extends Rule {

    protected $expected = 1;
    
    /**
     * Validate the rule against the value
     *
     * @return mixed
     */
    public function validate()
    {
        return in_array($this->getValue(), $this->getArg());
    }


    /**
     * Get error message in case of fail
     *
     * @return string
     */
    public function getMessage()
    {
        return sprintf('The field `%s` should contain a value from this list: %s!',
            $this->inputName, implode(', ', $this->getArg()));
    }
}