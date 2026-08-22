<?php

namespace Mod15\Application\DTO;

final class CreatePrescriptionInput
{
    public function __construct(
        public readonly string $patientId,
        public readonly string $medicationId,
        public readonly string $doctorId,
        public readonly string $dose,
        public readonly string $route,
        public readonly string $frequency,
        public readonly string $date,
        public readonly bool $exceptionAuthorized,
        public readonly ?string $exceptionReason,
        public readonly ?string $exceptionAuthorizedBy
    ) {
    }

    public static function fromArray(array $data): self
    {
        $exception = $data['exception'] ?? [];

        return new self(
            (string) $data['patient_id'],
            (string) $data['medication_id'],
            (string) $data['doctor_id'],
            (string) $data['dose'],
            (string) $data['route'],
            (string) $data['frequency'],
            (string) ($data['date'] ?? date('Y-m-d')),
            (bool) ($exception['authorized'] ?? false),
            isset($exception['reason']) ? (string) $exception['reason'] : null,
            isset($exception['authorized_by']) ? (string) $exception['authorized_by'] : null,
        );
    }
}
