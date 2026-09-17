# Semana 11 - Alcance del mockup

## Incluye

- Formulario visual de prescripcion.
- Estado inicial.
- Estado de exito.
- Estado de validacion.
- Alerta clinica critica.
- Excepcion autorizada.
- Excepcion incompleta.
- Error tecnico.
- Adaptacion responsive del prototipo.

## No incluye

- Conexion API.
- Solicitudes de red.
- Persistencia.
- Autenticacion.
- JWT.
- RBAC.
- Catalogo de pacientes.
- Catalogo de medicamentos.
- Catalogo de medicos.
- Historial de prescripciones.
- Busquedas reales.
- Frontend productivo.

## Contrato representado

El formulario visual conserva los campos reales del contrato `POST /prescriptions`:

- `patient_id`.
- `medication_id`.
- `doctor_id`.
- `dose`.
- `route`.
- `frequency`.
- `date` opcional.

La excepcion autorizada representa los campos reales:

- `reason`.
- `authorized_by`.

## Limitacion por backend

Como no existen endpoints de catalogo, los campos `patient_id`, `medication_id` y `doctor_id` se mantienen como entrada directa. Las busquedas, nombres visibles y selectores remotos quedan como mejoras futuras.
