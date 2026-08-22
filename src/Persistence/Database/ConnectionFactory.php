<?php

namespace Mod15\Persistence\Database;

use PDO;
use RuntimeException;
use Mod15\Support\Env;

final class ConnectionFactory
{
    public function create(): PDO
    {
        Env::load(__DIR__ . '/../../../.env');

        $config = require __DIR__ . '/../../../config/database.php';

        if ($config['driver'] === 'sqlite') {
            $path = $config['path'];
            if (!preg_match('/^(?:[A-Za-z]:\\\\|\\/)/', $path)) {
                $root = realpath(__DIR__ . '/../../../') ?: (__DIR__ . '/../../../');
                $path = $root . DIRECTORY_SEPARATOR . ltrim($path, '\\/');
            }
            $dir = dirname($path);

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            if (!is_file($path)) {
                touch($path);
            }

            $pdo = new PDO('sqlite:' . $path);
        } elseif ($config['driver'] === 'pgsql') {
            $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s', $config['host'], $config['port'], $config['database']);
            $pdo = new PDO($dsn, (string) $config['username'], (string) $config['password']);
        } else {
            throw new RuntimeException('Unsupported database driver');
        }

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        if ($config['driver'] === 'sqlite') {
            $pdo->exec('PRAGMA foreign_keys = ON');
        }

        return $pdo;
    }
}
