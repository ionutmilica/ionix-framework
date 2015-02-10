<?php namespace Ionix\Validation;

class Parser {

    private $command;

    private $rules = [];

    /**
     * @param $command
     */
    public function __construct($command = null)
    {
        if ( ! is_null($command)) {
            $this->setCommand($command);
        }
    }

    /**
     * Set the command that will be parsed
     *
     * @param $command
     * @return $this
     */
    public function setCommand($command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Parse the rule and find sub-rules in it.
     *
     * @return array
     */
    public function parse()
    {
        $parts = explode('|', $this->command);

        foreach ($parts as $part) {
            $segments = explode(':', $part);

            $this->rules[] = array(
                'name' => $segments[0],
                'args' => isset($segments[1]) ? explode(',', $segments[1]) : array()
            );
        }

        return $this->rules;
    }
}