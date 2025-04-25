<?php
spl_autoload_register(function ($class) {
    // Define la ruta base donde están las clases
    $baseDir = __DIR__ . '/src/';

    // Convierte el nombre de la clase en una ruta válida
    $file = $baseDir . str_replace('\\', '/', $class) . '.php';

    // Si el archivo existe, lo carga
    if (file_exists($file)) {
        require $file;
    }
});