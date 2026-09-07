# Semana 2 - RF/RNF, Criterios de Aceptacion y Mejora SOLID

## Portada tecnica

- Curso: Analisis de Sistemas II
- Sistema: Sistema Hospitalario Integrado
- Estudiante: MARIA DE LOS ANGELES LOPEZ FAJARDO
- GitHub: Mar-03
- Repositorio: `https://github.com/Mar-03/sistema-hospitalario-integrado-SistenasII-2026.git`
- Rama evaluada: `main`
- Commit de cierre de la evidencia Git de Semana 2: `ac4164b`
- Commit evaluado de Semana 2: `ac4164b docs(asii-15): registrar evidencia git semana 2`
- Modulo: Prescripciones electronicas con validacion de alergias
- Proceso: Creacion de prescripcion con verificacion previa de alergias
- Semana: 2
- Fuente obligatoria SOLID: `https://mvpcluster.com/diseno-de-software-2/`

## Introduccion

Esta entrega convierte el analisis UML de la Semana 1 en requisitos verificables y en una mejora inicial de diseno. El modulo debe permitir que un Medico cree una prescripcion electronica y que el sistema valide previamente alergias activas del paciente antes de permitir la confirmacion. La mejora de diseno separa responsabilidades para evitar que un unico controlador concentre validacion HTTP, consultas de datos, comparacion de alergias, bloqueo y guardado.

La actividad usa datos ficticios y no incluye informacion clinica identificable.

## Alcance de Semana 2

- Definir requerimientos funcionales del flujo de prescripcion con alergias.
- Definir requerimientos no funcionales relevantes para seguridad, trazabilidad, rendimiento y mantenibilidad.
- Especificar criterios de aceptacion verificables.
- Proponer un diseno antes/despues aplicando DIP como principio SOLID principal.
- Dejar evidencia editable para defensa oral.

## Requerimientos funcionales

| Codigo | Requerimiento funcional | Descripcion | Prioridad | Caso de uso relacionado |
|---|---|---|:---:|---|
| RF-ASII15-01 | Seleccionar paciente existente | El Medico debe poder seleccionar un paciente registrado del tenant actual antes de crear la prescripcion. | Alta | `Seleccionar paciente existente` |
| RF-ASII15-02 | Capturar datos de prescripcion | El sistema debe permitir ingresar medicamento, dosis, frecuencia, duracion, via e indicaciones con datos ficticios o institucionales. | Alta | `Ingresar datos de prescripcion` |
| RF-ASII15-03 | Validar medicamento activo | El sistema debe validar que el medicamento seleccionado exista, este activo y pertenezca al tenant actual. | Alta | `Seleccionar medicamento activo` |
| RF-ASII15-04 | Consultar alergias activas | Antes de confirmar, el sistema debe consultar las alergias activas del paciente. | Critica | `Consultar alergias activas` |
| RF-ASII15-05 | Comparar medicamento contra alergias | El sistema debe comparar el medicamento seleccionado contra las alergias activas usando nombre comercial y nombre generico cuando esten disponibles. | Critica | `Validar medicamento contra alergias` |
| RF-ASII15-06 | Mostrar alerta preventiva | Si existe coincidencia con una alergia activa, el sistema debe mostrar una alerta clara al Medico antes de confirmar. | Critica | `Mostrar alerta de alergia` |
| RF-ASII15-07 | Modificar y revalidar prescripcion | Ante una alerta, el Medico debe poder cambiar medicamento o datos y ejecutar nuevamente la validacion. | Alta | `Modificar prescripcion` |
| RF-ASII15-08 | Cancelar prescripcion bloqueada | Ante una alerta, el Medico debe poder cancelar el proceso sin guardar una prescripcion confirmada. | Alta | `Crear prescripcion electronica` |
| RF-ASII15-09 | Guardar solo prescripciones sin bloqueo | El sistema debe guardar la prescripcion unicamente cuando la validacion termina sin coincidencia activa y el Medico confirma. | Critica | `Guardar prescripcion` |
| RF-ASII15-10 | Informar errores controlados | El sistema debe informar errores de paciente, medicamento, consulta de alergias y guardado sin registrar informacion clinica real en la evidencia. | Alta | Excepciones del flujo |

