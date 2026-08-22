# ADR-001 - Arquitectura

## Decision

Se implementa una arquitectura por capas:

- Presentation
- Application
- Domain
- Persistence

## Repository Pattern

El dominio depende de contratos y no de PDO directamente. Esto permite cambiar la persistencia sin tocar las reglas de negocio.

## PDO

PDO se usa para consultas preparadas, manejo de errores y transacciones cuando se guarda prescripcion y auditoria.

## Separacion dominio/persistencia

Las reglas de alergias, validacion y excepcion viven en Domain/Application. La base de datos solo guarda y recupera datos.
