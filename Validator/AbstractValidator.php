<?php

namespace ParsedYamlValidator\Validator;

use ParsedYamlValidator\Exception\InvalidTypeException;
use ParsedYamlValidator\Type\TypeInterface;
use ParsedYamlValidator\Validator\ValidationResult;
use ParsedYamlValidator\Type\BooleanType;
use ParsedYamlValidator\Type\BranchType;
use ParsedYamlValidator\Type\CollectionType;
use ParsedYamlValidator\Type\DecimalType;
use ParsedYamlValidator\Type\IntegerType;
use ParsedYamlValidator\Type\StrategyType;
use ParsedYamlValidator\Type\StringType;

abstract class AbstractValidator
{
    public const VARIABLE = 'variable';

    public const TYPE_BOOL = 'boolean';
    public const TYPE_DECIMAL = 'double';
    public const TYPE_INTEGER = 'integer';
    public const TYPE_STRING = 'string';

    public const TYPES = [
        self::TYPE_BOOL,
        self::TYPE_DECIMAL,
        self::TYPE_INTEGER,
        self::TYPE_STRING,
    ];

    public function validate(array $input): ValidationResult
    {
        return DelegatingValidator::delegate($input, $this->describe());
    }

    protected function boolean(string $name): BooleanType
    {
        return new BooleanType($name);
    }

    protected function branch(string $name, array $formats = []): BranchType
    {
        return new BranchType($name, $formats);
    }

    protected function collection(string $name): CollectionType
    {
        return new CollectionType($name);
    }

    protected function decimal(string $name): DecimalType
    {
        return new DecimalType($name);
    }

    protected function integer(string $name): IntegerType
    {
        return new IntegerType($name);
    }

    public function strategy(string $name, array $formats = []): StrategyType
    {
        return new StrategyType($name, $formats);
    }

    protected function string(string $name): StringType
    {
        return new StringType($name);
    }
}
