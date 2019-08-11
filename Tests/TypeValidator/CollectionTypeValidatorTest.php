<?php

declare(strict_types=1);

namespace ParsedYamlValidator\Test\TypeValidator;

use ParsedYamlValidator\Type\CollectionType;
use ParsedYamlValidator\TypeValidator\CollectionTypeValidator;
use ParsedYamlValidator\Validator\AbstractValidator;
use PHPUnit\Framework\TestCase;

class CollectionTypeValidatorTest extends TestCase
{
    public function testInitialize(): void
    {
        $collectionType = new CollectionType('foo');
        $this->assertEquals('foo', $collectionType->getName());
    }

    public function testNotRequiredByDefault(): void
    {
        $collectionType = new CollectionType('bar');
        $validator = new CollectionTypeValidator();
        $result = $validator->validate($collectionType, null, null);

        $this->assertTrue($result->isValid());
    }

    public function testRequired(): void
    {
        $collectionType = new CollectionType('baz');
        $collectionType->required();

        $validator = new CollectionTypeValidator();
        $result = $validator->validate($collectionType, null, null);

        $this->assertFalse($result->isValid());
    }

    public function testMin(): void
    {
        $collectionType = new CollectionType('baz');
        $collectionType->min(3);

        $validator = new CollectionTypeValidator();

        $result = $validator->validate($collectionType, 'baz', [
            'foo',
            'bar',
        ]);
        $this->assertFalse($result->isValid());

        $result = $validator->validate($collectionType, 'baz', [
            'foo',
            'bar',
            'baz'
        ]);

        $this->assertTrue($result->isValid());

        $result = $validator->validate($collectionType, 'baz', [
            'foo',
            'bar',
            'baz',
            'acme'
        ]);
        $this->assertTrue($result->isValid());
    }

    public function testMax(): void
    {
        $collectionType = new CollectionType('baz');
        $collectionType->max(3);

        $validator = new CollectionTypeValidator();

        $result = $validator->validate($collectionType, 'baz', [
            'foo',
            'bar',
        ]);
        $this->assertTrue($result->isValid());

        $result = $validator->validate($collectionType, 'baz', [
            'foo',
            'bar',
            'baz'
        ]);

        $this->assertTrue($result->isValid());

        $result = $validator->validate($collectionType, 'baz', [
            'foo',
            'bar',
            'baz',
            'acme'
        ]);
        $this->assertFalse($result->isValid());
    }

    public function testTypes(): void
    {
        $validator = new CollectionTypeValidator();

        $collectionType = new CollectionType('foo');
        $collectionType->type(AbstractValidator::TYPE_BOOL);

        $result = $validator->validate($collectionType, 'baz', [
            'foo',
            true,
        ]);
        $this->assertFalse($result->isValid(), 'test case contains string, only boolean allowed');

        $collectionType = new CollectionType('bar');
        $collectionType->type(AbstractValidator::TYPE_BOOL);

        $result = $validator->validate($collectionType, 'foo', [
            false,
            true,
        ]);
        $this->assertTrue($result->isValid());

        $collectionType = new CollectionType('baz');
        $collectionType->type(AbstractValidator::TYPE_DECIMAL);

        $result = $validator->validate($collectionType, 'bar', [
            123.45,
            true,
        ]);
        $this->assertFalse($result->isValid(), 'test case contains boolean, only decimals allowed');

        $collectionType = new CollectionType('foo');
        $collectionType->types([
            AbstractValidator::TYPE_BOOL,
            AbstractValidator::TYPE_STRING
        ]);

        $result = $validator->validate($collectionType, 'bar', [
            false,
            'baz',
            true,
            'foo'
        ]);
        $this->assertTrue($result->isValid());
    }
}
