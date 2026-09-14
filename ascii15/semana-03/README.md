# Semana 3 — Diseño arquitectónico, vistas y patrones

## Portada técnica

- Curso: Análisis de Sistemas II
- Sistema: Sistema Hospitalario Integrado
- Estudiante: MARIA DE LOS ANGELES LOPEZ FAJARDO
- GitHub: Mar-03
- Repositorio: `https://github.com/Mar-03/sistema-hospitalario-integrado-SistenasII-2026.git`
- Rama: `feature/week-03-arquitectura-asii15-mar-03`
- Base: `origin/developer` (`76cd2bb`)
- Worktree: `shi-personal-asii15-week-03-arquitectura`
- Módulo: Prescripciones electrónicas con validación de alergias
- Semana: 3

## 1. Consigna

Iniciar un "Micro-HIS Prescripciones electrónicas con validación de alergias" en PHP 8.2+ vanilla para ejecutar la creación de prescripción con verificación previa de alergias, separando Presentation, Application, Domain y Persistence, usando PDO y sentencias preparadas, sin framework, y probando el camino feliz, una regla de dominio y el error de persistencia.

## 2. Objetivo

Creación de prescripción con verificación previa de alergias: el Medico selecciona paciente y medicamento, el sistema consulta las alergias activas antes de confirmar y bloquea la prescripción si existe una alergia crítica no autorizada.

## 3. Micro-HIS ASII-15

Es un micro-monolito educativo ejecutable con PHP 8.2+ vanilla, ya auditado (≈97 % de la consigna) y heredado desde el historial estable. Esta semana NO lo reimplementa: solo completa los faltantes reales (validación ejecutable de PHP 8.2+, cobertura de dosis inválida y evidencia semanal).

## 4. Arquitectura

### Presentation

- `src/Presentation/Router.php`: enruta la petición HTTP.
- `src/Presentation/Controllers/PrescriptionController.php`: orquesta la petición y construye la respuesta.
- `src/Presentation/Requests/CreatePrescriptionRequest.php`: valida el payload HTTP (paciente, medicamento, dosis, vía, frecuencia, excepción).

### Application

- `src/Application/UseCases/CreatePrescriptionUseCase.php`: caso de uso de creación de prescripción con validación previa de alergias.
- `src/Application/DTO/CreatePrescriptionInput.php` y `CreatePrescriptionResult.php`: contratos de entrada y salida del caso de uso.

### Domain

- Entidades: `Patient`, `Medication`, `Allergy`, `Prescription`, `PrescriptionAuthorization`.
- Value Objects: `Dose`, `Frequency`, `AdministrationRoute`.
- Contratos: `PatientRepositoryInterface`, `MedicationRepositoryInterface`, `AllergyRepositoryInterface`, `PrescriptionRepositoryInterface`.
- Regla de negocio: `AllergyConflictDetector`.
- Excepciones: `DomainException`, `PatientNotFoundException`, `MedicationNotFoundException`, `AllergyConflictException`, `InvalidDoseException`, `InvalidFrequencyException`, `InvalidRouteException`, `PersistenceException`.

### Persistence

- `src/Persistence/Database/ConnectionFactory.php`: crea la conexión PDO según entorno.
- `src/Persistence/Repositories/PdoPatientRepository.php`, `PdoMedicationRepository.php`, `PdoAllergyRepository.php`, `PdoPrescriptionRepository.php`.
- `src/Persistence/Migrations/*`: migraciones de las tablas (patients, medications, allergies, prescriptions, prescription_audits).
- `src/Persistence/Seeders/DemoDataSeeder.php`: datos demo.

## 5. Dirección de dependencias

- `Presentation`, `Application` y `Domain` son capas de alto nivel.
- `Application` y `Domain` dependen de **contratos** (`*RepositoryInterface`) y no de implementaciones concretas.
- `Persistence` **implementa** esos contratos con repositorios PDO.
- El caso de uso recibe los repositorios por inyección de dependencias; en pruebas se inyectan implementaciones InMemory (`tests/Fakes/`).
- Esto aplica el Principio de Inversión de Dependencias (DIP): los detalles de infraestructura dependen de abstracciones, no al revés.

