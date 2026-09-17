# Semana 9 - Accesibilidad conceptual

## 1. Alcance

Este documento define criterios de accesibilidad para una implementacion futura. No afirma que existan HTML, ARIA, navegacion por teclado o lector de pantalla implementados.

## 2. Etiquetas visibles

Cada campo debe tener etiqueta visible:

- `Paciente ID *`.
- `Medicamento ID *`.
- `Medico ID *`.
- `Dosis *`.
- `Via *`.
- `Frecuencia *`.
- `Fecha (opcional)`.
- `Motivo *`.
- `Autorizado por *`.

La obligatoriedad se expresa textualmente mediante `*` y una nota: `Los campos marcados con * son obligatorios`.

## 3. Mensajes no dependientes del color

Los estados deben ser comprensibles en representacion monocromatica.

Correcto:

- `ALERTA CLINICA CRITICA: ALERGIA`.
- `LA PRESCRIPCION NO FUE REGISTRADA`.
- `Revise los campos indicados`.
- `No fue posible registrar la prescripcion`.

No basta con usar color, iconos o forma.

## 4. Iconos acompanados de texto

Si una implementacion futura usa iconos, cada icono debe acompanarse de texto equivalente. El wireframe S9 no depende de iconos.

## 5. Jerarquia clara

La jerarquia recomendada es:

- Critico: alerta de alergia `409`.
- Error de accion: `403` y `422`.
- Error tecnico: `500`.
- Exito: `201`.
- Estado tecnico no normal de formulario: `404`.

## 6. Orden logico de foco futuro

Wireframe principal:

1. `patient_id`.
2. `medication_id`.
3. `doctor_id`.
4. `dose`.
5. `route`.
6. `frequency`.
7. `date`.
8. Registrar prescripcion.

Wireframe alerta:

1. Titulo/estado de alerta.
2. Explicacion del conflicto.
3. Modificar prescripcion.
4. Cancelar.
5. Iniciar excepcion autorizada.
6. `reason`.
7. `authorized_by`.
8. Confirmar excepcion autorizada.

Esto es especificacion futura de accesibilidad, no navegacion por teclado implementada.

## 7. Asociacion conceptual entre error y campo

Los errores deben estar cerca del campo o seccion que los origina:

- Error de dosis junto a `Dosis *`.
- Error de frecuencia junto a `Frecuencia *`.
- Error de excepcion junto a `Motivo *` y `Autorizado por *`.

## 8. Tecnologia asistiva futura

Una implementacion futura deberia anunciar:

- Resultado exitoso.
- Errores de campo.
- Alerta clinica critica.
- Estado de no persistencia.
- Requisitos de excepcion autorizada.

No se implementa lector de pantalla ni ARIA en Semana 9.

## 9. Contraste y lenguaje

El contraste visual queda como criterio futuro de implementacion. Semana 9 no define colores finales, branding ni tipografias.

El lenguaje debe ser comprensible para el medico y evitar que codigos HTTP sean el mensaje principal.
