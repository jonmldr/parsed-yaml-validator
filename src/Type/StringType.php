<?php

namespace ParsedYamlValidator\Type;

use ParsedYamlValidator\Validator\TypeValidator\StringTypeValidator;

class StringType implements TypeInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var bool
     */
    private $required = false;

    /**
     * @var bool
     */
    private $notEmpty = false;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function description(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function required(): self
    {
        $this->required = true;

        return $this;
    }

    public function notEmpty(): self
    {
        $this->notEmpty = true;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function isNotEmpty(): bool
    {
        return $this->notEmpty;
    }

    public function getValidatorClass(): string
    {
        return StringTypeValidator::class;
    }
}
