<?php

declare(strict_types=1);

namespace ParsedYamlValidator\Test\TypeValidator;

use ParsedYamlValidator\Type\BooleanType;
use ParsedYamlValidator\TypeValidator\BooleanTypeValidator;
use PHPUnit\Framework\TestCase;

class BooleanTypeValidatorTest extends TestCase
{
    public function testInitialize(): void
    {
        $booleanType = new BooleanType('foo');
        $this->assertEquals('foo', $booleanType->getName());
    }

    public function testNotRequiredByDefault(): void
    {
        $booleanType = new BooleanType('bar');
        $validator = new BooleanTypeValidator();
        $result = $validator->validate($booleanType, null, null);

        $this->assertTrue($result->isValid());
    }

    public function testRequired(): void
    {
        $booleanType = new BooleanType('baz');
        $booleanType->required();

        $validator = new BooleanTypeValidator();
        $result = $validator->validate($booleanType, null, null);

        $this->assertFalse($result->isValid());
    }

    public function testBooleanInput(): void
    {
        $booleanType = new BooleanType('baz');

        $validator = new BooleanTypeValidator();

        $result = $validator->validate($booleanType, 'foo', true);
        $this->assertTrue($result->isValid());

        $result = $validator->validate($booleanType, 'foo', 'test');
        $this->assertFalse($result->isValid());

        $result = $validator->validate($booleanType, 'foo', []);
        $this->assertFalse($result->isValid());

        $result = $validator->validate($booleanType, 'foo', 123);
        $this->assertFalse($result->isValid());

        $result = $validator->validate($booleanType, 'foo', 123.45);
        $this->assertFalse($result->isValid());
    }
}
