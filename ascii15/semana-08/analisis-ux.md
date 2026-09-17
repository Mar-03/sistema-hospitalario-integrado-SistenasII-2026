# Semana 8 - Analisis UX

## 1. Usuario principal

Usuario principal: `Medico`.

El medico registra la prescripcion y recibe retroalimentacion del sistema sobre validaciones de datos, conflictos de alergia y resultados de persistencia.

## 2. Objetivo UX

Permitir que el medico complete los datos requeridos para crear una prescripcion electronica y comprenda claramente el resultado de la validacion del backend.

La experiencia debe responder:

- Que datos faltan o son invalidos.
- Si la prescripcion fue registrada.
- Si existe una alergia critica.
- Si la excepcion autorizada esta completa o incompleta.
- Si ocurrio un error interno.

## 3. Informacion necesaria

El backend real requiere:

| Campo | UX propuesta | Estado backend |
|---|---|---|
| `patient_id` | Campo de texto para ID de paciente | Implementado como dato del payload. |
| `medication_id` | Campo de texto para ID de medicamento | Implementado como dato del payload. |
| `doctor_id` | Campo de texto para ID del medico | Implementado como dato del payload; no autenticado. |
| `dose` | Campo de texto | Validado por Value Object. |
| `route` | Selector estatico | Valores del dominio: `oral`, `iv`, `im`, `subcutanea`, `topica`, `inhalada`. |
| `frequency` | Campo de texto | Ejemplo valido: `cada 8 horas`. |
| `date` | Campo opcional | Si se omite, backend usa fecha del servidor. |

## 4. Estados UX

| Estado | Descripcion | Respuesta relacionada |
|---|---|---|
| Inicial | Formulario vacio/listo para completar. | No aplica. |
| Completando formulario | Medico ingresa IDs y datos clinicos. | No aplica. |
| Validando | La UI envia `POST /prescriptions`. | Request en curso. |
| Exito | Prescripcion creada correctamente. | `201`. |
| Alergia critica | Se detecta conflicto y no se persiste. | `409`. |
| Excepcion autorizada | Se reenvia con `exception.authorized=true`, `reason`, `authorized_by`. | `201`. |
| Excepcion incompleta | Faltan `reason` o `authorized_by`. | `403`. |
| Datos invalidos | Campo faltante, dosis/via/frecuencia invalida, paciente/medicamento inexistente. | `422`. |
| Error interno | Fallo inesperado o persistencia. | `500`. |

## 5. Limitaciones de UX por backend actual

No existe frontend real ni endpoints de catalogo. Por tanto:

- No se representa selector dinamico de pacientes como funcionalidad actual.
- No se representa autocomplete de medicamentos como funcionalidad actual.
- No se representa catalogo de medicos como funcionalidad actual.
- No se consulta alergia antes de enviar; la alergia se conoce por la respuesta `409`.
- No se muestra historial/listado de prescripciones porque no hay endpoint de lectura.

## 6. Decisiones de baja fidelidad

- Usar dos wireframes para cubrir el flujo sin exceso de pantallas.
- Representar campos por ID porque el contrato actual opera por IDs.
- Representar `route` como selector estatico porque los valores estan en el dominio, no requieren endpoint externo.
- Representar `frequency` como texto libre guiado por ejemplo valido.
- Representar excepcion autorizada como reenvio del mismo `POST /prescriptions`, no como endpoint separado.
