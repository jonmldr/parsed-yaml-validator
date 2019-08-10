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
    private $ValidationErrors = [];

    public function add(ValidationError $ValidationError): self
    {
        $this->ValidationErrors[] = $ValidationError;

        return $this;
    }

    public function addCollection(ValidationErrorBag $collection): self
    {
        foreach ($collection as $collectionItem) {
            $this->ValidationErrors[] = $collectionItem;
        }

        return $this;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->ValidationErrors);
    }

    public function count()
    {
        return count($this->ValidationErrors);
    }
}
