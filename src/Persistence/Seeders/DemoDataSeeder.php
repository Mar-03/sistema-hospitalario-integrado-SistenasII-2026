<?php

namespace Mod15\Persistence\Seeders;

use PDO;

final class DemoDataSeeder
{
    public function __construct(private PDO $pdo)
    {
    }

    public function run(): void
    {
        $this->pdo->beginTransaction();

        $this->pdo->exec("INSERT OR IGNORE INTO patients (id, name) VALUES
            ('pat-safe', 'Paciente Seguro'),
            ('pat-allergic', 'Paciente Alergico')");

        $this->pdo->exec("INSERT OR IGNORE INTO medications (id, name, active_ingredient, active) VALUES
            ('med-amox', 'Amoxicilina', 'amoxicilina', 1),
            ('med-para', 'Paracetamol', 'paracetamol', 1)");

        $this->pdo->exec("INSERT OR IGNORE INTO allergies (patient_id, substance, severity, active) VALUES
            ('pat-allergic', 'amoxicilina', 'critica', 1)");

        $this->pdo->commit();
    }
}
