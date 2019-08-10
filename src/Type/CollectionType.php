<?php

namespace ParsedYamlValidator\Type;

use ParsedYamlValidator\Validator\TypeValidator\CollectionTypeValidator;

class CollectionType implements TypeInterface
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
     * @var string[]
     */
    private $types = [];

    /**
     * @var int
     */
    private $min;

    /**
     * @var int
     */
    private $max;

    /**
     * @var bool
     */
    private $required = false;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function description(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function types(array $types): self
    {
        $this->types = $types;

        return $this;
    }

    public function type(string $type): self
    {
        $this->types[] = $type;

        return $this;
    }

    public function min(int $min): self
    {
        $this->min = $min;

        return $this;
    }

    public function max(int $max): self
    {
        $this->max = $max;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getTypes(): array
    {
        return $this->types;
    }

    public function getMin(): int
    {
        return $this->min;
    }

    public function getMax(): int
    {
        return $this->max;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function getValidatorClass(): string
    {
        return CollectionTypeValidator::class;
    }
}
