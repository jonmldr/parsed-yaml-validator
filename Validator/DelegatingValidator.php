<?php

namespace ParsedYamlValidator\Validator;

use ParsedYamlValidator\Exception\InvalidTypeException;
use ParsedYamlValidator\Exception\InvalidTypeValidatorException;
use ParsedYamlValidator\Result\ValidationResult;
use ParsedYamlValidator\Type\TypeInterface;
use ParsedYamlValidator\ValidationError\ValidationError;
use ParsedYamlValidator\ValidationError\ValidationErrorBag;
use ParsedYamlValidator\TypeValidator\TypeValidatorInterface;

class DelegatingValidator
{
    public static function delegate(array $input, array $types): ValidationResult
    {
        $validationErrors = new ValidationErrorBag();

        $availableKeys = array_map(function (TypeInterface $type) {
            return $type->getName();
        }, $types);

        // Create errors for the undefined keys.
        foreach (array_keys($input) as $key) {
            if (in_array($key, $availableKeys, true) === false) {
                $error = new ValidationError(sprintf(
                    "Invalid option '%s', the available options are: %s",
                    $key,
                    implode(', ', $availableKeys),
                ));

                $validationErrors->add($error);
            }
        }

        // Handle types.
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
        }

        if (count($validationErrors) > 0) {
            return new ValidationResult(false, $validationErrors);
        }

        return new ValidationResult(true);
    }
}
