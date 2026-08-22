<?php

namespace Mod15\Persistence\Repositories;

use PDO;
use Mod15\Domain\Contracts\AllergyRepositoryInterface;
use Mod15\Domain\Entities\Allergy;

final class PdoAllergyRepository implements AllergyRepositoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function findActiveByPatientId(string $patientId): array
    {
        $stmt = $this->pdo->prepare('SELECT patient_id, substance, severity, active FROM allergies WHERE patient_id = :patient_id AND active = 1');
        $stmt->execute(['patient_id' => $patientId]);

        $items = [];
        foreach ($stmt->fetchAll() as $row) {
            $items[] = new Allergy($row['patient_id'], $row['substance'], $row['severity'], (bool) $row['active']);
        }

        return $items;
    }
}
