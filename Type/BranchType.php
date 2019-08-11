<?php

namespace ParsedYamlValidator\Type;

use ParsedYamlValidator\TypeValidator\BranchTypeValidator;

class BranchType implements TypeInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $formats;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var bool
     */
    private $required = false;

    public function __construct(string $name, array $formats)
    {
        $this->name = $name;
        $this->formats = $formats;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function getFormats(): array
    {
        return $this->formats;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function getValidatorClass(): string
    {
        return BranchTypeValidator::class;
    }
}
