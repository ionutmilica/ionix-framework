<?php namespace Ionix\Validation\Rules;

use Ionix\Validation\Rule;

class SameRule extends Rule {

    protected $expected = 1;

    /**
     * Validate the rule against the value
     *
     * @return mixed
     */
    public function validate()
    {
        $same = $this->getArg(0);

        return isset($this->input[$same]) && $this->input[$same] == $this->getValue();
    }


    /**
     * Get error message in case of fail
     *
     * @return string
     */
    public function getMessage()
    {
        return sprintf('The field `%s` value should be same as for `%s`!',
            $this->inputName, $this->getArg(0));
    }
}