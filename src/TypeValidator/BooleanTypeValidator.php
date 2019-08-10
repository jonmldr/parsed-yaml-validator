<?php

namespace ParsedYamlValidator\TypeValidator;

use ParsedYamlValidator\Exception\InvalidTypeException;
use ParsedYamlValidator\Result\ValidationTypeErrorResult;
use ParsedYamlValidator\Type\BooleanType;
use ParsedYamlValidator\Type\TypeInterface;
use ParsedYamlValidator\Result\ValidationTypeResult;
use ParsedYamlValidator\Result\ValidationTypeSuccessResult;

class BooleanTypeValidator implements TypeValidatorInterface
{
    public function validate(TypeInterface $type, $inputKey, $inputValue): ValidationTypeResult
    {
        if (!$type instanceof BooleanType) {
            throw new InvalidTypeException(sprintf("Expected type of instance '%s', instance of '%s' given.", BooleanType::class, get_class($type)));
        }

        // require()
        if (($inputKey === null || $inputValue === null) && $type->isRequired() === true) {
            return new ValidationTypeErrorResult(sprintf(
                "Boolean with key '%s' is required but does not exists",
                $type->getName(),
            ));
        }

        // BooleanType: check if value is a string
        if (is_bool($inputValue) === false) {
            return new ValidationTypeErrorResult(sprintf(
                "Value with key '%s' must be a boolean, %s given",
                $type->getName(),
                gettype($inputValue),
            ));
        }

        return new ValidationTypeSuccessResult();
    }
}
