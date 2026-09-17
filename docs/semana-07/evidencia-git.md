# Semana 7 - Evidencia Git

## 1. Base

- Base: `origin/developer`.
- Commit base: `8fe8237ed2662664d7f2dd58316dee469a1d9441`.
- Merge Semana 6: `8fe8237 Merge pull request #10 from Mar-03/feature/week-06-primer-parcial-asii15-mar-03`.

## 2. Rama y worktree

- Rama: `feature/week-07-componentes-refactor-asii15-mar-03`.
- Worktree: `shi-personal-asii15-s07-componentes-refactor`.

Verificacion inicial:

```text
$ git branch --show-current
feature/week-07-componentes-refactor-asii15-mar-03

$ git merge-base HEAD origin/developer
8fe8237ed2662664d7f2dd58316dee469a1d9441

$ git rev-list --left-right --count origin/developer...HEAD
0 0
```

## 3. Estado inicial

La rama S7 nace directamente desde el `origin/developer` que contiene Semana 6. Al inicio tiene cero commits propios respecto de `developer`.

## 4. Fase 1

Fase 1 realizo:

- Verificacion de `origin/developer`.
- Confirmacion de Semana 5 y Semana 6 integradas.
- Creacion de rama/worktree S7.
- Diagnostico de PHP.
- Auditoria en modo lectura de componentes reales.

No se modifico codigo ni documentacion durante Fase 1.

## 5. Fase 2A

Fase 2A realiza:

- Documentacion de componentes reales.
- Diseno del refactor seleccionado.
- Evidencia de validacion bloqueada por entorno PHP.
- Diagrama PlantUML de componentes internos.
- Actualizacion de `DECLARACION_IA.md`.

No implementa el refactor en codigo.

## 6. Archivos esperados de Fase 2A

| Archivo | Estado |
|---|---|
| `docs/semana-07/README.md` | nuevo |
| `docs/semana-07/componentes.md` | nuevo |
| `docs/semana-07/refactorizacion.md` | nuevo |
| `docs/semana-07/evidencia-validacion.md` | nuevo |
| `docs/semana-07/evidencia-git.md` | este archivo |
| `docs/semana-07/diagramas/componentes.puml` | nuevo |
| `docs/semana-07/diagramas/componentes.png` | generado |
| `DECLARACION_IA.md` | actualizado |

## 7. Fase 2B

Fase 2B realiza:

- Preparacion de PHP 8.3.33 portable fuera del repositorio.
- Preparacion de `plantuml.jar` fuera del repositorio.
- Render de `componentes.png`.
- Baseline pre-refactor.
- Implementacion de `src/Presentation/Responses/JsonResponseEmitter.php`.
- Refactor minimo de `src/Presentation/Router.php`.
- Validacion post-refactor por lint, tests, HTTP, persistencia y auditoria.

Archivos de codigo modificados/creados:

- `src/Presentation/Responses/JsonResponseEmitter.php`.
- `src/Presentation/Router.php`.

Commit funcional del refactor:

```text
bbc1630 refactor(asii-15): separate json response emission from router
```

Archivos de documentacion actualizados:

- `docs/semana-07/README.md`.
- `docs/semana-07/componentes.md`.
- `docs/semana-07/refactorizacion.md`.
- `docs/semana-07/evidencia-validacion.md`.
- `docs/semana-07/evidencia-git.md`.
- `docs/semana-07/diagramas/componentes.puml`.
- `docs/semana-07/diagramas/componentes.png`.

No se modificaron Domain, Application, Persistence, rutas, tests, migraciones, seeds ni contrato REST.
