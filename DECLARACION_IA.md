# Declaracion de Uso de IA

## Datos de la actividad

- Estudiante: MARIA DE LOS ANGELES LOPEZ FAJARDO
- GitHub: Mar-03
- Modulo: Prescripciones electronicas con validacion de alergias
- Proceso modelado: Creacion de prescripcion con verificacion previa de alergias
- Semanas cubiertas: 1, 2, 3 y 4

## Herramientas utilizadas

- ChatGPT.
- OpenCode con modelos de OpenAI.

## Proposito del uso

Las herramientas de inteligencia artificial se utilizaron como apoyo para:

- Revisar la estructura del documento de Semana 1.
- Analizar la coherencia entre el modulo asignado y el proyecto.
- Revisar la estructura disponible de la base de datos y los modelos relacionados.
- Proponer correcciones en actores, casos de uso, flujos y mensajes UML.
- Verificar que los diagramas fueran coherentes entre si.
- Definir RF/RNF y criterios de aceptacion para Semana 2.
- Proponer una mejora de diseno aplicando DIP al modulo.
- Revisar la fuente obligatoria SOLID indicada por la consigna.
- Revisar la arquitectura del Micro-HIS y confirmar el cumplimiento de la consigna de Semana 3.
- Apoyar la organizacion de la evidencia semanal (README, evidencia Git y diagrama C4/UML).
- Revisar las pruebas y agregar la cobertura de dosis invalida.
- Documentar el requisito PHP 8.2+ y la direccion de dependencias (DIP).
- Documentar la arquitectura en capas, el patrón Repository y la organizacion MVC de Semana 4.
- Analizar como un repositorio de datos compartido del HIS integraria este modulo (owners, lectura/escritura, IDs, tenant, consistencia, transacciones, seguridad y DIP).
- Inventariar los objetos reales reutilizables del Micro-HIS sin inventar clases.
- Redactar la evidencia de capas, responsabilidades, diagramas (arquitectura-capas y repositorio-datos-compartido) y la evidencia Git de Semana 4.


## Prompts relevantes

- "Analiza el proceso creacion de prescripcion con verificacion previa de alergias para el modulo de prescripciones electronicas con validacion de alergias".
- "Revisa las migraciones, modelos y relaciones existentes en el repositorio para que los diagramas UML sean coherentes con el proyecto".
- "Ayudame a identificar actores, casos de uso, decisiones, excepciones y mensajes del proceso".
- "Construye la Semana 2 con RF/RNF, criterios de aceptacion y diseno inicial para prescripciones electronicas con validacion de alergias".
- "Aplica al menos un principio SOLID de la fuente https://mvpcluster.com/diseno-de-software-2/ sin confundir DRY, KISS o YAGNI con SOLID".
- "Genera un diseno antes/despues que justifique arquitectonicamente la separacion de responsabilidades".
- "Revisa el cumplimiento de la consigna de Semana 3 en el Micro-HIS (capas, PDO, prepared statements, regla de alergias, camino feliz y error de persistencia)".
- "Agrega la cobertura de dosis invalida sin modificar los Value Objects".
- "Organiza la evidencia de Semana 3 y el diagrama C4/UML en ascii15/semana-03".
- "Organiza la entrada del Micro-HIS con MVC y verifica que el controlador no tenga SQL, PDO ni reglas de negocio".
- "Documenta la arquitectura en capas, el patron Repository con adaptadores PDO e InMemory y las responsabilidades por capa".
- "Analiza como un repositorio de datos compartido del HIS integraria el modulo ASII-15 sin modificar Domain".
- "Inventaria los objetos reutilizables reales del Micro-HIS para ascii15/semana-04".
- "Genera los diagramas arquitectura-capas y repositorio-datos-compartido (PlantUML + PNG) para ascii15/semana-04".
- "Actualiza DECLARACION_IA.md con las actividades reales de Semana 4 y valida pruebas, lint y git".


## Partes aceptadas o modificadas

Las propuestas generadas por IA fueron revisadas manualmente antes de aceptarse. Se modificaron nombres, actores, casos de uso, flujos alternativos, mensajes, estructura de los diagramas, RF/RNF, criterios de aceptacion, justificacion SOLID y la organizacion de la evidencia y del diagrama C4/UML de Semana 3 para mantener coherencia con la asignacion individual y con el repositorio. En Semana 4 se ajusto la redaccion de capas, responsabilidades, inventario de objetos reutilizables, analisis del repositorio de datos compartido, diagramas PlantUML y evidencia Git para reflejar exactamente el codigo real del Micro-HIS.

## Validacion humana

La estudiante verifico manualmente:

- El alcance del modulo asignado.
- La eleccion del Medico como actor principal.
- La decision de representar al Paciente como entidad consultada y no como actor.
- La decision de representar al HIS como limite del sistema y no como actor externo.
- Las relaciones `include` y `extend` del diagrama de casos de uso.
- Las decisiones y excepciones del diagrama de actividad.
- Los participantes, mensajes y respuestas del diagrama de secuencia.
- El uso exclusivo de datos ficticios.
- La ausencia de informacion clinica identificable.
- La existencia de fuentes editables PlantUML.
- La coherencia entre los RF/RNF de Semana 2 y los diagramas UML de Semana 1.
- La aplicacion de DIP como principio SOLID principal.
- La cita de la fuente obligatoria `https://mvpcluster.com/diseno-de-software-2/`.
- Que no se atribuyeran DRY, KISS ni YAGNI al articulo indicado.
- El cumplimiento de la consigna de Semana 3 sobre el Micro-HIS heredado y ya mergeado.
- La ubicacion real de `DECLARACION_IA.md` en la raiz del repositorio, sin crear duplicados.
- El resultado real de las pruebas y del lint PHP.
- Que todos los cambios de Semana 3 quedaron exclusivamente en la rama `feature/week-03-arquitectura-asii15-mar-03`.
- Que los cambios de Semana 4 quedaron exclusivamente en la rama `feature/week-04-capas-asii15-mar-03`, nacida de `developer`.
- Que el controlador real no contiene SQL, PDO ni reglas clinicas (verificado por lectura del codigo).
- Que los contratos de repositorio estan en `src/Domain/Contracts` y se implementan con adaptadores PDO e InMemory.
- Que el inventario de objetos reutilizables usa solo clases reales existentes en `src/` y `tests/Fakes`.
- Que el analisis del repositorio de datos compartido distingue estado ACTUAL (Micro-HIS con BD propia) de la PROPUESTA de integracion al HIS.
- Que los diagramas PlantUML de Semana 4 fueron renderizados a PNG y coinciden con la estructura real del proyecto.

## Responsabilidad de autoria

La IA se utilizo como herramienta de apoyo. La seleccion final de contenido, validacion, ajustes y defensa oral corresponden a la estudiante.
