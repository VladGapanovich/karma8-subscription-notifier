<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->exclude('var');

return (new PhpCsFixer\Config())
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'concat_space' => ['spacing' => 'one'],
        'array_syntax' => ['syntax' => 'short'],
        'braces' => [
            'allow_single_line_closure' => true,
        ],
        'ordered_imports' => true,
        'trailing_comma_in_multiline' => [
            'elements' => ['arrays', 'arguments', 'parameters'],
        ],
        'single_line_throw' => false,
        'declare_strict_types' => true,
        'single_import_per_statement' => false,
        'yoda_style' => false,
        'global_namespace_import' => [
            'import_classes' => true,
        ],
        'phpdoc_align' => false,
        'single_trait_insert_per_statement' => false,
        'php_unit_mock' => ['target' => 'newest'],
        'php_unit_namespaced' => ['target' => 'newest'],
        'php_unit_method_casing' => ['case' => 'snake_case'],
        'php_unit_set_up_tear_down_visibility' => true,
    ]);
