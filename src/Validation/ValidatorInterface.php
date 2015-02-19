<?php namespace Ionix\Validation;

interface ValidatorInterface {

    /**
     * Get error messages after validation fails
     *
     * @param null $inputName
     * @return array
     */
    public function getErrors($inputName = null);

    /**
     * Check if a given input passes validation tests
     *
     * @return mixed
     */
    public function passes();
}