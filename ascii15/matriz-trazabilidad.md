# Matriz de Trazabilidad - Semana 1

## Datos

- Estudiante: MARIA DE LOS ANGELES LOPEZ FAJARDO
- GitHub: Mar-03
- Modulo: Prescripciones electronicas con validacion de alergias
- Proceso: Creacion de prescripcion con verificacion previa de alergias

## Matriz requisito -> diagrama -> elemento

| Codigo | Requisito o regla del proceso | Caso de uso | Actividad | Secuencia |
|---|---|---|---|---|
| RT-01 | El Medico inicia la creacion de una prescripcion electronica para un paciente registrado. | `Crear prescripcion electronica`, actor `Medico` | `Seleccionar paciente existente` | `MEDICO -> UI : Solicitar creacion de prescripcion` |
| RT-02 | El sistema debe validar que el paciente exista y pertenezca al tenant actual. | `Seleccionar paciente existente` | Decision `Paciente valido y dentro del tenant?` | `CTRL -> PAT : Consultar paciente`, alternativa `Paciente inexistente o fuera del tenant` |
| RT-03 | El Medico debe ingresar medicamento y datos obligatorios de la prescripcion. | `Ingresar datos de prescripcion`, `Seleccionar medicamento activo` | `Ingresar medicamento(s) y datos de la prescripcion`, decision `Datos completos y validos?` | `CTRL -> MED : Validar medicamento` |
| RT-04 | El sistema debe validar que el medicamento exista, este activo y pertenezca al tenant. | `Seleccionar medicamento activo` | Validacion previa a consulta de alergias | Alternativa `Medicamento inexistente o inactivo` |
| RT-05 | Antes de confirmar, el sistema debe consultar alergias activas del paciente. | `Consultar alergias activas` incluido por `Validar medicamento contra alergias` | `Consultar alergias activas del paciente` | `SVC -> ALG : Consultar alergias activas` y `ALG -> DB : Buscar alergias activas del paciente` |
| RT-06 | El sistema debe comparar el medicamento seleccionado contra las alergias activas. | `Validar medicamento contra alergias` | `Comparar medicamento(s) contra alergias activas` | `SVC -> SVC : Comparar medicamento contra alergias activas` |
| RT-07 | Si no hay alergias registradas o no existe coincidencia, se permite continuar a confirmacion. | `Confirmar prescripcion` | Rama `Sin alergias registradas o sin coincidencia` | Alternativa `Sin coincidencia de alergia` con `blocked = false` |
| RT-08 | Si existe coincidencia con una alergia activa, el sistema debe mostrar alerta. | `Mostrar alerta de alergia` como `extend` | Rama `Existe coincidencia con una alergia activa?` y accion `Mostrar alerta de alergia` | Alternativa `Coincidencia de alergia detectada`, `CTRL --> UI : Enviar alerta de alergia` |
| RT-09 | Ante una alerta, el Medico puede modificar la prescripcion y revalidarla. | `Modificar prescripcion` como `extend` | Decision `El Medico modifica o cancela?`, accion `Modificar prescripcion` | `loop Mientras el Medico modifica la prescripcion` y `CTRL -> SVC : Revalidar prescripcion` |
| RT-10 | Ante una alerta, el Medico puede cancelar la prescripcion y no se guarda. | `Mostrar alerta de alergia`, `Modificar prescripcion` | Rama `Cancelar`, accion `Prescripcion cancelada; no se guarda` | Alternativa `El Medico cancela la prescripcion` |
| RT-11 | No se debe guardar una prescripcion bloqueada por alergia. | Nota de `Guardar prescripcion`: solo con `blocked = false` | Nota `Solo se llega aqui con blocked = false` | `opt Prescripcion confirmada y sin bloqueo` |
| RT-12 | Si la validacion es correcta, el Medico confirma y el sistema guarda la prescripcion. | `Confirmar prescripcion`, `Guardar prescripcion` | `Confirmar prescripcion`, `Guardar prescripcion`, `Informar resultado exitoso` | `MEDICO -> UI : Confirmar prescripcion`, `RX -> DB : Guardar prescripcion`, respuesta `201` |
| RT-13 | Si falla la consulta de alergias, el proceso debe abortarse con error. | Excepcion documentada en `ascii15/uml/README.md` | Rama `Se pudieron consultar las alergias?` con salida `No` | Alternativa `Error al consultar alergias`, respuesta `503` |
| RT-14 | Si falla el guardado, el sistema debe informar error y no confirmar exito. | Excepcion documentada en `ascii15/uml/README.md` | Decision `Guardado exitoso?` con salida `No` | Alternativa `Error al guardar`, respuesta `500` |

## Coherencia entre diagramas

- El actor principal en los tres diagramas es el `Medico`.
- El paciente se trata como entidad consultada porque no interactua directamente con el modulo durante la prescripcion.
- El Sistema Hospitalario Integrado se usa como limite del sistema, no como actor externo.
- La validacion previa de alergias aparece en los tres diagramas como paso obligatorio antes de confirmar.
- La alerta de alergia aparece como comportamiento condicional y no como flujo obligatorio.
- La cancelacion y los errores impiden guardar la prescripcion.
