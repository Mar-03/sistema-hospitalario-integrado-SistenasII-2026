<?php

return [
    'driver' => getenv('MOD15_DB_DRIVER') ?: 'sqlite',
    'path' => getenv('MOD15_DB_PATH') ?: __DIR__ . '/../storage/mod15.sqlite',
    'host' => getenv('MOD15_DB_HOST') ?: '127.0.0.1',
    'port' => getenv('MOD15_DB_PORT') ?: '5432',
    'database' => getenv('MOD15_DB_NAME') ?: 'mod15',
    'username' => getenv('MOD15_DB_USER') ?: 'postgres',
    'password' => getenv('MOD15_DB_PASSWORD') ?: '',
];
