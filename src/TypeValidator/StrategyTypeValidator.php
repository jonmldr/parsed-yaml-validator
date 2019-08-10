<?php

namespace ParsedYamlValidator\TypeValidator;

use ParsedYamlValidator\Exception\InvalidTypeException;
use ParsedYamlValidator\Type\StrategyType;
use ParsedYamlValidator\Type\TypeInterface;
use ParsedYamlValidator\Result\ValidationTypeResult;
use ParsedYamlValidator\Result\ValidationTypeSuccessResult;

class StrategyTypeValidator implements TypeValidatorInterface
{
    public function validate(TypeInterface $type, $inputKey, $inputValue): ValidationTypeResult
    {
        if (!$type instanceof StrategyType) {
            throw new InvalidTypeException(sprintf("Expected type of instance '%s', instance of '%s' given.", StrategyType::class, get_class($type)));
        }

        // @TODO
        return new ValidationTypeSuccessResult();
    }
}
