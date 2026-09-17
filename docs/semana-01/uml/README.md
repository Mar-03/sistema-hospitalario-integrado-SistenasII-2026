# ASII-15 - Diagramas UML - Semana 1

Proceso individual: **"Creacion de prescripcion con verificacion previa de alergias"**.
Estudiante: MARIA DE LOS ANGELES LOPEZ FAJARDO (GitHub: Mar-03).
Modulo: ASII-15 Prescripciones Electronicas con Validacion de Alergias.

## Proposito de cada diagrama

| Archivo | Diagrama | Proposito |
|---|---|---|
| `casos-de-uso.puml` | Casos de uso | Limite del modulo, actor principal y comportamientos obligatorios (include) / condicionales (extend). |
| `actividad.puml` | Actividad | Orden de acciones y decisiones: flujo normal, flujo con alerta, modificacion/cancelacion y errores. |
| `secuencia.puml` | Secuencia | Interaccion entre el Medico y los participantes logicos del HIS durante el proceso. |

## Actor identificado

- **Medico** (actor principal). El rol `Medico` existe en `database/seeders/RoleSeeder.php` como `Médico`.

## Por que el Paciente no es actor

El paciente no interactua directamente con el modulo: es **una entidad sobre la que se consulta informacion** (tabla `patients`; sus alergias estan en `allergies` por `patient_id`). El medico lo selecciona para construir la receta. En UML un actor interactua con el sistema; el paciente es un sujeto de datos, por lo que no aparece como actor.

## Por que el HIS es el limite del sistema

El Sistema Hospitalario Integrado es el sistema que se modela; el modulo de prescripciones vive **dentro** del HIS (misma base de datos, mismos modelos). Un sistema no puede ser actor de su propio modulo. Por eso el HIS se representa como el rectangulo limite y no como actor.

## Relaciones include y extend

- **include (obligatorio):** la flecha va **del caso base hacia el caso incluido**. `Crear prescripcion electronica` incluye: seleccionar paciente, ingresar datos, seleccionar medicamento, validar medicamento contra alergias, confirmar y guardar. A su vez, `Validar medicamento contra alergias` incluye `Consultar alergias activas`.
- **extend (condicional):** la flecha va **del caso condicional hacia el caso base**. `Mostrar alerta de alergia` extiende a `Crear prescripcion electronica` solo cuando la validacion detecta una coincidencia. `Modificar prescripcion` extiende al mismo caso base durante la revision de la alerta.
- `Guardar prescripcion` solo ocurre tras confirmacion y con `blocked = false`; no se guarda una prescripcion bloqueada (campo real `prescriptions.blocked`).

## Flujo principal

1. Medico autenticado y autorizado selecciona un paciente existente.
2. Ingresa el medicamento del catalogo activo y los datos: dosis, frecuencia, duracion, via e indicaciones.
3. El sistema consulta las alergias activas del paciente y compara contra el medicamento.
4. Sin coincidencia: confirma, guarda e informa resultado exitoso.

## Flujos alternativos y excepciones

- Medico sin autorizacion: precondicion no cumplida; no inicia el proceso.
- Paciente inexistente o de otro tenant: se informa error y no continua.
- Datos de prescripcion incompletos: vuelve a ingresar datos.
- Medicamento inexistente o inactivo: se informa error y no continua.
- Error al consultar alergias: aborta el proceso.
- Paciente sin alergias registradas: sin coincidencia; continua como flujo normal.
- Coincidencia con alergia activa: alerta; el Medico modifica y revalida, o cancela.
- Error al guardar: se informa error y no se confirma exito.

## Elementos tomados del repositorio (existentes)

- Tablas y modelos: `patients`, `doctors`, `medications`, `allergies`, `prescriptions`, `soap_notes`, `medical_records` (migraciones `2026_04_26_100000` y `2026_04_26_120000`).
- Campos reales del proceso: `prescriptions.blocked`, `blocked_reason`, `electronic_sign`, `signed_at`; `allergies.active`; `medications.active`.
- Logica de validacion de referencia: `database/seeders/DemoDataSeeder2026.php:375-396` (comparacion de alergia contra `name`/`generic_name`; bloqueo y firma anulada cuando hay alergia).
- Roles: `Médico`, `Admin`, `Enfermera`, `TecnicoLab`, `Recepcionista` (`RoleSeeder.php`).
- Middleware reales: `tenant` (`X-Tenant-ID`) y `jwt.auth` (`bootstrap/app.php:16-20`).
- API base: `/api/v1` (`routes/api.php`) - solo autenticacion por ahora.

## Elementos que son propuestas de diseno (no implementados)

- `PrescriptionController` y rutas de prescripcion.
- Servicio de validacion de alergias en tiempo de ejecucion (hoy solo existe en el seeder).
- Interfaz Vue del modulo y pantalla de alerta.
- Capa de repositorios (hoy las consultas son directas con Eloquent).
- Permisos especificos y politica de autorizacion por rol (hoy solo existen roles).
- Escritura en `audit_logs` y notificacion `AllergyAlert`.

## Cinco preguntas para defensa oral

1. **Por que "Mostrar alerta de alergia" es extend y no include?**
   Porque no ocurre siempre: es un comportamiento condicional que se ejecuta solo si la validacion detecta una coincidencia con una alergia activa. Un include seria obligatorio en todos los casos.

2. **Por que el Paciente no aparece como actor?**
   Porque no interactua con el modulo; es la entidad sobre la que se consulta su historial de alergias. El actor humano del proceso es el Medico.

3. **Donde esta el soporte real de la validacion en el proyecto?**
   En el esquema (campo `blocked` de `prescriptions`) y en la logica de referencia del seeder `DemoDataSeeder2026.php:375-396`. El servicio en tiempo de ejecucion aun no existe: es una propuesta.

4. **Que ocurre si el Medico intenta guardar un medicamento que coincide con una alergia activa?**
   No se permite guardar con `blocked = false`; las opciones son modificar la prescripcion (revalidando alergias) o cancelarla. El Medico conserva la decision final; el sistema solo apoya.

5. **Como se garantiza la separacion por tenant?**
   Mediante el middleware `tenant` que exige la cabecera `X-Tenant-ID` y el middleware `jwt.auth` que verifica que el tenant del token coincida. Todas las tablas del proceso incluyen `tenant_id`.
