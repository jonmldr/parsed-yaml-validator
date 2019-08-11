<?php

namespace ParsedYamlValidator\Type;

interface TypeInterface
{
    public function getValidatorClass(): string;

    public function getName(): string;
}
