<?php

require __DIR__ . '/../bootstrap/autoload.php';

use Mod15\Persistence\Database\ConnectionFactory;
use Mod15\Persistence\Migrations\MigrationRunner;
use Mod15\Persistence\Seeders\DemoDataSeeder;

$command = $argv[1] ?? null;
$options = array_slice($argv, 2);

if ($command === null) {
    fwrite(STDERR, "Usage: php bin/console.php migrate:fresh --seed | test [--filter=Class]\n");
    exit(1);
}

if ($command === 'migrate:fresh') {
    $connection = (new ConnectionFactory())->create();
    $runner = new MigrationRunner($connection);
    $runner->fresh();

    if (in_array('--seed', $options, true)) {
        (new DemoDataSeeder($connection))->run();
    }

    echo "Migration completed\n";
    exit(0);
}

if ($command === 'test') {
    $runner = new Tests\Runner();
    $filter = null;

    foreach ($options as $option) {
        if (str_starts_with($option, '--filter=')) {
            $filter = substr($option, 9);
        }
    }

    $result = $runner->run($filter);
    exit($result ? 0 : 1);
}

fwrite(STDERR, "Unknown command: {$command}\n");
exit(1);
