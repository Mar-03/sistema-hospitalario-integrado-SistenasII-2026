# ESPECIFICACION - Mod15

## Problema

Crear una prescripcion electronica sin validar alergias activas puede generar un riesgo clinico. El modulo debe rechazar alergias criticas incompatibles y permitir excepcion autorizada solo con registro.

## Actores

- Medico
- Usuario autorizado
- Sistema micro-HIS

## Historia de usuario

Como medico, quiero crear una prescripcion electronica y validar alergias antes de confirmarla, para evitar indicar un medicamento incompatible con el paciente.

## Alcance

- Crear prescripcion electronica.
- Validar medicamento, dosis, via y frecuencia.
- Consultar alergias activas.
- Bloquear alergia critica.
- Permitir excepcion autorizada.

## No alcance

- Laravel.
- Otros modulos del HIS.
- Farmacia.
- Laboratorio.
- Signos vitales.

## Reglas

1. El medicamento debe existir y estar activo.
2. La dosis debe ser valida.
3. La via debe ser valida.
4. La frecuencia debe ser valida.
5. Deben consultarse alergias activas.
6. Si existe alergia critica compatible, se rechaza.
7. Si hay excepcion autorizada, se permite guardar con auditoria.

## Criterios de aceptacion

- Paciente sin alergias: crea prescripcion.
- Paciente con alergia critica: rechaza.
- Dosis invalida: rechaza.
- Excepcion autorizada: permite continuar.
- Falla de persistencia: retorna error controlado.
