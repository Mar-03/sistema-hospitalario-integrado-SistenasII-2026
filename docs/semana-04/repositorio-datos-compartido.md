# Semana 4 — Repositorio de datos compartido: integración de ASII-15 con el HIS

## Contexto y distinción ACTUAL vs PROPUESTA

- **ACTUAL:** el Micro-HIS ASII-15 es una aplicación independiente con su propia base SQLite/PostgreSQL (tablas `patients`, `medications`, `allergies`, `prescriptions`, `prescription_audits`) accedida mediante repositorios PDO.
- **PROPUESTA:** integración futura de ASII-15 con un repositorio de datos compartido del Sistema Hospitalario Integrado (HIS), manteniendo Domain desacoplado de la fuente de datos.

No se afirma que existan APIs o módulos externos implementados: esta sección es análisis de diseño.

## 1. Datos que necesita ASII-15

El flujo "creación de prescripción con verificación previa de alergias" requiere:

- paciente (identidad y contexto/tenant);
- medicamento (catalogo activo);
- alergias activas del paciente;
- prescripciones (creación);
- auditoría (eventos del flujo).

## 2. Pacientes

- **OWNER:** módulo de pacientes del HIS.
- **QUIÉN LEE:** ASII-15 (solo lectura).
- **QUIÉN ESCRIBE:** módulo de pacientes.
- **IDENTIFICADOR:** `patient_id` (ver §8 IDs compartidos).
- **DEPENDENCIA:** ASII-15 no crea pacientes; consulta únicamente los que existen en el tenant.

## 3. Alergias

- **OWNER:** módulo de alergias.
- **QUIÉN LEE:** ASII-15 (solo lectura; consulta de alergias activas antes de confirmar).
- **QUIÉN ESCRIBE:** módulo de alergias.
- **IDENTIFICADOR:** `allergy_id` asociado a `patient_id` y `substance`.
- **DEPENDENCIA:** la regla `AllergyConflictDetector` depende de este dataset para bloquear (409) o autorizar excepciones.

## 4. Medicamentos

- **OWNER:** catálogo de medicamentos.
- **QUIÉN LEE:** ASII-15 (solo lectura).
- **QUIÉN ESCRIBE:** catálogo de medicamentos.
- **IDENTIFICADOR:** `medication_id` con nombre comercial y genérico (`substance`).
- **DEPENDENCIA:** validación de medicamento activo y comparación genérica con alergias.

## 5. Prescripciones

- **OWNER/responsable funcional:** ASII-15.
- **QUIÉN LEE:** ASII-15 y módulos que requieran historial clínico de prescripciones.
- **QUIÉN ESCRIBE:** ASII-15 (crea la prescripción solo cuando la validación no bloquea).
- **IDENTIFICADOR:** `prescription_id` (UUID conceptual, ver §8).
- **DEPENDENCIA:** referencia `patient_id`, `medication_id`, `doctor_id` y datos de prescripción.

## 6. Auditoría

- **OWNER del registro:** sistema de auditoría del HIS.
- **QUIÉN LEE/ESCRIBE:** ASII-15 **genera** el evento (p. ej. `authorized_exception` en `prescription_audits`); el sistema de auditoría conserva/gestiona el registro.
- **DEPENDENCIA:** trazabilidad del flujo (excepción autorizada, motivo, responsable).

## 7. Ownership de datos (resumen)

| Dato | Owner | ASII-15 lee | ASII-15 escribe |
|---|---|---|---|
| Pacientes | Módulo de pacientes | Sí | No |
| Alergias | Módulo de alergias | Sí | No |
| Medicamentos | Catálogo de medicamentos | Sí | No |
| Prescripciones | ASII-15 | Sí | Sí |
| Auditoría | Sistema de auditoría | — | Genera eventos |

## 8. Identificadores compartidos

- Se recomienda que las entidades raíz usen identificadores estables, conceptualmente UUID, para evitar colisiones e integrarse con un HIS multi-módulo.
- Las relaciones (paciente→alergias, prescripción→paciente/medicamento) deben referenciar los mismos identificadores del repositorio compartido.
- El Micro-HIS actual usa id cortos demo (`pat-1`, `med-1`); en la propuesta los ids deben resolverse contra el repositorio compartido.

## 9. Tenant

- Toda consulta/escritura debe filtrar por `tenant_id` (o contexto equivalente) para aislar datos entre instituciones/tenants. El Micro-HIS actual usa un único tenant demo.

## 10. Consistencia

- ASII-15 valida el pacientry y el medicamento antes de escribir; ante inconsistencia debe responder un error controlado sin crear prescripciones.
- La regla de alergias debe consultar alergias activas "al momento de confirmar" para reducir ventanas de inconsistencia.

## 11. Integridad referencial

- Si el repositorio es relacional: claves foráneas entre prescripción→paciente y prescripción→medicamento.
- Si el repositorio es distribuido (cada módulo con su BD): la integridad se preserva por referencias de datos/contracts y por validación previa, no por FKs cruzadas.

## 12. Transacciones

- La escritura de ASII-15 es atómica: crear prescripción y registrar su auditoría (ya implementado con `beginTransaction/commit/rollBack` en `PdoPrescriptionRepository`).
- En un esquema compartido no deben mezclarse transacciones de módulos externos dentro del flujo de ASII-15.

## 13. Concurrencia

- Bloqueo por alergia: dos prescripciones simultáneas para el mismo paciente deben evaluar alergias en el momento de la confirmación (optimistic check) y persistir solo la que pase validación.
- El guardado con excepción autorizada debe ser serializable para evitar dobles autorizaciones inconsistentes.

## 14. Seguridad y datos clínicos sensibles

- Los datos de pacientes/alergias/prescripciones son sensibles: acceso por rol (Medico), cifrado en tránsito, mínimo privilegio, y registros de auditoría inmutables.
- No usar datos clínicos reales en evidencias (todo demo/ficticio), tal como se mantiene en el repositorio.

## 15. Riesgo de acoplamiento por BD compartida

- Compartir la misma base física entre módulos genera acoplamiento físico: esquemas, FKs, permisos y releases acopladas.
- Mitigación: exponer los datos mediante contratos/ports de Repository (ya definidos en `Domain\Contracts`) en lugar de tablas directas de cada módulo.

## 16. Dependency Inversion y Repository/ports

- Ya implementado: `Application`/`Domain` dependen de `*RepositoryInterface`; `Persistence` implementa esos contratos (adaptadores PDO e InMemory).
- En el HIS compartido, los adaptadores seguirían implementando los mismos contratos pero resolviendo datos desde los repositorios/APIs de los módulos propietarios (pacientes, alergias, medicamentos).
- Domain permanece intacto al cambiar la fuente de datos: la sustitución se hace en la capa de adaptadores.

## 17. Evolución a API/servicios sin modificar Domain

- Los contratos de repositorio son el "port"; los "adapters" podrían cambiar de PDO a consumidores HTTP/API de otros módulos sin tocar `CreatePrescriptionUseCase` ni `AllergyConflictDetector`.
- Los adapters traducirían el contrato interno a llamadas del HIS (REST/RPC/mensajería) y mapearían las respuestas a entidades/Value Objects del dominio.
- Este diseño deja abierta la migración de "BD compartida" a "servicios" con cambios solo en `Persistence`/adapters.

## Resumen gráfico

Ver `docs/semana-04/diagramas/repositorio-datos-compartido.puml` (+ PNG): HIS compartido → Repository Ports → Application ASII-15 → Domain → Prescripciones (owner ASII-15) → Auditoría, con relaciones etiquetadas LEE / ESCRIBE / OWNER.