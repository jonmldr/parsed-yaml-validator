<?php

namespace ParsedYamlValidator\Result;

class ValidationTypeSuccessResult extends ValidationTypeResult
{
    public function __construct()
    {
        parent::__construct(true);
    }
}
