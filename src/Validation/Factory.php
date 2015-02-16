<?php namespace Ionix\Validation;

class Factory {
    /**
     * @var Parser
     */
    private $parser;

    /**
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    public function make(&$input, $rules)
    {
        return new Validator($this->parser, $input, $rules);
    }
}