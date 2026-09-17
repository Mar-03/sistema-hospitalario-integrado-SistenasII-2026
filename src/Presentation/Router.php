<?php

namespace Mod15\Presentation;

use Mod15\Presentation\Responses\JsonResponseEmitter;

final class Router
{
    /** @var array<string, callable> */
    private array $routes = [];

    public function __construct(private ?JsonResponseEmitter $emitter = null)
    {
        $this->emitter ??= new JsonResponseEmitter();
    }

    public function get(string $path, callable $handler): void
    {
        $this->routes['GET ' . $path] = $handler;
    }

    public function post(string $path, callable $handler): void
    {
        $this->routes['POST ' . $path] = $handler;
    }

    public function dispatch(string $method, string $path, array $payload = []): void
    {
        $key = strtoupper($method) . ' ' . $path;

        if (!isset($this->routes[$key])) {
            $this->respond(404, ['error' => 'Not found']);
            return;
        }

        try {
            $result = ($this->routes[$key])($payload);
            $status = $result['status'] ?? 200;
            unset($result['status']);
            $this->respond($status, $result);
        } catch (\Throwable $e) {
            $this->respond(500, ['error' => $e->getMessage()]);
        }
    }

    private function respond(int $status, array $body): void
    {
        $this->emitter->emit($status, $body);
    }
}
