<?php

namespace ParsedYamlValidator\TypeValidator;

use ParsedYamlValidator\Exception\InvalidTypeException;
use ParsedYamlValidator\Type\BooleanType;
use ParsedYamlValidator\Type\CollectionType;
use ParsedYamlValidator\Type\TypeInterface;
use ParsedYamlValidator\Result\ValidationTypeErrorResult;
use ParsedYamlValidator\Result\ValidationTypeResult;
use ParsedYamlValidator\Result\ValidationTypeSuccessResult;

class CollectionTypeValidator implements TypeValidatorInterface
{
    public function validate(TypeInterface $type, $inputKey, $inputValue): ValidationTypeResult
    {
        if (!$type instanceof CollectionType) {
            throw new InvalidTypeException(sprintf("Expected type of instance '%s', instance of '%s' given.", BooleanType::class, get_class($type)));
        }

        // require()
        if ($inputKey === null || $inputValue === null) {
            if ($type->isRequired() === true) {
                return new ValidationTypeErrorResult(sprintf(
                    "Collection with key '%s' is required but does not exists",
                    $type->getName(),
                ));
            }

            return new ValidationTypeSuccessResult();
        }

        // CollectionType: check if value is an array
        if (is_array($inputValue) === false) {
            return new ValidationTypeErrorResult(sprintf(
                "Value with key '%s' must be a collection, %s given",
                $type->getName(),
                gettype($inputValue),
            ));
        }

        // min()
        if (count($inputValue) < $type->getMin()) {
            return new ValidationTypeErrorResult(sprintf(
                "Too few collection items for collection with key '%s', minimal %s items required",
                $type->getName(),
                $type->getMin(),
            ));
        }

        // max()
        if (count($inputValue) > $type->getMax()) {
            return new ValidationTypeErrorResult(sprintf(
                "Too many collection items for collection with key '%s', maximum %s items allowed",
                $type->getName(),
                $type->getMax(),
            ));
        }

        // types() && type()
        foreach ($inputValue as $collectionItem) {
            $collectionItemType = gettype($collectionItem);

            if (in_array($collectionItemType, $type->getTypes(), true) === false) {
                return new ValidationTypeErrorResult(sprintf(
                    'Invalid collection type %s, expected %s',
                    $collectionItemType,
                    implode(', ', $type->getTypes()),
                ));
            }
        }

        return new ValidationTypeSuccessResult();
    }
}