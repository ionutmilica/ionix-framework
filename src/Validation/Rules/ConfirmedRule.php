<?php namespace Ionix\Validation\Rules;

use Ionix\Validation\Rule;

class ConfirmedRule extends Rule {

    /**
     * Validate the rule against the value
     *
     * @return mixed
     */
    public function validate()
    {
        $confirmationInput = $this->inputName.'_confirmation';

        if (isset($this->input[$confirmationInput]) &&
            $this->input[$confirmationInput] == $this->getValue()) {
            return true;
        }

        return false;
    }


    /**
     * Get error message in case of fail
     *
     * @return string
     */
    public function getMessage()
    {
        return sprintf('The field `%s` and `%s` should match!', $this->inputName,
            $this->inputName.'_confirmation');
    }
}