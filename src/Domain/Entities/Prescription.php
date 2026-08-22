<?php

namespace Mod15\Domain\Entities;

use DateTimeImmutable;

final class Prescription
{
    private ?PrescriptionAuthorization $authorization = null;

    public function __construct(
        public readonly string $id,
        public readonly string $patientId,
        public readonly string $medicationId,
        public readonly string $doctorId,
        public readonly string $dose,
        public readonly string $route,
        public readonly string $frequency,
        public readonly DateTimeImmutable $date
    ) {
    }

    public function authorizeException(PrescriptionAuthorization $authorization): void
    {
        $this->authorization = $authorization;
    }

    public function authorization(): ?PrescriptionAuthorization
    {
        return $this->authorization;
    }
}
