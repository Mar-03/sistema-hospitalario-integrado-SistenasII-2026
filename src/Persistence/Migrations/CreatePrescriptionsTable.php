<?php

namespace Mod15\Persistence\Migrations;

use PDO;

final class CreatePrescriptionsTable
{
    public function up(PDO $pdo): void
    {
        $pdo->exec('CREATE TABLE prescriptions (
            id TEXT PRIMARY KEY,
            patient_id TEXT NOT NULL,
            medication_id TEXT NOT NULL,
            doctor_id TEXT NOT NULL,
            dose TEXT NOT NULL,
            route TEXT NOT NULL,
            frequency TEXT NOT NULL,
            prescribed_at TEXT NOT NULL,
            exception_reason TEXT NULL,
            exception_authorized_by TEXT NULL,
            exception_authorized_at TEXT NULL,
            created_at TEXT NOT NULL,
            FOREIGN KEY(patient_id) REFERENCES patients(id),
            FOREIGN KEY(medication_id) REFERENCES medications(id)
        )');
    }

    public function down(PDO $pdo): void
    {
        $pdo->exec('DROP TABLE IF EXISTS prescriptions');
    }
}
