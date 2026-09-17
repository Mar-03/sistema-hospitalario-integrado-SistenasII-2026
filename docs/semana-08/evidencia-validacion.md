# Semana 8 - Evidencia de validacion

## 1. Baseline funcional

Comandos ejecutados desde el worktree S8 con PHP portable:

```text
php bin/console.php migrate:fresh --seed
Migration completed

php bin/console.php test
Tests: 6, Failed: 0

php bin/console.php test --filter=Mod15PrescriptionTest
Tests: 5, Failed: 0
```

Semana 8 no modifica backend, endpoints, payloads, reglas clinicas, persistencia ni auditoria.

## 2. Contrato usado para UX

Endpoints reales:

- `GET /health`.
- `POST /prescriptions`.

Payload real de `POST /prescriptions`:

- `patient_id`.
- `medication_id`.
- `doctor_id`.
- `dose`.
- `route`.
- `frequency`.
- `date` opcional.
- `exception` opcional: `authorized`, `reason`, `authorized_by`.

Codigos reales usados por los wireframes:

- `201` exito.
- `409` alergia critica.
- `403` excepcion incompleta.
- `422` datos invalidos.
- `500` error interno.

## 3. PlantUML

Wireframes fuente:

- `docs/semana-08/wireframes/prescripcion-principal.puml`.
- `docs/semana-08/wireframes/alergia-excepcion.puml`.

PNG generados:

- `docs/semana-08/wireframes/prescripcion-principal.png` (`820x432`, `16327` bytes).
- `docs/semana-08/wireframes/alergia-excepcion.png` (`804x358`, `14391` bytes).

Ambos wireframes fueron renderizados con PlantUML fuera del repositorio mediante:

```text
java -jar C:\Users\Omega20\Documents\tools\plantuml\plantuml.jar
```

Resultado de render: ambos comandos finalizaron correctamente y generaron PNG validos.

## 4. Correspondencia UX/API

| Wireframe | Endpoint | Estados representados |
|---|---|---|
| Prescripcion principal | `POST /prescriptions` | `201`, `422`, `500` y derivacion a `409`. |
| Alergia + excepcion | `POST /prescriptions` | `409`, reenvio con excepcion, `201`, `403`. |

## 5. Ausencia de endpoints de catalogo

Se confirma que no existen endpoints para listar o buscar pacientes, medicamentos, medicos, alergias ni prescripciones. Los wireframes no presentan estas capacidades como implementadas; cualquier selector dinamico queda como integracion futura.
