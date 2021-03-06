<?php

namespace ParsedYamlValidator\TypeValidator;

use ParsedYamlValidator\Exception\InvalidTypeException;
use ParsedYamlValidator\Validator\ValidationResult;
use ParsedYamlValidator\Type\DecimalType;
use ParsedYamlValidator\Type\TypeInterface;

class DecimalTypeValidator implements TypeValidatorInterface
{
    public function validate(TypeInterface $type, $inputKey, $inputValue): ValidationResult
    {
        if (!$type instanceof DecimalType) {
            throw new InvalidTypeException(sprintf("Expected type of instance '%s', instance of '%s' given.", DecimalType::class, get_class($type)));
        }

        // require()
        if ($inputKey === null || $inputValue === null) {
            if ($type->isRequired() === true) {
                return new ValidationResult(false, sprintf(
                    "Decimal with key '%s' is required but does not exists",
                    $type->getName(),
                ));
            }

            return new ValidationResult(true);
        }

        // DecimalType: check if value is a decimal
        if (is_float($inputValue) === false && is_int($inputValue) === false) {
            return new ValidationResult(false, sprintf(
                "Value with key '%s' must be a decimal, %s given",
                $type->getName(),
                gettype($inputValue),
            ));
        }

        return new ValidationResult(true);
    }
}
