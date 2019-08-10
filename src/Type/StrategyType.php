<?php

namespace ParsedYamlValidator\Type;

use ParsedYamlValidator\Validator\TypeValidator\StrategyTypeValidator;

class StrategyType implements TypeInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $min;

    /**
     * @var int
     */
    private $max;

    /**
     * @var array
     */
    private $formats;

    /**
     * @var bool
     */
    private $required = false;

    public function __construct(string $name, array $formats)
    {
        $this->name = $name;
        $this->formats = $formats;
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

    public function getMin(): int
    {
        return $this->min;
    }

    public function getMax(): int
    {
        return $this->max;
    }

    public function getFormats(): array
    {
        return $this->formats;
    }

    public function getValidatorClass(): string
    {
        return StrategyTypeValidator::class;
    }
}
