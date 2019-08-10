<?php

namespace ParsedYamlValidator\TypeValidator;

use ParsedYamlValidator\Validator\DelegatingValidator;
use ParsedYamlValidator\Exception\InvalidTypeException;
use ParsedYamlValidator\Result\ValidationErrorResult;
use ParsedYamlValidator\Result\ValidationResult;
use ParsedYamlValidator\Result\ValidationSuccessResult;
use ParsedYamlValidator\Type\BranchType;
use ParsedYamlValidator\Type\TypeInterface;

class BranchTypeValidator implements TypeValidatorInterface
{
    public function validate(TypeInterface $type, $inputKey, $inputValue): ValidationResult
    {
        if (!$type instanceof BranchType) {
            throw new InvalidTypeException(sprintf("Expected type of instance '%s', instance of '%s' given.", BooleanType::class, get_class($type)));
        }

        // require()
        if ($inputKey === null || $inputValue === null) {
            if ($type->isRequired() === true) {
                return new ValidationErrorResult(sprintf(
                    "Branch with key '%s' is required but does not exists",
                    $type->getName(),
                ));
            }

            return new ValidationSuccessResult();
        }

        // BranchType: check if value is an array
        if (is_array($inputValue) === false) {
            return new ValidationErrorResult(sprintf(
                "Value with key '%s' must be a collection, %s given",
                $type->getName(),
                gettype($inputValue),
            ));
        }

        $ValidationErrors = DelegatingValidator::delegate($inputValue, $type->getFormats());

        if ($ValidationErrors->getErrors() !== null) {
            return new ValidationErrorResult($ValidationErrors->getErrors());
        }

        return new ValidationSuccessResult();
    }
}
