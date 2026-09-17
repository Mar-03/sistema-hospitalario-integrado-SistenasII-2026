# Semana 10 - Evidencia de validacion

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

Semana 10 no modifica backend, endpoints, payloads, reglas clinicas, persistencia ni auditoria.

## 2. Validacion responsive documental

- Tres PUML renderizan correctamente.
- Tres PNG existen.
- Escritorio y movil muestran estructuras diferentes.
- Movil usa flujo vertical.
- No existe scroll horizontal conceptual.
- La alerta mantiene texto critico.
- No se pierde accesibilidad definida en Semana 9.

## 3. PlantUML

Wireframes fuente:

- `docs/semana-10/wireframes/prescripcion-desktop.puml`.
- `docs/semana-10/wireframes/prescripcion-mobile.puml`.
- `docs/semana-10/wireframes/alerta-mobile.puml`.

PNG generados:

- `docs/semana-10/wireframes/prescripcion-desktop.png` (`716x439`, `16743` bytes).
- `docs/semana-10/wireframes/prescripcion-mobile.png` (`420x677`, `15579` bytes).
- `docs/semana-10/wireframes/alerta-mobile.png` (`360x466`, `12792` bytes).

Los tres wireframes fueron renderizados con PlantUML mediante:

```text
java -jar C:\Users\Omega20\Documents\tools\plantuml\plantuml.jar
```

Resultado de render: los tres comandos finalizaron correctamente y generaron PNG validos.

## 4. Verificacion de alcance

Cambios esperados:

- `docs/semana-10/`.
- `DECLARACION_IA.md`.

No debe haber cambios en backend, frontend real, Semana 8 ni Semana 9.
