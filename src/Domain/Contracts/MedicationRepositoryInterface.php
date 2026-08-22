<?php

namespace Mod15\Domain\Contracts;

use Mod15\Domain\Entities\Medication;

interface MedicationRepositoryInterface
{
    public function findById(string $id): ?Medication;
}
