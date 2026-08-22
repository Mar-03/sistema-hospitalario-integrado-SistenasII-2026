<?php

namespace Mod15\Persistence\Migrations;

use PDO;

final class MigrationRunner
{
    /** @var list<object> */
    private array $migrations;

    public function __construct(private PDO $pdo)
    {
        $this->migrations = [
            new CreatePatientsTable(),
            new CreateMedicationsTable(),
            new CreateAllergiesTable(),
            new CreatePrescriptionsTable(),
            new CreatePrescriptionAuditsTable(),
        ];
    }

    public function fresh(): void
    {
        $this->dropAll();

        foreach ($this->migrations as $migration) {
            $migration->up($this->pdo);
        }
    }

    private function dropAll(): void
    {
        $tables = ['prescription_audits', 'prescriptions', 'allergies', 'medications', 'patients'];

        foreach ($tables as $table) {
            $this->pdo->exec('DROP TABLE IF EXISTS ' . $table);
        }
    }
}
