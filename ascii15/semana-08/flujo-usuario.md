# Semana 8 - Flujo de usuario

## 1. Flujo principal

```text
Medico abre formulario
  -> ingresa patient_id
  -> ingresa medication_id
  -> ingresa doctor_id
  -> ingresa dose
  -> selecciona/ingresa route
  -> ingresa frequency
  -> opcionalmente date
  -> presiona Registrar prescripcion
  -> UI envia POST /prescriptions
  -> backend valida
  -> UI interpreta respuesta
```

## 2. Relacion con respuestas reales

| Respuesta | Tratamiento UX |
|---|---|
| `201` | Mostrar confirmacion de prescripcion registrada. |
| `409` | Mostrar alerta critica de alergia y aclarar que no se registro la prescripcion. |
| `403` | Mostrar que la excepcion autorizada esta incompleta. |
| `422` | Mostrar mensaje de datos invalidos o entidad no valida. |
| `500` | Mostrar error interno y pedir reintentar o reportar. |

## 3. Flujo de alergia critica

```text
POST /prescriptions
        |
        v
       409
        |
        v
ALERTA CRITICA
        |
        v
"La prescripcion no fue registrada"
        |
        v
 ┌───────────────┬────────────┬─────────────────────┐
 │ Modificar     │ Cancelar   │ Registrar excepcion │
 └───────────────┴────────────┴─────────────────────┘
                                      |
                                      v
                                reason
                                authorized_by
                                      |
                                      v
                             POST /prescriptions
                                      |
                           ┌──────────┴──────────┐
                          201                  403
                           |                    |
                           v                    v
                        exito          autorizacion incompleta
```

## 4. Excepcion autorizada

No existe endpoint separado para excepciones. La excepcion se envia nuevamente dentro de `POST /prescriptions`:

```json
{
  "exception": {
    "authorized": true,
    "reason": "Riesgo aceptado por especialista",
    "authorized_by": "doctor-9"
  }
}
```

Resultado esperado:

- `201`: prescripcion registrada con excepcion autorizada.
- `403`: autorizacion incompleta si falta motivo o autorizador.

## 5. Flujo de datos invalidos

Cuando el backend responde `422`, la UI debe mostrar un mensaje integrado al formulario. No se inventan codigos nuevos. Ejemplos reales:

- Campo obligatorio faltante.
- Dosis invalida.
- Via invalida.
- Frecuencia invalida.
- Paciente inexistente.
- Medicamento inexistente o inactivo.

## 6. Flujo de error interno

Cuando el backend responde `500`, la UI debe indicar que no fue posible registrar la prescripcion por error interno. No se debe sugerir que la prescripcion fue guardada.
