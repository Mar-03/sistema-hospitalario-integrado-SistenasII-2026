<?php

namespace Mod15\Persistence\Migrations;

use PDO;

final class CreateMedicationsTable
{
    public function up(PDO $pdo): void
    {
        $pdo->exec('CREATE TABLE medications (
            id TEXT PRIMARY KEY,
            name TEXT NOT NULL,
            active_ingredient TEXT NOT NULL,
            active INTEGER NOT NULL DEFAULT 1
        )');
    }

    public function down(PDO $pdo): void
    {
        $pdo->exec('DROP TABLE IF EXISTS medications');
    }
}