## Requerimientos no funcionales

| Codigo | Requerimiento no funcional | Descripcion y metrica objetivo | Categoria |
|---|---|---|---|
| RNF-ASII15-01 | Seguridad por tenant | Toda consulta de paciente, medicamento, alergia y prescripcion debe filtrar por `tenant_id` o contexto equivalente. | Seguridad |
| RNF-ASII15-02 | Control de rol Medico | Solo usuarios autenticados con rol medico o permiso equivalente deben iniciar la creacion de prescripciones. | Seguridad |
| RNF-ASII15-03 | No uso de datos reales | Documentos, ejemplos, prompts y evidencias deben usar datos ficticios y no informacion clinica identificable. | Privacidad |
| RNF-ASII15-04 | Trazabilidad del bloqueo | Cuando exista coincidencia de alergia, la causa debe poder registrarse como razon de bloqueo o alerta para auditoria posterior. | Trazabilidad |
| RNF-ASII15-05 | Respuesta comprensible | Las alertas y errores deben ser claros para el Medico, diferenciando alergia detectada, medicamento invalido y error tecnico. | Usabilidad |
| RNF-ASII15-06 | Mantenibilidad por DIP | La logica de alto nivel del flujo de prescripcion debe depender de contratos y no de clases concretas de infraestructura. | Mantenibilidad |
| RNF-ASII15-07 | Rendimiento de validacion | La consulta de alergias activas y medicamento debe ejecutarse antes de guardar y no debe repetir consultas innecesarias dentro del mismo intento. | Rendimiento |
| RNF-ASII15-08 | Falla segura | Si no se pueden consultar alergias, el sistema no debe confirmar ni guardar la prescripcion como valida. | Fiabilidad |

## Criterios de aceptacion

### CA-ASII15-01 - Prescripcion sin alergia coincidente

- Dado que el Medico esta autenticado y pertenece al tenant `TENANT-DEMO-01`.
- Y el paciente ficticio `PAC-DEM-0001` no tiene alergias activas relacionadas con `Loratadina`.
- Cuando el Medico ingresa medicamento, dosis, frecuencia, duracion, via e indicaciones completas.
- Entonces el sistema consulta alergias activas antes de confirmar.
- Y responde que la prescripcion esta valida con `blocked = false`.
- Y permite confirmar y guardar la prescripcion.

### CA-ASII15-02 - Coincidencia con alergia activa

- Dado que el paciente ficticio `PAC-DEM-0001` tiene alergia activa a `Amoxicilina`.
- Cuando el Medico intenta prescribir `Amoxicilina 500 mg`.
- Entonces el sistema detecta la coincidencia antes de guardar.
- Y muestra una alerta preventiva de alergia.
- Y no permite guardar la prescripcion como confirmada mientras exista bloqueo.

### CA-ASII15-03 - Modificacion y revalidacion despues de alerta

- Dado que el sistema mostro una alerta por alergia a `Amoxicilina`.
- Cuando el Medico cambia el medicamento a `Azitromicina` y reenvia la prescripcion.
- Entonces el sistema vuelve a consultar alergias activas.
- Y compara el nuevo medicamento contra las alergias.
- Y si no hay coincidencia, permite continuar a confirmacion.

### CA-ASII15-04 - Cancelacion despues de alerta

- Dado que existe una coincidencia de alergia activa.
- Cuando el Medico decide cancelar la prescripcion.
- Entonces el sistema finaliza el proceso.
- Y no crea un registro de prescripcion confirmada.

### CA-ASII15-05 - Error al consultar alergias

