# Semana 9 - Usabilidad y accesibilidad

## 1. Objetivo

Semana 9 revisa los wireframes de baja fidelidad creados en Semana 8 para evaluar si la interaccion propuesta es clara, comprensible, segura y accesible para el `Medico`.

Esta semana aplica mejoras documentales de usabilidad y accesibilidad conceptual. No desarrolla frontend real, no modifica backend y no cambia el contrato de la API.

## 2. Continuidad con Semana 8

Semana 8 queda como diseno UX inicial en `ascii15/semana-08/`.

Semana 9 crea una version revisada en `ascii15/semana-09/` para mantener trazabilidad:

- S8: flujo UX inicial y wireframes base.
- S9: revision por usabilidad, accesibilidad, claridad de mensajes y prevencion de errores.

## 3. Problemas identificados

- Uso de IDs tecnicos para paciente, medicamento y medico.
- Campos obligatorios no marcados explicitamente en el wireframe principal.
- Mensajes de error generales, especialmente para `422` y `403`.
- Riesgo de tratar el `409` como error comun y no como alerta clinica critica.
- Ayuda limitada para formatos de dosis y frecuencia.
- Jerarquia de acciones mejorable en el flujo de alergia y excepcion.
- Criterios de accesibilidad todavia no especificados para implementacion futura.

## 4. Mejoras aplicadas

- Campos obligatorios identificados con `*`.
- Fecha marcada como opcional.
- Ayudas de formato para dosis y frecuencia.
- Mensajes orientados al medico en lugar de mostrar solo codigos HTTP.
- Estado critico `409` separado como alerta clinica.
- Flujo de excepcion autorizado tratado como accion excepcional.
- `reason` y `authorized_by` marcados como obligatorios.
- Estados comprensibles incluso sin depender de color.

## 5. Criterios de usabilidad

- Claridad de etiquetas.
- Facilidad de aprendizaje.
- Prevencion de errores.
- Recuperacion tras errores.
- Retroalimentacion clara.
- Jerarquia de acciones.
- Reduccion de carga cognitiva.
- Lenguaje comprensible para el medico.

## 6. Criterios de accesibilidad

- Etiquetas visibles.
- Obligatoriedad expresada textualmente.
- Mensajes no dependientes del color.
- Iconos acompanados de texto si se usan en el futuro.
- Orden logico de lectura y foco futuro.
- Asociacion conceptual entre error y campo.
- Mensajes preparados para tecnologia asistiva en implementacion futura.
- Contraste registrado como criterio futuro, sin definir estilos finales.

## 7. Wireframes revisados

| Wireframe S9 | Proposito |
|---|---|
| `wireframes/prescripcion-usabilidad.puml` + PNG | Formulario principal con obligatoriedad, ayudas y estados comprensibles. |
| `wireframes/alergia-accesible.puml` + PNG | Alerta clinica critica y excepcion autorizada con mejor jerarquia y accesibilidad conceptual. |

## 8. Limitaciones actuales

No implementado actualmente:

- Frontend real.
- Selectores dinamicos.
- API de pacientes.
- API de medicamentos.
- API de medicos/autorizadores.
- Consulta previa de alergias.
- Autenticacion, RBAC, JWT o tenancy funcional.
- Historial/listado de prescripciones.

## 9. Integraciones futuras

- Busqueda/autocomplete de pacientes.
- Busqueda/autocomplete de medicamentos.
- Selector remoto de medicos/autorizadores.
- Nombre visible + identificador tecnico.
- Autenticacion para obtener medico actual.
- Consulta previa de alergias.
- Historial de prescripciones.

Todas estas mejoras requieren endpoints o integraciones futuras; no se presentan como implementadas.

## 10. Evidencias

- Baseline funcional heredado: `Migration completed`, tests generales `6/6`, tests especificos `5/5`.
- Wireframes PlantUML/SALT renderizados a PNG.
- Revision documental de usabilidad y accesibilidad.
- Validacion de que Semana 9 no modifica backend ni frontend.

## 11. Rama/worktree

- Rama: `feature/week-09-usabilidad-accesibilidad-asii15-mar-03`.
- Worktree: `shi-personal-asii15-s09-usabilidad-accesibilidad`.
- Base: `origin/developer` en `99753cb5138198cb58a7fd1c2907deea2c2838c7`.
- Merge-base inicial: `99753cb5138198cb58a7fd1c2907deea2c2838c7`.
- Estado inicial: `0 0` contra `origin/developer`.
