# Parsed yaml validator

This library provides the opportunity to create easy-to-read, developer-friendly validators to validate your parsed yaml files.
In this way you can process the data without having to manually validate the data.

## Create your validator
Your validator must extend the `ParsedYamlValidator\Validator\AbstractValidator`
and implement the `ParsedYamlValidator\Validator\ValidatorInterface`.

#### Example:
````yaml
programmers:
  name: 'John Doe'
  age: 20
  height: 1.71
  lead_developer: true
  programming_languages:
    - 'C#'
    - 'PHP'
    - 'Javascript'
````

````PHP
use ParsedYamlValidator\Validator\AbstractValidator;
use ParsedYamlValidator\Validator\ValidatorInterface;

class ExampleValidator extends AbstractValidator implements ValidatorInterface
{
    public function describe(): array
    {
        return [
            // describe your yaml file here
            
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
````

You can call your validator in the following way:
````PHP
$content = // parsed yaml data

$validator = new ExampleValidator();
$result = $validator->validate($content);
````


## Validation result
The `validate()` method will return an instance of the `ParsedYamlValidator\Validator\ValidationResult`.
- `isValid()`: Returns `true` if the input is valid, otherwise it will return `false`
- `getErrors()`: Provides an `ValidationErrorBag` with one or multiple instances of `ValidationError` if the input is invalid.

Example:
````PHP
$result = $validator->validate($content);

if ($result->isValid() === false) {
    foreach ($result->getErrors() as $error) {
        echo sprintf('<pre>%s</pre>', (string) $error);
    }
}
````

## Data types

### BooleanType
The BooleanType represents a boolean.

````PHP
$this->boolean('isAdmin');
````

#### Options:
- `required()`

### BranchType
The BranchType represents a branch with subtypes.

````PHP
$this->branch('user', [
    $this
        ->string('username')
        ->required(),

    $this
        ->boolean('isAdmin')
        ->required(),
]);
````

### CollectionType
The CollectionType represents an collection with values.

````PHP
$this
    ->collection('ages')
    ->type(self::TYPE_INTEGER);
````

#### Options:
- `type()`
- `types()`
- `min()`
- `max()`
- `required()`

#### Available data options:
- `self::TYPE_BOOL`
- `self::TYPE_DECIMAL`
- `self::TYPE_INTEGER`
- `self::TYPE_STRING`

### DecimalType
The DecimalType represents an float/double.

````PHP
$this->decimal('length');
````

#### Options:
- `required()`

### IntegerType
The IntegerType represents an integer.

````PHP
$this->integer('age');
````

#### Options:
- `required()`

### StrategyType
The StrategyType represents multiple descriptions that the input can meet.

`In development`

### StringType
The IntegerType represents an string.

````PHP
$this->string('username');
````

#### Options:
- `notEmpty()`
- `required()`


## Tests
Run the unit tests by executing the following command:
````
./vendor/bin/phpunit tests/ --colors=auto
````

## ToDo list
- `StrategyType` / `StrategyTypeValidator`
- Moving ValidationType logic to universal `Assert` classes (required, notEmpty, min ect.)
- Unit tests for `DelegatingValidator`, `ValidationResult` & validator instances
- `min()` & `max()` for `DecimalType`, `IntegerType` & `StringType`
- `regex()` for `StringType`
- Publish @ Packagist

## Php CS Fixer
````
./vendor/bin/php-cs-fixer fix
````

## Links
- [Symfony's Yaml Component](https://symfony.com/doc/current/components/yaml.html)
- [PHP's yaml_parse() function](https://www.php.net/manual/en/function.yaml-parse.php)
