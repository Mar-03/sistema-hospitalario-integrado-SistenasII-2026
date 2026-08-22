<?php

namespace Mod15\Domain\Entities;

final class Medication
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $activeIngredient,
        public readonly bool $active = true
    ) {
    }
}
