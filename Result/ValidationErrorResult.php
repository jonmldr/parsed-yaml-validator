<?php

namespace ParsedYamlValidator\Result;

class ValidationErrorResult extends ValidationResult
{
    public function __construct($errors)
    {
        parent::__construct(false, $errors);
    }
}
