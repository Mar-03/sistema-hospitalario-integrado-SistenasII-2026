# Guia Breve Para Defensa Oral - Semana 1

## Datos

- Estudiante: MARIA DE LOS ANGELES LOPEZ FAJARDO
- GitHub: Mar-03
- Modulo: Prescripciones electronicas con validacion de alergias
- Proceso: Creacion de prescripcion con verificacion previa de alergias

## Explicacion corta del proceso

El proceso inicia cuando el Medico crea una prescripcion para un paciente registrado. El sistema valida paciente, tenant, medicamento y datos obligatorios. Antes de permitir la confirmacion, consulta las alergias activas del paciente y compara esa informacion con el medicamento seleccionado. Si no hay coincidencia, la prescripcion se confirma y guarda. Si existe coincidencia, se muestra una alerta y el Medico decide modificar y revalidar o cancelar.

## Decisiones principales

- El actor principal es el `Medico` porque es quien interactua con el modulo para crear la prescripcion.
- El `Paciente` no se modelo como actor porque no interactua directamente con el sistema en este proceso.
- El `Sistema Hospitalario Integrado` se modelo como limite del sistema porque el modulo forma parte del HIS.
- `Validar medicamento contra alergias` es obligatorio antes de confirmar, por eso se representa como `include`.
- `Mostrar alerta de alergia` es condicional, por eso se representa como `extend`.
- Una prescripcion con coincidencia de alergia no se guarda como confirmada; se modifica, revalida o cancela.

## Como explicar cada diagrama

### Diagrama de casos de uso

Muestra el limite del modulo, el actor principal y los objetivos funcionales. El caso base es `Crear prescripcion electronica`. Incluye seleccionar paciente, ingresar datos, seleccionar medicamento, validar alergias, confirmar y guardar. La alerta y modificacion son extensiones porque solo ocurren si existe una coincidencia con una alergia activa.

### Diagrama de actividad

Muestra el flujo paso a paso. Incluye validaciones de paciente, datos, medicamento, consulta de alergias, comparacion, alerta, modificacion, cancelacion, confirmacion y errores. Sirve para defender las decisiones y excepciones del proceso.

### Diagrama de secuencia

Muestra los participantes y mensajes. El Medico usa la interfaz, la interfaz llama a la API, el controlador consulta paciente y medicamento, el servicio valida alergias y el repositorio guarda la prescripcion cuando no hay bloqueo.

## Preguntas probables y respuestas

1. Por que el paciente no aparece como actor?

   Porque no interactua directamente con el modulo durante este proceso. Su informacion se consulta como dato clinico, pero quien usa el sistema es el Medico.

2. Por que la alerta de alergia es `extend`?

   Porque no ocurre siempre. Solo aparece si la validacion detecta una coincidencia entre el medicamento y una alergia activa.

3. Por que validar alergias es `include`?

   Porque es un paso obligatorio antes de confirmar una prescripcion. Sin esa validacion el proceso no cumple la consigna.

4. Que ocurre si se detecta una alergia?

   El sistema muestra una alerta. El Medico puede modificar la prescripcion y revalidar, o cancelarla. No se guarda una prescripcion bloqueada como confirmada.

5. Que excepciones se modelaron?

   Paciente inexistente o fuera del tenant, datos incompletos, medicamento invalido o inactivo, error al consultar alergias, coincidencia de alergia activa, cancelacion y error al guardar.

6. Que elemento podria modificar en vivo durante la defensa?

   Se podria agregar una excepcion adicional, por ejemplo `token vencido`, o cambiar el flujo de alerta para registrar una notificacion de auditoria. La modificacion debe mantenerse coherente en los tres diagramas.

## Evidencia que se debe mencionar

- Fuentes editables PlantUML en `ascii15/uml/`.
- Imagenes exportadas en `ascii15/imagenes/`.
- Matriz de trazabilidad en `ascii15/matriz-trazabilidad.md`.
- Declaracion de IA en `DECLARACION_IA.md`.
- Commit evaluado y rama de trabajo en Git.