## 6. PDO y sentencias preparadas

- `src/Persistence/Database/ConnectionFactory.php`: selecciona driver por `MOD15_DB_DRIVER` (`sqlite` → `storage/mod15.sqlite`; `pgsql` → PostgreSQL) con `PDO::ATTR_ERRMODE => ERRMODE_EXCEPTION`.
- Todos los repositorios PDO usan sentencias preparadas: `PDO::prepare()` + `$stmt->execute()` con parámetros nombrados.
  - `PdoPrescriptionRepository::save`: `INSERT INTO prescriptions` e `INSERT INTO prescription_audits`, con transacción `beginTransaction()/commit()/rollBack()`.
  - `PdoAllergyRepository`, `PdoMedicationRepository`, `PdoPatientRepository`: consultas con `prepare()`.
- No se concatenan valores del usuario en SQL.

## 7. Verificación de alergias

- `src/Domain/Services/AllergyConflictDetector.php` compara el medicamento contra las alergias activas del paciente (por nombre comercial y genérico).
- Si la alergia es crítica y no está autorizada: el UseCase responde `409` y no guarda.
- Con excepción autorizada (motivo y responsable válidos): permite continuar y guarda con trazabilidad en `prescription_audits`.

## 8. Flujo de creación de prescripción

1. `POST /prescriptions` llega al `Router`.
2. `CreatePrescriptionRequest` valida el payload.
3. `PrescriptionController` invoca `CreatePrescriptionUseCase`.
4. El caso de uso carga paciente y medicamento, construye los Value Objects, consulta alergias activas y llama a `AllergyConflictDetector`.
5. Si no hay conflicto (o existe excepción autorizada), crea la entidad `Prescription` y la persiste vía `PrescriptionRepositoryInterface` (implementación PDO en producción, InMemory en pruebas).
6. Devuelve `CreatePrescriptionResult` con estado HTTP (`201`, `409`, `403`, `422` o `500`).

## 9. Pruebas

Ejecución: `php bin/console.php test`

- camino feliz: `testHappyPathCreatesPrescription` → `201`, guarda 1 prescripción;
- regla de alergia: `testCriticalAllergyBlocksCreation` → `409`, no guarda;
- error de persistencia: `testPersistenceFailureReturnsError` → `500`;
- excepción autorizada: `testAuthorizedExceptionAllowsContinuation` → `201`, `exception_authorized = true`;
- dosis inválida: `testInvalidDoseIsRejected` → `422`, no guarda (regla `Dose` + `InvalidDoseException`);
- PDO real: `Mod15PdoRepositoryTest::testPdoRepositoriesPersistAndLoad` → SQLite temporal, migraciones + seed + guardado real.

## 10. Resultados

- `php bin/console.php test` → **Tests: 6, Failed: 0**.
- `php bin/console.php test --filter=Mod15PrescriptionTest` → **Tests: 5, Failed: 0**.
- `php -v` → PHP 8.2.12 (cumple requisito 8.2+; guard en `bootstrap/autoload.php`).
- Lint `php -l` en `src/ tests/ bin/ public/ config/ bootstrap/ routes/` → sin errores.
- PlantUML → `arquitectura-c4.png` generado sin errores.

## 11. Evidencias

- `ascii15/semana-03/README.md` (este archivo).
- `ascii15/semana-03/evidencia-git.md`.
- `ascii15/semana-03/diagramas/arquitectura-c4.puml` (fuente PlantUML editable).
- `ascii15/semana-03/diagramas/arquitectura-c4.png` (render).
- Comandos: `php -v`, `php bin/console.php test`, filtros, `php -l`, PlantUML.

## 12. Fuera de alcance

- No se reimplementa el Micro-HIS ni ninguna de sus capas, repositorios, reglas o pruebas existentes.
- No se migra a framework (Laravel u otro), ni se agregan dependencias.
- No se modifica la lógica de los Value Objects existentes.
- No se incorporan datos clínicos reales: todo es ficticio.
- No se trabaja la consigna de Semana 4 en esta rama.