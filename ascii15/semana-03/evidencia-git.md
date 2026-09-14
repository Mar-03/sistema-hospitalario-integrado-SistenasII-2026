# Evidencia Git — Semana 3

## Repositorio

- Repositorio: `https://github.com/Mar-03/sistema-hospitalario-integrado-SistenasII-2026.git`
- Usuario GitHub: `Mar-03`
- Rama: `feature/week-03-arquitectura-asii15-mar-03`
- Base: `origin/developer` (`76cd2bb Merge pull request #2 from Mar-03/docs/asii15-evidencia-semanas-1-2`)
- Worktree: `shi-personal-asii15-week-03-arquitectura`
- Estado Git: `Cumple`

## Flujo Git del curso

```text
main
  ↓
developer
  ↓
feature/week-XX-*
  ↓ PR
developer
```

Semana 3 nace de `developer` y su PR final se abrirá hacia `developer` (aún no creado).

## Comandos ejecutados

```bash
# Verificación de developer
git remote -v
git fetch origin
git branch -vv
git log developer --oneline -10
git log origin/developer --oneline -10

# Verificación por contenido del Micro-HIS en origin/developer
git cat-file -e origin/developer:<path>  # 28 rutas verificadas

# Creación del worktree de Semana 3 desde origin/developer
git worktree add ../shi-personal-asii15-week-03-arquitectura feature/week-03-arquitectura-asii15-mar-03
git branch --show-current

# Validaciones dentro del worktree
php -v
php bin/console.php test
php bin/console.php test --filter=Mod15PrescriptionTest
php -l (src/, tests/, bin/, public/, config/, bootstrap/, routes/)
java -jar plantuml.jar ascii15/semana-03/diagramas/arquitectura-c4.puml

# Validación Git final
git branch --show-current
git merge-base HEAD origin/developer
git log origin/developer..HEAD --oneline
git diff --name-only origin/developer...HEAD
git diff --check
git status
git diff --stat origin/developer...HEAD
```

## Versión PHP

- `php -v` → PHP 8.2.12.
- Requisito formalizado en `bootstrap/autoload.php` con `PHP_VERSION_ID < 80200` → error claro y `exit(1)`.

## Pruebas

- Suite global: **Tests: 6, Failed: 0**
  - camino feliz (201);
  - regla de alergia crítica (409);
  - error de persistencia (500);
  - excepción autorizada (201);
  - dosis inválida (422) — nueva en Semana 3;
  - PDO real (SQLite temporal, migraciones + seed + guardado).
- Filtro `Mod15PrescriptionTest`: **Tests: 5, Failed: 0**.
- Lint PHP: sin errores de sintaxis.

## Resultado

- `Tests: 6, Failed: 0`
- PlantUML: `arquitectura-c4.png` generado correctamente (173 KB).

## Archivos de evidencia de Semana 3

```text
ascii15/semana-03/README.md
ascii15/semana-03/evidencia-git.md
ascii15/semana-03/diagramas/arquitectura-c4.puml
ascii15/semana-03/diagramas/arquitectura-c4.png
bootstrap/autoload.php
tests/Feature/Mod15PrescriptionTest.php
DECLARACION_IA.md
```

## Commits conocidos

Commits locales creados solo en `feature/week-03-arquitectura-asii15-mar-03` (sin push):

1. `chore(asii-15): enforce php 8.2 for week 3` — guard en `bootstrap/autoload.php`;
2. `test(asii-15): cover invalid prescription data for week 3` — `testInvalidDoseIsRejected`;
3. `docs(asii-15): add week 3 architecture evidence` — README, evidencia-git y diagrama C4/UML (este commit agrega el presente archivo; no se registra aquí el hash de sí mismo);
4. `docs(asii-15): update week 3 ai declaration` — actualización de `DECLARACION_IA.md`.

## Base del merge

`git merge-base HEAD origin/developer` registra la base de la rama sobre `developer`. Sin push y sin PR hasta autorización.