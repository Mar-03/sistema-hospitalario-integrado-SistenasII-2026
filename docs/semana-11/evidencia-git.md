# Semana 11 - Evidencia Git

## 1. Base

```text
origin/developer = 3e2b883d45c3d63a1b8b446a49a808b14a433fbf
```

La base contiene la integracion de Semana 10 y la reorganizacion documental bajo `docs/`.

## 2. Rama

```text
feature/week-11-mockup-prototipo-asii15-mar-03
```

## 3. Worktree

```text
C:\Users\Omega20\Documents\hospital_personal\shi-personal-asii15-s11-mockup-prototipo
```

## 4. Merge-base

```text
3e2b883d45c3d63a1b8b446a49a808b14a433fbf
```

## 5. Estado inicial

```text
git rev-list --left-right --count origin/developer...HEAD
0 0
```

## 6. Archivos creados

- `docs/semana-11/README.md`.
- `docs/semana-11/alcance-mockup.md`.
- `docs/semana-11/decisiones-visuales.md`.
- `docs/semana-11/flujo-prototipo.md`.
- `docs/semana-11/comparacion-wireframe-mockup.md`.
- `docs/semana-11/evidencia-validacion.md`.
- `docs/semana-11/evidencia-git.md`.
- `docs/semana-11/mockups/prescripcion.html`.
- `docs/semana-11/mockups/styles.css`.

## 7. Archivos modificados

- `DECLARACION_IA.md`.

## 8. Diff real

El diff se limita a `docs/semana-11/` y `DECLARACION_IA.md`.

## 9. Estado actual

```text
git status --short
 M DECLARACION_IA.md
?? docs/semana-11/
```

## 10. Validaciones Git reales

```text
git diff --check
warning: in the working copy of 'DECLARACION_IA.md', LF will be replaced by CRLF the next time Git touches it
```

```text
git diff --name-only
DECLARACION_IA.md
```

Nota: `docs/semana-11/` aparece como contenido nuevo sin seguimiento; por eso no entra en `git diff --name-only` hasta ser agregado al indice.

```text
git ls-files --others --exclude-standard
docs/semana-11/README.md
docs/semana-11/alcance-mockup.md
docs/semana-11/comparacion-wireframe-mockup.md
docs/semana-11/decisiones-visuales.md
docs/semana-11/evidencia-git.md
docs/semana-11/evidencia-validacion.md
docs/semana-11/flujo-prototipo.md
docs/semana-11/mockups/prescripcion.html
docs/semana-11/mockups/styles.css
```

```text
git diff --stat
DECLARACION_IA.md | 12 +++++++++++-
1 file changed, 11 insertions(+), 1 deletion(-)
```

```text
git diff --name-only -- docs/semana-08 docs/semana-09 docs/semana-10

```

Resultado: Semanas 8, 9 y 10 sin cambios.
