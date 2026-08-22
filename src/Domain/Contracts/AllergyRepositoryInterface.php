<?php

namespace Mod15\Domain\Contracts;

use Mod15\Domain\Entities\Allergy;

interface AllergyRepositoryInterface
{
    /** @return list<Allergy> */
    public function findActiveByPatientId(string $patientId): array;
}
