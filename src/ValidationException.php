<?php
namespace JsonSchemaValidation;

/**
 * JsonSchemaValidation\Exception is thrown when input json does not validate
 */
class ValidationException extends \RuntimeException
{
    protected $validator;

    public function __construct($message, \JsonSchema\Validator $validator)
    {
        parent::__construct($message);
        $this->validator = $validator;
    }

    public function getErrors()
    {
        return $this->validator->getErrors();
    }

    public function getViolation()
    {
        $desc = "{$this->getMessage()}\nViolations:\n";
        foreach ($this->getErrors() as $e) {
            $desc .= sprintf(" %-12s %s\n", "[{$e['property']}]", $e['message']);
        }
        return $desc;
    }
}
