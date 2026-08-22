<?php

namespace Mod15\Presentation\Requests;

use InvalidArgumentException;

final class CreatePrescriptionRequest
{
    public function __construct(private array $input)
    {
    }

    public function validated(): array
    {
        $required = ['patient_id', 'medication_id', 'dose', 'route', 'frequency', 'doctor_id'];

        foreach ($required as $field) {
            if (!array_key_exists($field, $this->input) || $this->input[$field] === '') {
                throw new InvalidArgumentException("Missing field: {$field}");
            }
        }

        return [
            'patient_id' => (string) $this->input['patient_id'],
            'medication_id' => (string) $this->input['medication_id'],
            'dose' => (string) $this->input['dose'],
            'route' => (string) $this->input['route'],
            'frequency' => (string) $this->input['frequency'],
            'doctor_id' => (string) $this->input['doctor_id'],
            'date' => isset($this->input['date']) ? (string) $this->input['date'] : date('Y-m-d'),
            'exception' => is_array($this->input['exception'] ?? null) ? $this->input['exception'] : [],
        ];
    }
}
