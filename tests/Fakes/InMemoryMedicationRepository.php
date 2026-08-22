<?php

namespace Tests\Fakes;

use Mod15\Domain\Contracts\MedicationRepositoryInterface;
use Mod15\Domain\Entities\Medication;

final class InMemoryMedicationRepository implements MedicationRepositoryInterface
{
    /** @param array<string, Medication> $medications */
    public function __construct(private array $medications)
    {
    }

    public function findById(string $id): ?Medication
    {
        return $this->medications[$id] ?? null;
    }
}
