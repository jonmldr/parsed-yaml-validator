<?php

namespace ParsedYamlValidator;

use Symfony\Component\Yaml\Yaml;

include 'vendor/autoload.php';

$content = Yaml::parseFile('services.yaml');

$validator = new ExampleValidator();
$result = $validator->validate($content);

if ($result->isValid() === false) {
    foreach ($result->getErrors() as $error) {
        echo sprintf('<pre>%s</pre>', (string) $error);
    }
}
