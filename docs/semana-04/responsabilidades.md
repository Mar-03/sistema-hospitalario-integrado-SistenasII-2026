# Semana 4 — Responsabilidades por capa

## Introducción

Inventario de responsabilidades reales del Micro-HIS ASII-15 (`src/`). Base verificada: `feature/week-04-capas-asii15-mar-03` sobre `origin/developer` (`50d4bba`).

## Tabla de responsabilidades por capa

| Capa | Responsabilidad | Entrada | Salida | Puede depender de | No debe depender de | Objetos principales |
|---|---|---|---|---|---|---|
| **Presentation** | Recibir peticiones HTTP, validar payload, orquestar entrada, producir la representación de salida (JSON) | JSON / petición HTTP (`POST /prescriptions`) | Respuesta JSON serializada | `Application` (UseCase, DTOs), `Presentation\Requests` | PDO, SQL, reglas clínicas, persistencia concreta | `Router`, `PrescriptionController`, `CreatePrescriptionRequest` |
| **Application** | Orquestar el caso de uso sin exponer infraestructura; coordinar Domain y repositorios; traducir excepciones a resultados HTTP | `CreatePrescriptionInput` (DTO) | `CreatePrescriptionResult` (DTO) | `Domain` (entidades, Value Objects, servicios, contratos), `Persistence` vía contratos | Detalles concretos de infraestructura (PDO, HTTP, InMemory) | `CreatePrescriptionUseCase`, `CreatePrescriptionInput`, `CreatePrescriptionResult` |
| **Domain** | Reglas de negocio: entidades, Value Objects, detección de conflicto de alergias, contratos de repositorio y excepciones del dominio | Entidades y Value Objects creados por Application | Resultados de reglas, entidades, resultados de detección; contratos | Nada externo (reglas puras) | PDO, SQL, frameworks, persistencia concreta, HTTP | `Patient`, `Medication`, `Allergy`, `Prescription`, `PrescriptionAuthorization`, `Dose`, `Frequency`, `AdministrationRoute`, `AllergyConflictDetector`, `*RepositoryInterface`, excepciones |
| **Persistence** | Implementar los contratos de Domain con PDO; migraciones y seed; garantizar sentencias preparadas y transacciones | Consultas definidas por los contratos; entidades a guardar | Datos desde/hacia `Domain` (via contratos) | `Domain` (contratos), PDO | Reglas clínicas, HTTP, lógica de presentación | `ConnectionFactory`, `MigrationRunner`, migraciones, seeder, `PdoPatientRepository`, `PdoMedicationRepository`, `PdoAllergyRepository`, `PdoPrescriptionRepository` |

## Organización MVC

| Rol MVC | Objeto real | Responsabilidad |
|---|---|---|
| **Model** | `src/Domain/` + `src/Application/` | Datos, reglas y contratos (entidades, VO, DTOs, repositorios como ports) |
| **Controller** | `src/Presentation/Controllers/PrescriptionController.php` | Enlaza entrada HTTP con el caso de uso y compone la respuesta; sin SQL ni reglas |
| **View / Representation** | Respuesta JSON generada desde `Presentation` / `Router` | Representa el resultado del caso de uso (rol de presentación de una API) |
| **Router** | `routes/api.php` + `src/Presentation/Router.php` | Define y despacha las rutas de la interfaz |

### Garantías explícitas (verificadas sobre el código)

- `PrescriptionController`:
  - **NO contiene SQL.**
  - **NO contiene PDO.**
  - **NO contiene reglas clínicas** (no valida alergias, dosis ni frecuencias; solo valida presencia de campos en la Request).
- `Domain` **NO depende de `Persistence` concreta**: no se referencia PDO ni implementaciones de repositorios en `src/Domain/`.
- Los adaptadores PDO e InMemory implementan el mismo contrato definido en `Domain\Contracts`.
- Verificación técnica: `grep PDO|prepare|query|SELECT|INSERT|UPDATE|DELETE` sobre `src/Domain/` y `src/Presentation/` no devuelve coincidencias de infraestructura (solo campos de la Request, sin lógica de negocio).

## Adaptadores y contratos

| Contrato (Domain) | Adaptador PDO | Adaptador InMemory |
|---|---|---|
| `PatientRepositoryInterface` | `PdoPatientRepository` | `InMemoryPatientRepository` (tests/Fakes) |
| `MedicationRepositoryInterface` | `PdoMedicationRepository` | `InMemoryMedicationRepository` (tests/Fakes) |
| `AllergyRepositoryInterface` | `PdoAllergyRepository` | `InMemoryAllergyRepository` (tests/Fakes) |
| `PrescriptionRepositoryInterface` | `PdoPrescriptionRepository` | `InMemoryPrescriptionRepository` (tests/Fakes) |