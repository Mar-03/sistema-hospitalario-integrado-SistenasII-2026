# Semana 7 - Refactorizacion aplicada

## 1. Problema

`src/Presentation/Router.php` mezclaba routing y emision HTTP/JSON.

Antes del refactor el Router:

- Registraba rutas con `get()` y `post()`.
- Construia la clave metodo + path.
- Localizaba el handler.
- Ejecutaba el handler.
- Obtenia el `status` desde el arreglo de resultado.
- Configuraba `http_response_code`.
- Configuraba `Content-Type: application/json`.
- Ejecutaba `json_encode`.
- Imprimia la respuesta.
- Capturaba errores genericos y los convertia en `500`.

La clase funcionaba, pero combinaba dos responsabilidades: decidir a que handler va una peticion y emitir una respuesta HTTP JSON.

## 2. Estado anterior

Flujo anterior:

```text
Router
  -> localiza ruta
  -> ejecuta handler
  -> separa status/body
  -> configura HTTP
  -> serializa JSON
  -> imprime respuesta
```

Formato de respuesta que debia preservarse:

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

El principio relacionado es Responsabilidad Unica / separacion de responsabilidades. El Router debe concentrarse en routing y dispatch; la emision de respuesta JSON debe concentrarse en un componente de salida.

## 4. Decision

Se selecciono un unico refactor principal para Semana 7:

```text
Extraer JsonResponseEmitter desde Router
```

El componente implementado es:

```text
src/Presentation/Responses/JsonResponseEmitter.php
```

En Fase 2A quedo propuesto porque PHP no estaba disponible. En Fase 2B se implemento despues de confirmar baseline con PHP 8.3.33 portable.

## 5. Diseno aplicado

Flujo despues del refactor:

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

Responsabilidad actual del Router:

- Registrar rutas.
- Localizar handler.
- Ejecutar handler.
- Manejar dispatch.
- Mantener 404 y 500 generico.
- Delegar emision de respuesta.

Responsabilidad actual de `JsonResponseEmitter`:

- Recibir `status` y `body`.
- Configurar `http_response_code` cuando no se ejecuta por CLI.
- Configurar `Content-Type: application/json`.
- Mantener el formato `{"status": <code>, "data": {...}}`.
- Emitir JSON con `JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES`.

## 6. Contrato que no cambio

No se cambio:

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

## 7. Riesgo controlado

El riesgo principal era alterar accidentalmente el formato JSON o los codigos HTTP al mover la emision fuera del Router. Se controlo ejecutando pruebas antes y despues del refactor, mas validacion HTTP del envelope `status`/`data`.

## 8. Tests relacionados

Pruebas ejecutadas en Fase 2B:

```text
php bin/console.php migrate:fresh --seed
php bin/console.php test
php bin/console.php test --filter=Mod15PrescriptionTest
```

Resultado post-refactor:

- `Migration completed`.
- `Tests: 6, Failed: 0`.
- `Tests: 5, Failed: 0` con `Mod15PrescriptionTest`.
- HTTP conserva `200`, `201`, `409`, `201`, `403`, `422`, `404`.
- El JSON conserva `status` y `data` en todos los casos probados.

## 9. Refactors no seleccionados

| Refactor | Prioridad | Decision |
|---|---|---|
| Extraer Composition Root desde `public/index.php` | MEDIA | Postergado; mejora potencial, pero amplia alcance. |
| Centralizar default de `date` | MEDIA | Postergado; duplicidad menor, no bloquea el diseno actual. |
| Dividir `CreatePrescriptionUseCase` | NO NECESARIA | No se justifica actualmente; podria sobredisenar. |

## 10. Impacto funcional observado

Impacto funcional observado: ninguno. El cambio fue puramente estructural.

La evidencia demuestra:

```text
estructura modificada, comportamiento preservado
```

## 11. Antes vs despues

Antes:

- `Router` registraba rutas.
- `Router` hacia dispatch.
- `Router` configuraba status HTTP.
- `Router` configuraba `Content-Type`.
- `Router` ejecutaba `json_encode`.
- `Router` imprimia la respuesta.

Despues:

- `Router` registra rutas.
- `Router` hace dispatch.
- `Router` conserva 404, 500 generico y extraccion status/body.
- `Router` delega salida a `JsonResponseEmitter`.
- `JsonResponseEmitter` configura status HTTP.
- `JsonResponseEmitter` configura `Content-Type`.
- `JsonResponseEmitter` ejecuta `json_encode`.
- `JsonResponseEmitter` emite la respuesta.

No se modificaron reglas clinicas, DTOs, contratos Repository, persistencia, auditoria, migraciones, seeds ni endpoints.
