# Semana 4 — Objetivos/servicios reutilizables (inventario real)

Inventario de objetos reales del Micro-HIS ASII-15, verificados por contenido. No se incluyen clases inventadas.

## DTOs (Application)

| Nombre | Tipo | Capa | Responsabilidad | Uso/reutilización |
|---|---|---|---|---|
| `CreatePrescriptionInput` | DTO (constructor + `fromArray`) | Application | Transporta la entrada del caso de uso de forma inmutable | Es la entrada de `CreatePrescriptionUseCase::execute`; lo construye el Controller desde el payload validado |
| `CreatePrescriptionResult` | DTO (immutable) | Application | Encapsula éxito/fracaso, `statusCode`, mensaje y datos de la prescripción | Es la salida de `CreatePrescriptionUseCase::execute`; el Controller lo serializa en la respuesta |

## Entidades (Domain)

| Nombre | Tipo | Capa | Responsabilidad | Uso/reutilización |
|---|---|---|---|---|
| `Patient` | Entidad | Domain | Representa al paciente con su id y nombre | La consulta del paciente en el caso de uso; seed demo y fakes |
| `Medication` | Entidad | Domain | Representa el medicamento (id, nombre comercial, genérico, activo) | Validación del medicamento y comparación de alergias; seed demo y fakes |
| `Allergy` | Entidad | Domain | Representa la alergia del paciente (paciente, sustancia, severidad) | `AllergyConflictDetector`; seed demo y fakes |
| `Prescription` | Entidad | Domain | Representa la prescripción creada (paciente, medicamento, dosis, vía, frecuencia, fecha, autorización) | Guardar en `PrescriptionRepositoryInterface`; construcción del resultado |
| `PrescriptionAuthorization` | Entidad | Domain | Representa la excepción autorizada (motivo, responsable, fecha) | Adjunta a `Prescription` cuando se autoriza una excepción de alergia; genera el registro de auditoría |

## Value Objects (Domain)

| Nombre | Tipo | Capa | Responsabilidad | Uso/reutilización |
|---|---|---|---|---|
| `Dose` | Value Object (final, validation by regex) | Domain | Valida y normaliza la dosis (`InvalidDoseException`) | Construcción de `Prescription`; cubierto por `testInvalidDoseIsRejected` |
| `Frequency` | Value Object | Domain | Valida y normaliza la frecuencia (`InvalidFrequencyException`) | Construcción de `Prescription` |
| `AdministrationRoute` | Value Object | Domain | Valida y normaliza la vía de administración (`InvalidRouteException`) | Construcción de `Prescription` |

## Servicio de dominio (Domain)

| Nombre | Tipo | Capa | Responsabilidad | Uso/reutilización |
|---|---|---|---|---|
| `AllergyConflictDetector` | Servicio | Domain | Compara el medicamento contra las alergias activas del paciente y devuelve el conflicto si existe | Invocado por `CreatePrescriptionUseCase`; regla central del módulo |

## Contratos (Domain\Contracts)

| Nombre | Tipo | Capa | Responsabilidad | Uso/reutilización |
|---|---|---|---|---|
| `PatientRepositoryInterface` | Interface | Domain | Contrato de consulta de paciente | Implementado por `PdoPatientRepository` y `InMemoryPatientRepository` |
| `MedicationRepositoryInterface` | Interface | Domain | Contrato de consulta de medicamento | Implementado por `PdoMedicationRepository` y `InMemoryMedicationRepository` |
| `AllergyRepositoryInterface` | Interface | Domain | Contrato de consulta de alergias activas | Implementado por `PdoAllergyRepository` y `InMemoryAllergyRepository` |
| `PrescriptionRepositoryInterface` | Interface | Domain | Contrato de guardado de prescripciones | Implementado por `PdoPrescriptionRepository` y `InMemoryPrescriptionRepository` |

## Adaptadores PDO (Persistence)

| Nombre | Tipo | Capa | Responsabilidad | Uso/reutilización |
|---|---|---|---|---|
| `PdoPatientRepository` | Adapter (PDO) | Persistence | Implementa `PatientRepositoryInterface` con `prepare()/execute()` | Carga de paciente en el caso de uso (entorno real) |
| `PdoMedicationRepository` | Adapter (PDO) | Persistence | Implementa `MedicationRepositoryInterface` con PDO | Carga de medicamento activo |
| `PdoAllergyRepository` | Adapter (PDO) | Persistence | Implementa `AllergyRepositoryInterface` con PDO | Consulta de alergias activas |
| `PdoPrescriptionRepository` | Adapter (PDO) | Persistence | Implementa `PrescriptionRepositoryInterface` con transacción y auditoría | Persistencia de la prescripción y su evento de auditoría |

## Adaptadores InMemory (tests/Fakes)

| Nombre | Tipo | Capa | Responsabilidad | Uso/reutilización |
|---|---|---|---|---|
| `InMemoryPatientRepository` | Adapter (fake) | tests | Implementa el contrato en memoria | Pruebas del caso de uso sin BD |
| `InMemoryMedicationRepository` | Adapter (fake) | tests | Implementa el contrato en memoria | Pruebas del caso de uso sin BD |
| `InMemoryAllergyRepository` | Adapter (fake) | tests | Implementa el contrato en memoria con alergias controladas | Pruebas del bloqueo por alergia y excepción autorizada |
| `InMemoryPrescriptionRepository` | Adapter (fake) | tests | Implementa el contrato en memoria; puede fallar a propósito | Pruebas del camino feliz y del error de persistencia |

## Excepciones (Domain)

| Nombre | Tipo | Capa | Responsabilidad | Uso/reutilización |
|---|---|---|---|---|
| `PersistenceException` | Excepción | Domain | Representa fallo de persistencia | Lanzada por los adaptadores PDO; el caso de uso responde `500` |
| `DomainException` | Excepción base | Domain | Base de excepciones del dominio | Heredada por el resto de excepciones del módulo |
| `PatientNotFoundException` | Excepción | Domain | Paciente no encontrado | Caso de uso → `422` |
| `MedicationNotFoundException` | Excepción | Domain | Medicamento no encontrado o inactivo | Caso de uso → `422` |
| `AllergyConflictException` | Excepción | Domain | Conflicto de alergia | Modelo de la regla de alergias |
| `InvalidDoseException` | Excepción | Domain | Dosis inválida | Lanzada por `Dose` → `422` |
| `InvalidFrequencyException` | Excepción | Domain | Frecuencia inválida | Lanzada por `Frequency` → `422` |
| `InvalidRouteException` | Excepción | Domain | Vía de administración inválida | Lanzada por `AdministrationRoute` → `422` |

## Nota

Estos objetos se reutilizan de forma consistente entre el flujo HTTP (`public/index.php` + `routes/api.php`), el CLI (`bin/console.php`) y las pruebas (`tests/`), a través de los contratos definidos en `Domain\Contracts`. No se duplicaron ni se crearon versiones alternativas en Semana 4.