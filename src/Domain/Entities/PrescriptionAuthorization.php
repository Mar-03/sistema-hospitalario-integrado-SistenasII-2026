<?php

namespace Mod15\Domain\Entities;

use DateTimeImmutable;

final class PrescriptionAuthorization
{
    public function __construct(
        public readonly string $reason,
        public readonly string $authorizedBy,
        public readonly DateTimeImmutable $authorizedAt
    ) {
    }
}
