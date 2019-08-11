<?php

namespace ParsedYamlValidator;

use Symfony\Component\Yaml\Yaml;

include 'vendor/autoload.php';

$content = Yaml::parseFile('services.yaml');

$validator = new ExampleValidator();

dd($validator->validate($content));
