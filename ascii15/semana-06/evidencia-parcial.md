# Semana 6 - Evidencia del Primer Parcial

## 1. Alcance

Esta evidencia registra el estado real del modulo ASII-15 al checkpoint del Primer Parcial. Semana 6 no implementa funcionalidad, no agrega endpoints, no cambia reglas clinicas, no crea UI y no refactoriza codigo.

## 2. Base verificada

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

Confirmaciones:

- `origin/developer` contiene Semana 5 recien integrada.
- HEAD actual de `origin/developer`: `ee4537114e81f99c804a80637ba15fb1cab4a09d`.
- Merge de Semana 5: `ee45371 Merge pull request #8 from Mar-03/feature/week-05-api-rest-asii15-mar-03`.
- `ascii15/semana-05/` contiene README, contrato API, integracion HIS, evidencia, diagrama PlantUML y PNG.
- El backend funcional sigue presente.

## 3. Validacion solicitada

Comandos solicitados:

```text
php bin/console.php migrate:fresh --seed
php bin/console.php test
php bin/console.php test --filter=Mod15PrescriptionTest
```

Resultado real en este entorno:

```text
$ php bin/console.php migrate:fresh --seed
php : El termino 'php' no se reconoce como nombre de un cmdlet, funcion, archivo de script o programa ejecutable.
```

Verificacion adicional:

```text
$ where.exe php
INFORMACION: no se pudo encontrar ningun archivo para los patrones dados.
```

Conclusion: no se pudieron ejecutar migracion ni pruebas en este entorno porque PHP no esta disponible. No se registran resultados inventados. La ultima evidencia ejecutada y mergeada desde Semana 5 reporta `Tests: 6, Failed: 0` y `Tests: 5, Failed: 0` para `Mod15PrescriptionTest`.

## 4. Contrato funcional acumulado

Estado esperado del contrato, documentado en Semana 5 y preservado por Semana 6:

| Caso | Resultado esperado |
|---|---|
| `GET /health` | `200` |
| `POST /prescriptions` valida | `201` |
| Alergia critica sin excepcion | `409` |
| Excepcion autorizada completa | `201` |
| Excepcion incompleta | `403` |
| Datos invalidos | `422` |
| Ruta inexistente | `404` |
| Falla de persistencia | `500` por prueba automatizada |

## 5. Persistencia actual

El backend mantiene persistencia SQLite con:

- `prescriptions`.
- `prescription_audits`.
- Auditoria `authorized_exception` cuando se crea una prescripcion con excepcion autorizada.

No se modificaron migraciones, seeders ni repositorios en Semana 6.

## 6. Estado arquitectonico real

Componentes presentes:

- Presentation.
- Application.
- Domain.
- Persistence.
- Repository contracts.
- PDO repositories.
- InMemory repositories.
- SQLite.
- Router.
- Controller.
- UseCase.
- Value Objects.
- Detector de alergias.

Componentes aun no implementados:

- UI ASII-15.
- JWT funcional en este Micro-HIS.
- RBAC funcional.
- Tenancy funcional.
- Integracion real con modulos externos.
- Endpoints de lectura de catalogos.

## 7. Observacion de checkpoint

Semana 6 queda como punto de control documental del Primer Parcial. El codigo funcional permanece igual al recibido desde `origin/developer`; cualquier refactor o reorganizacion tecnica se posterga para Semana 7 y debera preservar el comportamiento observable.
