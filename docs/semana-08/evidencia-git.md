# Semana 8 - Evidencia Git

## 1. Base

- Base: `origin/developer`.
- Commit base: `b48a35c2be9eaf9c10ff3091664ef895a8c74b48`.
- Merge Semana 7: `b48a35c Merge pull request #11 from Mar-03/feature/week-07-componentes-refactor-asii15-mar-03`.

## 2. Rama y worktree

- Rama: `feature/week-08-ux-wireframes-asii15-mar-03`.
- Worktree: `shi-personal-asii15-s08-ux-wireframes`.

Verificacion inicial:

```text
$ git merge-base HEAD origin/developer
b48a35c2be9eaf9c10ff3091664ef895a8c74b48

$ git rev-list --left-right --count origin/developer...HEAD
0 0
```

## 3. Estado inicial

La rama S8 nace directamente desde `origin/developer` actualizado con Semana 7. Al inicio tiene cero commits propios.

## 4. Fase 1

Fase 1 realizo:

- Verificacion de integracion de Semana 7.
- Creacion de rama/worktree S8.
- Baseline funcional rapido.
- Auditoria de endpoints reales.
- Identificacion de actor principal y flujo UX.
- Propuesta de wireframes minimos.

## 5. Fase 2

Fase 2 realiza:

- Documentacion UX.
- Flujo de usuario.
- Wireframes de baja fidelidad.
- Render PNG con PlantUML.
- Actualizacion de `DECLARACION_IA.md`.

No modifica backend ni implementa frontend.

## 6. Archivos esperados

| Archivo | Estado |
|---|---|
| `docs/semana-08/README.md` | nuevo |
| `docs/semana-08/analisis-ux.md` | nuevo |
| `docs/semana-08/flujo-usuario.md` | nuevo |
| `docs/semana-08/wireframes.md` | nuevo |
| `docs/semana-08/evidencia-validacion.md` | nuevo |
| `docs/semana-08/evidencia-git.md` | este archivo |
| `docs/semana-08/wireframes/prescripcion-principal.puml` | nuevo |
| `docs/semana-08/wireframes/prescripcion-principal.png` | generado |
| `docs/semana-08/wireframes/alergia-excepcion.puml` | nuevo |
| `docs/semana-08/wireframes/alergia-excepcion.png` | generado |
| `DECLARACION_IA.md` | actualizado |
