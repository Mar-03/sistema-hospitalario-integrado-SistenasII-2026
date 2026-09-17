# Semana 6 - Evidencia Git

Rama: `feature/week-06-primer-parcial-asii15-mar-03` · Worktree: `shi-personal-asii15-s06-parcial` · Base: `origin/developer` (`ee4537114e81f99c804a80637ba15fb1cab4a09d`)

## 1. Verificacion inicial

```text
$ git fetch origin

$ git log origin/developer -10 --oneline
ee45371 Merge pull request #8 from Mar-03/feature/week-05-api-rest-asii15-mar-03
088f21b docs(asii-15): finalize week 5 git evidence
ba87a63 docs(asii-15): update week 5 ai declaration
deb4c74 docs(asii-15): document week 5 validation and git evidence
aa4d39c docs(asii-15): add week 5 client-server integration diagram
028f090 docs(asii-15): document week 5 rest contract and client-server integration
3383ac6 Merge pull request #7 from Mar-03/tech/asii15-consolidacion-funcional-s04-mar-03
b918390 Merge pull request #5 from Mar-03/feature/week-04-capas-asii15-mar-03
bd929d3 fix(asii-15): health endpoint returns 200 and route map uses GET
495f769 chore(asii-15): align sqlite db path to database/prescripciones.sqlite
```

```text
$ git status
On branch main
Your branch is up to date with 'origin/main'.

nothing to commit, working tree clean
```

La verificacion inicial se hizo desde el worktree principal antes de crear S6. Se confirmo que `origin/developer` contiene el merge de Semana 5 y que los archivos `docs/semana-05/` estan presentes en el arbol remoto.

## 2. Creacion de rama y worktree

```text
$ git worktree add -b feature/week-06-primer-parcial-asii15-mar-03 C:\Users\Omega20\Documents\hospital_personal\shi-personal-asii15-s06-parcial origin/developer
Preparing worktree (new branch 'feature/week-06-primer-parcial-asii15-mar-03')
branch 'feature/week-06-primer-parcial-asii15-mar-03' set up to track 'origin/developer'.
HEAD is now at ee45371 Merge pull request #8 from Mar-03/feature/week-05-api-rest-asii15-mar-03
```

Confirmacion de base exacta:

```text
$ git rev-parse HEAD
ee4537114e81f99c804a80637ba15fb1cab4a09d

$ git rev-parse origin/developer
ee4537114e81f99c804a80637ba15fb1cab4a09d
```

## 3. Archivos de Semana 6

Archivos creados o modificados:

| Archivo | Estado |
|---|---|
| `docs/semana-06/README.md` | nuevo |
| `docs/semana-06/evidencia-parcial.md` | nuevo |
| `docs/semana-06/evidencia-git.md` | este archivo |
| `DECLARACION_IA.md` | actualizado |

No se modifico codigo de `src/`, `tests/`, `public/`, `routes/`, `bin/`, `bootstrap/`, `config/` ni `database/`.

## 4. Pruebas

Comandos requeridos para el checkpoint:

```text
php bin/console.php migrate:fresh --seed
php bin/console.php test
php bin/console.php test --filter=Mod15PrescriptionTest
```

Resultado real de ejecucion en este entorno:

```text
php : El termino 'php' no se reconoce como nombre de un cmdlet, funcion, archivo de script o programa ejecutable.
```

```text
$ where.exe php
INFORMACION: no se pudo encontrar ningun archivo para los patrones dados.
```

Por ausencia de PHP en el entorno actual, la validacion queda pendiente de repetir localmente con PHP disponible. No se altero codigo para sortear el problema.

## 5. Estado del proyecto

Semana 6 conserva el flujo acumulativo:

```text
developer
  -> Semana 1
  -> Semana 2
  -> Semana 3
  -> Semana 4
  -> backend funcional
  -> Semana 5
  -> Semana 6
```

Semana 7 no fue creada. Su rama y worktree se prepararan solo despues de mergear Semana 6 a `developer`.

## 6. Seccion para completar despues

Pendiente despues de contar con PHP disponible y antes del PR:

```text
$ git diff --check

$ git status

$ php bin/console.php migrate:fresh --seed

$ php bin/console.php test

$ php bin/console.php test --filter=Mod15PrescriptionTest
```

Tambien quedara pendiente registrar los commits reales de Semana 6 una vez autorizados. No se incluyen hashes futuros.
