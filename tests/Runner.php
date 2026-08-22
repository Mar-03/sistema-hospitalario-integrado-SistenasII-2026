<?php

namespace Tests;

use ReflectionClass;

final class Runner
{
    public function run(?string $filter = null): bool
    {
        $total = 0;
        $failed = 0;

        foreach ($this->collectTestFiles(__DIR__) as $file) {
            require_once $file;
        }

        foreach (get_declared_classes() as $class) {
            if (!str_starts_with($class, 'Tests\\')) {
                continue;
            }

            if (!is_subclass_of($class, TestCase::class)) {
                continue;
            }

            if ($filter !== null && !str_contains($class, $filter)) {
                continue;
            }

            $ref = new ReflectionClass($class);
            $instance = $ref->newInstance();

            foreach ($ref->getMethods() as $method) {
                if (!str_starts_with($method->getName(), 'test')) {
                    continue;
                }

                $total++;

                try {
                    $method->invoke($instance);
                    echo '[OK] ' . $class . '::' . $method->getName() . PHP_EOL;
                } catch (\Throwable $e) {
                    $failed++;
                    echo '[FAIL] ' . $class . '::' . $method->getName() . ' - ' . $e->getMessage() . PHP_EOL;
                }
            }
        }

        echo sprintf('Tests: %d, Failed: %d%s', $total, $failed, PHP_EOL);

        return $failed === 0;
    }

    /** @return list<string> */
    private function collectTestFiles(string $directory): array
    {
        $files = [];
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS));

        foreach ($iterator as $file) {
            if (!$file->isFile() || !str_ends_with($file->getFilename(), 'Test.php')) {
                continue;
            }

            $files[] = $file->getPathname();
        }

        sort($files);

        return $files;
    }
}
