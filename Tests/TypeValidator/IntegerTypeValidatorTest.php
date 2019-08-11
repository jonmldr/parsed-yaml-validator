<?php

declare(strict_types=1);

namespace ParsedYamlValidator\Test\TypeValidator;

use ParsedYamlValidator\Type\IntegerType;
use ParsedYamlValidator\TypeValidator\IntegerTypeValidator;
use PHPUnit\Framework\TestCase;

class IntegerTypeValidatorTest extends TestCase
{
    public function testInitialize(): void
    {
        $integerType = new IntegerType('foo');
        $this->assertEquals('foo', $integerType->getName());
    }

    public function testNotRequiredByDefault(): void
    {
        $integerType = new IntegerType('bar');
        $validator = new IntegerTypeValidator();
        $result = $validator->validate($integerType, null, null);

        $this->assertTrue($result->isValid());
    }

    public function testRequired(): void
    {
        $integerType = new IntegerType('baz');
        $integerType->required();

        $validator = new IntegerTypeValidator();
        $result = $validator->validate($integerType, null, null);

        $this->assertFalse($result->isValid());
    }

    public function testIntegerInput(): void
    {
        $integerType = new IntegerType('baz');

        $validator = new IntegerTypeValidator();

        $result = $validator->validate($integerType, 'bar', 1);
        $this->assertTrue($result->isValid());

        $result = $validator->validate($integerType, 'baz', 12345);
        $this->assertTrue($result->isValid());

        $result = $validator->validate($integerType, 'foo', 123.45);
        $this->assertFalse($result->isValid());

        $result = $validator->validate($integerType, 'foo', 'test');
        $this->assertFalse($result->isValid());

        $result = $validator->validate($integerType, 'bar', []);
        $this->assertFalse($result->isValid());

        $result = $validator->validate($integerType, 'baz', false);
        $this->assertFalse($result->isValid());
    }
}
