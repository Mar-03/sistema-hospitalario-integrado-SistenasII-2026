# Evidencia de Validacion - Semana 2

## Objetivo

Verificar que la entrega de Semana 2 contiene RF/RNF, criterios de aceptacion, diseno antes/despues, aplicacion SOLID y evidencia editable sin modificar el PDF.

## Archivos de la entrega

```text
ascii15/semana-02/README.md
ascii15/semana-02/diseno-antes-despues.puml
ascii15/semana-02/infraestructura-red-servidor.md
ascii15/semana-02/infraestructura-red-servidor.puml
ascii15/semana-02/evidencia-git.md
ascii15/semana-02/evidencia-validacion.md
ascii15/semana-02/guia-defensa.md
DECLARACION_IA.md
```

## Checklist de aceptacion

| Requisito de la consigna | Evidencia | Estado |
|---|---|:---:|
| RF/RNF | Tablas en `README.md` | Cumple |
| Criterios de aceptacion | Escenarios CA-ASII15-01 a CA-ASII15-06 | Cumple |
| Al menos un principio SOLID | DIP aplicado al diseno del modulo | Cumple |
| Fuente obligatoria | Cita a `https://mvpcluster.com/diseno-de-software-2/` | Cumple |
| No confundir etiqueta con justificacion | Se explica la razon arquitectonica y las razones de cambio | Cumple |
| Diseno antes/despues | Tabla y PlantUML `diseno-antes-despues.puml` | Cumple |
| Infraestructura de red y servidor | Documento y PlantUML nuevos | Cumple |
| Fuentes editables | Markdown y PlantUML | Cumple |
| Evidencia Git | `evidencia-git.md` con remoto, rama, historial, estado actual y commits verificados | Cumple |
| Datos ficticios | `PAC-DEM-0001`, `TENANT-DEMO-01`, medicamentos de ejemplo | Cumple |
| Declaracion IA | `DECLARACION_IA.md` actualizado | Cumple |
| Defensa oral | `guia-defensa.md` | Cumple |

## Comandos sugeridos para evidencia Git

```bash
git status --short --branch
git log --oneline -10
git remote -v
git ls-tree -r --name-only HEAD
```

## Validacion manual realizada

- Se reviso que la fuente SOLID usada sea la indicada por la consigna.
- Se uso DIP como principio principal y no se atribuyeron DRY, KISS ni YAGNI a la fuente.
- Se mantuvo coherencia con los diagramas UML de Semana 1 ubicados en `ascii15/uml/`.
- Se mantuvieron datos ficticios y sin informacion clinica identificable.
- No se genero ni modifico el PDF.
