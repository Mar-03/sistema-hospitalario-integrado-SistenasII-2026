# Semana 7 - Componentes y refactorizacion

## 1. Objetivo

Semana 7 analiza los componentes internos del modulo ASII-15 y define una refactorizacion pequena, justificada y segura. La pregunta central es: que componentes existen, que responsabilidades tienen y que cambio mejora el diseno sin cambiar el comportamiento observable.

Esta entrega se divide en dos fases:

- Fase 2A: analisis, diseno, documentacion y diagrama. No modifica codigo funcional.
- Fase 2B: implementacion del refactor y validacion antes/despues, solo cuando PHP este disponible.

## 2. Continuidad con Semanas 4-6

Semana 4 organizo el backend en capas y documento el patron Repository. Semana 5 documento el contrato cliente-servidor REST y la integracion con el HIS. Semana 6 funciono como checkpoint del Primer Parcial. Semana 7 continua sobre ese estado acumulado y se enfoca en componentes internos y refactorizacion controlada.

La base de la rama S7 es `origin/developer` en `8fe8237ed2662664d7f2dd58316dee469a1d9441`, que contiene el merge de Semana 6.

## 3. Componentes identificados

Componentes reales confirmados por lectura del codigo:

- Entrada HTTP / Composition Root: `public/index.php`.
- Presentation: `Router`, `PrescriptionController`, `CreatePrescriptionRequest`.
- Application: `CreatePrescriptionUseCase`, `CreatePrescriptionInput`, `CreatePrescriptionResult`.
- Domain: entidades, Value Objects y excepciones.
- Clinical Validation: `AllergyConflictDetector`, `Dose`, `AdministrationRoute`, `Frequency`.
- Repository Contracts: interfaces en `src/Domain/Contracts`.
- Persistence Adapters: repositorios PDO.
- Audit: tabla `prescription_audits` y escritura desde `PdoPrescriptionRepository`.
- Database: PDO, SQLite, migraciones y seeders.
- Testing Adapters: repositorios InMemory, runner propio y tests Feature.

Detalle completo: `ascii15/semana-07/componentes.md`.

## 4. Problema seleccionado

El problema seleccionado es que `src/Presentation/Router.php` mezcla routing/dispatch con emision HTTP/JSON. Actualmente registra rutas, localiza el handler, ejecuta el handler, extrae el status, configura `http_response_code`, define `Content-Type`, serializa con `json_encode` e imprime la respuesta.

Esto funciona, pero concentra responsabilidades distintas en una misma clase.

## 5. Refactor elegido

El refactor elegido para Fase 2B es separar la emision de respuesta JSON en un componente dedicado propuesto:

```text
src/Presentation/Responses/JsonResponseEmitter.php
```

Responsabilidad futura del Router:

- Registrar rutas.
- Localizar handlers.
- Ejecutar dispatch.
- Delegar la respuesta al emisor.

Responsabilidad futura del JsonResponseEmitter:

- Recibir `status` y `body`.
- Configurar `http_response_code`.
- Configurar `Content-Type: application/json`.
- Serializar el formato JSON actual.
- Emitir la respuesta.

Este refactor no debe cambiar endpoints, codigos HTTP, payloads, tablas, seeds, reglas clinicas, persistencia ni auditoria.

## 6. Refactors no seleccionados

- Extraer Composition Root: prioridad MEDIA. Puede mejorar `public/index.php`, pero amplia el alcance y no es el problema principal de esta semana.
- Centralizar default de `date`: prioridad MEDIA. Existe duplicidad menor entre request y DTO, pero no afecta el objetivo principal.
- Dividir `CreatePrescriptionUseCase`: NO NECESARIA actualmente. La clase concentra orquestacion, pero el tamano y el alcance siguen siendo manejables.

Semana 7 mantiene un solo refactor principal para evitar cambios innecesarios.

## 7. Comportamiento que debe preservarse

El comportamiento observable debe permanecer identico:

| Caso | Codigo esperado |
|---|---|
| `GET /health` | `200` |
| `POST /prescriptions` valida | `201` |
| Alergia critica sin excepcion | `409` |
| Excepcion autorizada completa | `201` |
| Excepcion incompleta | `403` |
| Datos invalidos | `422` |
| Ruta inexistente | `404` |
| Falla de persistencia | `500` |

Persistencia esperada:

- Caso feliz persiste.
- `409` no persiste.
- `403` no persiste.
- `422` no persiste.
- Excepcion autorizada persiste.
- Auditoria `authorized_exception` continua funcionando.

## 8. Estado actual de validacion

PHP no esta disponible en el entorno actual. Por eso Fase 2A no ejecuta `migrate:fresh`, tests ni pruebas HTTP. La ultima validacion funcional confirmada corresponde a Semana 5 y queda registrada como baseline historico en `evidencia-validacion.md`.

La validacion actual y post-refactor queda pendiente para Fase 2B.

## 9. Entregables

- `ascii15/semana-07/README.md`.
- `ascii15/semana-07/componentes.md`.
- `ascii15/semana-07/refactorizacion.md`.
- `ascii15/semana-07/evidencia-validacion.md`.
- `ascii15/semana-07/evidencia-git.md`.
- `ascii15/semana-07/diagramas/componentes.puml`.
- `ascii15/semana-07/diagramas/componentes.png` queda pendiente si PlantUML no esta disponible.
- `DECLARACION_IA.md` actualizado.

## 10. Rama/worktree

- Rama: `feature/week-07-componentes-refactor-asii15-mar-03`.
- Worktree: `shi-personal-asii15-s07-componentes-refactor`.
- Base: `origin/developer` en `8fe8237ed2662664d7f2dd58316dee469a1d9441`.
- Estado inicial: `git rev-list --left-right --count origin/developer...HEAD` = `0 0`.
