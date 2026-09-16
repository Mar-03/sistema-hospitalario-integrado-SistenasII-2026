# Semana 7 - Evidencia de validacion

## 1. Alcance de esta evidencia

Semana 7 Fase 2A documenta el analisis de componentes y el diseno del refactor. No modifica codigo funcional y no ejecuta refactorizacion porque PHP no esta disponible en el entorno actual.

## 2. Baseline funcional historico confirmado

La ultima validacion funcional confirmada corresponde a Semana 5, antes del checkpoint documental de Semana 6.

Resultados historicos registrados:

```text
Migration completed
Tests generales: 6/6
Tests especificos Mod15PrescriptionTest: 5/5
```

Contrato historicamente confirmado:

| Caso | Resultado |
|---|---|
| `GET /health` | `200` |
| `POST /prescriptions` valida | `201` |
| Alergia critica sin excepcion | `409` |
| Excepcion autorizada completa | `201` |
| Excepcion incompleta | `403` |
| Datos invalidos | `422` |
| Ruta inexistente | `404` |
| Falla de persistencia | `500` por prueba automatizada |

Persistencia historicamente confirmada:

- Caso feliz persiste.
- `409` no persiste.
- `403` no persiste.
- `422` no persiste.
- Excepcion autorizada persiste.
- Auditoria `authorized_exception` funciona en `prescription_audits`.

## 3. Validacion actual S7

Validacion actual: bloqueada temporalmente.

Comandos requeridos para baseline actual:

```text
php bin/console.php migrate:fresh --seed
php bin/console.php test
php bin/console.php test --filter=Mod15PrescriptionTest
```

Resultado del entorno:

```text
Get-Command php -ErrorAction SilentlyContinue
# sin resultado

where.exe php
INFORMACION: no se pudo encontrar ningun archivo para los patrones dados.
```

Conclusion: PHP no esta disponible en el entorno actual, por lo que no se afirma ejecucion nueva de migraciones, tests ni pruebas HTTP para Semana 7 Fase 2A.

## 4. Validacion post-refactor

Pendiente de Fase 2B.

Cuando PHP este disponible, Fase 2B debe registrar antes y despues:

- `php bin/console.php migrate:fresh --seed`.
- `php bin/console.php test`.
- `php bin/console.php test --filter=Mod15PrescriptionTest`.
- Pruebas HTTP de `GET /health`, `POST /prescriptions`, alergia critica, excepciones, datos invalidos, ruta inexistente y persistencia fallida.

La evidencia final debe demostrar que el refactor separa responsabilidades sin cambiar comportamiento observable.
