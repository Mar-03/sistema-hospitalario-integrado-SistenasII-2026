# Guia Breve Para Defensa Oral - Semana 2

## Resumen para explicar

En Semana 2 se transformo el proceso UML de prescripcion con validacion de alergias en requerimientos funcionales, no funcionales y criterios de aceptacion. Ademas, se propuso una mejora de diseno aplicando DIP para que el flujo de alto nivel dependa de contratos y no de clases concretas de persistencia o validacion.

## Decision principal

La decision mas relevante fue hacer que `CreatePrescriptionAction` dependa de contratos como `PatientLookup`, `MedicationLookup`, `AllergyValidator` y `PrescriptionWriter`. Esto permite cambiar Eloquent, el motor de validacion o la persistencia sin modificar la politica principal del flujo.

## Como defender DIP

- DIP significa que las clases de alto nivel no deben depender de clases de bajo nivel; ambas deben depender de abstracciones.
- En el diseno antes, `CreatePrescriptionAction` dependia directamente de repositorios Eloquent y de un servicio concreto de validacion.
- En el diseno despues, `CreatePrescriptionAction` depende de interfaces: `PatientLookup`, `MedicationLookup`, `AllergyValidator` y `PrescriptionWriter`.
- La mejora es arquitectonica porque reduce acoplamiento, permite reemplazar implementaciones y facilita pruebas con dobles ficticios.

## Preguntas probables

1. Que principio SOLID aplicaste?

   Aplique DIP, principio de inversion de dependencias.

2. Cual es la fuente obligatoria usada?

   MVP Cluster, `https://mvpcluster.com/diseno-de-software-2/`, especificamente la seccion de Dependency Inversion.

3. Por que no basta con decir "aplico DIP"?

   Porque la rubrica pide justificacion arquitectonica. Por eso se muestra el diseno antes con dependencias concretas y el diseno despues con contratos e implementaciones separadas.

4. Que cambia si manana cambia la regla de alergias?

   Cambia la implementacion de `AllergyValidator`, no el contrato ni `CreatePrescriptionAction`.

5. Que criterio de aceptacion prueba el caso critico?

   `CA-ASII15-02`, donde el paciente ficticio tiene alergia activa a Amoxicilina y el sistema bloquea la confirmacion.

6. Que pasa si no se pueden consultar alergias?

   Segun `RNF-ASII15-08` y `CA-ASII15-05`, el sistema falla de forma segura: informa error y no guarda como valida.

7. Que elemento podrias modificar en vivo?

    Se podria agregar un nuevo contrato `AuditRecorder` y una implementacion `EloquentAuditRecorder` en el diagrama despues, manteniendo `CreatePrescriptionAction` dependiente de abstracciones.

8. Como se justifica separar red de aplicacion y red de datos?

    Porque la base de datos contiene informacion sensible y no debe quedar expuesta a la red publica. La aplicacion solo accede por red privada, lo que reduce superficie de ataque y facilita control por firewall.

## Archivos que debes mencionar

- `docs/semana-02/README.md`
- `docs/semana-02/diseno-antes-despues.puml`
- `docs/semana-02/infraestructura-red-servidor.md`
- `docs/semana-02/infraestructura-red-servidor.puml`
- `docs/semana-02/evidencia-validacion.md`
- `docs/semana-02/guia-defensa.md`
- `DECLARACION_IA.md`
