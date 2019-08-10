<?php

namespace ParsedYamlValidator\Validator\TypeValidator;

use ParsedYamlValidator\Exception\InvalidTypeException;
use ParsedYamlValidator\Type\StrategyType;
use ParsedYamlValidator\Type\TypeInterface;
use ParsedYamlValidator\Result\ValidationResult;
use ParsedYamlValidator\Result\ValidationSuccessResult;

class StrategyTypeValidator implements TypeValidatorInterface
{
    public function validate(TypeInterface $type, $inputKey, $inputValue): ValidationResult
    {
        if (!$type instanceof StrategyType) {
            throw new InvalidTypeException(sprintf("Expected type of instance '%s', instance of '%s' given.", StrategyType::class, get_class($type)));
        }

        // @TODO
        return new ValidationSuccessResult();
    }
}
