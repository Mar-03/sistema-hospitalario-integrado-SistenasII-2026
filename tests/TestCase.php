<?php

namespace Tests;

use Throwable;

abstract class TestCase
{
    protected function assertTrue(bool $condition, string $message = 'Assertion failed'): void
    {
        if (!$condition) {
            throw new \RuntimeException($message);
        }
    }

    protected function assertFalse(bool $condition, string $message = 'Assertion failed'): void
    {
        $this->assertTrue(!$condition, $message);
    }

    protected function assertEquals(mixed $expected, mixed $actual, string $message = 'Values are not equal'): void
    {
        if ($expected !== $actual) {
            throw new \RuntimeException($message . ' Expected: ' . var_export($expected, true) . ' Actual: ' . var_export($actual, true));
        }
    }

    protected function assertCount(int $expected, array $actual, string $message = 'Unexpected count'): void
    {
        if (count($actual) !== $expected) {
            throw new \RuntimeException($message . ' Expected: ' . $expected . ' Actual: ' . count($actual));
        }
    }

    protected function assertThrows(string $exceptionClass, callable $callback): void
    {
        try {
            $callback();
        } catch (Throwable $e) {
            if ($e instanceof $exceptionClass) {
                return;
            }

            throw new \RuntimeException('Unexpected exception type: ' . $e::class);
        }

        throw new \RuntimeException('Expected exception was not thrown: ' . $exceptionClass);
    }
}
