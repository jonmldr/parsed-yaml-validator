<?php

namespace ParsedYamlValidator\Result;

abstract class ValidationResult
{
    /**
     * @var bool
     */
    private $valid;

    /**
     * @var ValidationMessage[]|null
     */
    protected $messages;

    public function __construct(bool $valid, ?array $messages = null)
    {
        $this->valid = $valid;
        $this->messages = $messages;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }
}
