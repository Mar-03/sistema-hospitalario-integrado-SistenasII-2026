# Semana 11 - Mockup y prototipo de interfaz

## 1. Objetivo

Semana 11 transforma los wireframes y criterios de Semanas 8, 9 y 10 en un mockup/prototipo visual estatico para el modulo ASII-15: Prescripciones electronicas con validacion de alergias.

El resultado es una representacion visual mas cercana a una aplicacion real, pero no es frontend productivo ni se conecta al backend.

## 2. Relacion con semanas previas

- Semana 8: define UX y wireframes iniciales.
- Semana 9: mejora usabilidad, accesibilidad conceptual, mensajes y jerarquia clinica.
- Semana 10: define adaptacion responsive para escritorio, tablet y movil.
- Semana 11: aplica esas decisiones en HTML/CSS estatico.

## 3. Que es el mockup

El mockup es un documento HTML local con estilos CSS propios. Representa estados del flujo sin ejecutar solicitudes reales.

No incluye logica funcional, persistencia, catalogos, autenticacion ni integracion con API.

## 4. Tecnologias usadas

- HTML estatico.
- CSS local.
- Fuente de sistema.
- Navegacion interna por anclas.

No se usan frameworks, CDN, JavaScript ni dependencias externas.

## 5. Estructura

- `mockups/prescripcion.html`.
- `mockups/styles.css`.
- Documentos de alcance, decisiones visuales, flujo, comparacion y evidencias.

## 6. Estados representados

- Formulario principal.
- Exito.
- Error de validacion.
- Alerta clinica critica por alergia.
- Excepcion autorizada.
- Excepcion incompleta.
- Error tecnico.

Los codigos `201`, `409`, `403`, `422` y `500` se documentan como trazabilidad tecnica, no como mensajes principales para el medico.

## 7. Adaptacion responsive

El CSS aplica un breakpoint del prototipo alrededor de `768px`:

- Escritorio: contenedor centrado, tarjetas amplias, grupos con dos columnas cuando corresponde.
- Movil: una columna, controles a ancho disponible y acciones apiladas.

Ese breakpoint pertenece al prototipo estatico, no define el sistema productivo futuro.

## 8. Criterios de accesibilidad

- Etiquetas visibles.
- Asociacion `label` / control con `for` e `id`.
- Campos obligatorios expresados con texto y `*`.
- Mensajes textuales.
- Acciones con nombres claros.
- Jerarquia de encabezados.
- No depender solo del color.

No se afirma certificacion WCAG ni validacion formal con lector de pantalla.

## 9. Limitaciones

- No hay conexion API.
- No hay catalogos reales.
- No hay busqueda ni autocomplete funcional.
- No hay autenticacion, JWT ni RBAC.
- No hay historial de prescripciones.
- No hay persistencia.

El backend real solo expone `GET /health` y `POST /prescriptions`.

## 10. Validaciones

- Baseline funcional ejecutado antes de crear S11.
- Baseline final ejecutado con `C:\Users\Omega20\Documents\tools\php-8.3\php.exe`.
- Revision estatica de HTML/CSS.
- Busqueda de integraciones prohibidas en el mockup.
- Validacion Git de alcance.

## 11. Rama/worktree

- Rama: `feature/week-11-mockup-prototipo-asii15-mar-03`.
- Worktree: `shi-personal-asii15-s11-mockup-prototipo`.
- Base: `origin/developer` en `3e2b883d45c3d63a1b8b446a49a808b14a433fbf`.
- Merge-base inicial: `3e2b883d45c3d63a1b8b446a49a808b14a433fbf`.
- Estado inicial: `0 0` contra `origin/developer`.
