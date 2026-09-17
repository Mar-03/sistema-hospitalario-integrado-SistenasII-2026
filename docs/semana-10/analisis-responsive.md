# Semana 10 - Analisis responsive

## 1. Escritorio

En escritorio existe mayor ancho disponible. El formulario puede agruparse en bloques para reducir carga visual:

- Bloque de identificacion.
- Bloque de datos clinicos.
- Bloque de mensajes y estados.

Cuando exista espacio suficiente, algunos campos pueden ubicarse en dos columnas. Los mensajes pueden mantenerse visibles sin saturar el formulario.

## 2. Tablet

Tablet representa una transicion intermedia. La prioridad debe ser legibilidad y no densidad.

Recomendaciones:

- Maximo dos columnas cuando exista espacio.
- Una columna si los textos o ayudas quedan comprimidos.
- Alertas a ancho completo.
- Botones suficientemente separados.
- Errores visibles cerca del campo.

## 3. Movil

En movil el flujo debe ser vertical y de una sola columna.

Recomendaciones:

- Campos a ancho disponible.
- Acciones apiladas.
- Sin scroll horizontal conceptual.
- Ayudas debajo del campo.
- Errores cerca del campo.
- Alerta clinica visible y textual.
- Excepcion autorizada debajo de la alerta.

## 4. Riesgos responsive

- Separar errores de sus campos por reorganizacion visual.
- Ocultar ayudas para ahorrar espacio.
- Presentar botones criticos demasiado juntos.
- Reducir la alerta clinica a color o icono.
- Provocar scroll horizontal por textos largos.
- Hacer que la excepcion autorizada parezca una accion normal.

## 5. Backend y catalogos

El backend actual solo expone `GET /health` y `POST /prescriptions`. No existen endpoints `GET /patients`, `GET /medications`, `GET /doctors`, `GET /allergies` ni `GET /prescriptions`.

La adaptacion responsive no convierte IDs tecnicos en selectores funcionales.
