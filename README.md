# Parsed yaml validator

This library provides an easy-to-use validator to validate your parsed yaml config files.
This way you can use the data without having to manually validate the data.

## Describing your validator
Your validator must extend `ParsedYamlValidator\Validator\AbstractValidator`
and implement `ParsedYamlValidator\Validator\ValidatorInterface`.

````PHP
use ParsedYamlValidator\Validator\AbstractValidator;
use ParsedYamlValidator\Validator\ValidatorInterface;

class ExampleValidator extends AbstractValidator implements ValidatorInterface
{
    public function describe(): array
    {
        return [
            // describe your config file here
        ];
    }
}
````

## Data types


## Tests
Run the unit tests by executing the following command:
````
./vendor/bin/phpunit tests/ --colors=auto
````

## Php cs fixer
````
./vendor/bin/php-cs-fixer fix
````
