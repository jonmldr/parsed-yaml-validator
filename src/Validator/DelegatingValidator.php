<?php

namespace ParsedYamlValidator\Validator;

use ParsedYamlValidator\Exception\InvalidTypeException;
use ParsedYamlValidator\Exception\InvalidTypeValidatorException;
use ParsedYamlValidator\Result\ValidationErrorResult;
use ParsedYamlValidator\Result\ValidationResult;
use ParsedYamlValidator\Result\ValidationSuccessResult;
use ParsedYamlValidator\Type\TypeInterface;
use ParsedYamlValidator\ValidationError\ValidationError;
use ParsedYamlValidator\ValidationError\ValidationErrorBag;
use ParsedYamlValidator\TypeValidator\TypeValidatorInterface;

class DelegatingValidator
{
    public static function delegate(array $input, array $types): ValidationResult
    {
        $validationErrors = new ValidationErrorBag();

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
            $validationResult = $validator->validate($type, $inputKey, $inputValue);

            $validationErrors->addCollection($validationResult->getErrors());

            // Remove the key from the "To-do list".
            if (($key = array_search($type->getName(), $inputKeysToHandle, true)) !== false) {
                unset($inputKeysToHandle[$key]);
            }
        }

        // Create errors for the undefined keys.
        foreach ($inputKeysToHandle as $inputKey) {
            $error = new ValidationError(sprintf(
                "Invalid option '%s', the available options are: %s",
                $inputKey,
                implode(', ', array_keys($input)),
            ));

            $validationErrors->add($error);
        }

        if (count($validationErrors) > 0) {
            return new ValidationErrorResult($validationErrors);
        }

        return new ValidationSuccessResult();
    }
}
