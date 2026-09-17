# Declaracion de Uso de IA

## Datos de la actividad

- Estudiante: MARIA DE LOS ANGELES LOPEZ FAJARDO
- GitHub: Mar-03
- Modulo: Prescripciones electronicas con validacion de alergias
- Proceso modelado: Creacion de prescripcion con verificacion previa de alergias
- Semanas cubiertas: 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 y 11

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
- Auditar el backend personal real (rutas, Router, Controller, Request, DTO, UseCase, Domain, contratos, adaptadores PDO/InMemory, migraciones, seeds y tests) antes de la Semana 5.
- Confirmar el contrato HTTP real (200, 201, 403, 404, 409, 422, 500) y el payload de POST /prescriptions contra el código personal.
- Documentar la Semana 5 (modelo cliente-servidor, contrato REST, integración con el HIS, permisos y monolito vs microservicio) distinguiendo estado implementado de diseño futuro.
- Elaborar la evidencia HTTP y de persistencia/auditoría con resultados reales (prescriptions = 2, prescription_audits = 1, acción authorized_exception).
- Generar el diagrama PlantUML de integración cliente-servidor (implementado + futura integración con el HIS) y la evidencia Git de Semana 5.
- Revisar el estado acumulado del modulo ASII-15 para el checkpoint del Primer Parcial de Semana 6.
- Organizar la evidencia documental de Semana 6 sin agregar funcionalidad nueva, endpoints, UI, reglas clinicas ni refactorizaciones.
- Validar la consistencia entre Semanas 1-5, el merge de Semana 5 en `developer`, la estructura del backend y la trazabilidad Git.
- Registrar el bloqueo real de validacion tecnica cuando PHP no estuvo disponible en el entorno de ejecucion actual.
- Analizar los componentes internos reales de ASII-15 para Semana 7 sin inventar clases ni endpoints.
- Revisar responsabilidades entre entrada HTTP, Presentation, Application, Domain, contratos Repository, adaptadores de persistencia, auditoria y tests.
- Identificar oportunidades de refactorizacion y seleccionar una mejora arquitectonica pequena: separar la emision JSON del Router.
- Apoyar la documentacion y el diagrama de componentes internos, dejando claro en Fase 2A que la implementacion quedaba pendiente para Fase 2B.
- Apoyar la implementacion controlada de Semana 7 separando `JsonResponseEmitter` desde `Router` sin cambiar contrato HTTP ni reglas clinicas.
- Revisar la evidencia antes/despues del refactor: lint, migracion, tests, HTTP, persistencia y auditoria.
- Analizar la experiencia de usuario de Semana 8 a partir del backend real disponible, sin inventar endpoints ni frontend.
- Relacionar el flujo UX con el contrato real `POST /prescriptions`, sus payloads y codigos HTTP.
- Proponer wireframes de baja fidelidad para el formulario principal y el flujo de alergia/excepcion autorizada.
- Apoyar la generacion de fuentes PlantUML/SALT y la revision documental de los wireframes.
- Auditar los wireframes de Semana 8 desde criterios de usabilidad y accesibilidad conceptual.
- Identificar mejoras de claridad, prevencion de errores, retroalimentacion y jerarquia de acciones para Semana 9.
- Comparar los wireframes S8 con versiones revisadas S9 sin modificar los artefactos de Semana 8.
- Apoyar el diseno de wireframes S9 de baja fidelidad en PlantUML/SALT y su renderizado a PNG.
- Documentar criterios futuros de accesibilidad sin afirmar implementacion de HTML, ARIA, teclado ni lector de pantalla.
- Analizar la adaptacion responsive de los wireframes revisados de Semana 9 para escritorio, tablet y movil.
- Proponer estrategia conceptual de layout sin definir breakpoints reales ni frontend implementado.
- Generar wireframes responsive de baja fidelidad en PlantUML/SALT para formulario desktop, formulario mobile y alerta mobile.
- Documentar la preservacion de accesibilidad S9 durante la adaptacion responsive.
- Transformar los wireframes y criterios de Semanas 8-10 en un mockup visual estatico de Semana 11.
- Apoyar decisiones visuales, jerarquia de estados y representacion de flujos en HTML/CSS local.
- Revisar que el prototipo no use JavaScript, dependencias externas ni conexion API real.
- Documentar el alcance del mockup, flujo del prototipo, comparacion S8-S11 y evidencia de validacion.


## Prompts relevantes