- Dado que el Medico ingreso una prescripcion completa.
- Cuando ocurre un error tecnico al consultar alergias activas.
- Entonces el sistema informa que no se pudo consultar el historial de alergias.
- Y aborta el proceso sin guardar la prescripcion como valida.

### CA-ASII15-06 - Medicamento inactivo o inexistente

- Dado que el Medico selecciona un medicamento inexistente o inactivo.
- Cuando el sistema valida el medicamento contra el catalogo del tenant.
- Entonces responde con error de validacion.
- Y no ejecuta el guardado de la prescripcion.

## Principio SOLID aplicado

### Principio seleccionado: DIP - Dependency Inversion Principle

La fuente obligatoria MVP Cluster indica que el principio de inversion de dependencias busca evitar alto acoplamiento y que "las clases de alto nivel no tienen que depender de otras de bajo nivel, sino que ambas dependan de abstracciones". Fuente: MVP Cluster, *Principios básicos del diseño de software*, seccion "Dependency Inversion".

En este modulo se aplica DIP haciendo que el flujo de alto nivel `CreatePrescriptionAction` dependa de contratos (`PatientLookup`, `MedicationLookup`, `AllergyValidator`, `PrescriptionWriter`) y no directamente de implementaciones concretas como repositorios Eloquent o un servicio especifico de validacion. Asi, las reglas del caso de uso quedan protegidas frente a cambios de base de datos, ORM, proveedor de validacion o mecanismo de persistencia.

No se atribuyen DRY, KISS ni YAGNI al articulo porque la fuente indicada cubre SOLID: SRP, OCP, LSP, ISP y DIP.

## Diseno antes

En el diseno inicial no refinado, `CreatePrescriptionAction` o incluso `PrescriptionController` podria depender directamente de clases concretas como `EloquentPatientRepository`, `EloquentMedicationRepository`, `DefaultAllergyValidationService` y `EloquentPrescriptionRepository`. Ese diseno funciona para un caso pequeno, pero acopla la politica de alto nivel del flujo de prescripcion a detalles de infraestructura.

| Componente | Dependencia concreta | Riesgo |
|---|---|---|
| `CreatePrescriptionAction` | `EloquentPatientRepository` | Cambios de persistencia afectan el caso de uso |
| `CreatePrescriptionAction` | `EloquentMedicationRepository` | Cambios del catalogo de medicamentos obligan a tocar el flujo principal |
| `CreatePrescriptionAction` | `DefaultAllergyValidationService` | Cambios en el motor de validacion afectan la orquestacion |
| `CreatePrescriptionAction` | `EloquentPrescriptionRepository` | Cambios de guardado o auditoria se mezclan con la politica de negocio |

## Diseno despues

La mejora invierte dependencias. La logica de alto nivel depende de abstracciones y las clases concretas implementan esos contratos:

| Contrato o componente | Tipo | Responsabilidad |
|---|---|---|
| `CreatePrescriptionAction` | Alto nivel | Orquestar el flujo de negocio sin conocer detalles de infraestructura |
| `PatientLookup` | Contrato | Obtener paciente valido por tenant |
| `MedicationLookup` | Contrato | Obtener medicamento activo por tenant |
| `AllergyValidator` | Contrato | Validar medicamento contra alergias activas |
| `PrescriptionWriter` | Contrato | Guardar prescripcion confirmada |
| `EloquentPatientRepository` | Implementacion | Consultar pacientes usando Eloquent |
| `EloquentMedicationRepository` | Implementacion | Consultar medicamentos usando Eloquent |
| `DefaultAllergyValidator` | Implementacion | Comparar alergias activas contra medicamento |
| `EloquentPrescriptionRepository` | Implementacion | Persistir prescripciones usando Eloquent |

## Ejemplo conceptual de codigo

```php
final class PrescriptionController
{
    public function store(StorePrescriptionRequest $request, CreatePrescriptionAction $action): JsonResponse
    {
        $result = $action->execute($request->validated(), $request->user());

        return response()->json($result->toArray(), $result->httpStatus());
    }
}
```

