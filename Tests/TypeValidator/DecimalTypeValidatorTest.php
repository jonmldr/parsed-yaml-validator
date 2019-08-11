<?php

declare(strict_types=1);

namespace ParsedYamlValidator\Test\TypeValidator;

use ParsedYamlValidator\Type\DecimalType;
use ParsedYamlValidator\TypeValidator\DecimalTypeValidator;
use PHPUnit\Framework\TestCase;

class DecimalTypeValidatorTest extends TestCase
{
    public function testInitialize(): void
    {
        $decimalType = new DecimalType('foo');
        $this->assertEquals('foo', $decimalType->getName());
    }

    public function testNotRequiredByDefault(): void
    {
        $decimalType = new DecimalType('bar');
        $validator = new DecimalTypeValidator();
        $result = $validator->validate($decimalType, null, null);

        $this->assertTrue($result->isValid());
    }

    public function testRequired(): void
    {
        $decimalType = new DecimalType('baz');
        $decimalType->required();

        $validator = new DecimalTypeValidator();
        $result = $validator->validate($decimalType, null, null);

        $this->assertFalse($result->isValid());
    }

    public function testDecimalInput(): void
    {
        $decimalType = new DecimalType('baz');

        $validator = new DecimalTypeValidator();

        $result = $validator->validate($decimalType, 'foo', 123.45);
        $this->assertTrue($result->isValid());

        $result = $validator->validate($decimalType, 'bar', 1);
        $this->assertTrue($result->isValid());

        $result = $validator->validate($decimalType, 'baz', 12345);
        $this->assertTrue($result->isValid());

        $result = $validator->validate($decimalType, 'foo', 'test');
        $this->assertFalse($result->isValid());

        $result = $validator->validate($decimalType, 'bar', []);
        $this->assertFalse($result->isValid());

        $result = $validator->validate($decimalType, 'baz', false);
        $this->assertFalse($result->isValid());
    }
}
