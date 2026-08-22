<?php

spl_autoload_register(static function (string $class): void {
    $prefixes = [
        'Mod15\\' => __DIR__ . '/../src/',
        'Tests\\' => __DIR__ . '/../tests/',
    ];

    foreach ($prefixes as $prefix => $baseDir) {
        if (!str_starts_with($class, $prefix)) {
            continue;
        }

        $relative = substr($class, strlen($prefix));
        $path = $baseDir . str_replace('\\', DIRECTORY_SEPARATOR, $relative) . '.php';

        if (is_file($path)) {
            require $path;
        }

        return;
    }
});
