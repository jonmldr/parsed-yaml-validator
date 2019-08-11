<?php

namespace ParsedYamlValidator\ValidationError;

use ArrayIterator;
use Countable;
use IteratorAggregate;

class ValidationErrorBag implements IteratorAggregate, Countable
{
    /**
     * @var ValidationError[]|array
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

    public function first(): ?ValidationError
    {
        if (isset($this->validationErrors[0]) === true) {
            return $this->validationErrors[0];
        }

        return null;
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
