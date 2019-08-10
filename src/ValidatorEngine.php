<?php

namespace ParsedYamlValidator;

use ParsedYamlValidator\Exception\InvalidTypeException;
use ParsedYamlValidator\Exception\InvalidTypeValidatorException;
use ParsedYamlValidator\Result\ValidationErrorResult;
use ParsedYamlValidator\Result\ValidationResult;
use ParsedYamlValidator\Result\ValidationSuccessResult;
use ParsedYamlValidator\Result\ValidationTypeErrorResult;
use ParsedYamlValidator\Type\TypeInterface;
use ParsedYamlValidator\TypeValidator\TypeValidatorInterface;

class ValidatorEngine
{
    public static function validate(array $input, array $types): ValidationResult
    {
        $validationMessages = [];
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
            $validationTypeResult = $validator->validate($type, $inputKey, $inputValue);

            if ($validationTypeResult instanceof ValidationTypeErrorResult) {
                $validationMessages[] = $validationTypeResult->getMessage();
            }

            // Remove the key from the "To-do list"
            if (array_key_exists($type->getName(), $inputKeysToHandle)) {
                unset($inputKeysToHandle[$type->getName()]);
            }
        }

        if (count($validationMessages) > 0) {
            return new ValidationErrorResult($validationMessages);
        }

        return new ValidationSuccessResult();
    }
}
