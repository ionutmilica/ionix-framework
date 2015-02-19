<?php namespace Ionix\Validation\Rules;

use Ionix\Validation\Rule;

class UrlRule extends Rule {

    /**
     * Validate the rule against the value
     *
     * @return mixed
     */
    public function validate()
    {
        return filter_var($this->getValue(), FILTER_VALIDATE_URL) !== false;
    }


    /**
     * Get error message in case of fail
     *
     * @return string
     */
    public function getMessage()
    {
        return sprintf('The field `%s` should be a valid url!', $this->inputName);
    }
}