- "Analiza el proceso creacion de prescripcion con verificacion previa de alergias para el modulo de prescripciones electronicas con validacion de alergias".
- "Revisa las migraciones, modelos y relaciones existentes en el repositorio para que los diagramas UML sean coherentes con el proyecto".
- "Ayudame a identificar actores, casos de uso, decisiones, excepciones y mensajes del proceso".
- "Construye la Semana 2 con RF/RNF, criterios de aceptacion y diseno inicial para prescripciones electronicas con validacion de alergias".
- "Aplica al menos un principio SOLID de la fuente https://mvpcluster.com/diseno-de-software-2/ sin confundir DRY, KISS o YAGNI con SOLID".
- "Genera un diseno antes/despues que justifique arquitectonicamente la separacion de responsabilidades".
- "Revisa el cumplimiento de la consigna de Semana 3 en el Micro-HIS (capas, PDO, prepared statements, regla de alergias, camino feliz y error de persistencia)".
- "Agrega la cobertura de dosis invalida sin modificar los Value Objects".
- "Organiza la evidencia de Semana 3 y el diagrama C4/UML en docs/semana-03".
- "Organiza la entrada del Micro-HIS con MVC y verifica que el controlador no tenga SQL, PDO ni reglas de negocio".
- "Documenta la arquitectura en capas, el patron Repository con adaptadores PDO e InMemory y las responsabilidades por capa".
- "Analiza como un repositorio de datos compartido del HIS integraria el modulo ASII-15 sin modificar Domain".
- "Inventaria los objetos reutilizables reales del Micro-HIS para docs/semana-04".
- "Genera los diagramas arquitectura-capas y repositorio-datos-compartido (PlantUML + PNG) para docs/semana-04".
- "Actualiza DECLARACION_IA.md con las actividades reales de Semana 4 y valida pruebas, lint y git".
- "Audita el backend personal real de ASII-15 (rutas, payload, validaciones y códigos HTTP) sin modificar código".
- "Documenta el contrato REST real y la integración cliente-servidor de Semana 5 distinguiendo implementado de futuro".
- "Elabora el análisis de monolito vs microservicio y los permisos de la Semana 5 a partir del código real".
- "Ejecuta y registra la evidencia HTTP y de persistencia/auditoría reales de Semana 5".
- "Genera el diagrama PlantUML de integración cliente-servidor (implementado + futuro) para docs/semana-05".
- "Construye Semana 6 como checkpoint del Primer Parcial sin funcionalidad nueva, verificando developer, evidencia acumulada y trazabilidad Git".
- "Documenta el estado real del backend ASII-15, sus pruebas esperadas y las limitaciones actuales sin inventar resultados".
- "Prepara un diagnostico de lectura para Semana 7 sobre componentes internos y oportunidades reales de refactorizacion".
- "Documenta Semana 7 Fase 2A con componentes reales, responsabilidades y refactor propuesto sin modificar codigo".
- "Disena la separacion futura de JsonResponseEmitter desde Router preservando contrato HTTP y formato JSON".
- "Genera un diagrama PlantUML de componentes internos diferente al diagrama cliente-servidor de Semana 5".
- "Implementa el refactor minimo de Semana 7 separando la emision JSON del Router y valida que el comportamiento observable no cambie".
- "Actualiza la evidencia de Semana 7 con baseline pre-refactor, validacion post-refactor, persistencia y auditoria reales".
- "Construye Semana 8 como analisis UX y wireframes de baja fidelidad sin implementar frontend ni modificar backend".
- "Audita los endpoints reales disponibles y distingue backend actual, UX propuesta e integraciones futuras".
- "Genera wireframes PlantUML/SALT para prescripcion principal y alergia critica con excepcion autorizada".
- "Continua Semana 9 con analisis de usabilidad y accesibilidad sin modificar backend ni crear frontend".
- "Compara los wireframes de Semana 8 contra una version revisada por claridad, errores y jerarquia de acciones".
- "Genera wireframes S9 de baja fidelidad para prescripcion usable y alerta clinica accesible".
- "Desarrolla Semana 10 como documentacion responsive y wireframes adaptados sin implementar frontend real".
- "Analiza escritorio, tablet y movil preservando los criterios de accesibilidad de Semana 9".
- "Genera wireframes PlantUML/SALT para prescripcion desktop, prescripcion mobile y alerta mobile".
- "Completa Semana 11 con un mockup HTML/CSS estatico sin backend, JavaScript ni dependencias externas".
- "Convierte los wireframes de Semanas 8-10 en un prototipo visual con estados de exito, validacion, alergia, excepcion y error tecnico".
- "Valida que el mockup preserve accesibilidad conceptual y no implemente frontend funcional".


## Partes aceptadas o modificadas

