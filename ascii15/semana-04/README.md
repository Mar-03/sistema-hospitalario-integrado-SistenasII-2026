# Semana 4 — Arquitectura en capas y patrón Repository

## Portada técnica

- Curso: Análisis de Sistemas II
- Sistema: Sistema Hospitalario Integrado
- Estudiante: MARIA DE LOS ANGELES LOPEZ FAJARDO
- GitHub: Mar-03
- Repositorio: `https://github.com/Mar-03/sistema-hospitalario-integrado-SistenasII-2026.git`
- Rama: `feature/week-04-capas-asii15-mar-03`
- Base: `origin/developer` (commit `50d4bba`, Semana 3 integrada vía PR #4)
- Worktree: `shi-personal-asii15-s04-capas`
- Módulo: Prescripciones electrónicas con validación de alergias
- Semana: 4

## 1. Consigna

Continuar el MISMO Micro-HIS "Prescripciones electrónicas con validación de alergias" y el flujo "creación de prescripción con verificación previa de alergias". Organizar la entrada con MVC; definir una interfaz Repository en el límite apropiado con adaptadores PDO e InMemory. El controlador no debe tener SQL ni reglas de negocio. Además, analizar y diagramar cómo un repositorio de datos compartido integraría este módulo. Entregable: capas, responsabilidades y objetos reutilizables.

## 2. Objetivo

Documentar la arquitectura en capas y el patrón Repository ya implementados en el Micro-HIS, validando el cumplimiento de: capas separadas, contratos en Domain, adaptadores PDO e InMemory, controlador limpio (sin SQL/PDO/reglas clínicas) y análisis de integración con un repositorio de datos compartido del HIS.

## 3. Continuidad con Semana 3

Semana 4 utiliza EXACTAMENTE el mismo Micro-HIS ya integrado en `developer` (PR #4). No se reimplementa código: las capas, repositorios, casos de uso, reglas y pruebas de Semana 3 se conservan intactas. La Semana 4 agrega evidencia documental y de análisis, no funcionalidad clínica nueva.

## 4. Organización MVC

La consigna pide organizar la entrada con MVC. El Micro-HIS no genera vistas HTML porque expone una interfaz tipo API; por lo tanto la "View" es una representación JSON. El mapeo se hace sobre el código real:

### Model

- Domain (`src/Domain/`): entidades, Value Objects, servicios y contratos (`Repository Interfaces`).
- Application (`src/Application/`): `CreatePrescriptionUseCase` y DTOs.

### Controller

- `src/Presentation/Controllers/PrescriptionController.php`: valida el payload HTTP a través de `CreatePrescriptionRequest` y delega en el caso de uso. No contiene SQL, ni PDO, ni reglas clínicas.

### View / Representation JSON

- La presentación del resultado se produce desde `src/Presentation/` y `routes/api.php`: la respuesta del caso de uso se serializa como array/JSON en el Controller y se entrega por el Router. No existen plantillas HTML porque el flujo está diseñado como API.

### Router

- `routes/api.php` + `src/Presentation/Router.php`: registran `GET /health` y `POST /prescriptions`, despachan la petición y devuelven la representación JSON.

## 5. Presentation

- `Router.php`: registro y despacho de rutas.
- `PrescriptionController`: entrada HTTP → validación → caso de uso → representación.
- `CreatePrescriptionRequest`: validación del payload (campos requeridos y mapeo).

## 6. Application

- `CreatePrescriptionUseCase`: orquesta el flujo de creación con validación previa de alergias.
- `CreatePrescriptionInput` / `CreatePrescriptionResult`: contratos de entrada y salida (DTOs).

## 7. Domain

- Entidades: `Patient`, `Medication`, `Allergy`, `Prescription`, `PrescriptionAuthorization`.
- Value Objects: `Dose`, `Frequency`, `AdministrationRoute`.
- Servicio: `AllergyConflictDetector`.
- Contratos: `PatientRepositoryInterface`, `MedicationRepositoryInterface`, `AllergyRepositoryInterface`, `PrescriptionRepositoryInterface`.
- Excepciones: `DomainException`, `PatientNotFoundException`, `MedicationNotFoundException`, `AllergyConflictException`, `InvalidDoseException`, `InvalidFrequencyException`, `InvalidRouteException`, `PersistenceException`.

Sin dependencia de PDO ni de ninguna infraestructura concreta.

## 8. Persistence

- `ConnectionFactory.php`: conexión PDO según entorno (`MOD15_DB_DRIVER`).
- Migraciones y seeder (`src/Persistence/Migrations/`, `src/Persistence/Seeders/`).
- Adaptadores PDO: `PdoPatientRepository`, `PdoMedicationRepository`, `PdoAllergyRepository`, `PdoPrescriptionRepository` (con sentencias preparadas y transacciones).

## 9. Patrón Repository

- El caso de uso depende de contratos definidos en `src/Domain/Contracts/` y NO de clases concretas.
- Las implementaciones viven en `src/Persistence/Repositories/` (adaptador PDO) y en `tests/Fakes/` (adaptadores InMemory para pruebas).
- Beneficios documentados: Dependency Inversion, desacoplamiento, testabilidad, sustitución de infraestructura y separación de responsabilidades.

## 10. Adaptador PDO

- Implementa los contratos de Domain usando PDO con `prepare()`/`execute()` y parámetros nombrados.
- `PdoPrescriptionRepository::save` usa transacción (`beginTransaction`/`commit`/`rollBack`) y persiste además el registro de auditoría (`prescription_audits`).
- Localización real: `src/Persistence/Repositories/Pdo*.php`.

## 11. Adaptador InMemory

- `tests/Fakes/InMemory*.php`: implementan los mismos contratos en memoria, permiten probar el caso de uso sin infraestructura y simular errores de persistencia (repositorio configurado para fallar).
- Pruebas que lo usan: `tests/Feature/Mod15PrescriptionTest.php`.

## 12. Dirección de dependencias

```text
Application / Domain  →  Repository Interface (en Domain)
                                   ^
Persistence → PDO / InMemory  implementan el contrato
```

- Alto nivel depende de abstracciones; los detalles (PDO, InMemory) dependen de las mismas abstracciones.
- `Domain` no conoce `Persistence` concreta; se cumple DIP.

## 13. Integración con repositorio de datos compartido

El análisis completo está en `ascii15/semana-04/repositorio-datos-compartido.md`. Resumen: ASII-15 se integra con datos del HIS compartido de forma de solo lectura para Pacientes, Alergias y Medicamentos (otros módulos son owners), y es owner/responsable de Prescripciones; genera eventos de Auditoría que gestiona el sistema de auditoría. Los contratos de Repository son el puerto que mantiene a Domain desacoplado de la fuente de datos.

## 14. Objetos reutilizables

Ver `ascii15/semana-04/objetos-reutilizables.md` con el inventario real (DTOs, entidades, Value Objects, contratos, adaptadores PDO e InMemory, excepciones) y dónde se reutilizan.

## 15. Pruebas heredadas

Son las pruebas existentes del Micro-HIS (no se agregó comportamiento clínico nuevo):

- camino feliz (`201`);
- alergia crítica (`409`);
- error de persistencia (`500`);
- excepción autorizada (`201`);
- dosis inválida (`422`);
- PDO real (`Mod15PdoRepositoryTest`).

Resultado esperado: `Tests: 6, Failed: 0`; filtro `Mod15PrescriptionTest`: `5, Failed: 0`. Ver números reales en la sección Evidencias.

## 16. Evidencias

- `ascii15/semana-04/README.md`
- `ascii15/semana-04/responsabilidades.md`
- `ascii15/semana-04/objetos-reutilizables.md`
- `ascii15/semana-04/repositorio-datos-compartido.md`
- `ascii15/semana-04/evidencia-git.md`
- `ascii15/semana-04/diagramas/arquitectura-capas.puml` (+ PNG)
- `ascii15/semana-04/diagramas/repositorio-datos-compartido.puml` (+ PNG)

Comandos y resultados reales en `evidencia-git.md`.

## 17. Fuera de alcance

- No se reimplementa ninguna pieza del Micro-HIS.
- No se crea interfaz gráfica/HTML artificial.
- No se implementan nuevas interfaces, adaptadores ni funcionalidad clínica.
- No se integran APIs externas reales (no existen en el código); la integración con el HIS es una PROPUESTA de diseño.
- No se trabaja Semana 5 ni se toca `main`, `developer`, `feat/mod15-prescripciones-vanilla` ni Semana 3.