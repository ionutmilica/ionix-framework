<?php namespace Ionix\Validation;

abstract class Rule {

    /**
     * Every rule will have acces to the input
     *
     * @var $input
     */
    protected $input;

    /**
     * Store rule arguments
     *
     * @var array $args
     */
    protected $args = [];

    /**
     * Rule input to be validated
     *
     * @var $inputName
     */
    protected $inputName;

    /**
     * @param $input
     * @param $inputName
     * @param $args
     */
    public function __construct(&$input, $inputName, $args)
    {
        $this->input = $input;
        $this->args = $args;
        $this->inputName = $inputName;
    }

    /**
     * Return the value to be validated
     *
     * @return mixed
     */
    public function getValue()
    {
        if ( ! isset($this->input[$this->inputName])) {
            return null;
        }

        return $this->input[$this->inputName];
    }

    /**
     * Set a new value to the input
     *
     * @param $value
     */
    public function setValue($value)
    {
        $this->input[$this->inputName] = $value;
    }

    public function getMessage() { return null; }

    /**
     * Validate the rule against the value
     *
     * @return mixed
     */
    abstract public function validate();
}