# Semana 5 — Contrato REST del Micro-HIS ASII-15

Este documento describe el contrato REST **real** del módulo. Fue extraído del código (sin inventar reglas) y confirmado ejecutando el servidor. La entrada es el front controller `public/index.php`, que registra las rutas en `src/Presentation/Router.php`; `routes/api.php` funciona como mapa documental de la API.

## 1. Formato general de respuesta

Todas las respuestas usan `Content-Type: application/json` con la forma:

```json
{
  "status": <código HTTP>,
  "data": { ... }
}
```

La serialización la produce `src/Presentation/Router.php::respond()`.

## 2. GET /health

- Método: GET
- Ruta: `/health`
- HTTP: 200
- Formato real:

```json
{
  "status": 200,
  "data": {
    "health": "ok",
    "module": "mod15-prescriptions"
  }
}
```

Indica que el módulo está operativo. No consulta base de datos ni reglas de negocio.

## 3. POST /prescriptions

Crea una prescripción electrónica tras validar el paciente, el medicamento (existente y activo), los Value Objects y las alergias activas del paciente.

### 3.1 Payload

```json
{
  "patient_id": "pat-safe",
  "medication_id": "med-para",
  "doctor_id": "doc-1",
  "dose": "500 mg",
  "route": "oral",
  "frequency": "cada 8 horas",
  "exception": {
    "authorized": true,
    "reason": "Riesgo aceptado por especialista",
    "authorized_by": "doctor-9"
  }
}
```

Si se omite `date`, el servidor usa su fecha local (`date('Y-m-d')`); no hay una fecha fija en el contrato.

### 3.2 Campos obligatorios

Requeridos por `src/Presentation/Requests/CreatePrescriptionRequest.php` (deben existir en el JSON y no ser cadena vacía):

| Campo | Tipo | Significado |
|---|---|---|
| `patient_id` | string | Identificador del paciente |
| `medication_id` | string | Identificador del medicamento |
| `doctor_id` | string | Identificador del médico que prescribe |
| `dose` | string | Dosis (ej. `500 mg`) |
| `route` | string | Vía de administración |
| `frequency` | string | Frecuencia (ej. `cada 8 horas`) |

Si falta alguno o llega vacío, la respuesta es **422** con `message: "Missing field: <campo>"`.

### 3.3 Campos opcionales

| Campo | Tipo | Default real |
|---|---|---|
| `date` | string (YYYY-MM-DD) | `date('Y-m-d')` del servidor (fecha local del entorno). NO es una fecha fija del contrato |
| `exception` | objeto | sin entrega equivale a excepción no solicitada |

### 3.4 Estructura de `exception`

```json
{
  "authorized": false,
  "reason": null,
  "authorized_by": null
}
```

- `authorized`: boolean. Default `false`. Se interpreta con `(bool)` en `CreatePrescriptionInput::fromArray`, por lo que el contrato espera un booleano JSON real.
- `reason`: string con la justificación clínica.
- `authorized_by`: string con quién autoriza (rol o identificador).

### 3.5 Respuesta de éxito (201)

```json
{
  "status": 201,
  "data": {
    "message": "Prescription created",
    "prescription": {
      "id": "rx_...",
      "patient_id": "pat-safe",
      "medication_id": "med-para",
      "dose": "500 mg",
      "route": "oral",
      "frequency": "cada 8 horas",
      "date": "<YYYY-MM-DD de la fecha local del servidor>",
      "exception_authorized": false
    }
  }
}
```

Con excepción autorizada, `message` es `"Prescription created with authorized exception"` y `exception_authorized` es `true`.

## 4. Validaciones reales

| Regla | Implementación real | Respuesta |
|---|---|---|
| Campos obligatorios presentes | `CreatePrescriptionRequest::validated()` | 422 |
| `dose` válida | `Dose::fromString()` — patrón `^\d+(?:\.\d+)?\s?[a-zA-Z][a-zA-Z0-9\/\-%]*$` (número + unidad) | 422 |
| `route` válida | `AdministrationRoute::fromString()` — lista fija: `oral`, `iv`, `im`, `subcutanea`, `topica`, `inhalada` | 422 |
| `frequency` válida | `Frequency::fromString()` — `cada N horas`, `cada N dias`, `1 vez al dia` | 422 |
| paciente existe | `PatientRepositoryInterface::findById` | 422 |
| medicamento existe y está activo | `MedicationRepositoryInterface::findById` + campo `active` | 422 |
| conflicto de alergia crítica | `AllergyConflictDetector::detect()` — alergia activa de severidad `critica` cuya sustancia coincide (como subcadena, sin distinguir mayúsculas) con el nombre o el principio activo del medicamento | 409 / 403 / 201 según excepción |

Coherencia con el código: todas las excepciones de dominio (`InvalidDoseException`, `InvalidFrequencyException`, `InvalidRouteException`, `PatientNotFoundException`, `MedicationNotFoundException`) heredan de `DomainException` y se traducen a **422** en `CreatePrescriptionUseCase`.

## 5. Códigos HTTP reales

| Código | Cuándo ocurre |
|---|---|
| 200 | `GET /health` |
| 201 | Prescripción creada (sin conflicto o con excepción autorizada completa). En este segundo caso se persiste la prescripción y se registra auditoría |
| 403 | Hay conflicto crítico y `exception.authorized = true`, pero `reason` o `authorized_by` están vacíos: se exige autorización para la excepción |
| 404 | Ruta no registrada en el Router (`router not found`) |
| 409 | Conflicto de alergia crítica sin excepción autorizada. La prescripción NO se persiste |
| 422 | Campo obligatorio faltante o vacío, o regla de dominio inválida (dose/route/frequency, paciente inexistente, medicamento inexistente o inactivo) |
| 500 | Falla de persistencia (`PersistenceException`) en `save()` o error inesperado del servidor. Caso cubierto en las pruebas con repositorio InMemory que falla |

No se documentan otros códigos porque el código no los produce.

## 6. Límites del contrato actual

- No existen endpoints de lectura: no hay catálogos de pacientes/medicamentos por API ni listado de prescripciones. Los datos se cargan con `DemoDataSeeder` (SQLite local).
- No existe autenticación en ninguna ruta; `doctor_id` solo registra un dato.
- El servidor de desarrollo es HTTP plano; la producción requeriría TLS y despliegue adecuado (fuera de alcance de esta semana).