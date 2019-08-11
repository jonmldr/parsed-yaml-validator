<?php

namespace ParsedYamlValidator\TypeValidator;

use ParsedYamlValidator\Validator\ValidationResult;
use ParsedYamlValidator\Type\TypeInterface;

interface TypeValidatorInterface
{
    public function validate(TypeInterface $type, $inputKey, $inputValue): ValidationResult;
}
