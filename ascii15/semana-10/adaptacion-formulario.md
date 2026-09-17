# Semana 10 - Adaptacion del formulario

## 1. Campos

El formulario debe seguir representando el contrato real de `POST /prescriptions`:

- `patient_id`.
- `medication_id`.
- `doctor_id`.
- `dose`.
- `route`.
- `frequency`.
- `date` opcional.

## 2. Escritorio

Bloque Identificacion:

- `patient_id`.
- `medication_id`.
- `doctor_id`.

Bloque Prescripcion:

- `dose`.
- `route`.
- `frequency`.
- `date`.

Cuando exista espacio suficiente:

- `dose` y `route` pueden ir lado a lado.
- `frequency` y `date` pueden ir lado a lado.

## 3. Tablet

La tablet puede mantener una o dos columnas segun espacio. La decision debe priorizar que etiquetas, ayudas y errores sigan visibles y comprensibles.

## 4. Movil

Todos los campos deben apilarse:

1. `patient_id`.
2. `medication_id`.
3. `doctor_id`.
4. `dose`.
5. `route`.
6. `frequency`.
7. `date`.
8. Registrar prescripcion.

No debe existir scroll horizontal conceptual.

## 5. IDs tecnicos

`patient_id`, `medication_id` y `doctor_id` siguen siendo ingreso manual porque el backend actual no expone catalogos.

No se convierten en selectores funcionales. La busqueda, autocomplete, nombre visible y selector remoto quedan como integraciones futuras.

## 6. Accesibilidad y errores

Se preserva:

- Etiqueta visible.
- `*` para obligatorio.
- Ayuda cercana al campo.
- Error contextual cerca del campo.
- Mensajes entendibles sin codigos HTTP como texto principal.
