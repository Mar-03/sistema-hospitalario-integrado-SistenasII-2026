# Sistema Hospitalario Integrado 2026

## Estudiante

María de los Ángeles López Fajardo

## Módulo

ASII-15 — Prescripciones electrónicas con validación de alergias

## Objetivo del módulo

Gestionar la creación de prescripciones electrónicas validando previamente las alergias activas del paciente para prevenir indicaciones inseguras.

## Avance académico

### Semana 1 - Conceptos generales, orientación a objetos y UML

Se realizaron:

- Diagrama de casos de uso.
- Diagrama de actividad.
- Diagrama de secuencia.
- Narrativa de alcance.
- Matriz de trazabilidad.
- Evidencia Git.
- Fuentes PlantUML editables.
- Imágenes PNG de los diagramas.

Enlaces:

- `docs/semana-01/uml/README.md`
- `docs/semana-01/uml/casos-de-uso.puml`
- `docs/semana-01/uml/actividad.puml`
- `docs/semana-01/uml/secuencia.puml`
- `docs/semana-01/imagenes/`
- `docs/semana-01/matriz-trazabilidad.md`
- `docs/semana-01/evidencia-git.md`
- `docs/semana-01/guia-defensa.md`

### Semana 2 - Proceso y modelo de diseño; principios SOLID

Se realizaron:

- Requerimientos funcionales.
- Requerimientos no funcionales.
- Criterios de aceptación.
- Aplicación del principio DIP.
- Diseño antes/después.
- Justificación de responsabilidades y dependencias.
- Evidencia Git.
- Evidencia de validación.

Enlaces:

- `docs/semana-02/README.md`
- `docs/semana-02/proceso-global.puml`
- `docs/semana-02/proceso-prescripciones.puml`
- `docs/semana-02/diseno-antes-despues.puml`
- `docs/semana-02/diagrama-procesos-global.md`
- `docs/semana-02/infraestructura-red-servidor.md`
- `docs/semana-02/infraestructura-red-servidor.puml`
- `docs/semana-02/evidencia-git.md`
- `docs/semana-02/evidencia-validacion.md`
- `docs/semana-02/guia-defensa.md`

### Avance posterior

El repositorio contiene avances posteriores del módulo en una rama de trabajo independiente. La presente evidencia académica se concentra únicamente en las Semanas 1 y 2.

## Estructura del repositorio

```text
docs/
├── semana-01/
│   ├── imagenes/
│   ├── uml/
│   ├── evidencia-git.md
│   ├── guia-defensa.md
│   └── matriz-trazabilidad.md
└── semana-02/
```

## Flujo Git

El historial revisado muestra que la evidencia académica de Semana 1 y Semana 2 quedó documentada en la rama `main` del repositorio remoto. El trabajo posterior del módulo se separó en una rama independiente de desarrollo para no mezclar la entrega académica con avances adicionales.

Para los próximos avances, el flujo recomendado será:

```text
main
└── developer
    └── feature/<semana-o-funcionalidad>
```

- `main`: versión estable y entregable.
- `developer`: integración de avances antes de publicar.
- `feature/*`: trabajo aislado por semana o funcionalidad.

## Referencias útiles

- `docs/semana-01/flujo-git.md`
- `docs/README.md`
- `docs/ESPECIFICACION.md`
- `docs/ADR-001-arquitectura.md`
