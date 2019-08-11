<?php

declare(strict_types=1);

namespace ParsedYamlValidator\Test\TypeValidator;

use ParsedYamlValidator\Type\StringType;
use ParsedYamlValidator\TypeValidator\StringTypeValidator;
use PHPUnit\Framework\TestCase;

class StringTypeValidatorTest extends TestCase
{
    public function testInitialize(): void
    {
        $stringType = new StringType('foo');
        $this->assertEquals('foo', $stringType->getName());
    }

    public function testNotRequiredByDefault(): void
    {
        $stringType = new StringType('bar');
        $validator = new StringTypeValidator();
        $result = $validator->validate($stringType, null, null);

        $this->assertTrue($result->isValid());
    }

    public function testRequired(): void
    {
        $stringType = new StringType('baz');
        $stringType->required();

        $validator = new StringTypeValidator();
        $result = $validator->validate($stringType, null, null);

        $this->assertFalse($result->isValid());
    }

    public function testNotEmpty(): void
    {
        $stringType = new StringType('baz');
        $stringType->notEmpty();

        $validator = new StringTypeValidator();

        $result = $validator->validate($stringType, 'foo', 'foo');
        $this->assertTrue($result->isValid());

        $result = $validator->validate($stringType, 'foo', '');
        $this->assertFalse($result->isValid());

        $result = $validator->validate($stringType, 'foo', ' ');
        $this->assertFalse($result->isValid());

        $result = $validator->validate($stringType, 'foo', '     ');
        $this->assertFalse($result->isValid());
    }

    public function testStringInput(): void
    {
        $stringType = new StringType('baz');
        $validator = new StringTypeValidator();

        $result = $validator->validate($stringType, 'foo', 'foo');
        $this->assertTrue($result->isValid());

        $result = $validator->validate($stringType, 'foo', '');
        $this->assertTrue($result->isValid());

        $result = $validator->validate($stringType, 'bar', 1);
        $this->assertFalse($result->isValid());

        $result = $validator->validate($stringType, 'baz', 12345);
        $this->assertFalse($result->isValid());

        $result = $validator->validate($stringType, 'foo', 123.45);
        $this->assertFalse($result->isValid());

        $result = $validator->validate($stringType, 'bar', []);
        $this->assertFalse($result->isValid());

        $result = $validator->validate($stringType, 'baz', false);
        $this->assertFalse($result->isValid());
    }
}
