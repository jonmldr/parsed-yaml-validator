<?php

namespace ParsedYamlValidator\Validator\TypeValidator;

use ParsedYamlValidator\Result\ValidationResult;
use ParsedYamlValidator\Type\TypeInterface;

interface TypeValidatorInterface
{
    public function validate(TypeInterface $type, $inputKey, $inputValue): ValidationResult;
}
