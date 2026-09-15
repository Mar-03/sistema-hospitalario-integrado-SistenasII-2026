# Semana 4 — Evidencia Git

Rama: `feature/week-04-capas-asii15-mar-03` · Worktree: `shi-personal-asii15-s04-capas` · Base: `origin/developer` (`50d4bba`)

## 1. Flujo

De acuerdo con la política del curso, el trabajo de Semana 4 se desarrolla sobre una rama `feature/` que nace de `developer` (donde ya quedó integrada la Semana 3 vía PR #4), para ser integrada después mediante Pull Request hacia `developer`.

## 2. Referencias verificadas al inicio

```text
$ git branch --show-current
feature/week-04-capas-asii15-mar-03

$ git log --oneline -3 origin/developer
50d4bba (origin/developer) Merge pull request #4 from Mar-03/feature/week-03-arquitectura-asii15-mar-03
...
```

- La rama `feature/week-04-capas-asii15-mar-03` fue recreada desde `origin/developer` tras eliminar un worktree/rama prematuros sin commits propios.
- `merge-base` con `origin/developer`: apunta a la propia base (`50d4bba`).
- El working tree se mantuvo limpio durante el desarrollo (solo adiciones de documentación en `ascii15/semana-04/`).

## 3. Código verificado (heredado, sin cambios en Semana 4)

- No se modificó código de la aplicación en esta semana.
- Se confirman por revisión: capas `src/Presentation`, `src/Application`, `src/Domain`, `src/Persistence`; contratos en `src/Domain/Contracts`; adaptadores PDO e InMemory; `PrescriptionController` sin SQL/PDO/reglas clínicas; usar PDO directamente en `src/Domain/` = 0 coincidencias.

## 4. Entregables de Semana 4

| Archivo | Estado |
|---|---|
| `ascii15/semana-04/README.md` | nuevo |
| `ascii15/semana-04/responsabilidades.md` | nuevo |
| `ascii15/semana-04/objetos-reutilizables.md` | nuevo |
| `ascii15/semana-04/repositorio-datos-compartido.md` | nuevo |
| `ascii15/semana-04/evidencia-git.md` | este archivo |
| `ascii15/semana-04/diagramas/arquitectura-capas.puml` | nuevo |
| `ascii15/semana-04/diagramas/arquitectura-capas.png` | generado |
| `ascii15/semana-04/diagramas/repositorio-datos-compartido.puml` | nuevo |
| `ascii15/semana-04/diagramas/repositorio-datos-compartido.png` | generado |
| `DECLARACION_IA.md` (raíz) | actualizado |

## 5. Pruebas

```text
$ php -v
PHP 8.2.12 (cli) ...

$ php bin/console.php test
Tests: 6, Failed: 0.

$ php bin/console.php test --filter=Mod15PrescriptionTest
Tests: 5, Failed: 0.
```

## 6. Lint (sintaxis PHP)

```text
$ php -l (sobre src/, tests/, bin/, public/, config/, bootstrap/, routes/)
No syntax errors detected (rango de archivos indicados por directorio)
```

## 7. Diagramas

- `arquitectura-capas.png` y `repositorio-datos-compartido.png` generados con PlantUML (v1.2024.8) a partir de los `.puml` de `ascii15/semana-04/diagramas/`.

## 8. Commit de esta rama

```text
docs(asii-15): document week 4 layered architecture
...(+ archivos de README, responsabilidades, objetos reutilizables,
repositorio de datos compartido, diagramas y evidencia; ver mensajes de
commits individuales en git log)
```

## 9. Estado final

```text
$ git branch --show-current
feature/week-04-capas-asii15-mar-03

$ git status
On branch feature/week-04-capas-asii15-mar-03
nothing to commit, working tree clean

$ git log origin/developer..HEAD --oneline
<commits de Semana 4>

$ git diff --check origin/developer...HEAD   # sin errores de espacio
```

## 10. Conclusión

Semana 4 queda documentada sobre la rama `feature/week-04-capas-asii15-mar-03` sin tocar `main`, `developer`, `feat/mod15-prescripciones-vanilla` ni la Semana 3. Pendiente: apertura de Pull Request hacia `developer` (a coordinar).