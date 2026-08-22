<?php

namespace Mod15\Domain\Entities;

final class Allergy
{
    public function __construct(
        public readonly string $patientId,
        public readonly string $substance,
        public readonly string $severity,
        public readonly bool $active = true
    ) {
    }

    public function isCritical(): bool
    {
        return strtolower($this->severity) === 'critica';
    }
}
