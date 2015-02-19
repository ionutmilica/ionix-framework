<?php namespace Ionix\Validation\Rules;

use Ionix\Validation\Rule;

class DateRule extends Rule {

    /**
     * Validate the rule against the value
     *
     * @return mixed
     */
    public function validate()
    {
        $value = $this->getValue();

        if ($value instanceof \DateTime) return true;
        if (strtotime($value) === false) return false;
        $date = date_parse($value);

        return checkdate($date['month'], $date['day'], $date['year']);
    }


    /**
     * Get error message in case of fail
     *
     * @return string
     */
    public function getMessage()
    {
        return sprintf('The field `%s` should be a valid date!', $this->inputName);
    }
}