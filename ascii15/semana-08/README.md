# Semana 8 - UX y Wireframes

## 1. Objetivo

Semana 8 define el flujo de experiencia de usuario y wireframes de baja fidelidad para el modulo ASII-15: Prescripciones electronicas con validacion de alergias. No implementa frontend ni modifica backend. El objetivo es traducir el contrato real del Micro-HIS a una propuesta UX coherente, trazable y limitada al comportamiento disponible.

## 2. Contexto acumulado

El modulo ya cuenta con:

- Requisitos, actores y casos de uso documentados desde Semana 1.
- Requisitos funcionales/no funcionales y criterios de aceptacion de Semana 2.
- Backend PHP 8.2+ por capas con Repository, SQLite y pruebas.
- Contrato REST documentado en Semana 5.
- Checkpoint del Primer Parcial en Semana 6.
- Refactor interno de Semana 7 separando `JsonResponseEmitter` del `Router`.

Semana 8 se apoya en ese backend, pero no crea UI funcional.

## 3. Actor principal

Actor principal documentado: `Medico`.

- El medico es el usuario conceptual que registra la prescripcion.
- El paciente es una entidad procesada/consultada, no un actor directo.
- El HIS es el limite del sistema, no un actor externo.

## 4. Backend disponible

Implementado en backend:

| Endpoint | Estado | Uso UX |
|---|---|---|
| `GET /health` | Implementado | Verificar disponibilidad del modulo. |
| `POST /prescriptions` | Implementado | Crear prescripcion, validar alergias y registrar excepcion autorizada si aplica. |

Payload real de `POST /prescriptions`:

- `patient_id`.
- `medication_id`.
- `doctor_id`.
- `dose`.
- `route`.
- `frequency`.
- `date` opcional.
- `exception` opcional con `authorized`, `reason`, `authorized_by`.

Codigos reales: `200`, `201`, `403`, `404`, `409`, `422`, `500`.

## 5. Limitaciones actuales

No implementado actualmente:

- Frontend real.
- Autenticacion real.
- JWT/RBAC/tenancy funcional.
- API de pacientes.
- API de medicamentos.
- API de medicos.
- API de alergias.
- Historial/listado de prescripciones.

Por eso los wireframes no representan selectores dinamicos como funcionalidad actual. Cuando muestran seleccion o ingreso, se documenta como entrada de IDs al contrato existente o como integracion futura.

## 6. Flujo UX

Flujo principal:

1. Medico abre formulario.
2. Ingresa `patient_id`.
3. Ingresa `medication_id`.
4. Ingresa `doctor_id`.
5. Ingresa `dose`.
6. Selecciona/ingresa `route`.
7. Ingresa `frequency`.
8. Opcionalmente ingresa `date`.
9. Envia formulario.
10. UI hace `POST /prescriptions`.
11. Backend valida.
12. UI interpreta respuesta.

Ramas principales:

- `201`: mostrar confirmacion.
- `409`: mostrar alerta critica de alergia.
- `403`: indicar autorizacion incompleta.
- `422`: indicar datos invalidos.
- `500`: informar error interno.

Detalle: `ascii15/semana-08/flujo-usuario.md`.

## 7. Wireframes realizados

Se crean dos wireframes de baja fidelidad:

| Wireframe | Archivo | Proposito |
|---|---|---|
| Prescripcion principal | `wireframes/prescripcion-principal.puml` + PNG | Registrar los datos que el backend acepta y mostrar estados 201/422/500. |
| Alergia + excepcion autorizada | `wireframes/alergia-excepcion.puml` + PNG | Representar 409, decision del medico y reenvio con excepcion autorizada o incompleta. |

No son pantallas implementadas. Son artefactos de diseno UX de baja fidelidad.

## 8. Integraciones futuras

Quedan como integracion futura:

- Selector dinamico de pacientes.
- Busqueda/autocomplete de medicamentos.
- Catalogo de medicos/autorizadores.
- Consulta previa de alergias.
- Listado/historial de prescripciones.
- Autenticacion y autorizacion real.
- UI implementada en framework o HTML.

## 9. Evidencias

- Baseline funcional: `Migration completed`, tests `6/6`, filtro `Mod15PrescriptionTest 5/5`.
- Wireframes PlantUML renderizados a PNG.
- Trazabilidad con `POST /prescriptions` y respuestas HTTP reales.
- Evidencia: `ascii15/semana-08/evidencia-validacion.md` y `ascii15/semana-08/evidencia-git.md`.

## 10. Rama/worktree

- Rama: `feature/week-08-ux-wireframes-asii15-mar-03`.
- Worktree: `shi-personal-asii15-s08-ux-wireframes`.
- Base: `origin/developer` en `b48a35c2be9eaf9c10ff3091664ef895a8c74b48`.
- Merge-base inicial: `b48a35c2be9eaf9c10ff3091664ef895a8c74b48`.
- Estado inicial: `0 0` contra `origin/developer`.
