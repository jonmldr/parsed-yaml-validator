<?php

namespace ParsedYamlValidator\Result;

class ValidationMessage
{
    /**
     * @var string
     */
    private $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }
}
