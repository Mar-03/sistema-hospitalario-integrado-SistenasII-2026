# Semana 10 - Estrategia de layout

## 1. Alcance

La estrategia es conceptual. No se definen breakpoints reales porque no existe frontend implementado.

## 2. Escritorio

Layout amplio con maximo dos columnas.

Agrupacion recomendada:

- Identificacion: paciente, medicamento, medico.
- Datos clinicos: dosis, via, frecuencia, fecha.
- Estados: exito, error de datos, error tecnico y alerta clinica.

Campos que pueden ir lado a lado si hay espacio:

- `dose` + `route`.
- `frequency` + `date`.

## 3. Tablet

Layout intermedio.

Regla conceptual:

- Usar dos columnas solo si ayudas y errores siguen legibles.
- Cambiar a una columna si la densidad reduce claridad.
- Mantener alertas a ancho completo.

## 4. Movil

Layout de una sola columna.

Regla conceptual:

- Un campo por fila.
- Ayuda debajo del campo.
- Error debajo o inmediatamente despues del campo.
- Acciones apiladas.
- Textos criticos completos, sin depender de color.

## 5. Breakpoints

Los breakpoints exactos se definiran cuando exista frontend real. Semana 10 solo documenta la adaptacion de estructura.
