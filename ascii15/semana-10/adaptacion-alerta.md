# Semana 10 - Adaptacion de alerta clinica

## 1. Contenido obligatorio

La alerta debe mantener siempre:

- `ALERTA CLINICA CRITICA: ALERGIA`.
- `Se detecto un conflicto de alergia.`
- `LA PRESCRIPCION NO FUE REGISTRADA.`

Estos textos hacen que la alerta sea comprensible sin depender del color.

## 2. Escritorio

En escritorio la alerta puede usar un panel destacado con acciones visibles:

- Modificar prescripcion.
- Cancelar.
- Iniciar excepcion autorizada.

La excepcion autorizada puede presentarse como panel separado para reforzar que no es una accion normal.

## 3. Tablet

En tablet la alerta debe ocupar ancho completo si el espacio se reduce. Las acciones pueden estar en una fila solo si siguen claramente separadas; de lo contrario deben apilarse.

## 4. Movil

En movil:

- La alerta ocupa el ancho disponible.
- El texto critico queda completo.
- Las acciones se apilan.
- Los botones no quedan demasiado juntos.
- La excepcion autorizada aparece debajo de la alerta.

## 5. Excepcion autorizada

Campos existentes:

- `reason`.
- `authorized_by`.

En movil ambos campos deben apilarse verticalmente.

La accion debe mantener un texto claro: `Confirmar excepcion autorizada y registrar`.

## 6. Error de autorizacion incompleta

El error `403` debe comunicarse como informacion faltante, no como codigo tecnico principal:

- No fue posible autorizar la excepcion.
- Complete motivo.
- Complete autorizado por.
