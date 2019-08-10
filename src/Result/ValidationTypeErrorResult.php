<?php

namespace ParsedYamlValidator\Result;

class ValidationTypeErrorResult extends ValidationTypeResult
{
    public function __construct(string $message)
    {
        parent::__construct(false, new ValidationMessage($message));
    }

    public function getMessage(): ValidationMessage
    {
        return $this->message;
    }
}
