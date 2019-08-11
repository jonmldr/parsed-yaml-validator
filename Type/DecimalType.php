<?php

namespace ParsedYamlValidator\Type;

use ParsedYamlValidator\TypeValidator\DecimalTypeValidator;

class DecimalType implements TypeInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $required = false;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function required(): self
    {
        $this->required = true;

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

    public function getValidatorClass(): string
    {
        return DecimalTypeValidator::class;
    }
}
