<?php

namespace Mod15\Domain\Contracts;

use Mod15\Domain\Entities\Patient;

interface PatientRepositoryInterface
{
    public function findById(string $id): ?Patient;
}
