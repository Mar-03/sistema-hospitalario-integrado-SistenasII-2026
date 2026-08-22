# Micro-HIS Mod15

Modulo educativo ejecutable en PHP 8.2+ vanilla para crear prescripciones electronicas con validacion previa de alergias.

## Instalacion

1. Copiar `.env.example` a `.env` si quieres cambiar la ruta de la base de datos.
2. Ejecutar migraciones y seed:

```bash
php bin/console.php migrate:fresh --seed
```

## Ejecucion

```bash
php -S localhost:8000 -t public
```

Endpoint principal:

- `POST /prescriptions`

## Pruebas

```bash
php bin/console.php test
php bin/console.php test --filter=Mod15PrescriptionTest
```
