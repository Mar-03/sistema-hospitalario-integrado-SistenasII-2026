<?php

namespace Tests\Feature;

use DateTimeImmutable;
use Mod15\Application\DTO\CreatePrescriptionInput;
use Mod15\Application\UseCases\CreatePrescriptionUseCase;
use Mod15\Domain\Entities\Allergy;
use Mod15\Domain\Entities\Medication;
use Mod15\Domain\Entities\Patient;
use Tests\Fakes\InMemoryAllergyRepository;
use Tests\Fakes\InMemoryMedicationRepository;
use Tests\Fakes\InMemoryPatientRepository;
use Tests\Fakes\InMemoryPrescriptionRepository;
use Tests\TestCase;

final class Mod15PrescriptionTest extends TestCase
{
    public function testHappyPathCreatesPrescription(): void
    {
        $prescriptions = new InMemoryPrescriptionRepository();
        $useCase = $this->useCase(
            new InMemoryPatientRepository(['pat-1' => new Patient('pat-1', 'Paciente Seguro')]),
            new InMemoryMedicationRepository(['med-1' => new Medication('med-1', 'Paracetamol', 'paracetamol')]),
            new InMemoryAllergyRepository(['pat-1' => []]),
            $prescriptions
        );

        $result = $useCase->execute($this->input());

        $this->assertTrue($result->success, 'Expected success');
        $this->assertEquals(201, $result->statusCode);
        $this->assertCount(1, $prescriptions->saved);
    }

    public function testCriticalAllergyBlocksCreation(): void
    {
        $prescriptions = new InMemoryPrescriptionRepository();
        $useCase = $this->useCase(
            new InMemoryPatientRepository(['pat-1' => new Patient('pat-1', 'Paciente Alergico')]),
            new InMemoryMedicationRepository(['med-1' => new Medication('med-1', 'Amoxicilina', 'amoxicilina')]),
            new InMemoryAllergyRepository(['pat-1' => [new Allergy('pat-1', 'amoxicilina', 'critica')]]),
            $prescriptions
        );

        $result = $useCase->execute($this->input());

        $this->assertFalse($result->success, 'Expected failure');
        $this->assertEquals(409, $result->statusCode);
        $this->assertCount(0, $prescriptions->saved);
    }

    public function testPersistenceFailureReturnsError(): void
    {
        $useCase = $this->useCase(
            new InMemoryPatientRepository(['pat-1' => new Patient('pat-1', 'Paciente Seguro')]),
            new InMemoryMedicationRepository(['med-1' => new Medication('med-1', 'Paracetamol', 'paracetamol')]),
            new InMemoryAllergyRepository(['pat-1' => []]),
            new InMemoryPrescriptionRepository(true)
        );

        $result = $useCase->execute($this->input());

        $this->assertFalse($result->success, 'Expected failure');
        $this->assertEquals(500, $result->statusCode);
    }

    public function testAuthorizedExceptionAllowsContinuation(): void
    {
        $prescriptions = new InMemoryPrescriptionRepository();
        $useCase = $this->useCase(
            new InMemoryPatientRepository(['pat-1' => new Patient('pat-1', 'Paciente Alergico')]),
            new InMemoryMedicationRepository(['med-1' => new Medication('med-1', 'Amoxicilina', 'amoxicilina')]),
            new InMemoryAllergyRepository(['pat-1' => [new Allergy('pat-1', 'amoxicilina', 'critica')]]),
            $prescriptions
        );

        $result = $useCase->execute($this->input([
            'exception' => [
                'authorized' => true,
                'reason' => 'Risk accepted by specialist',
                'authorized_by' => 'doctor-9',
            ],
        ]));

        $this->assertTrue($result->success, 'Expected success');
        $this->assertEquals(201, $result->statusCode);
        $this->assertEquals(true, $result->prescription['exception_authorized']);
        $this->assertCount(1, $prescriptions->saved);
    }

    private function input(array $overrides = []): CreatePrescriptionInput
    {
        return CreatePrescriptionInput::fromArray(array_replace([
            'patient_id' => 'pat-1',
            'medication_id' => 'med-1',
            'doctor_id' => 'doc-1',
            'dose' => '500 mg',
            'route' => 'oral',
            'frequency' => 'cada 8 horas',
            'date' => (new DateTimeImmutable())->format('Y-m-d'),
            'exception' => [],
        ], $overrides));
    }

    private function useCase(
        InMemoryPatientRepository $patients,
        InMemoryMedicationRepository $medications,
        InMemoryAllergyRepository $allergies,
        InMemoryPrescriptionRepository $prescriptions
    ): CreatePrescriptionUseCase {
        return new CreatePrescriptionUseCase($patients, $medications, $allergies, $prescriptions);
    }
}
