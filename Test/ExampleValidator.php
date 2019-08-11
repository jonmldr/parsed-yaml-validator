<?php

namespace ParsedYamlValidator\Test;

use ParsedYamlValidator\Validator\AbstractValidator;
use ParsedYamlValidator\Validator\ValidatorInterface;

class ExampleValidator extends AbstractValidator implements ValidatorInterface
{
    public function describe(): array
    {
        return [
            $this->branch('programmers', [
                $this
                    ->string('name')
                    ->notEmpty()
                    ->required(),
                $this
                    ->integer('age')
                    ->required(),
                $this
                    ->decimal('height')
                    ->required(),
                $this
                    ->boolean('lead_developer')
                    ->required(),
                $this
                    ->collection('programming_languages')
                    ->type(self::TYPE_STRING)
                    ->min(2)
                    ->max(20)
                    ->required(),
            ]),
        ];
    }
}
