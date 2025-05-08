<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_trailing_whitespace' => true,  // 行末の不要な空白を削除
        'no_empty_statement' => true,  // 空のステートメント（空行）を削除
    ])
    ->setFinder($finder);
