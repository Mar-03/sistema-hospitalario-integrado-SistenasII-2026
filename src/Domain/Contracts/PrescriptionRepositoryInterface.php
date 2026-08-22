<?php

namespace Mod15\Domain\Contracts;

use Mod15\Domain\Entities\Prescription;

interface PrescriptionRepositoryInterface
{
    public function save(Prescription $prescription): Prescription;
}
