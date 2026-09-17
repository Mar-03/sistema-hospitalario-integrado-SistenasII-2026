# Semana 10 - Responsive y adaptacion de interfaz

## 1. Objetivo

Semana 10 documenta y representa como los wireframes revisados de Semana 9 se adaptan conceptualmente a escritorio, tablet y movil.

No se implemento frontend responsive real. No se agrego HTML, CSS, JavaScript, backend, endpoints ni logica nueva. El alcance es documentacion responsive y wireframes adaptados de baja fidelidad.

## 2. Continuidad con S8 y S9

- Semana 8 define el flujo UX inicial.
- Semana 9 mejora usabilidad, accesibilidad conceptual, mensajes y jerarquia clinica.
- Semana 10 conserva los criterios de Semana 9 y analiza su adaptacion a diferentes anchos de pantalla.

## 3. Principios responsive

- Evitar scroll horizontal conceptual.
- Conservar etiquetas visibles y campos obligatorios.
- Mantener ayudas y errores cerca del campo correspondiente.
- Priorizar legibilidad sobre densidad.
- Apilar acciones cuando el ancho sea limitado.
- Mantener visible la alerta clinica critica y la no persistencia.

## 4. Estrategia por dispositivo

| Contexto | Estrategia |
|---|---|
| Escritorio | Layout amplio, agrupacion por bloques y hasta dos columnas cuando exista espacio. |
| Tablet | Transicion intermedia, una o dos columnas segun espacio disponible y prioridad en legibilidad. |
| Movil | Flujo vertical, una columna, acciones apiladas y campos a ancho disponible. |

Los breakpoints exactos se definiran cuando exista frontend real.

## 5. Adaptacion del formulario

Campos del contrato real:

- `patient_id`.
- `medication_id`.
- `doctor_id`.
- `dose`.
- `route`.
- `frequency`.
- `date` opcional.

En escritorio se propone separar identificacion y datos clinicos. En movil todos los campos deben apilarse para evitar scroll horizontal.

## 6. Adaptacion de la alerta clinica

Debe mantenerse el contenido critico:

- `ALERTA CLINICA CRITICA: ALERGIA`.
- `Se detecto un conflicto de alergia.`
- `LA PRESCRIPCION NO FUE REGISTRADA.`

En movil las acciones deben apilarse y la excepcion autorizada debe quedar debajo de la alerta.

## 7. Accesibilidad preservada

- Etiquetas visibles.
- Obligatoriedad textual.
- Mensajes explicitos.
- No depender solo del color.
- Errores asociados al campo.
- Orden logico.
- Acciones con nombres claros.

## 8. Wireframes generados

| Wireframe | Proposito |
|---|---|
| `wireframes/prescripcion-desktop.puml` + PNG | Adaptacion de formulario a escritorio con bloques y dos columnas conceptuales. |
| `wireframes/prescripcion-mobile.puml` + PNG | Adaptacion movil de formulario en una columna. |
| `wireframes/alerta-mobile.puml` + PNG | Adaptacion movil de alerta clinica y excepcion autorizada. |

## 9. Limitaciones

No existen endpoints de catalogo para pacientes, medicamentos, medicos, alergias ni historial de prescripciones. Por eso los IDs siguen representados como ingreso manual y no como selectores funcionales.

## 10. Evidencias

- Baseline funcional: `Migration completed`, tests generales `6/6`, tests especificos `5/5`.
- Tres wireframes PlantUML/SALT renderizados a PNG.
- Validacion de que Semana 10 no modifica backend, frontend real ni Semanas 8/9.

## 11. Rama/worktree

- Rama: `feature/week-10-responsive-asii15-mar-03`.
- Worktree: `shi-personal-asii15-s10-responsive`.
- Base: `origin/developer` en `d51c90b21be5843c0aa9fa3a492a25c2edb1643b`.
- Merge-base inicial: `d51c90b21be5843c0aa9fa3a492a25c2edb1643b`.
- Estado inicial: `0 0` contra `origin/developer`.
