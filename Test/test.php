<?php

namespace ParsedYamlValidator\Test;

use Symfony\Component\Yaml\Yaml;

include '../vendor/autoload.php';

$content = Yaml::parseFile('test.yaml');

$validator = new TestValidator();
$result = $validator->validate($content);

dd($result);
