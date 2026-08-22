# Evidencia

## Comandos ejecutados

- `php -v`
- `composer -V`
- `phpunit --version`
- `php bin/console.php migrate:fresh --seed`
- `php bin/console.php test`
- `php bin/console.php test --filter=Mod15PrescriptionTest`
- `php -l public/index.php`
- `php -l bin/console.php`
- `php -l tests/Runner.php`

## Resultado esperado

- PHP 8.2+ disponible.
- PDO SQLite funcional.
- Pruebas automatizadas sin fallos.

## Resultados obtenidos

- `migrate:fresh --seed`: ok.
- `test`: 5 pruebas, 0 fallos.
- `test --filter=Mod15PrescriptionTest`: 4 pruebas, 0 fallos.
- Lint de puntos de entrada: sin errores de sintaxis.

## Arbol del proyecto

```text
bin/
bootstrap/
config/
docs/
public/
routes/
src/
tests/
storage/
```

## Git log

- `896c144 docs(asii-15): agregar diagramas de procesos semana 2`
- `7143a1d docs(asii-15): agregar infraestructura red y servidor`
- `ac4164b docs(asii-15): registrar evidencia git semana 2`
- `2b1ae4b docs(asii-15): actualizar declaracion IA semana 2`
- `eabbb98 docs(asii-15): agregar evidencia y defensa semana 2`

## Commit evaluado

- `896c144`
