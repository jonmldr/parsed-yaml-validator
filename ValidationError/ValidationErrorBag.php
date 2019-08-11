<?php

namespace ParsedYamlValidator\ValidationError;

use ArrayIterator;
use Countable;
use IteratorAggregate;

class ValidationErrorBag implements IteratorAggregate, Countable
{
    /**
     * @var
     */
    private $validationErrors = [];

    public function add(ValidationError $ValidationError): self
    {
        $this->validationErrors[] = $ValidationError;

        return $this;
    }

    public function addCollection(ValidationErrorBag $collection): self
    {
        foreach ($collection as $collectionItem) {
            $this->validationErrors[] = $collectionItem;
        }

        return $this;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->validationErrors);
    }

    public function count()
    {
        return count($this->validationErrors);
    }
}
