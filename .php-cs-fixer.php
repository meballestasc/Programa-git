<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return (new Config())
    ->setRiskyAllowed(true) // Permite reglas avanzadas
    ->setRules([
        '@PSR12' => true, // Usa el estándar PSR-12
        'array_syntax' => ['syntax' => 'short'], // Usa `[]` en lugar de `array()`
        'no_unused_imports' => true, // Elimina importaciones innecesarias
        'single_quote' => true, // Prefiere comillas simples para cadenas
    ])
    ->setFinder(
        Finder::create()
            ->in(__DIR__ . '/src') // Aplica las reglas a archivos dentro de `src/`
    );