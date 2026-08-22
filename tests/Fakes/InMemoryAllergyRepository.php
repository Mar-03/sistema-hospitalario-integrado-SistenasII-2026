<?php

namespace Tests\Fakes;

use Mod15\Domain\Contracts\AllergyRepositoryInterface;
use Mod15\Domain\Entities\Allergy;

final class InMemoryAllergyRepository implements AllergyRepositoryInterface
{
    /** @param array<string, list<Allergy>> $allergiesByPatient */
    public function __construct(private array $allergiesByPatient)
    {
    }

    public function findActiveByPatientId(string $patientId): array
    {
        return $this->allergiesByPatient[$patientId] ?? [];
    }
}
