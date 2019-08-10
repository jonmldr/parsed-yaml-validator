<?php

namespace ParsedYamlValidator\Type;

use ParsedYamlValidator\TypeValidator\StrategyTypeValidator;

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
     * @var bool
     */
    private $required = false;

    public function __construct(string $name)
    {
        $this->name = $name;
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

    public function getValidatorClass(): string
    {
        return StrategyTypeValidator::class;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
