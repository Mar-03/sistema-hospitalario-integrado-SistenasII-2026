<?php

namespace Mod15\Presentation\Responses;

final class JsonResponseEmitter
{
    public function emit(int $status, array $body): void
    {
        if (PHP_SAPI !== 'cli') {
            http_response_code($status);
            header('Content-Type: application/json');
        }

        echo json_encode(['status' => $status, 'data' => $body], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
    }
}
