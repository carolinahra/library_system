<?php

spl_autoload_register(function ($class) {
    // Convertir namespaces a rutas
    $baseDir = __DIR__ . '/';
    // echo $baseDir;
    $classPath = str_replace('\\', '/', $class) . '.php';

    $file = "{$baseDir}{$classPath}";

    if (file_exists($file)) {
        require_once $file;
    }
});

require_once __DIR__ . "/../vendor/autoload.php";

