<?php

namespace Mod15\Persistence\Migrations;

use PDO;

final class CreatePrescriptionAuditsTable
{
    public function up(PDO $pdo): void
    {
        $pdo->exec('CREATE TABLE prescription_audits (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            prescription_id TEXT NOT NULL,
            action TEXT NOT NULL,
            reason TEXT NOT NULL,
            actor_id TEXT NOT NULL,
            created_at TEXT NOT NULL,
            FOREIGN KEY(prescription_id) REFERENCES prescriptions(id)
        )');
    }

    public function down(PDO $pdo): void
    {
        $pdo->exec('DROP TABLE IF EXISTS prescription_audits');
    }
}
