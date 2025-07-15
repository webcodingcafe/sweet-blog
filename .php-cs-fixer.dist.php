<?php

declare(strict_types=1);

$finder = new PhpCsFixer\Finder()
    ->in(__DIR__);

return new PhpCsFixer\Config()
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setRules([
        '@PHP84Migration' => true,
        '@PER-CS' => true,
        'no_extra_blank_lines' => [
            'tokens' => [
                'attribute',
                'break',
                'case',
                'continue',
                'curly_brace_block',
                'default',
                'extra',
                'parenthesis_brace_block',
                'return',
                'square_brace_block',
                'switch',
                'throw',
                'use',
            ],
        ],
        'php_unit_attributes' => ['keep_annotations' => false],
        'php_unit_method_casing' => ['case' => 'camel_case'],
        'php_unit_test_case_static_method_calls' => ['call_type' => 'self'],
    ]);