```php
interface PatientLookup
{
    public function findForTenant(int $patientId, string $tenantId): Patient;
}

interface MedicationLookup
{
    public function findActiveForTenant(int $medicationId, string $tenantId): Medication;
}

interface AllergyValidator
{
    public function validate(Patient $patient, Medication $medication): AllergyValidationResult;
}

interface PrescriptionWriter
{
    public function createConfirmed(Patient $patient, User $doctor, Medication $medication, array $data): Prescription;
}
```

```php
final class CreatePrescriptionAction
{
    public function __construct(
        private PatientLookup $patients,
        private MedicationLookup $medications,
        private AllergyValidator $allergyValidation,
        private PrescriptionWriter $prescriptions,
    ) {}

    public function execute(array $data, User $doctor): PrescriptionResult
    {
        $patient = $this->patients->findForTenant($data['patient_id'], $doctor->tenant_id);
        $medication = $this->medications->findActiveForTenant($data['medication_id'], $doctor->tenant_id);
        $validation = $this->allergyValidation->validate($patient, $medication);

        if ($validation->blocked()) {
            return PrescriptionResult::blocked($validation->message());
        }

        return PrescriptionResult::created(
            $this->prescriptions->createConfirmed($patient, $doctor, $medication, $data)
        );
    }
}
```

## Justificacion arquitectonica

- `CreatePrescriptionAction` representa la politica de alto nivel: crear prescripcion solo si la validacion previa de alergias no bloquea el flujo.
- Las clases concretas de base de datos son detalles de bajo nivel y no deben condicionar la politica del caso de uso.
- Si cambia Eloquent por otra fuente de datos, se reemplaza la implementacion del contrato sin alterar el caso de uso.
- Si se cambia el algoritmo de validacion de alergias, se reemplaza la implementacion de `AllergyValidator` sin modificar la orquestacion.
- En pruebas, se pueden usar dobles o implementaciones ficticias de los contratos para validar errores, alergias coincidentes y guardado exitoso.

## Evidencia de validacion

| Evidencia | Archivo | Resultado esperado |
|---|---|---|
| RF/RNF y criterios | `ascii15/semana-02/README.md` | Requisitos y criterios verificables |
| Diseno antes/despues editable | `ascii15/semana-02/diseno-antes-despues.puml` | Diagrama modificable en PlantUML |
| Infraestructura de red y servidor | `ascii15/semana-02/infraestructura-red-servidor.md` | Propuesta tecnica para despliegue |
| Infraestructura de red y servidor editable | `ascii15/semana-02/infraestructura-red-servidor.puml` | Diagrama de despliegue modificable |
| Guia de defensa | `ascii15/semana-02/guia-defensa.md` | Preguntas y respuestas para defensa oral |
| Evidencia de validacion | `ascii15/semana-02/evidencia-validacion.md` | Checklist y comandos sugeridos |
| Evidencia Git | `ascii15/semana-02/evidencia-git.md` | Historial, remoto, rama, estado y commits verificados | 
| Declaracion IA | `DECLARACION_IA.md` | Uso transparente de IA actualizado |

## Conclusion

Se definieron RF, RNF y criterios de aceptacion para el modulo de prescripciones electronicas con validacion de alergias. La decision mas relevante fue aplicar DIP para que el caso de uso dependa de contratos y no de detalles concretos de infraestructura. La limitacion principal es que esta semana presenta diseno inicial y no implementacion funcional. La evidencia queda respaldada por documentos Markdown editables, una fuente PlantUML del diseno antes/despues y la declaracion de IA.

## Bibliografia

- MVP Cluster. *Principios básicos del diseño de software*. https://mvpcluster.com/diseno-de-software-2/
- Object Management Group. *Unified Modeling Language (UML), version 2.5.1*.
- Documentacion oficial de PHP. *Supported Versions* y manual de PDO. https://www.php.net/docs.php
