<?php namespace Ionix\Validation;

class Validator implements ValidatorInterface {

    /**
     * User input - We keep an reference to it in the case of
     * modifications that can occur in some rules.
     * Ex: trim - will trim the input and change to the new value
     *
     * @var
     */
    private $input;

    /**
     * Rules provided by user to be validated against the input
     *
     * @var
     */
    private $userRules;

    /**
     * Validator rules that are tested against input
     *
     * @var array
     */
    private static $rules = [
        'required' => 'Ionix\Validation\Rules\RequiredRule',
        'boolean' => 'Ionix\Validation\Rules\BooleanRule',
    ];

    /**
     * Parser used to parse rules
     *
     * @var Parser
     */
    private $parser;

    /**
     * Holds validation state
     *
     * @var bool
     */
    private $isValid = true;

    /**
     * Error messages after validation fails
     *
     * @var array
     */
    private $messages = [];

    /**
     * Create new rule for the validator
     *
     * @param $rule
     * @param $class
     */
    public static function extend($rule, $class)
    {
        self::$rules[$rule] = $class;
    }

    /**
     * @param Parser $parser
     * @param $input
     * @param $userRules
     */
    public function __construct(Parser $parser, &$input, $userRules)
    {
        $this->input =& $input;
        $this->userRules = $userRules;
        $this->parser = $parser;
    }

    /**
     * Get error messages after validation fails
     *
     * @param null $inputName
     * @return array
     */
    public function getMessage($inputName = null)
    {
        return $this->messages;
    }

    /**
     * Check if the given input is valid under the specified rules
     *
     * @return bool
     */
    public function passes()
    {
        foreach ($this->userRules as $inputName => $userRule) {
            $rules = $this->parser->setCommand($userRule)->parse();
            $this->validateInput($inputName, $rules);
        }

        return $this->isValid;
    }

    /**
     * Validates the input for a specific group of rules
     *
     * @param $inputName
     * @param $rules
     * @return bool
     * @throws \Exception
     */
    public function validateInput($inputName, $rules)
    {
        foreach ($rules as $rule) {
            $this->validateRule($rule, $inputName);
        }
    }

    /**
     * @param $rule
     * @param $inputName
     * @throws \Exception
     */
    private function validateRule($rule, $inputName)
    {
        $ruleName = $rule['name'];

        if ( ! isset(self::$rules[$ruleName])) {
            throw new \Exception(sprintf('Undefined rule `%s` for the validator !', $ruleName));
        }

        $ruleObject = new self::$rules[$ruleName]($this->input, $inputName, $rule['args']);

        if ( ! $ruleObject->validate()) {
            $this->isValid = false;
            $this->messages[$inputName][] = $ruleObject->getMessage();
        }
    }
}