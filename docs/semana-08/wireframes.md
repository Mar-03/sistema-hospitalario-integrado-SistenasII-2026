# Semana 8 - Wireframes

Los wireframes son de baja fidelidad. No representan una UI implementada ni evidencian frontend funcional.

## 1. Prescripcion principal

| Campo | Detalle |
|---|---|
| Archivo | `docs/semana-08/wireframes/prescripcion-principal.puml` y `.png` |
| Proposito | Representar el formulario principal para enviar `POST /prescriptions`. |
| Actor | Medico. |
| Entrada | `patient_id`, `medication_id`, `doctor_id`, `dose`, `route`, `frequency`, `date` opcional. |
| Accion | Registrar prescripcion. |
| Endpoint relacionado | `POST /prescriptions`. |
| Resultado | `201`, `422` o `500`; `409` deriva al wireframe de alergia. |
| Estados | Inicial, completando, validando, exito, datos invalidos, error interno. |
| Limitaciones | No usa catalogos dinamicos porque no hay endpoints de pacientes, medicamentos ni medicos. |
| Integraciones futuras | Selectores/autocomplete, autenticacion, validaciones cliente enriquecidas. |

## 2. Alergia + excepcion autorizada

| Campo | Detalle |
|---|---|
| Archivo | `docs/semana-08/wireframes/alergia-excepcion.puml` y `.png` |
| Proposito | Representar respuesta `409` y decision del medico ante alergia critica. |
| Actor | Medico. |
| Entrada | Motivo (`reason`) y autorizador (`authorized_by`) si decide registrar excepcion. |
| Accion | Modificar, cancelar o reenviar `POST /prescriptions` con `exception`. |
| Endpoint relacionado | `POST /prescriptions`. |
| Resultado | `201` si excepcion completa, `403` si incompleta. |
| Estados | Alerta critica, no persistido, excepcion en edicion, exito con excepcion, autorizacion incompleta. |
| Limitaciones | No recomienda medicamento alternativo ni toma decisiones clinicas automaticas. |
| Integraciones futuras | Consulta previa de alergias, permisos de autorizador, auditoria visible en UI. |

## 3. Trazabilidad con backend

| Elemento UX | Backend real |
|---|---|
| Boton Registrar prescripcion | `POST /prescriptions`. |
| Mensaje de exito | `201`. |
| Alerta de alergia | `409`. |
| Excepcion incompleta | `403`. |
| Datos invalidos | `422`. |
| Error interno | `500`. |

## 4. Lo que no se representa como actual

- Selector dinamico de pacientes.
- Selector/autocomplete de medicamentos.
- Catalogo de medicos.
- Consulta previa de alergias.
- Historial/listado de prescripciones.
- Autenticacion/RBAC/JWT/tenancy.
