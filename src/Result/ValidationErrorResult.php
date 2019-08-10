<?php

namespace ParsedYamlValidator\Result;

class ValidationErrorResult extends ValidationResult
{
    public function __construct(array $messages)
    {
        parent::__construct(false, $messages);
    }
}
