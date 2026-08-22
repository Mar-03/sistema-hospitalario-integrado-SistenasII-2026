<?php

namespace Mod15\Domain\ValueObjects;

use Mod15\Domain\Exceptions\InvalidDoseException;

final class Dose
{
    private function __construct(public readonly string $value)
    {
    }

    public static function fromString(string $value): self
    {
        $normalized = trim($value);

        if ($normalized === '' || !preg_match('/^\d+(?:\.\d+)?\s?[a-zA-Z][a-zA-Z0-9\/\-%]*$/', $normalized)) {
            throw new InvalidDoseException('Invalid dose');
        }

        return new self($normalized);
    }
}
