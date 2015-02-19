<?php namespace Ionix\Validation\Rules;

use Ionix\Validation\Rule;

class BetweenRule extends Rule {

    protected $expect = 2;

    /**
     * Validate number as is it numeric
     */
    public function validateNumeric()
    {
        $val = $this->getValue() + 0;

        return $val >= $this->getArg(0) && $val <= $this->getArg(1);
    }

    /**
     * Validate string by min length
     */
    public function validateString()
    {
        $len = function_exists('mb_strlen') ? mb_strlen($this->getValue()) : strlen($this->getValue());

        return $len >= $this->getArg(0) && $len <= $this->getArg(1);
    }

    /**
     * Validate the rule against the value
     *
     * @return mixed
     */
    public function validate()
    {
        if (is_numeric($this->getValue())) {
            return $this->validateNumeric();
        }

        return $this->validateString();
    }


    /**
     * Get error message in case of fail
     *
     * @return string
     */
    public function getMessage()
    {
        return sprintf('The field `%s` length should be between %d and %d. (%d given) !',
            $this->inputName, $this->getArg(0), $this->getArg(1), $this->getValue());
    }
}