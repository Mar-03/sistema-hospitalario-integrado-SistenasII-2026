<?php

namespace Mod15\Application\UseCases;

use DateTimeImmutable;
use Mod15\Application\DTO\CreatePrescriptionInput;
use Mod15\Application\DTO\CreatePrescriptionResult;
use Mod15\Domain\Contracts\AllergyRepositoryInterface;
use Mod15\Domain\Contracts\MedicationRepositoryInterface;
use Mod15\Domain\Contracts\PatientRepositoryInterface;
use Mod15\Domain\Contracts\PrescriptionRepositoryInterface;
use Mod15\Domain\Entities\Prescription;
use Mod15\Domain\Entities\PrescriptionAuthorization;
use Mod15\Domain\Exceptions\AllergyConflictException;
use Mod15\Domain\Exceptions\DomainException;
use Mod15\Domain\Exceptions\MedicationNotFoundException;
use Mod15\Domain\Exceptions\PersistenceException;
use Mod15\Domain\Exceptions\PatientNotFoundException;
use Mod15\Domain\Services\AllergyConflictDetector;
use Mod15\Domain\ValueObjects\AdministrationRoute;
use Mod15\Domain\ValueObjects\Dose;
use Mod15\Domain\ValueObjects\Frequency;

final class CreatePrescriptionUseCase
{
    public function __construct(
        private PatientRepositoryInterface $patients,
        private MedicationRepositoryInterface $medications,
        private AllergyRepositoryInterface $allergies,
        private PrescriptionRepositoryInterface $prescriptions,
        private AllergyConflictDetector $detector = new AllergyConflictDetector()
    ) {
    }

    public function execute(CreatePrescriptionInput $input): CreatePrescriptionResult
    {
        try {
            $patient = $this->patients->findById($input->patientId);
            if ($patient === null) {
                throw new PatientNotFoundException('Patient not found');
            }

            $medication = $this->medications->findById($input->medicationId);
            if ($medication === null || !$medication->active) {
                throw new MedicationNotFoundException('Medication not found or inactive');
            }

            $dose = Dose::fromString($input->dose)->value;
            $route = AdministrationRoute::fromString($input->route)->value;
            $frequency = Frequency::fromString($input->frequency)->value;
            $activeAllergies = $this->allergies->findActiveByPatientId($input->patientId);
            $conflict = $this->detector->detect($medication, $activeAllergies);

            if ($conflict !== null) {
                if (!$input->exceptionAuthorized) {
                    return CreatePrescriptionResult::failure(409, 'Critical allergy conflict detected');
                }

                if (trim((string) $input->exceptionReason) === '' || trim((string) $input->exceptionAuthorizedBy) === '') {
                    return CreatePrescriptionResult::failure(403, 'Authorization is required for the exception');
                }
            }

            $prescription = new Prescription(
                uniqid('rx_', true),
                $patient->id,
                $medication->id,
                $input->doctorId,
                $dose,
                $route,
                $frequency,
                new DateTimeImmutable($input->date)
            );

            if ($conflict !== null) {
                $prescription->authorizeException(new PrescriptionAuthorization(
                    (string) $input->exceptionReason,
                    (string) $input->exceptionAuthorizedBy,
                    new DateTimeImmutable()
                ));
            }

            $saved = $this->prescriptions->save($prescription);

            return CreatePrescriptionResult::success([
                'id' => $saved->id,
                'patient_id' => $saved->patientId,
                'medication_id' => $saved->medicationId,
                'dose' => $saved->dose,
                'route' => $saved->route,
                'frequency' => $saved->frequency,
                'date' => $saved->date->format('Y-m-d'),
                'exception_authorized' => $saved->authorization() !== null,
            ], $conflict !== null ? 'Prescription created with authorized exception' : 'Prescription created');
        } catch (PatientNotFoundException|MedicationNotFoundException|DomainException $e) {
            return CreatePrescriptionResult::failure(422, $e->getMessage());
        } catch (PersistenceException $e) {
            return CreatePrescriptionResult::failure(500, $e->getMessage());
        } catch (\Throwable $e) {
            return CreatePrescriptionResult::failure(500, $e->getMessage());
        }
    }
}
