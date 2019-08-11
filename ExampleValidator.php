<?php

namespace ParsedYamlValidator;

use ParsedYamlValidator\Validator\AbstractValidator;
use ParsedYamlValidator\Validator\ValidatorInterface;

class ExampleValidator extends AbstractValidator implements ValidatorInterface
{
    public function describe(): array
    {
        return [

            $this
                ->collection('parameters')
                ->description('collection with parameters with keys & values')
                ->types([
                    self::TYPE_STRING,
                ])
                ->min(2)
                ->max(8)
                ->required(),

            $this
                ->boolean('testBool')
                ->required(),

            $this
                ->string('testString')
                ->notEmpty()
                ->required(),

            $this
                ->decimal('testDecimal')
                ->required(),

            $this
                ->integer('testInteger')
                ->required(),

            $this
                ->collection('testCollection')
                ->description('collection with parameters with keys & values')
                ->types([
                    self::TYPE_STRING,
                    self::TYPE_INTEGER,
                    self::TYPE_BOOL,
                    self::TYPE_DECIMAL,
                ])
                ->min(2)
                ->max(8)
                ->required(),

            $this
                ->branch('testBranch', [
                    $this
                        ->string('class')
                        ->description('describes the class of the service definition')
                        ->required()
                        ->notEmpty(),

                    $this
                        ->collection('tags')
                        ->description('collection with tags')
                        ->type(self::TYPE_STRING)
                        ->max(10),

                    $this->boolean('autowire'),
                ])
                ->description('describes an service definition')
                ->required(),

            $this
                ->strategy('services', [
                    $this
                        ->branch(self::VARIABLE, [
                            $this
                                ->string('class')
                                ->description('describes the class of the service definition')
                                ->required()
                                ->notEmpty(),

                            $this
                                ->collection('tags')
                                ->description('collection with tags')
                                ->type(self::TYPE_STRING)
                                ->max(10),

                            $this->boolean('autowire'),
                        ])
                        ->description('describes an service definition'),

                    $this
                        ->string(self::VARIABLE)
                        ->description('references to another service definition')
                        ->notEmpty(),
                ])
                ->min(2)
                ->max(8)
                ->required(),

        ];
    }
}
