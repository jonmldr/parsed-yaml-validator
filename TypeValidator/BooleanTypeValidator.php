<?php

namespace ParsedYamlValidator\TypeValidator;

use ParsedYamlValidator\Exception\InvalidTypeException;
use ParsedYamlValidator\Result\ValidationErrorResult;
use ParsedYamlValidator\Type\BooleanType;
use ParsedYamlValidator\Type\TypeInterface;
use ParsedYamlValidator\Result\ValidationResult;
use ParsedYamlValidator\Result\ValidationSuccessResult;

class BooleanTypeValidator implements TypeValidatorInterface
{
    public function validate(TypeInterface $type, $inputKey, $inputValue): ValidationResult
    {
        if (!$type instanceof BooleanType) {
            throw new InvalidTypeException(sprintf("Expected type of instance '%s', instance of '%s' given.", BooleanType::class, get_class($type)));
        }

        // require()
        if ($inputKey === null || $inputValue === null) {
            if ($type->isRequired() === true) {
                return new ValidationErrorResult(sprintf(
                    "Boolean with key '%s' is required but does not exists",
                    $type->getName(),
                ));
            }

            return new ValidationSuccessResult();
        }

        // BooleanType: check if value is a boolean
        if (is_bool($inputValue) === false) {
            return new ValidationErrorResult(sprintf(
                "Value with key '%s' must be a boolean, %s given",
                $type->getName(),
                gettype($inputValue),
            ));
        }

        return new ValidationSuccessResult();
    }
}
