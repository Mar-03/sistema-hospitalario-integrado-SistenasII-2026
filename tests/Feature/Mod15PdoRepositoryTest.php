<?php

namespace Tests\Feature;

use DateTimeImmutable;
use Mod15\Application\DTO\CreatePrescriptionInput;
use Mod15\Application\UseCases\CreatePrescriptionUseCase;
use Mod15\Persistence\Database\ConnectionFactory;
use Mod15\Persistence\Migrations\MigrationRunner;
use Mod15\Persistence\Repositories\PdoAllergyRepository;
use Mod15\Persistence\Repositories\PdoMedicationRepository;
use Mod15\Persistence\Repositories\PdoPatientRepository;
use Mod15\Persistence\Repositories\PdoPrescriptionRepository;
use Mod15\Persistence\Seeders\DemoDataSeeder;
use Tests\TestCase;

final class Mod15PdoRepositoryTest extends TestCase
{
    public function testPdoRepositoriesPersistAndLoad(): void
    {
        $path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mod15-test-' . uniqid() . '.sqlite';
        putenv('MOD15_DB_DRIVER=sqlite');
        putenv('MOD15_DB_PATH=' . $path);

        $pdo = (new ConnectionFactory())->create();
        (new MigrationRunner($pdo))->fresh();
        (new DemoDataSeeder($pdo))->run();

        $useCase = new CreatePrescriptionUseCase(
            new PdoPatientRepository($pdo),
            new PdoMedicationRepository($pdo),
            new PdoAllergyRepository($pdo),
            new PdoPrescriptionRepository($pdo)
        );

        $result = $useCase->execute(CreatePrescriptionInput::fromArray([
            'patient_id' => 'pat-safe',
            'medication_id' => 'med-para',
            'doctor_id' => 'doc-1',
            'dose' => '500 mg',
            'route' => 'oral',
            'frequency' => 'cada 8 horas',
            'date' => (new DateTimeImmutable())->format('Y-m-d'),
            'exception' => [],
        ]));

        $this->assertTrue($result->success, 'Expected success');
        $this->assertEquals(201, $result->statusCode);

        $row = $pdo->query('SELECT COUNT(*) AS total FROM prescriptions')->fetch();
        $this->assertEquals(1, (int) $row['total']);
    }
}
