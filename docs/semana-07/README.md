# Semana 7 - Componentes y refactorizacion

## 1. Objetivo

Semana 7 analiza los componentes internos del modulo ASII-15 y aplica una refactorizacion pequena, justificada y segura. La pregunta central es: que componentes existen, que responsabilidades tienen y que cambio mejora el diseno sin cambiar el comportamiento observable.

Esta entrega se dividio en dos fases:

- Fase 2A: analisis, diseno, documentacion y diagrama fuente. No modifico codigo funcional.
- Fase 2B: implementacion del refactor y validacion antes/despues con PHP portable.

## 2. Continuidad con Semanas 4-6

Semana 4 organizo el backend en capas y documento el patron Repository. Semana 5 documento el contrato cliente-servidor REST y la integracion con el HIS. Semana 6 funciono como checkpoint del Primer Parcial. Semana 7 continua sobre ese estado acumulado y se enfoca en componentes internos y refactorizacion controlada.

La base de la rama S7 es `origin/developer` en `8fe8237ed2662664d7f2dd58316dee469a1d9441`, que contiene el merge de Semana 6.

## 3. Componentes identificados

Componentes reales confirmados por lectura del codigo:

- Entrada HTTP / Composition Root: `public/index.php`.
- Presentation: `Router`, `JsonResponseEmitter`, `PrescriptionController`, `CreatePrescriptionRequest`.
- Application: `CreatePrescriptionUseCase`, `CreatePrescriptionInput`, `CreatePrescriptionResult`.
- Domain: entidades, Value Objects y excepciones.
- Clinical Validation: `AllergyConflictDetector`, `Dose`, `AdministrationRoute`, `Frequency`.
- Repository Contracts: interfaces en `src/Domain/Contracts`.
- Persistence Adapters: repositorios PDO.
- Audit: tabla `prescription_audits` y escritura desde `PdoPrescriptionRepository`.
- Database: PDO, SQLite, migraciones y seeders.
- Testing Adapters: repositorios InMemory, runner propio y tests Feature.

Detalle completo: `docs/semana-07/componentes.md`.

## 4. Problema seleccionado

El problema seleccionado fue que `src/Presentation/Router.php` mezclaba routing/dispatch con emision HTTP/JSON. Antes del refactor registraba rutas, localizaba el handler, ejecutaba el handler, extraia el status, configuraba `http_response_code`, definia `Content-Type`, serializaba con `json_encode` e imprimia la respuesta.

Esto funcionaba, pero concentraba responsabilidades distintas en una misma clase.

## 5. Refactor elegido

El refactor implementado en Fase 2B separa la emision de respuesta JSON en un componente dedicado:

```text
src/Presentation/Responses/JsonResponseEmitter.php
```

Responsabilidad actual del Router:

- Registrar rutas.
- Localizar handlers.
- Ejecutar dispatch.
- Mantener 404 y 500 generico.
- Delegar la respuesta al emisor JSON.

Responsabilidad actual del JsonResponseEmitter:

- Recibir `status` y `body`.
- Configurar `http_response_code`.
- Configurar `Content-Type: application/json`.
- Serializar el formato JSON actual.
- Emitir la respuesta.

Este refactor no cambia endpoints, codigos HTTP, payloads, tablas, seeds, reglas clinicas, persistencia ni auditoria.

## 6. Refactors no seleccionados

- Extraer Composition Root: prioridad MEDIA. Puede mejorar `public/index.php`, pero amplia el alcance y no era el problema principal de esta semana.
- Centralizar default de `date`: prioridad MEDIA. Existe duplicidad menor entre request y DTO, pero no afecta el objetivo principal.
- Dividir `CreatePrescriptionUseCase`: NO NECESARIA actualmente. La clase concentra orquestacion, pero el tamano y el alcance siguen siendo manejables.

Semana 7 mantiene un solo refactor principal para evitar cambios innecesarios.

## 7. Comportamiento preservado

El comportamiento observable se preservo:

| Caso | Codigo post-refactor |
|---|---|
| `GET /health` | `200` |
| `POST /prescriptions` valida | `201` |
| Alergia critica sin excepcion | `409` |
| Excepcion autorizada completa | `201` |
| Excepcion incompleta | `403` |
| Datos invalidos | `422` |
| Ruta inexistente | `404` |
| Falla de persistencia | `500` por test |

Persistencia post-refactor:

- `prescriptions = 2`.
- `prescription_audits = 1`.
- `authorized_exception = 1`.

## 8. Estado de validacion

Para Fase 2B se preparo PHP 8.3.33 portable fuera del repositorio y se ejecuto validacion antes/despues.

Validacion final:

- `php bin/console.php migrate:fresh --seed` -> `Migration completed`.
- Tests generales -> `Tests: 6, Failed: 0`.
- `Mod15PrescriptionTest` -> `Tests: 5, Failed: 0`.
- HTTP preservado: `200`, `201`, `409`, `201`, `403`, `422`, `404`.
- JSON preservado con envelope `status` + `data`.
- Falla de persistencia -> `500` por test automatizado.
- Persistencia y auditoria preservadas.

## 9. Entregables

- `docs/semana-07/README.md`.
- `docs/semana-07/componentes.md`.
- `docs/semana-07/refactorizacion.md`.
- `docs/semana-07/evidencia-validacion.md`.
- `docs/semana-07/evidencia-git.md`.
- `docs/semana-07/diagramas/componentes.puml`.
- `docs/semana-07/diagramas/componentes.png`.
- `src/Presentation/Responses/JsonResponseEmitter.php`.
- `src/Presentation/Router.php` refactorizado.
- `DECLARACION_IA.md` actualizado si corresponde.

## 10. Rama/worktree

- Rama: `feature/week-07-componentes-refactor-asii15-mar-03`.
- Worktree: `shi-personal-asii15-s07-componentes-refactor`.
- Base: `origin/developer` en `8fe8237ed2662664d7f2dd58316dee469a1d9441`.
- Estado inicial: `git rev-list --left-right --count origin/developer...HEAD` = `0 0`.
