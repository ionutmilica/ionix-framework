<?php namespace Ionix\Validation;

class Validator implements ValidatorInterface {

    /**
     * @var
     */
    private $input;
    /**
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
     * @var Parser
     */
    private $parser;

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
     * Create new rule for the validator
     *
     * @param $rule
     * @param $class
     */
    public static function extend($rule, $class)
    {
        self::$rules[$rule] = $class;
    }

    public function validateRule($inputName, $rules)
    {
        $result = [];
        $isValid = true;

        foreach ($rules as $rule) {
            $ruleName = $rule['name'];
            if (isset(self::$rules[$ruleName])) {
                $ruleObj = new self::$rules[$ruleName]($this->input, $inputName, $rule['args']);
                $isValid = $this->trueFalse($isValid, $ruleObj->validate());
                //$result[$ruleName] = $ruleObj->validate();
            }
        }

        return $isValid;
    }


    public function passes()
    {
        $isValid = true;

        foreach ($this->userRules as $inputName => $userRule) {
            $rules = $this->parser->setCommand($userRule)->parse();
            $isValid = $this->trueFalse($isValid, $this->validateRule($inputName, $rules));
        }

        return $isValid;
    }

    /**
     * Helper for flag setting
     *
     * @param $value
     * @param $newValue
     * @return bool
     */
    private function trueFalse($value, $newValue)
    {
        if ($value == false) {
            return false;
        }

        return $newValue;
    }
}