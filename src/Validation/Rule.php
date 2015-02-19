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
     * Rule used to set the expected amount of args
     *
     * @var int
     */
    protected $expect  = 0;

    /**
     * @param $input
     * @param $inputName
     * @param array $args
     * @throws \Exception
     */
    public function __construct(&$input, $inputName, array $args)
    {
        $this->input = $input;
        $this->args = $args;
        $this->inputName = $inputName;

        if (count($args) < $this->expect) {
            throw new \Exception(sprintf('Rule `%s` expected %d arguments !', $this->inputName,
                $this->expect));
        }
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
     * Get arg or args
     *
     * @param null $pos
     * @return array
     */
    public function getArg($pos = null)
    {
        if ($pos === null) {
            return $this->args;
        }

        return isset($this->args[$pos]) ? $this->args[$pos] : $this->args;
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