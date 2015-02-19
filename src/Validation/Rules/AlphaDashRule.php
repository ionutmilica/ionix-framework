<?php namespace Ionix\Validation\Rules;

use Ionix\Validation\Rule;

class AlphaDashRule extends Rule {

    /**
     * Validate the rule against the value
     *
     * @return mixed
     */
    public function validate()
    {
        return preg_match('/^[\pL\pM\pN_-]+$/u', $this->getValue());
    }


    /**
     * Get error message in case of fail
     *
     * @return string
     */
    public function getMessage()
    {
        return sprintf('The field `%s` should contain alpha-numeric characters, dashes or underscores!',
            $this->inputName);
    }
}