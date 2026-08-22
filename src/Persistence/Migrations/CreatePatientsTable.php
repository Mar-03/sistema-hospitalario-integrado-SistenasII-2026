<?php

namespace Mod15\Persistence\Migrations;

use PDO;

final class CreatePatientsTable
{
    public function up(PDO $pdo): void
    {
        $pdo->exec('CREATE TABLE patients (
            id TEXT PRIMARY KEY,
            name TEXT NOT NULL
        )');
    }

    public function down(PDO $pdo): void
    {
        $pdo->exec('DROP TABLE IF EXISTS patients');
    }
}
