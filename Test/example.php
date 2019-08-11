<?php

namespace ParsedYamlValidator\Test;

use Symfony\Component\Yaml\Yaml;

include '../vendor/autoload.php';

$content = Yaml::parseFile('example.yaml');

$validator = new ExampleValidator();
$result = $validator->validate($content);

dd($result);
