<?php

declare(strict_types=1);

namespace ParsedYamlValidator\Test\TypeValidator;

use ParsedYamlValidator\Type\BranchType;
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
}
