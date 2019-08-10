<?php

namespace ParsedYamlValidator\Result;

abstract class ValidationTypeResult
{
    /**
     * @var bool
     */
    private $valid;

    /**
     * @var ValidationMessage|null
     */
    protected $message;

    public function __construct(bool $valid, ?ValidationMessage $message = null)
    {
        $this->valid = $valid;
        $this->message = $message;
    }

    public function getMessage(): ?ValidationMessage
    {
        return $this->message;
    }
}
