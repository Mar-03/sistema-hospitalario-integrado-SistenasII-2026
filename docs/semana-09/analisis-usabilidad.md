# Semana 9 - Analisis de usabilidad

## 1. Facilidad de aprendizaje

El flujo sigue una secuencia reconocible para el medico: identificar paciente, medicamento, medico responsable, datos clinicos de administracion y registrar la prescripcion.

La mejora principal consiste en hacer explicitos los campos obligatorios, reducir lenguaje tecnico visible y orientar los mensajes hacia acciones concretas.

## 2. Claridad del formulario

| Campo | Evaluacion | Mejora S9 |
|---|---|---|
| `patient_id` | Baja usabilidad porque exige un identificador tecnico. | Mostrar `Paciente ID *` y ayuda: ingreso manual mientras no exista catalogo. |
| `medication_id` | Baja usabilidad y riesgo clinico por error de escritura. | Mostrar `Medicamento ID *` y ayuda: ingreso manual mientras no exista catalogo. |
| `doctor_id` | Requiere conocer el identificador del medico. | Mostrar `Medico ID *`; futura autenticacion deberia completar este dato. |
| `dose` | El ejemplo `500 mg` es claro, pero debe guiar formato. | Mostrar obligatorio y ejemplo junto al campo. |
| `route` | Selector estatico adecuado porque los valores son de dominio. | Mantener selector con valores reales: `oral`, `iv`, `im`, `subcutanea`, `topica`, `inhalada`. |
| `frequency` | Campo libre puede inducir errores. | Mostrar ejemplo compatible: `cada 8 horas` o `1 vez al dia`. |
| `date` | Opcional, pero debe explicarse. | Marcar como opcional e indicar comportamiento si se omite. |

## 3. IDs tecnicos

`patient_id`, `medication_id` y `doctor_id` tienen baja usabilidad porque trasladan al medico la carga de conocer identificadores internos.

Riesgos:

- Error de digitacion.
- Seleccion involuntaria de paciente equivocado.
- Seleccion de medicamento incorrecto o inactivo.
- Dificultad para reconocer autorizadores validos.

No se resuelve artificialmente en Semana 9 porque el backend actual no expone endpoints de catalogo ni autenticacion.

Dependencias futuras:

- Busqueda de pacientes.
- Autocomplete de medicamentos.
- Nombre visible + identificador.
- Selector remoto de medicos/autorizadores.
- Autenticacion para determinar medico actual.

Estas mejoras requieren nuevos endpoints o integraciones futuras.

## 4. Prevencion de errores

Mejoras documentadas:

- Campos obligatorios con `*`.
- Ayuda visible para entradas manuales.
- Ejemplos de formato para `dose` y `frequency`.
- Mensajes cerca del campo o seccion relacionada.
- Confirmacion textual cuando la prescripcion no se registro.
- Diferenciacion entre error de datos, error tecnico y alerta clinica.

## 5. Mensajes y retroalimentacion

Los mensajes principales deben expresarse en lenguaje clinico-operativo, no como codigos HTTP.

| Estado tecnico | Mensaje UX recomendado |
|---|---|
| `201` | Prescripcion registrada correctamente. |
| `409` | Alerta clinica critica: se detecto conflicto de alergia. La prescripcion no fue registrada. |
| `403` | No fue posible autorizar la excepcion. Complete motivo y autorizado por. |
| `422` | Revise los campos indicados. |
| `500` | No fue posible registrar la prescripcion. No se confirmo el registro. |

## 6. Jerarquia de acciones

En el flujo principal, la accion primaria es `Registrar prescripcion`.

En la alerta de alergia, la accion mas segura debe ser `Modificar prescripcion`. `Cancelar` queda como accion secundaria. `Iniciar excepcion autorizada` debe estar separada conceptualmente porque implica aceptar una condicion clinica excepcional.

## 7. Carga cognitiva

La carga cognitiva aumenta por:

- IDs tecnicos.
- Formatos textuales estrictos.
- Excepcion clinica dentro del mismo endpoint.
- Codigos HTTP visibles.

Semana 9 reduce esa carga mediante ayudas, mensajes comprensibles y separacion de estados.

## 8. Recuperacion tras errores

La UX propuesta debe permitir:

- Conservar datos ingresados despues de `422` o `500` cuando sea posible en frontend futuro.
- Mostrar errores junto al campo relacionado.
- Reintentar despues de corregir datos.
- Volver desde alerta de alergia a modificar la prescripcion.
- Cancelar sin sugerir que la prescripcion fue registrada.

No se implementa esta recuperacion en codigo; queda documentada como criterio de diseno.
