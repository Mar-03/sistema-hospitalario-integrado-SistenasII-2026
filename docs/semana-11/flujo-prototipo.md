# Semana 11 - Flujo del prototipo

## Flujo principal

```text
Inicio
  -> completar formulario
  -> Registrar prescripcion
```

## Resultados posibles

```text
Registrar prescripcion
  -> exito
  -> error de validacion
  -> alergia critica
  -> error tecnico/persistencia
```

## Flujo de alergia

```text
Alergia critica
  -> modificar prescripcion
  -> cancelar
  -> iniciar excepcion autorizada
```

## Flujo de excepcion autorizada

```text
Iniciar excepcion autorizada
  -> completar reason
  -> completar authorized_by
  -> confirmar excepcion autorizada y registrar
  -> exito
```

Si falta informacion:

```text
Confirmar excepcion autorizada
  -> autorizacion incompleta
```

## Trazabilidad tecnica

| Codigo | Interpretacion UX |
|---|---|
| `201` | Prescripcion registrada correctamente. |
| `409` | Alerta clinica critica por alergia. |
| `403` | Excepcion autorizada incompleta. |
| `422` | Error de validacion o datos invalidos. |
| `500` | Error tecnico o persistencia. |

Los codigos no son mensajes principales de interfaz para el medico.
