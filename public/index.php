<?php

require __DIR__ . '/../bootstrap/autoload.php';

use Mod15\Application\DTO\CreatePrescriptionInput;
use Mod15\Application\UseCases\CreatePrescriptionUseCase;
use Mod15\Persistence\Database\ConnectionFactory;
use Mod15\Persistence\Migrations\MigrationRunner;
use Mod15\Persistence\Repositories\PdoAllergyRepository;
use Mod15\Persistence\Repositories\PdoMedicationRepository;
use Mod15\Persistence\Repositories\PdoPatientRepository;
use Mod15\Persistence\Repositories\PdoPrescriptionRepository;
use Mod15\Presentation\Controllers\PrescriptionController;
use Mod15\Presentation\Requests\CreatePrescriptionRequest;
use Mod15\Presentation\Router;

$connection = (new ConnectionFactory())->create();
$router = new Router();
$controller = new PrescriptionController(
    new CreatePrescriptionUseCase(
        new PdoPatientRepository($connection),
        new PdoMedicationRepository($connection),
        new PdoAllergyRepository($connection),
        new PdoPrescriptionRepository($connection)
    )
);

$router->get('/health', static function (): array {
    return ['status' => 'ok', 'module' => 'mod15-prescriptions'];
});

$router->post('/prescriptions', static function (array $payload) use ($controller): array {
    $request = new CreatePrescriptionRequest($payload);
    return $controller->create($request);
});

$router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/', json_decode(file_get_contents('php://input') ?: '[]', true) ?: []);
