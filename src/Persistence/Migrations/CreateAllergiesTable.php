<?php

namespace Mod15\Persistence\Migrations;

use PDO;

final class CreateAllergiesTable
{
    public function up(PDO $pdo): void
    {
        $pdo->exec('CREATE TABLE allergies (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            patient_id TEXT NOT NULL,
            substance TEXT NOT NULL,
            severity TEXT NOT NULL,
            active INTEGER NOT NULL DEFAULT 1,
            FOREIGN KEY(patient_id) REFERENCES patients(id)
        )');
    }

    public function down(PDO $pdo): void
    {
        $pdo->exec('DROP TABLE IF EXISTS allergies');
    }
}