Las propuestas generadas por IA fueron revisadas manualmente antes de aceptarse. Se modificaron nombres, actores, casos de uso, flujos alternativos, mensajes, estructura de los diagramas, RF/RNF, criterios de aceptacion, justificacion SOLID y la organizacion de la evidencia y del diagrama C4/UML de Semana 3 para mantener coherencia con la asignacion individual y con el repositorio. En Semana 4 se ajusto la redaccion de capas, responsabilidades, inventario de objetos reutilizables, analisis del repositorio de datos compartido, diagramas PlantUML y evidencia Git para reflejar exactamente el codigo real del Micro-HIS. En Semana 5 se reviso que el contrato REST, los payloads, las validaciones, los codigos HTTP, los permisos, el analisis de monolito vs microservicio y la evidencia (HTTP, persistencia y auditoria) coincidan exactamente con el codigo y con la ejecucion real, sin presentar diseno futuro como implementado. En Semana 6 se acepto solo apoyo documental para revisar el estado acumulado, organizar evidencia del Primer Parcial, validar consistencia y registrar trazabilidad; no se atribuye a la IA implementacion de funcionalidad nueva. En Semana 7 Fase 2A se acepto apoyo para analizar componentes, comparar responsabilidades, seleccionar un refactor propuesto y preparar documentacion/diagrama. En Semana 7 Fase 2B se acepto apoyo para implementar el refactor minimo `JsonResponseEmitter`, actualizar la evidencia y verificar que no hubiera cambios observables de comportamiento. En Semana 8 se acepto apoyo para analizar UX, relacionar el flujo de usuario con la API real, disenar wireframes de baja fidelidad y documentar integraciones futuras; no se implemento frontend. En Semana 9 se acepto apoyo para auditar usabilidad y accesibilidad conceptual, proponer mejoras priorizadas, comparar S8/S9 y generar wireframes revisados de baja fidelidad; no se implemento frontend real. En Semana 10 se acepto apoyo para analizar responsive, definir estrategia de layout conceptual y generar wireframes adaptados; no se implemento frontend responsive real.

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
- Que el backend de Semana 5 no se modifico: la evidencia se obtuvo ejecutando el codigo existente.
- Que el contrato REST documentado (200, 201, 403, 404, 409, 422, 500) coincide con las pruebas HTTP reales y no inventa endpoints ni codigos.
- Que los permisos (sin JWT, RBAC ni tenancy) se declaran como estado actual y que el acceso de medico, excepcion y auditoria se marca como diseno futuro.
- Que la integracion con el HIS y el microservicio se presentan como propuesta de diseno, no como implementacion.
- Que los IDs de prescripcion observados se registran como ejemplos de la corrida (no como parte fija del contrato).
- Que el diagrama PlantUML de integracion cliente-servidor fue renderizado a PNG sin errores y distingue flujo implementado de integracion futura.
- Que Semana 6 parte del `origin/developer` actualizado que contiene el merge de Semana 5.
- Que Semana 6 no modifica codigo funcional, reglas clinicas, endpoints, arquitectura ni UI.
- Que la evidencia del Primer Parcial distingue resultados ejecutados previamente de validaciones pendientes por ausencia de PHP en el entorno actual.
- Que Semana 7 queda solo diagnosticada en modo lectura y no se crea rama, worktree ni archivos de esa semana.
- Que Semana 7 parte del `origin/developer` actualizado que contiene el merge de Semana 6.
- Que la Fase 2A de Semana 7 documenta componentes y diseno de refactor sin modificar backend.
- Que el refactor seleccionado fue separar la emision JSON del Router mediante `JsonResponseEmitter`, propuesto en Fase 2A e implementado en Fase 2B.
- Que no se afirma ejecucion nueva de pruebas mientras PHP no este disponible.
- Que Fase 2B implementa solamente `JsonResponseEmitter` y el ajuste minimo de `Router`.
- Que no se modificaron endpoints, payloads, reglas clinicas, contratos Repository, persistencia, auditoria, migraciones ni seeds.
- Que la validacion post-refactor conserva tests `6/6`, `Mod15PrescriptionTest 5/5`, codigos HTTP, envelope JSON `status`/`data`, persistencia y auditoria `authorized_exception`.
- Que Semana 8 parte de `origin/developer` actualizado con Semana 7 mergeada.
- Que Semana 8 no implementa frontend, HTML, CSS, JavaScript, Vue ni React.
- Que los wireframes representan baja fidelidad y distinguen backend actual de integraciones futuras.
- Que no se presentan endpoints de catalogo como implementados porque el backend actual solo expone `GET /health` y `POST /prescriptions`.
- Que Semana 9 parte de `origin/developer` actualizado con Semana 8 mergeada.
- Que Semana 9 no modifica Semana 8, backend, endpoints, payloads ni reglas clinicas.
- Que los criterios de accesibilidad de Semana 9 son especificaciones futuras y no implementacion de ARIA, lector de pantalla, teclado, CSS ni HTML.
- Que no se adelanta Semana 10 responsive ni Semana 11 mockup/prototipo de alta fidelidad.
- Que Semana 10 parte de `origin/developer` actualizado con Semana 9 mergeada.
- Que Semana 10 no modifica Semanas 8/9, backend, endpoints, payloads ni reglas clinicas.
- Que Semana 10 documenta adaptacion responsive y wireframes de baja fidelidad, sin HTML, CSS, JavaScript ni frontend funcional.
- Que Semana 10 no adelanta Semana 11: no crea mockup de alta fidelidad, branding ni prototipo navegable.
- Que Semana 11 parte de `origin/developer` actualizado con Semana 10 y la reorganizacion documental bajo `docs/` mergeadas.
- Que Semana 11 crea un mockup/prototipo visual estatico con HTML/CSS local, sin JavaScript, sin API real y sin dependencias externas.
- Que Semana 11 no modifica backend, endpoints, reglas clinicas, persistencia, tests ni semanas anteriores.

## Responsabilidad de autoria

La IA se utilizo como herramienta de apoyo. La seleccion final de contenido, validacion, ajustes y defensa oral corresponden a la estudiante.
