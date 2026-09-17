# Semana 11 - Decisiones visuales

## Jerarquia tipografica

El mockup usa encabezados claros para separar formulario, estados, alerta y excepcion. La prioridad visual esta en el titulo del modulo y en la alerta clinica.

## Ancho de contenido

El contenido se centra en un contenedor de lectura amplia para escritorio. En pantallas reducidas se convierte en una sola columna.

## Agrupacion de campos

El formulario separa:

- Identificacion: paciente, medicamento y medico.
- Datos clinicos: dosis, via, frecuencia y fecha.

Esta separacion reduce carga cognitiva sin cambiar el contrato backend.

## Ayudas y obligatoriedad

Cada campo muestra etiqueta visible, marca `*` cuando es obligatorio y ayuda breve. Los errores se colocan cerca del campo correspondiente.

## Botones

El boton principal es `Registrar prescripcion`. Las acciones de alerta se diferencian por texto: modificar, cancelar e iniciar excepcion autorizada.

## Alerta critica

La alerta usa texto explicito:

- `ALERTA CLINICA CRITICA: ALERGIA`.
- `LA PRESCRIPCIÓN NO FUE REGISTRADA.`

La criticidad no depende solamente del color.

## Excepcion autorizada

La excepcion se presenta como panel separado porque es una accion clinica excepcional. Requiere motivo y responsable de autorizacion.

## Exito y error tecnico

El exito confirma registro. El error tecnico evita detalles internos como excepciones, SQL o trazas.

## Comportamiento movil

En movil se apilan campos y acciones. Se prioriza legibilidad y se evita scroll horizontal.

## Branding

No se inventa logotipo ni identidad institucional. Se usa una estetica sobria de sistema clinico educativo.
