<?php

namespace Mod15\Domain\ValueObjects;

use Mod15\Domain\Exceptions\InvalidRouteException;

final class AdministrationRoute
{
    private const VALID_ROUTES = ['oral', 'iv', 'im', 'subcutanea', 'topica', 'inhalada'];

    private function __construct(public readonly string $value)
    {
    }

    public static function fromString(string $value): self
    {
        $normalized = strtolower(trim($value));

        if (!in_array($normalized, self::VALID_ROUTES, true)) {
            throw new InvalidRouteException('Invalid route');
        }

        return new self($normalized);
    }
}
