<?php

namespace ParsedYamlValidator\ValidationError;

class ValidationError
{
    /**
     * @var string
     */
    private $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function __toString(): string
    {
        return $this->message;
    }
}
