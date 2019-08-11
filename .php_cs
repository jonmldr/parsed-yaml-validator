<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude([
    ])
    ->in(__DIR__)
;
return PhpCsFixer\Config::create()
    ->setRules([
        'strict_param' => false,
        'phpdoc_align' => false,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'yoda_style' => false,
        'phpdoc_separation' => false,
        'concat_space' => ['spacing' => 'one'],
        'array_syntax' => ['syntax' => 'short'],
        'line_ending' => false,
        'phpdoc_order' => true,
        'no_superfluous_phpdoc_tags' => true,
    ])
    ->setFinder($finder)
;
