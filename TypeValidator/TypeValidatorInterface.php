<?php

namespace ParsedYamlValidator\TypeValidator;

use ParsedYamlValidator\ValidationResult\ValidationResult;
use ParsedYamlValidator\Type\TypeInterface;

interface TypeValidatorInterface
{
    public function validate(TypeInterface $type, $inputKey, $inputValue): ValidationResult;
}
