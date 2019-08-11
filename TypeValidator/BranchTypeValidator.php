<?php

namespace ParsedYamlValidator\TypeValidator;

use ParsedYamlValidator\Exception\InvalidTypeValidatorException;
use ParsedYamlValidator\Validator\DelegatingValidator;
use ParsedYamlValidator\Exception\InvalidTypeException;
use ParsedYamlValidator\Result\ValidationResult;
use ParsedYamlValidator\Type\BranchType;
use ParsedYamlValidator\Type\TypeInterface;

class BranchTypeValidator implements TypeValidatorInterface
{
    public function validate(TypeInterface $type, $inputKey, $inputValue): ValidationResult
    {
        if (!$type instanceof BranchType) {
            throw new InvalidTypeException(sprintf("Expected type of instance '%s', instance of '%s' given.", BranchType::class, get_class($type)));
        }

        // minimal one child
        if ($type !== null && count($type->getFormats()) < 1) {
            throw new InvalidTypeValidatorException('Minimal one child has to be defined for a BranchType');
        }

        // require()
        if ($inputKey === null || $inputValue === null) {
            if ($type->isRequired() === true) {
                return new ValidationResult(false, sprintf(
                    "Branch with key '%s' is required but does not exists",
                    $type->getName(),
                ));
            }

            return new ValidationResult(true);
        }

        // min()
        $min = $type->getMin();

        if ($min !== null && count($type->getFormats()) < $min) {
            return new ValidationResult(false, sprintf(
                "Too few collection items for collection with key '%s', minimal %s items required",
                $type->getName(),
                $type->getMin(),
            ));
        }

        // max()
        $max = $type->getMax();

        if ($max !== null && count($type->getFormats()) > $max) {
            return new ValidationResult(false, sprintf(
                "Too many collection items for collection with key '%s', maximum %s items allowed",
                $type->getName(),
                $type->getMax(),
            ));
        }

        // BranchType: check if value is an array
        if (is_array($inputValue) === false) {
            return new ValidationResult(false, sprintf(
                "Value with key '%s' must be a collection, %s given",
                $type->getName(),
                gettype($inputValue),
            ));
        }

        $validationErrors = DelegatingValidator::delegate($inputValue, $type->getFormats());

        if ($validationErrors->getErrors() !== null) {
            return new ValidationResult(false, $validationErrors->getErrors());
        }

        return new ValidationResult(true);
    }
}
