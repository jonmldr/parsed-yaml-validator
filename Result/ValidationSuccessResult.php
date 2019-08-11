<?php

namespace ParsedYamlValidator\Result;

class ValidationSuccessResult extends ValidationResult
{
    public function __construct()
    {
        parent::__construct(true);
    }
}
