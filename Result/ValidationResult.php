<?php

namespace ParsedYamlValidator\Result;

use ParsedYamlValidator\Exception\InvalidTypeException;
use ParsedYamlValidator\ValidationError\ValidationError;
use ParsedYamlValidator\ValidationError\ValidationErrorBag;

class ValidationResult
{
    /**
     * @var bool
     */
    private $valid;

    /**
     * @var ValidationErrorBag
     */
    protected $errors;

    public function __construct(bool $valid, $errors = null)
    {
        $this->valid = $valid;
        $this->errors = new ValidationErrorBag();

        if ($errors === null) {
            return;
        }

        if (is_string($errors) === true) {
            $this->errors->add(new ValidationError($errors));

            return;
        }

        if ($errors instanceof ValidationErrorBag) {
            $this->errors->addCollection($errors);

            return;
        }

        if (is_array($errors) === true) {
            foreach ($errors as $message) {
                $this->errors->add(new ValidationError($message));

                return;
            }
        }

        throw new InvalidTypeException(sprintf(
            'Invalid type provided for parameter $errors, type %s provided',
            gettype($errors)
        ));
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function getErrors(): ValidationErrorBag
    {
        return $this->errors;
    }
}
