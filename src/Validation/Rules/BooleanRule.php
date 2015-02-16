<?php namespace Ionix\Validation\Rules;

use Ionix\Validation\Rule;

class BooleanRule extends Rule {

    /**
     * Validate the rule against the value
     *
     * @return mixed
     */
    public function validate()
    {
        $acceptable = array(true, false, 0, 1, '0', '1');
        return in_array($this->getValue(), $acceptable, true);
    }


    /**
     * Get error message in case of fail
     *
     * @return string
     */
    public function getMessage()
    {
        return sprintf('The field `%s` should be of boolean type !', $this->inputName);
    }
}