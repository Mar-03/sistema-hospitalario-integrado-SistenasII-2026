# Semana 5 — Integración con el HIS: implementado vs futuro

Este documento separa de forma explícita lo que el Micro-HIS ASII-15 **tiene implementado hoy** (ejecutable y verificado) de la **integración futura** con el Sistema Hospitalario Integrado (diseño). También desarrolla el análisis de **monolito vs microservicio** y el estado de **permisos**.

## 1. Estado implementado actualmente

El módulo es un micro-monolito educativo que vive en un único proceso PHP con su propia base de datos SQLite (`database/prescripciones.sqlite`). No consume servicios externos por red.

### 1.1 Datos con los que trabaja (locales, sembrados)

- **Pacientes** (`patients`) — sembrados: `pat-safe`, `pat-allergic`.
- **Medicamentos** (`medications`) — sembrados: `med-para`, `med-amox` (ambos activos).
- **Alergias** (`allergies`) — sembradas: alergia crítica de `pat-allergic` a `amoxicilina`.
- **Médicos**: NO hay tabla de médicos; el paylot solo trae `doctor_id`. No se valida identidad.
- **Prescripciones** (`prescriptions`) — entidad de salida del módulo.
- **Auditoría** (`prescription_audits`) — solo se escribe cuando hay excepción autorizada (`action = authorized_exception`).

### 1.2 Lo que produce el módulo

| Salida | Detalle real |
|---|---|
| Prescripción | fila en `prescriptions` (201) |
| Bloqueo clínico | respuesta 409, NO persiste |
| Excepción autorizada | prescripción 201 que persiste excepción + auditoría |
| Auditoría | fila en `prescription_audits` |

### 1.3 Persistencia

- `src/Persistence/Repositories/Pdo*.php` implementan los contratos de Domain con PDO y sentencias preparadas.
- `PdoPrescriptionRepository::save()` usa transacción y escribe prescripción y, si aplica, auditoría de forma atómica.
- Drivers soportados por `ConnectionFactory`: `sqlite` y `pgsql`; por defecto SQLite local (`MOD15_DB_DRIVER`/`MOD15_DB_PATH`).

## 2. Integración futura con el HIS (diseño conceptual)

La integración con el repositorio de datos compartido del HIS fue analizada en `docs/semana-04/repositorio-datos-compartido.md`. En el futuro, ASII-15 **consumiría**:

- datos de **paciente** (owner: módulo de pacientes);
- catálogo de **medicamentos** (owner: farmacia/catálogo);
- **alergias clínicas** del paciente (owner: historia clínica);
- **identidad/autorización del médico** (owner: identidad/usuarios).

E **produciría**:

- prescripción (owner: ASII-15);
- bloqueo clínico (efecto de validación);
- excepción autorizada (con auditoría);
- auditoría (consumida por el sistema de auditoría del HIS).

En ese escenario, los contratos de Repository (`*RepositoryInterface`) son el puerto que mantiene a `Domain` desacoplado de la fuente de datos: se sustituiría la implementación PDO local por adaptadores que consulten los servicios del HIS sin tocar dominio ni casos de uso. **Esta integración NO está implementada.**

## 3. Permisos

### 3.1 Estado actual (implementado)

Explicitamente:

- NO hay JWT.
- NO hay RBAC.
- NO hay middleware de autorización.
- NO hay tenancy funcional.
- `doctor_id` **no se autentica**: solo viaja como dato del payload.

La única protección que existe es de dominio: si hay alergia crítica y el cuerpo pide una excepción, esta debe traer `reason` y `authorized_by` no vacíos (si no, 403).

### 3.2 Diseño futuro (NO implementado)

- Médico **autorizado** para prescribir.
- Excepción clínica aprobada por la **autorización correspondiente**.
- Acceso **restringido** a la auditoría.

Este diseño se menciona como horizonte, nunca como funcionalidad actual.

## 4. Monolito vs microservicio

### 4.1 Contexto real

ASII-15 es un **micro-monolito educativo**: la consigna pide un "Micro-HIS", pero técnicamente es un proceso PHP único, sin framework, con BD local y sin comunicación entre servicios. Su nombre "micro" describe el alcance funcional, no una arquitectura de microservicios.

### 4.2 Factores a evaluar para decidir si convendría extraerlo como microservicio

| Factor | Análisis sobre el código real |
|---|---|
| Dependencia de pacientes / medicamentos / alergias | El caso de uso consulta estos datos siempre que crea una prescripción. Hoy viven en la misma BD; como microservicio requerirían llamadas síncronas o su replicación |
| Transacciones | `save()` persiste prescripción + auditoría en una transacción ACID local. Separado en servicios, la atomicidad exigiría transacciones distribuidas o saga |
| Consistencia clínica | El bloqueo por alergia es una regla crítica que depende de que paciente/alergia estén actualizados; en un microservicio habría ventana de inconsistencia entre módulos |
| Auditoría | Es parte de la misma escritura transaccional; en microservicios habría que garantizar entrega y trazabilidad de eventos |
| Despliegue | Hoy: `php -S` o un host con PHP. Como microservicio: contenedor, versión de API, ciclo de vida independiente |
| Observabilidad | Hoy: logs del servidor embebido. Un microservicio exigiría métricas, tracing y logs centralizados |
| Complejidad operativa | El monolito actual es trivial de operar; un microservicio suma despliegue, red, seguridad y gobernanza de contratos |

### 4.3 Decisión preliminar

**Mantener el módulo dentro del sistema/monolito integrado.** Justificación: el acoplamiento funcional con pacientes, medicamentos y alergias es alto, la regla de alergia requiere consistencia cercana a la escritura y la operación es simple. No se implementa microservicio.

### 4.4 Condiciones para una extracción futura

La posible salida como microservicio debería darse solo cuando existan:

- **contratos estables** (API madura entre módulos);
- **APIs maduras** de pacientes, catálogo, alergias e identidad;
- **identidad compartida** (sabemos qué paciente/medicamento se referencia);
- **estrategia de consistencia** (eventos, transacciones, tolerancia);
- **observabilidad** (métricas, tracing, logs);
- **despliegue independiente** (CI/CD, contenedores).

De nuevo: esto es análisis de diseño, no implementación.