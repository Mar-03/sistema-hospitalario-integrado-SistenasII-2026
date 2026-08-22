<?php

namespace Tests\Fakes;

use Mod15\Domain\Contracts\PrescriptionRepositoryInterface;
use Mod15\Domain\Entities\Prescription;

final class InMemoryPrescriptionRepository implements PrescriptionRepositoryInterface
{
    /** @var list<Prescription> */
    public array $saved = [];

    public function __construct(private bool $shouldFail = false)
    {
    }

    public function save(Prescription $prescription): Prescription
    {
        if ($this->shouldFail) {
            throw new \RuntimeException('Simulated persistence failure');
        }

        $this->saved[] = $prescription;

        return $prescription;
    }
}
