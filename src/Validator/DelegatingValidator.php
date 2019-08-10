<?php

namespace ParsedYamlValidator\Validator;

use ParsedYamlValidator\Exception\InvalidTypeException;
use ParsedYamlValidator\Exception\InvalidTypeValidatorException;
use ParsedYamlValidator\Result\ValidationErrorResult;
use ParsedYamlValidator\Result\ValidationResult;
use ParsedYamlValidator\Result\ValidationSuccessResult;
use ParsedYamlValidator\Type\TypeInterface;
use ParsedYamlValidator\ValidationError\ValidationErrorBag;
use ParsedYamlValidator\Validator\TypeValidator\TypeValidatorInterface;

class DelegatingValidator
{
    public static function delegate(array $input, array $types): ValidationResult
    {
        $ValidationErrors = new ValidationErrorBag();

        $inputKeysToHandle = array_keys($input);

        foreach ($types as $type) {

            if (!$type instanceof TypeInterface) {
                throw new InvalidTypeException(sprintf("Type '%s' does not implement ParsedYamlValidator\Type\TypeInterface", get_class($type)));
            }

            // Instantiate & verify the validator class.
            $validatorClass = $type->getValidatorClass();
            $validator = new $validatorClass();

            if (!$validator instanceof TypeValidatorInterface) {
                throw new InvalidTypeValidatorException(sprintf("TypeValidator '%s' does not implement ParsedYamlValidator\TypeValidator\TypeValidatorInterface", get_class($validator)));
            }

            // Match the key of the type with the key of the input.
            $inputKey = null;
            $inputValue = null;

            if (array_key_exists($type->getName(), $input)) {
                $inputKey = $type->getName();
                $inputValue = $input[$type->getName()];
            }

            // Call the validator & handle the output.
            $ValidationResult = $validator->validate($type, $inputKey, $inputValue);

            $ValidationErrors->addCollection($ValidationResult->getErrors());

            // Remove the key from the "To-do list"
            if (array_key_exists($type->getName(), $inputKeysToHandle)) {
                unset($inputKeysToHandle[$type->getName()]);
            }
        }

        if (count($ValidationErrors) > 0) {
            return new ValidationErrorResult($ValidationErrors);
        }

        return new ValidationSuccessResult();
    }
}
