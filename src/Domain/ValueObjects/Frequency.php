<?php

namespace Mod15\Domain\ValueObjects;

use Mod15\Domain\Exceptions\InvalidFrequencyException;

final class Frequency
{
    private function __construct(public readonly string $value)
    {
    }

    public static function fromString(string $value): self
    {
        $normalized = strtolower(trim($value));

        if (!preg_match('/^(cada\s+\d+\s+horas?|cada\s+\d+\s+dias?|1\s+vez\s+al\s+dia)$/', $normalized)) {
            throw new InvalidFrequencyException('Invalid frequency');
        }

        return new self($normalized);
    }
}
