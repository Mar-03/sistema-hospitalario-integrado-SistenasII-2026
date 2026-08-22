<?php

namespace Mod15\Persistence\Repositories;

use DateTimeImmutable;
use PDO;
use Mod15\Domain\Contracts\PrescriptionRepositoryInterface;
use Mod15\Domain\Entities\Prescription;
use Mod15\Domain\Exceptions\PersistenceException;

final class PdoPrescriptionRepository implements PrescriptionRepositoryInterface
{
    public function __construct(private PDO $pdo)
    {
    }

    public function save(Prescription $prescription): Prescription
    {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare('INSERT INTO prescriptions (
                id, patient_id, medication_id, doctor_id, dose, route, frequency, prescribed_at,
                exception_reason, exception_authorized_by, exception_authorized_at, created_at
            ) VALUES (
                :id, :patient_id, :medication_id, :doctor_id, :dose, :route, :frequency, :prescribed_at,
                :exception_reason, :exception_authorized_by, :exception_authorized_at, :created_at
            )');

            $authorization = $prescription->authorization();

            $stmt->execute([
                'id' => $prescription->id,
                'patient_id' => $prescription->patientId,
                'medication_id' => $prescription->medicationId,
                'doctor_id' => $prescription->doctorId,
                'dose' => $prescription->dose,
                'route' => $prescription->route,
                'frequency' => $prescription->frequency,
                'prescribed_at' => $prescription->date->format(DateTimeImmutable::ATOM),
                'exception_reason' => $authorization?->reason,
                'exception_authorized_by' => $authorization?->authorizedBy,
                'exception_authorized_at' => $authorization?->authorizedAt->format(DateTimeImmutable::ATOM),
                'created_at' => (new DateTimeImmutable())->format(DateTimeImmutable::ATOM),
            ]);

            if ($authorization !== null) {
                $audit = $this->pdo->prepare('INSERT INTO prescription_audits (
                    prescription_id, action, reason, actor_id, created_at
                ) VALUES (
                    :prescription_id, :action, :reason, :actor_id, :created_at
                )');

                $audit->execute([
                    'prescription_id' => $prescription->id,
                    'action' => 'authorized_exception',
                    'reason' => $authorization->reason,
                    'actor_id' => $authorization->authorizedBy,
                    'created_at' => $authorization->authorizedAt->format(DateTimeImmutable::ATOM),
                ]);
            }

            $this->pdo->commit();

            return $prescription;
        } catch (\Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            throw new PersistenceException('Failed to save prescription: ' . $e->getMessage(), 0, $e);
        }
    }
}
