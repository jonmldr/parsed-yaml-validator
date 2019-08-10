<?php

namespace ParsedYamlValidator\TypeValidator;

use ParsedYamlValidator\Result\ValidationTypeResult;
use ParsedYamlValidator\Type\TypeInterface;

interface TypeValidatorInterface
{
    public function validate(TypeInterface $type, $inputKey, $inputValue): ValidationTypeResult;
}
