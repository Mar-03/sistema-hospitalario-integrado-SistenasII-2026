# Semana 7 - Evidencia de validacion

## 1. Alcance

Esta evidencia demuestra que Semana 7 aplica un refactor estructural y no una funcionalidad nueva. El objetivo es separar la emision HTTP/JSON del Router preservando comportamiento observable.

## 2. Baseline historico confirmado

La ultima validacion funcional previa a Semana 7 correspondia a Semana 5:

```text
Migration completed
Tests generales: 6/6
Tests especificos Mod15PrescriptionTest: 5/5
```

Contrato historicamente confirmado:

| Caso | Resultado |
|---|---|
| `GET /health` | `200` |
| `POST /prescriptions` valida | `201` |
| Alergia critica sin excepcion | `409` |
| Excepcion autorizada completa | `201` |
| Excepcion incompleta | `403` |
| Datos invalidos | `422` |
| Ruta inexistente | `404` |
| Falla de persistencia | `500` por prueba automatizada |

## 3. Entorno preparado para Fase 2B

PHP portable fuera del repositorio:

```text
C:\Users\Omega20\Documents\tools\php-8.3\php.exe
PHP 8.3.33
```

Extensiones confirmadas por `php -m`:

- `PDO`.
- `pdo_sqlite`.
- `sqlite3`.
- `json`.

Prueba SQLite previa:

```text
new PDO('sqlite::memory:') -> ok
```

PlantUML fuera del repositorio:

```text
C:\Users\Omega20\Documents\tools\plantuml\plantuml.jar
PlantUML 1.2026.8
```

## 4. Baseline pre-refactor

Antes de modificar `Router` se ejecuto:

```text
Migration completed
Tests: 6, Failed: 0
Tests: 5, Failed: 0
```

HTTP pre-refactor:

| Caso | Resultado |
|---|---|
| `GET /health` | `200` |
| `POST /prescriptions` valida | `201` |
| Alergia critica sin excepcion | `409` |
| Excepcion autorizada completa | `201` |
| Excepcion incompleta | `403` |
| Dosis invalida | `422` |
| Ruta inexistente | `404` |
| Falla de persistencia | `500` por prueba automatizada |

Persistencia pre-refactor:

```text
prescriptions=2
prescription_audits=1
```

## 5. Validacion post-refactor

Lint:

```text
No syntax errors detected in src\Presentation\Responses\JsonResponseEmitter.php
No syntax errors detected in src\Presentation\Router.php
```

Pruebas:

```text
Migration completed
Tests: 6, Failed: 0
Tests: 5, Failed: 0
```

HTTP post-refactor:

| Caso | HTTP | JSON `status` | `status`/`data` presentes |
|---|---:|---:|---|
| `GET /health` | `200` | `200` | si |
| `POST /prescriptions` valida | `201` | `201` | si |
| Alergia critica sin excepcion | `409` | `409` | si |
| Excepcion autorizada completa | `201` | `201` | si |
| Excepcion incompleta | `403` | `403` | si |
| Dosis invalida | `422` | `422` | si |
| Ruta inexistente | `404` | `404` | si |

Persistencia post-refactor:

```text
prescriptions=2
prescription_audits=1
```

## 6. Comparacion antes/despues

| Aspecto | Antes | Despues |
|---|---|---|
| Tests generales | `6/6` | `6/6` |
| Tests especificos | `5/5` | `5/5` |
| Contrato HTTP | `200`, `201`, `409`, `201`, `403`, `422`, `404` | Igual |
| Error persistencia | `500` por test | Igual |
| JSON | `status` + `data` | Igual |
| Prescripciones persistidas | `2` | `2` |
| Auditorias | `1` | `1` |
| `authorized_exception` | `1` | `1` |

Conclusion: estructura modificada, comportamiento preservado.
