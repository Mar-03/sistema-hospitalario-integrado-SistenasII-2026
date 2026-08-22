<?php

namespace Mod15\Persistence\Repositories;

use PDO;
use Mod15\Domain\Contracts\PatientRepositoryInterface;
use Mod15\Domain\Entities\Patient;

final class PdoPatientRepository implements PatientRepositoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function findById(string $id): ?Patient
    {
        $stmt = $this->pdo->prepare('SELECT id, name FROM patients WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ? new Patient($row['id'], $row['name']) : null;
    }
}
