<?php

namespace Mod15\Domain\Entities;

final class Patient
{
    public function __construct(
        public readonly string $id,
        public readonly string $name
    ) {
    }
}
