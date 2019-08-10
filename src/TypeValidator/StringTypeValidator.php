<?php

namespace ParsedYamlValidator\TypeValidator;

use ParsedYamlValidator\Exception\InvalidTypeException;
use ParsedYamlValidator\Result\ValidationTypeErrorResult;
use ParsedYamlValidator\Type\StringType;
use ParsedYamlValidator\Type\TypeInterface;
use ParsedYamlValidator\Result\ValidationTypeResult;
use ParsedYamlValidator\Result\ValidationTypeSuccessResult;

class StringTypeValidator implements TypeValidatorInterface
{
    public function validate(TypeInterface $type, $inputKey, $inputValue): ValidationTypeResult
    {
        if (!$type instanceof StringType) {
            throw new InvalidTypeException(sprintf("Expected type of instance '%s', instance of '%s' given.", StringType::class, get_class($type)));
        }

        // require()
        if ($inputKey === null || $inputValue === null) {
            if ($type->isRequired() === true) {
                return new ValidationTypeErrorResult(sprintf(
                    "String with key '%s' is required but does not exists",
                    $type->getName(),
                ));
            }

            return new ValidationTypeSuccessResult();
        }

        // StringType: check if value is a string
        if (is_string($inputValue) === false) {
            return new ValidationTypeErrorResult(sprintf(
                "Value with key '%s' must be a string, %s given",
                $type->getName(),
                gettype($inputValue),
            ));
        }

        // notEmpty()
        if (empty($inputValue) === true && $type->isNotEmpty() === true) {
            return new ValidationTypeErrorResult(sprintf(
                "String with key '%s' is has an empty value",
                $inputKey,
            ));
        }

        return new ValidationTypeSuccessResult();
    }
}
