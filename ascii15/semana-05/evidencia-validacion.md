# Semana 5 — Evidencia de validación

Resultados **reales** obtenidos en el worktree `shi-personal-asii15-s05-api-rest` sobre la rama `feature/week-05-api-rest-asii15-mar-03` (base `3383ac6`). No se modificó código para obtener estos resultados.

## 1. Entorno

```text
$ php -v
PHP 8.2.12 (cli) ...

$ git branch --show-current
feature/week-05-api-rest-asii15-mar-03
```

Servidor embebido PHP (`php -S`) en puerto libre (8000 estaba ocupado por el entorno de trabajo del repo de trabajo, por eso se usaron 8093–8095).

## 2. Migración y datos demo

```text
$ php bin/console.php migrate:fresh --seed
Migration completed
```

Se crean las 5 tablas (`patients`, `medications`, `allergies`, `prescriptions`, `prescription_audits`) y se siembran: `pat-safe`, `pat-allergic`, `med-para`, `med-amox` y la alergia crítica `pat-allergic / amoxicilina`.

## 3. Suite de pruebas

```text
$ php bin/console.php test
Tests: 6, Failed: 0
```

Casos: camino feliz (201), alergia crítica (409), error de persistencia (500), excepción autorizada (201), dosis inválida (422) y prueba de repositorios PDO reales.

```text
$ php bin/console.php test --filter=Mod15PrescriptionTest
Tests: 5, Failed: 0
```

## 4. Pruebas HTTP (contrato)

Peticiones reales con `curl` hacia el servidor embebido:

### A. GET /health → 200

```text
$ curl -s -w "%{http_code}" http://127.0.0.1:8093/health
{
  "status": 200,
  "data": { "health": "ok", "module": "mod15-prescriptions" }
}
200
```

### B. POST /prescriptions válida → 201

Body: `pat-safe` + `med-para` (paracetamol), `500 mg`, `oral`, `cada 8 horas`.

```text
201
message: "Prescription created"
exception_authorized: false
```

### C. Alergia crítica sin excepción → 409

Body: `pat-allergic` + `med-amox` (amoxicilina) sin excepción.

```text
409
message: "Critical allergy conflict detected"
prescription: []
```

### D. Excepción autorizada completa → 201

Body: `pat-allergic` + `med-amox` con `exception.authorized=true`, `reason` y `authorized_by="doctor-9"`.

```text
201
message: "Prescription created with authorized exception"
exception_authorized: true
```

### E. Excepción incompleta → 403

Body: `pat-allergic` + `med-amox` con `exception.authorized=true` pero sin `reason`/`authorized_by`.

```text
403
message: "Authorization is required for the exception"
```

### F. Dosis inválida → 422

Body: `dose = "abc"` con `pat-safe` + `med-para`.

```text
422
message: "Invalid dose"
```

### G. Ruta inexistente → 404

```text
$ curl -s -w "%{http_code}" http://127.0.0.1:8093/nonexistent
{
  "status": 404,
  "data": { "error": "Not found" }
}
404
```

Falla de persistencia (500): cubierta por la suite heredada `Mod15PdoRepositoryTest`/`Mod15PrescriptionTest` con repositorio InMemory configurado para fallar; no se fuerza en las pruebas HTTP.

## 5. Nota sobre PowerShell 5.1 y curl

Durante la validación en Windows/PowerShell 5.1 se observó que pasar el JSON **inline** con `curl -d '{"patient_id": ...}'` pierde el quoting (el shell reensambla los argumentos con espacios y comillas) y la petición llega sin cuerpo. **Es un problema de quoting del shell, NO del backend**: con el mismo servidor, usando un archivo JSON se obtienen los códigos esperados (201, 409, 403, 422).

Para reproducir la evidencia en PowerShell se recomienda:

```text
$ curl.exe -s -X POST http://127.0.0.1:8093/prescriptions -H "Content-Type: application/json" --data "@body.json"
```

donde `body.json` contiene el payload. En una shell POSIX (Linux/macOS/Git Bash) el JSON inline es válido.

## 6. Evidencia de persistencia (SQLite)

Estado de la base tras las pruebas HTTP (poblada por las peticiones válidas B y D; las 409, 403 y 422 no escriben nada):

```sql
SELECT COUNT(*) FROM prescriptions;        -- 2
SELECT COUNT(*) FROM prescription_audits;  -- 1
```

Filas reales observadas:

| id | patient_id | medication_id | exception_authorized_by |
|---|---|---|---|
| `rx_6aaa139022f3d2.26729010` | pat-safe | med-para | NULL |
| `rx_6aaa13c6e2f2b5.26302794` | pat-allergic | med-amox | doctor-9 |

Auditoría observada:

| prescription_id | action | reason | actor_id |
|---|---|---|---|
| `rx_6aaa13c6e2f2b5.26302794` | authorized_exception | Riesgo aceptado por especialista | doctor-9 |

**Confirmado**: prescripciones 409, 403 y 422 NO persisten; la excepción autorizada 201 persiste prescripción + auditoría `authorized_exception`.

> Nota: los IDs de prescripción son generados con `uniqid('rx_', true)` en cada ejecución y varían; los aquí mostrados son los observados en esta corrida.