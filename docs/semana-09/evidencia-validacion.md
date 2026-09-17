# Semana 9 - Evidencia de validacion

## 1. Baseline funcional

Comandos ejecutados con PHP portable:

```text
php bin/console.php migrate:fresh --seed
Migration completed

php bin/console.php test
Tests: 6, Failed: 0

php bin/console.php test --filter=Mod15PrescriptionTest
Tests: 5, Failed: 0
```

Semana 9 no modifica backend, endpoints, payloads, reglas clinicas, persistencia ni auditoria.

## 2. Validacion documental

- Ambos PUML renderizan correctamente.
- Ambos PNG existen.
- Obligatorios identificados con `*`.
- Alerta critica textual incluida.
- No hay dependencia exclusiva de color.
- Errores representados cerca del contexto correspondiente.
- `exception.reason` y `exception.authorized_by` identificados como obligatorios para excepcion autorizada.
- Integraciones futuras distinguidas del backend actual.

## 3. PlantUML

Wireframes fuente:

- `docs/semana-09/wireframes/prescripcion-usabilidad.puml`.
- `docs/semana-09/wireframes/alergia-accesible.puml`.

PNG generados:

- `docs/semana-09/wireframes/prescripcion-usabilidad.png` (`684x612`, `21516` bytes).
- `docs/semana-09/wireframes/alergia-accesible.png` (`572x456`, `16331` bytes).

Ambos wireframes fueron renderizados con PlantUML fuera del repositorio mediante:

```text
java -jar C:\Users\Omega20\Documents\tools\plantuml\plantuml.jar
```

Resultado de render: ambos comandos finalizaron correctamente y generaron PNG validos.

## 4. Verificacion de alcance

Cambios esperados:

- `docs/semana-09/`.
- `DECLARACION_IA.md`.

No debe haber cambios en:

- `src/`.
- `public/`.
- `routes/`.
- `tests/`.
- `database/`.
- `bin/`.
- `bootstrap/`.
- `config/`.
- `docs/semana-08/`.
