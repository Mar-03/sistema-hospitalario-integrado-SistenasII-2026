<?php

namespace Mod15\Persistence\Repositories;

use PDO;
use Mod15\Domain\Contracts\MedicationRepositoryInterface;
use Mod15\Domain\Entities\Medication;

final class PdoMedicationRepository implements MedicationRepositoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function findById(string $id): ?Medication
    {
        $stmt = $this->pdo->prepare('SELECT id, name, active_ingredient, active FROM medications WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ? new Medication($row['id'], $row['name'], $row['active_ingredient'], (bool) $row['active']) : null;
    }
}
