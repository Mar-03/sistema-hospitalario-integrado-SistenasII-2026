# Semana 7 - Refactorizacion propuesta

## 1. Problema

`src/Presentation/Router.php` mezcla routing y emision HTTP/JSON.

Actualmente el Router:

- Registra rutas con `get()` y `post()`.
- Construye la clave metodo + path.
- Localiza el handler.
- Ejecuta el handler.
- Obtiene el `status` desde el arreglo de resultado.
- Configura `http_response_code`.
- Configura `Content-Type: application/json`.
- Ejecuta `json_encode`.
- Imprime la respuesta.
- Captura errores genericos y los convierte en `500`.

La clase funciona, pero combina dos responsabilidades: decidir a que handler va una peticion y emitir una respuesta HTTP JSON.

## 2. Estado anterior

Flujo actual:

```text
Router
  -> localiza ruta
  -> ejecuta handler
  -> separa status/body
  -> configura HTTP
  -> serializa JSON
  -> imprime respuesta
```

Formato actual de respuesta que debe preservarse:

```json
{
  "status": 200,
  "data": {
    "health": "ok",
    "module": "mod15-prescriptions"
  }
}
```

## 3. Principio relacionado

El principio relacionado es Responsabilidad Unica / separacion de responsabilidades. El Router deberia concentrarse en routing y dispatch; la emision de respuesta JSON deberia concentrarse en un componente de salida.

## 4. Decision

Se selecciona un unico refactor principal para Semana 7:

```text
Extraer JsonResponseEmitter desde Router
```

El componente propuesto es:

```text
src/Presentation/Responses/JsonResponseEmitter.php
```

Este archivo todavia no se crea en Fase 2A porque PHP no esta disponible para validar antes y despues. La implementacion queda pendiente para Fase 2B.

## 5. Diseno propuesto

Flujo futuro:

```text
Router
  -> localiza ruta
  -> ejecuta handler
  -> obtiene resultado
  -> JsonResponseEmitter
       -> configura status HTTP
       -> configura Content-Type
       -> serializa JSON
       -> emite respuesta
```

Responsabilidad futura del Router:

- Registrar rutas.
- Localizar handler.
- Ejecutar handler.
- Manejar dispatch.
- Delegar emision de respuesta.

Responsabilidad futura de `JsonResponseEmitter`:

- Recibir `status` y `body`.
- Configurar `http_response_code` cuando no se ejecuta por CLI.
- Configurar `Content-Type: application/json`.
- Mantener el formato `{"status": <code>, "data": {...}}`.
- Emitir JSON con `JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES`.

## 6. Contrato que no debe cambiar

No se debe cambiar:

- `GET /health`.
- `POST /prescriptions`.
- Payload de entrada.
- Formato de salida.
- Codigos `200`, `201`, `403`, `404`, `409`, `422`, `500`.
- Reglas de alergias.
- Persistencia.
- Auditoria.
- Migraciones.
- Seeds.

## 7. Riesgo

El riesgo principal es alterar accidentalmente el formato JSON o los codigos HTTP al mover la emision fuera del Router. Por eso Fase 2B debe ejecutar pruebas antes y despues cuando PHP este disponible.

## 8. Tests relacionados

Pruebas a ejecutar en Fase 2B:

```text
php bin/console.php migrate:fresh --seed
php bin/console.php test
php bin/console.php test --filter=Mod15PrescriptionTest
```

Tambien deben repetirse pruebas HTTP relevantes para confirmar que la respuesta mantiene el mismo formato.

## 9. Refactors no seleccionados

| Refactor | Prioridad | Decision |
|---|---|---|
| Extraer Composition Root desde `public/index.php` | MEDIA | Postergado; mejora potencial, pero amplia alcance. |
| Centralizar default de `date` | MEDIA | Postergado; duplicidad menor, no bloquea el diseno actual. |
| Dividir `CreatePrescriptionUseCase` | NO NECESARIA | No se justifica actualmente; podria sobredisenar. |

## 10. Impacto funcional esperado

Impacto funcional esperado: ninguno. El cambio debe ser puramente estructural.

La evidencia esperada para cerrar Semana 7 debe demostrar:

```text
estructura modificada, comportamiento preservado
```
