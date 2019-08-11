<?php

declare(strict_types=1);

namespace ParsedYamlValidator\Test\TypeValidator;

use ParsedYamlValidator\Type\BooleanType;
use ParsedYamlValidator\Type\BranchType;
use ParsedYamlValidator\Type\DecimalType;
use ParsedYamlValidator\Type\IntegerType;
use ParsedYamlValidator\Type\StringType;
use ParsedYamlValidator\TypeValidator\BranchTypeValidator;
use PHPUnit\Framework\TestCase;

class BranchTypeValidatorTest extends TestCase
{
    public function testInitialize(): void
    {
        $branchType = new BranchType('foo', [
            new StringType('bar'),
        ]);
        $this->assertEquals('foo', $branchType->getName());
    }

    public function testMinimalOneChild(): void
    {
        $branchType = new BranchType('foo', []);
        $validator = new BranchTypeValidator();

        $this->expectExceptionMessage('Minimal one child has to be defined for a BranchType');
        $validator->validate($branchType, 'foo', []);
    }

    public function testNotRequiredByDefault(): void
    {
        $branchType = new BranchType('bar', [
            new StringType('bar'),
        ]);
        $validator = new BranchTypeValidator();
        $result = $validator->validate($branchType, null, null);

        $this->assertTrue($result->isValid());
    }

    public function testRequired(): void
    {
        $branchType = new BranchType('baz', [
            new StringType('bar'),
        ]);
        $branchType->required();

        $validator = new BranchTypeValidator();
        $result = $validator->validate($branchType, null, null);

        $this->assertFalse($result->isValid());
    }

    public function testBranchString(): void
    {
        $branchType = new BranchType('baz', [
            new StringType('bar'),
        ]);

        $validator = new BranchTypeValidator();

        $result = $validator->validate($branchType, 'baz', [
            'bar' => '123'
        ]);
        $this->assertTrue($result->isValid());
    }

    public function testInvalidKey(): void
    {
        $branchType = new BranchType('baz', [
            new StringType('bar'),
            new BooleanType('baz'),
        ]);

        $validator = new BranchTypeValidator();

        $result = $validator->validate($branchType, 'baz', [
            'bar' => '123',
            'acme' => false,
        ]);
        $this->assertFalse($result->isValid(), (string) $result->getErrors()->first());
    }

    public function testMultipleValidTypes(): void
    {
        $branchType = new BranchType('baz', [
            (new StringType('foo'))->required(),
            (new BooleanType('bar'))->required(),
            (new IntegerType('baz'))->required(),
            new DecimalType('acme'),
        ]);

        $validator = new BranchTypeValidator();

        $result = $validator->validate($branchType, 'baz', [
            'foo' => '123',
            'bar' => false,
            'baz' => 500,
        ]);
        $this->assertTrue($result->isValid(), (string) $result->getErrors()->first());
    }
}
