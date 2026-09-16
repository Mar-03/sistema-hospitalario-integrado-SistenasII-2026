# Semana 6 - Primer Parcial

## 1. Objetivo

Semana 6 funciona como punto de control del Primer Parcial para el modulo ASII-15: Prescripciones electronicas con validacion de alergias. No agrega funcionalidad nueva. Su objetivo es verificar y documentar el estado acumulado del repositorio personal hasta Semana 5, manteniendo trazabilidad tecnica y academica.

## 2. Estado acumulado

El repositorio personal llega a Semana 6 con documentacion incremental de Semanas 1 a 5 y con un backend funcional del Micro-HIS para crear prescripciones, validar alergias criticas, permitir excepciones autorizadas, persistir en SQLite y registrar auditoria para excepciones.

Base verificada al inicio:

- `origin/developer`: `ee4537114e81f99c804a80637ba15fb1cab4a09d`.
- Merge de Semana 5 detectado: `ee45371 Merge pull request #8 from Mar-03/feature/week-05-api-rest-asii15-mar-03`.
- Archivos de Semana 5 presentes en `ascii15/semana-05/`.
- Backend funcional presente en `src/`, `public/`, `routes/`, `bin/`, `bootstrap/`, `config/`, `database/` y `tests/`.

## 3. Resumen Semanas 1-5

| Semana | Enfoque | Resultado acumulado |
|---|---|---|
| Semana 1 | Requisitos, actores y casos de uso | Definicion del proceso de prescripcion con verificacion previa de alergias, actor Medico y limites del HIS. |
| Semana 2 | Requisitos funcionales/no funcionales y SOLID | RF/RNF, criterios de aceptacion y aplicacion inicial de DIP para separar reglas de negocio de infraestructura. |
| Semana 3 | Arquitectura de alto nivel | Modelo arquitectonico del Micro-HIS, flujo de prescripcion y validacion tecnica inicial. |
| Semana 4 | Arquitectura por capas + Repository | Separacion Presentation/Application/Domain/Persistence, contratos Repository y adaptadores PDO/InMemory. |
| Semana 5 | Cliente-servidor + contrato REST + integracion HIS | Contrato HTTP real, integracion cliente-servidor, evidencia funcional y distincion entre implementado y diseno futuro. |
| Semana 6 | Primer Parcial | Checkpoint del estado acumulado, evidencia de consistencia y preparacion para Semana 7 sin modificar comportamiento. |

## 4. Estado arquitectonico

Actualmente existe:

- `Presentation`: `Router`, `PrescriptionController`, `CreatePrescriptionRequest`.
- `Application`: `CreatePrescriptionUseCase` y DTOs de entrada/salida.
- `Domain`: entidades, Value Objects, excepciones y detector de alergias.
- `Persistence`: migraciones, seeders, conexion SQLite y repositorios PDO.
- Contratos Repository en `src/Domain/Contracts`.
- Repositorios PDO para ejecucion real.
- Repositorios InMemory en `tests/Fakes` para pruebas.
- SQLite como base local del Micro-HIS.
- Router HTTP con `GET /health` y `POST /prescriptions`.
- Controller de prescripciones.
- UseCase de creacion de prescripcion.
- Value Objects para dosis, via y frecuencia.
- Detector de alergias criticas.

Todavia no existe:

- UI ASII-15.
- JWT funcional en este Micro-HIS.
- RBAC funcional.
- Tenancy funcional.
- Integracion real con modulos externos.
- Endpoints de lectura de catalogos.

## 5. Estado funcional

El comportamiento acumulado documentado y protegido por pruebas hasta Semana 5 es:

- `GET /health` responde `200`.
- `POST /prescriptions` valida campos obligatorios.
- Prescripcion valida responde `201`.
- Alergia critica sin excepcion responde `409`.
- Excepcion autorizada completa responde `201` y persiste auditoria.
- Excepcion incompleta responde `403`.
- Datos invalidos responden `422`.
- Falla de persistencia responde `500` por prueba automatizada.
- Ruta inexistente responde `404`.

Persistencia actual:

- Tabla `prescriptions`.
- Tabla `prescription_audits`.
- Auditoria con accion `authorized_exception` cuando existe excepcion clinica autorizada.

## 6. Pruebas

Comandos definidos para validar el checkpoint:

```text
php bin/console.php migrate:fresh --seed
php bin/console.php test
php bin/console.php test --filter=Mod15PrescriptionTest
```

En este entorno de ejecucion actual, `php` no esta disponible en el PATH (`where.exe php` no encontro ejecutable), por lo que las pruebas no pudieron ejecutarse nuevamente desde este worktree. No se inventan resultados. La evidencia tecnica de Semana 5 permanece como ultimo resultado ejecutado y mergeado en `developer`: suite completa `Tests: 6, Failed: 0` y filtro `Mod15PrescriptionTest` `Tests: 5, Failed: 0`.

## 7. Riesgos/deuda conocida

- No hay autenticacion real; `doctor_id` viene del payload.
- No hay JWT, RBAC ni tenancy.
- No hay integracion real con catalogos externos de pacientes, medicamentos o alergias.
- No hay endpoints de lectura de catalogos.
- El Router centraliza respuesta JSON y captura generica de errores.
- El bootstrap HTTP arma dependencias manualmente en `public/index.php`.
- La validacion de entrada y mapeo a DTO pueden revisarse en Semana 7 sin cambiar comportamiento.

## 8. Que queda pendiente

- Ejecutar nuevamente migracion y pruebas cuando PHP este disponible en el entorno local.
- Abrir PR de Semana 6 hacia `developer` despues de revision.
- Mergear Semana 6 a `developer` antes de crear Semana 7.
- En Semana 7, analizar componentes internos y aplicar solo refactors justificados que preserven el contrato observable.

## 9. Entregables

- `ascii15/semana-06/README.md`.
- `ascii15/semana-06/evidencia-parcial.md`.
- `ascii15/semana-06/evidencia-git.md`.
- `DECLARACION_IA.md` actualizado.

No se crean diagramas nuevos en Semana 6 porque el parcial es un checkpoint del estado acumulado y no introduce arquitectura nueva.

## 10. Rama/worktree

- Rama: `feature/week-06-primer-parcial-asii15-mar-03`.
- Worktree: `shi-personal-asii15-s06-parcial`.
- Base exacta: `origin/developer` en `ee4537114e81f99c804a80637ba15fb1cab4a09d`.
- Flujo: Semana 6 nace de `developer` actual. Semana 7 no debe crearse hasta que Semana 6 sea mergeada a `developer`.
