# Semana 7 - Componentes internos ASII-15

Este documento inventaria los componentes reales del backend ASII-15 encontrados por lectura del codigo. No se incluyen componentes no implementados.

## 1. Entrada HTTP / Composition Root

| Campo | Detalle |
|---|---|
| Archivos | `public/index.php` |
| Responsabilidad | Cargar autoload, crear conexion, instanciar repositorios PDO, construir UseCase y Controller, registrar rutas y despachar la peticion HTTP. |
| Dependencias | `ConnectionFactory`, repositorios PDO, `CreatePrescriptionUseCase`, `PrescriptionController`, `CreatePrescriptionRequest`, `Router`. |
| Entrada | `$_SERVER`, `php://input`, metodo HTTP, URI y JSON de request. |
| Salida | Delegacion al `Router` para emitir respuesta JSON. |
| Capa | Borde de aplicacion / composition root. |

Problema detectado: concentra composicion de dependencias y wiring HTTP en el front controller. Es aceptable para el tamano actual, pero podria extraerse despues si el modulo crece.

## 2. Presentation

| Campo | Detalle |
|---|---|
| Archivos | `src/Presentation/Router.php`, `src/Presentation/Controllers/PrescriptionController.php`, `src/Presentation/Requests/CreatePrescriptionRequest.php` |
| Responsabilidad | Resolver rutas HTTP, adaptar payload a request validado, llamar al caso de uso y devolver arreglo de respuesta. |
| Dependencias | `CreatePrescriptionUseCase`, `CreatePrescriptionInput`, `InvalidArgumentException`. |
| Entrada | Metodo, path y payload JSON ya decodificado. |
| Salida | Arreglo con `status`, `message` y `prescription`, emitido como JSON por el Router actual. |
| Capa | Presentation. |

Problema detectado: `Router` mezcla routing/dispatch con emision HTTP/JSON. Este es el refactor seleccionado para Semana 7.

## 3. Application

| Campo | Detalle |
|---|---|
| Archivos | `src/Application/UseCases/CreatePrescriptionUseCase.php`, `src/Application/DTO/CreatePrescriptionInput.php`, `src/Application/DTO/CreatePrescriptionResult.php` |
| Responsabilidad | Orquestar la creacion de prescripcion: cargar paciente, medicamento, alergias, aplicar validacion clinica, crear entidad, autorizar excepcion y persistir. |
| Dependencias | Contratos Repository, entidades de dominio, Value Objects, `AllergyConflictDetector`, excepciones de dominio. |
| Entrada | `CreatePrescriptionInput`. |
| Salida | `CreatePrescriptionResult` con exito/error, status code, mensaje y datos de prescripcion. |
| Capa | Application. |

Problema detectado: concentra bastante orquestacion, pero sigue siendo razonable para el alcance actual. No se selecciona para dividir en Semana 7.

## 4. Domain

| Campo | Detalle |
|---|---|
| Archivos | `Patient.php`, `Medication.php`, `Allergy.php`, `Prescription.php`, `PrescriptionAuthorization.php`, Value Objects y excepciones en `src/Domain`. |
| Responsabilidad | Modelar conceptos clinicos y reglas simples de validez. |
| Dependencias | No depende de Presentation ni Persistence. |
| Entrada | Datos normalizados desde Application. |
| Salida | Entidades y Value Objects validos o excepciones de dominio. |
| Capa | Domain. |

Problema detectado: no hay problema prioritario. La direccion de dependencias es correcta.

## 5. Clinical Validation

| Campo | Detalle |
|---|---|
| Archivos | `src/Domain/Services/AllergyConflictDetector.php`, `Dose.php`, `AdministrationRoute.php`, `Frequency.php` |
| Responsabilidad | Validar dosis, via, frecuencia y detectar conflicto por alergia critica contra medicamento. |
| Dependencias | Entidades `Medication` y `Allergy`; excepciones de dominio. |
| Entrada | Medicamento, alergias activas y strings de payload. |
| Salida | Alergia conflictiva, Value Objects validos o excepciones. |
| Capa | Domain / clinical validation. |

Problema detectado: no se modifica. Cambiar esta capa implicaria riesgo clinico innecesario para Semana 7.

## 6. Repository Contracts

| Campo | Detalle |
|---|---|
| Archivos | `src/Domain/Contracts/*RepositoryInterface.php` |
| Responsabilidad | Definir puertos para pacientes, medicamentos, alergias y prescripciones. |
| Dependencias | Entidades de dominio. |
| Entrada | Identificadores o entidades. |
| Salida | Entidades, listas o entidad persistida. |
| Capa | Domain contracts / ports. |

Problema detectado: contratos suficientes para el alcance actual. No requieren cambio en Fase 2A.

## 7. Persistence Adapters

| Campo | Detalle |
|---|---|
| Archivos | `PdoPatientRepository.php`, `PdoMedicationRepository.php`, `PdoAllergyRepository.php`, `PdoPrescriptionRepository.php` |
| Responsabilidad | Implementar contratos Repository usando PDO. |
| Dependencias | PDO, contratos de dominio, entidades y `PersistenceException`. |
| Entrada | IDs, entidades y conexion PDO. |
| Salida | Entidades cargadas o persistidas. |
| Capa | Persistence / adapters. |

Problema detectado: `PdoPrescriptionRepository` tambien escribe auditoria. Es aceptable porque la auditoria actual esta ligada a la transaccion de persistencia de prescripcion.

## 8. Audit

| Campo | Detalle |
|---|---|
| Archivos | `src/Persistence/Migrations/CreatePrescriptionAuditsTable.php`, `src/Persistence/Repositories/PdoPrescriptionRepository.php` |
| Responsabilidad | Persistir trazabilidad `authorized_exception` cuando una prescripcion se crea con excepcion autorizada. |
| Dependencias | SQLite/PDO y autorizacion de la entidad `Prescription`. |
| Entrada | `PrescriptionAuthorization`. |
| Salida | Fila en `prescription_audits`. |
| Capa | Persistence / audit. |

Problema detectado: no se modifica para no alterar transacciones ni evidencia clinica.

## 9. Database

| Campo | Detalle |
|---|---|
| Archivos | `ConnectionFactory.php`, migraciones, `DemoDataSeeder.php`, `database/prescripciones.sqlite`, `config/database.php` |
| Responsabilidad | Crear conexion, definir tablas y poblar datos demo. |
| Dependencias | PDO, configuracion, variables de entorno. |
| Entrada | Configuracion de base de datos y comandos CLI. |
| Salida | Base SQLite lista para pruebas/manual. |
| Capa | Infrastructure / database. |

Problema detectado: sin cambios. Semana 7 no modifica esquema, seeds ni almacenamiento.

## 10. Testing Adapters

| Campo | Detalle |
|---|---|
| Archivos | `tests/Fakes/*`, `tests/Runner.php`, `tests/Feature/*Test.php`, `tests/TestCase.php` |
| Responsabilidad | Probar comportamiento de UseCase y repositorios sin depender siempre de SQLite real. |
| Dependencias | Contratos Repository, entidades, UseCase y runner propio. |
| Entrada | Datos de prueba en memoria o SQLite temporal. |
| Salida | Resultados de pruebas y conteos `Tests`/`Failed`. |
| Capa | Tests / adapters. |

Problema detectado: tests protegen comportamiento principal. En Fase 2B se deben ejecutar antes y despues del refactor.
