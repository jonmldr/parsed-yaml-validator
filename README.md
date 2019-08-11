# Parsed yaml validator

This library provides an easy-to-read, developer-friendly validator to validate your parsed yaml config files.
In this way you can handle the data without having to manually validate the data.

## Create your validator
Your validator must extend the `ParsedYamlValidator\Validator\AbstractValidator`
and implement the `ParsedYamlValidator\Validator\ValidatorInterface`.

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

#### Options
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

#### Options
- `type()`
- `types()`
- `min()`
- `max()`
- `required()`

#### Available data options
- `self::TYPE_BOOL`
- `self::TYPE_DECIMAL`
- `self::TYPE_INTEGER`
- `self::TYPE_STRING`

### DecimalType
The DecimalType represents an float/double.

````PHP
$this->decimal('length');
````

#### Options
- `required()`

### IntegerType
The IntegerType represents an integer.

````PHP
$this->integer('age');
````

#### Options
- `required()`

### StrategyType
The StrategyType represents multiple descriptions that the input can meet.

`In development`

### StringType
The IntegerType represents an string.

````PHP
$this->string('username');
````

#### Options
- `notEmpty()`
- `required()`


## Tests
Run the unit tests by executing the following command:
````
./vendor/bin/phpunit tests/ --colors=auto
````

## Php CS Fixer
````
./vendor/bin/php-cs-fixer fix
````
