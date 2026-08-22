<?php

namespace Mod15\Presentation\Controllers;

use InvalidArgumentException;
use Mod15\Application\DTO\CreatePrescriptionInput;
use Mod15\Application\UseCases\CreatePrescriptionUseCase;
use Mod15\Presentation\Requests\CreatePrescriptionRequest;

final class PrescriptionController
{
    public function __construct(private CreatePrescriptionUseCase $useCase)
    {
    }

    public function create(CreatePrescriptionRequest $request): array
    {
        try {
            $payload = $request->validated();
        } catch (InvalidArgumentException $e) {
            return [
                'status' => 422,
                'message' => $e->getMessage(),
                'prescription' => [],
            ];
        }

        $result = $this->useCase->execute(CreatePrescriptionInput::fromArray($payload));

        return [
            'status' => $result->statusCode,
            'message' => $result->message,
            'prescription' => $result->prescription,
        ];
    }
}
