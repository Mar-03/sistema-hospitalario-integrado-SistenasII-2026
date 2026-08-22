<?php

namespace Tests\Fakes;

use Mod15\Domain\Contracts\PatientRepositoryInterface;
use Mod15\Domain\Entities\Patient;

final class InMemoryPatientRepository implements PatientRepositoryInterface
{
    /** @param array<string, Patient> $patients */
    public function __construct(private array $patients)
    {
    }

    public function findById(string $id): ?Patient
    {
        return $this->patients[$id] ?? null;
    }
}
