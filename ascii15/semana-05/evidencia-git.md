# Semana 5 — Evidencia Git

Rama: `feature/week-05-api-rest-asii15-mar-03` · Worktree: `shi-personal-asii15-s05-api-rest` · Base: `origin/developer` (`3383ac6`)

## 1. Flujo

El trabajo de Semana 5 se desarrolla sobre la rama `feature/` nacida de `developer`, siguiendo el flujo `main → developer → feature/<semana-o-funcionalidad>`. La rama fue actualizada por fast-forward a la base consolidada antes de comenzar (ver sección 2) y NO se trabaja en `main` ni en `developer`.

## 2. Referencias verificadas al inicio

```text
$ git branch --show-current
feature/week-05-api-rest-asii15-mar-03

$ git log -1 --oneline HEAD
3383ac6 Merge pull request #7 from Mar-03/tech/asii15-consolidacion-funcional-s04-mar-03

$ git merge-base HEAD origin/developer
3383ac6...
```

- `origin/developer` se encontraba en `3383ac6` al inicio de Semana 5 (Semanas 1–4 + consolidación funcional vía PR #7).
- `git fetch origin` no trajo cambios nuevos para `developer` (`3383ac6`).
- La rama `feature/week-05-api-rest-asii15-mar-03` fue alineada previamente con `origin/developer` mediante fast-forward puro (`50d4bba..3383ac6`), sin rebase ni cherry-pick.

## 3. Código verificado (heredado, sin cambios en Semana 5)

- No se modificó código de la aplicación.
- Se confirma por revisión y ejecución: capas `src/Presentation`, `src/Application`, `src/Domain`, `src/Persistence`; contratos en `src/Domain/Contracts`; adaptadores PDO e InMemory; `public/index.php` como front controller; Router que despacha `GET /health` y `POST /prescriptions` y responde JSON `{"status", "data"}`.

## 4. Entregables de Semana 5

| Archivo | Estado |
|---|---|
| `ascii15/semana-05/README.md` | nuevo |
| `ascii15/semana-05/contrato-api.md` | nuevo |
| `ascii15/semana-05/integracion-his.md` | nuevo |
| `ascii15/semana-05/evidencia-validacion.md` | nuevo |
| `ascii15/semana-05/evidencia-git.md` | este archivo |
| `ascii15/semana-05/diagramas/integracion-cliente-servidor.puml` | nuevo |
| `ascii15/semana-05/diagramas/integracion-cliente-servidor.png` | generado |
| `DECLARACION_IA.md` (raíz) | actualizado |

## 5. Pruebas (resultados en `evidencia-validacion.md`)

```text
$ php bin/console.php migrate:fresh --seed
Migration completed

$ php bin/console.php test
Tests: 6, Failed: 0

$ php bin/console.php test --filter=Mod15PrescriptionTest
Tests: 5, Failed: 0
```

## 6. Lint (sintaxis PHP)

```text
$ php -l (sobre src/, tests/, bin/, public/, config/, bootstrap/, routes/)
No syntax errors detected
```

## 7. Diagramas

- `integracion-cliente-servidor.png` generado con PlantUML a partir del `.puml` de `ascii15/semana-05/diagramas/`, sin errores de renderizado.

## 8. Commits de esta rama

```text
028f090 docs(asii-15): document week 5 rest contract and client-server integration
        (README.md · contrato-api.md · integracion-his.md)

aa4d39c docs(asii-15): add week 5 client-server integration diagram
        (diagramas/integracion-cliente-servidor.puml · .png)

<pendiente> docs(asii-15): document week 5 validation and git evidence
        (evidencia-validacion.md · este archivo)

<pendiente> docs(asii-15): update week 5 ai declaration
        (DECLARACION_IA.md)
```

El hash del commit de este archivo se registra al finalizar (evita el ciclo autorreferencial: no se escribe `evidencia-git.md` con su propio hash).

## 9. Estado final

```text
$ git branch --show-current
feature/week-05-api-rest-asii15-mar-03

$ git status
On branch feature/week-05-api-rest-asii15-mar-03
... (al día - commits de Semana 5 realizados; pendiente push/PR)

$ git diff --check   # sin errores de espacio
```

## 10. Conclusión

Semana 5 queda documentada sobre `feature/week-05-api-rest-asii15-mar-03` sin tocar `main` ni `developer`, sin modificar código y sin adelantar Semanas 6–11. Pendiente: apertura de Pull Request hacia `developer` (a coordinar).