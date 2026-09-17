# Semana 9 - Evaluacion de wireframes

## 1. Comparacion general

| Aspecto | Semana 8 | Semana 9 |
|---|---|---|
| Trazabilidad | Contrato real `POST /prescriptions`. | Mantiene trazabilidad y agrega criterios de usabilidad/accesibilidad. |
| Fidelidad | Baja fidelidad. | Baja fidelidad. |
| Backend | No modifica backend. | No modifica backend. |
| Frontend | No implementa frontend. | No implementa frontend. |

## 2. Wireframe principal

Antes:

- Campos sin obligacion explicita.
- `422` generico.
- Ayuda limitada.
- IDs tecnicos visibles.
- Jerarquia debil de estados.

Despues:

- Obligatorios explicitos.
- Fecha opcional.
- Ayudas de formato.
- Mensajes proximos al campo.
- Lenguaje orientado al medico.
- Estado critico separado.

## 3. Wireframe alergia/excepcion

Antes:

- Alerta clara, pero acciones poco jerarquizadas.
- Excepcion poco diferenciada de acciones normales.
- `403` generico.

Despues:

- Alerta clinica critica explicita.
- Prescripcion no registrada indicada claramente.
- Jerarquia de acciones.
- Excepcion presentada como accion excepcional.
- `reason` y `authorized_by` obligatorios.
- `403` indica informacion faltante.

## 4. Conservacion de Semana 8

Los artefactos de `ascii15/semana-08/` no se sobrescriben. Semana 9 crea una version revisada para conservar la evolucion:

- `ascii15/semana-09/wireframes/prescripcion-usabilidad.puml`.
- `ascii15/semana-09/wireframes/alergia-accesible.puml`.

## 5. Estado de los cambios

Las mejoras son documentales y de wireframe. No agregan validacion cliente, no agregan endpoint, no cambian API y no implementan interfaz real.
