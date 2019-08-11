<?php

namespace ParsedYamlValidator\TypeValidator;

use ParsedYamlValidator\Exception\InvalidTypeException;
use ParsedYamlValidator\Type\BooleanType;
use ParsedYamlValidator\Type\CollectionType;
use ParsedYamlValidator\Type\TypeInterface;
use ParsedYamlValidator\Validator\ValidationResult;

class CollectionTypeValidator implements TypeValidatorInterface
{
    public function validate(TypeInterface $type, $inputKey, $inputValue): ValidationResult
    {
        if (!$type instanceof CollectionType) {
            throw new InvalidTypeException(sprintf("Expected type of instance '%s', instance of '%s' given.", BooleanType::class, get_class($type)));
        }

        // require()
        if ($inputKey === null || $inputValue === null) {
            if ($type->isRequired() === true) {
                return new ValidationResult(false, sprintf(
                    "Collection with key '%s' is required but does not exists",
                    $type->getName(),
                ));
            }

            return new ValidationResult(true);
        }

        // CollectionType: check if value is an array
        if (is_array($inputValue) === false) {
            return new ValidationResult(false, sprintf(
                "Value with key '%s' must be a collection, %s given",
                $type->getName(),
                gettype($inputValue),
            ));
        }

        // min()
        $min = $type->getMin();

        if ($min !== null && count($inputValue) < $min) {
            return new ValidationResult(false, sprintf(
                "Too few collection items for collection with key '%s', minimal %s items required",
                $type->getName(),
                $type->getMin(),
            ));
        }

        // max()
        $max = $type->getMax();

        if ($max !== null && count($inputValue) > $max) {
            return new ValidationResult(false, sprintf(
                "Too many collection items for collection with key '%s', maximum %s items allowed",
                $type->getName(),
                $type->getMax(),
            ));
        }

        // types() && type()
        if (count($type->getTypes()) > 0) {
            foreach ($inputValue as $collectionItem) {
                $collectionItemType = gettype($collectionItem);

                if (in_array($collectionItemType, $type->getTypes(), true) === false) {
                    return new ValidationResult(false, sprintf(
                        'Invalid collection type %s, expected %s',
                        $collectionItemType,
                        implode(', ', $type->getTypes()),
                    ));
                }
            }
        }

        return new ValidationResult(true);
    }
}
