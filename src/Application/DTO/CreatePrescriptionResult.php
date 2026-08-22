<?php

namespace Mod15\Application\DTO;

final class CreatePrescriptionResult
{
    public function __construct(
        public readonly bool $success,
        public readonly int $statusCode,
        public readonly string $message,
        public readonly array $prescription = []
    ) {
    }

    public static function success(array $prescription, string $message = 'Prescription created'): self
    {
        return new self(true, 201, $message, $prescription);
    }

    public static function failure(int $statusCode, string $message): self
    {
        return new self(false, $statusCode, $message, []);
    }
}
