# Semana 5 — Cliente-servidor, contrato REST e integración

## Portada técnica

- Curso: Análisis de Sistemas II
- Sistema: Sistema Hospitalario Integrado
- Estudiante: MARIA DE LOS ANGELES LOPEZ FAJARDO
- GitHub: Mar-03
- Repositorio: `https://github.com/Mar-03/sistema-hospitalario-integrado-SistenasII-2026.git`
- Rama: `feature/week-05-api-rest-asii15-mar-03`
- Base: `origin/developer` (commit `3383ac6`, incluye Semanas 1–4 y la consolidación funcional vía PR #7)
- Worktree: `shi-personal-asii15-s05-api-rest`
- Módulo: Prescripciones electrónicas con validación de alergias
- Semana: 5

## 1. Consigna

Analizar y documentar cómo el Micro-HIS ASII-15, ya construido en las Semanas 3 y 4, se expone e integra mediante un modelo **cliente-servidor** y un **contrato REST**: endpoints, payloads, campos obligatorios y opcionales, respuestas, errores, permisos, integración con el HIS, análisis de monolito vs microservicio y evidencia funcional real. No se solicita implementar interfaz gráfica.

## 2. Objetivo

Documentar, a partir del código real y de la ejecución efectiva, el contrato REST que expone el módulo y la forma en que se integra arquitectónicamente con el HIS, distinguiendo siempre **estado implementado** de **diseño futuro**.

## 3. Continuidad con Semana 4

Semana 5 usa EXACTAMENTE el mismo Micro-HIS ya consolidado en `developer` (PR #7, sobre Semana 4): capas `Presentation`, `Application`, `Domain`, `Persistence`; patrón Repository con contratos en `src/Domain/Contracts` (adaptadores PDO e InMemory); respuesta API JSON; SQLite en `database/prescripciones.sqlite`; y los seis casos probados. **No se reimplementa ni se modifica nada del backend.** La Semana 4 respondió "cómo se organiza la arquitectura por capas y el patrón Repository". La Semana 5 responde: **"¿cómo se expone e integra esa arquitectura mediante cliente-servidor y contrato REST?"**.

## 4. Arquitectura cliente-servidor

El Micro-HIS es un **cliente-servidor HTTP**: un cliente (representado en la evidencia por `curl`) envía peticiones HTTP/1.1 con cuerpo JSON a un servidor PHP. El flujo real, de entrada a salida:

```text
Cliente HTTP (curl)
  → public/index.php (front controller)
  → src/Presentation/Router.php (despacho)
  → src/Presentation/Controllers/PrescriptionController.php
  → src/Application/UseCases/CreatePrescriptionUseCase.php
  → src/Domain (entidades, Value Objects, regla de alergias)
  → contratos *RepositoryInterface
  → src/Persistence/Repositories/Pdo*.php
  → database/prescripciones.sqlite
```

El servidor responde siempre JSON con la estructura `{"status": <código>, "data": {...}}`. Para ejecución local se usa el servidor embebido de PHP (`php -S`); la validación de esta semana se hizo en un puerto libre (8000 estaba ocupado por el entorno de trabajo).

## 5. Contrato REST

Contrato real (confirmado contra el código y ejecutado):

| Método | Ruta | Caso | HTTP |
|---|---|---|---|
| GET | `/health` | salud del módulo | 200 |
| POST | `/prescriptions` | prescripción válida | 201 |
| POST | `/prescriptions` | alergia crítica sin excepción | 409 |
| POST | `/prescriptions` | excepción autorizada completa | 201 |
| POST | `/prescriptions` | excepción incompleta | 403 |
| POST | `/prescriptions` | datos inválidos / dominio inválido | 422 |
| POST | `/prescriptions` | falla de persistencia | 500 |
| GET/POST | cualquier otra ruta | ruta inexistente | 404 |

Payload real (POST `/prescriptions`):

- Obligatorios: `patient_id`, `medication_id`, `doctor_id`, `dose`, `route`, `frequency`.
- Opcionales: `date` (predeterminado `date('Y-m-d')` del servidor) y `exception` (`authorized` → boolean con default `false`, `reason`, `authorized_by`).

Detalle completo: `docs/semana-05/contrato-api.md`.

## 6. Integración con el HIS

- **Implementado hoy**: el módulo trabaja con datos locales (SQLite) de pacientes, medicamentos, alergias y `doctor_id`, y produce prescripciones, bloqueos clínicos (409), excepciones autorizadas y auditoría (`prescription_audits`). No consume servicios externos.
- **Integración futura (diseño)**: consumir pacientes, medicamentos, alergias e identidad/autorización de médicos desde el HIS compartido (análisis de owners y puertos en `docs/semana-04/repositorio-datos-compartido.md`).

Detalle completo: `docs/semana-05/integracion-his.md`.

## 7. Permisos

- **Estado actual**: NO hay JWT, RBAC, middleware de autorización ni tenancy funcional. `doctor_id` es un dato del payload que **no se autentica**. La única "autorización" es la validación de la excepción clínica (`reason` y `authorized_by` no vacíos cuando hay conflicto crítico).
- **Diseño futuro**: médico autorizado para prescribir, excepción clínica aprobada por la autorización correspondiente y acceso restringido a la auditoría. En ningún caso se presenta este diseño como implementado.

## 8. Monolito vs microservicio

El Micro-HIS es un **micro-monolito educativo**: un único proceso PHP, una base de datos propia (SQLite) y contratos de repositorio que lo desacoplan de la infraestructura. A pesar de su nombre, no es un microservicio: no se comunica por red con otros servicios. El análisis completo (acoplamiento, transacciones, consistencia clínica, auditoría, despliegue, observabilidad y complejidad operativa) está en `docs/semana-05/integracion-his.md`.

**Decisión preliminar**: mantener el módulo dentro del sistema/monolito integrado. La extracción a microservicio futuro debería depender de contratos estables, APIs maduras, identidad compartida, estrategia de consistencia, observabilidad y despliegue independiente. **No se implementa microservicio en esta semana.**

## 9. Evidencia

- Pruebas unitarias/integración: `Tests: 6, Failed: 0`; filtro `Mod15PrescriptionTest`: `Tests: 5, Failed: 0`.
- Evidencia HTTP real (200, 201, 409, 201, 403, 422, 404) y de persistencia/auditoría (`prescriptions = 2`, `prescription_audits = 1`).
- Números y comandos reproducibles: `docs/semana-05/evidencia-validacion.md`.
- Evidencia Git: `docs/semana-05/evidencia-git.md`.

## 10. Archivos entregados

- `docs/semana-05/README.md`
- `docs/semana-05/contrato-api.md`
- `docs/semana-05/integracion-his.md`
- `docs/semana-05/evidencia-validacion.md`
- `docs/semana-05/evidencia-git.md`
- `docs/semana-05/diagramas/integracion-cliente-servidor.puml` (+ PNG)
- `DECLARACION_IA.md` (raíz) · actualizado

## 11. Rama y worktree

- Rama: `feature/week-05-api-rest-asii15-mar-03` (actualizada por fast-forward a la base consolidada antes de comenzar Semana 5).
- Worktree: `shi-personal-asii15-s05-api-rest`.
- Base: `origin/developer` en `3383ac6`.
- Flujo: sin tocar `main` ni `developer`; la integración se coordinará mediante Pull Request hacia `developer`.

## 12. Fuera de alcance

- No se modifica código del Micro-HIS (solo documentación).
- No se agregan endpoints ni reglas de dominio.
- No se implementa autenticación, JWT, RBAC ni tenancy.
- No se crea UI, wireframes, mockups, accesibilidad ni responsive (Semanas 8–11).
- No se desarrollan componentes ni refactores de Semana 7.
- La integración con el HIS u otros módulos es una PROPUESTA de diseño, no una implementación.