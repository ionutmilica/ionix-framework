<?php namespace Ionix\Validation;

interface ValidatorInterface {

    /**
     * Check if a given input passes validation tests
     *
     * @return mixed
     */
    public function passes();
}