# Diagrama de Procesos e Integracion Global - ASII-15

## Objetivo

Diseñar el proceso del modulo ASII-15 - Prescripciones Electronicas con validacion de alergias e integrarlo dentro del flujo general del Sistema Hospitalario Integrado.

## Modulo analizado

ASII-15 - Prescripciones Electronicas con validacion de alergias.

## Actores

- Medico, actor principal del proceso de prescripcion.
- Usuario autenticado del HIS, con JWT y contexto de tenant.
- Sistema de seguridad transversal, mediante `TenantMiddleware` y `JwtAuth`.
- Modulo de laboratorio, como consumidor y generador de informacion clinica.
- Auditoria y notificaciones, como soporte de trazabilidad.

## Proceso de Prescripciones Electronicas

1. El medico inicia sesion y el sistema valida JWT, tenant y permisos.
2. Se selecciona un paciente del mismo tenant y se abre su expediente medico.
3. Desde la atencion clinica se inicia la prescripcion.
4. Se selecciona un medicamento activo del catalogo.
5. El sistema consulta alergias activas del paciente y compara contra el medicamento.
6. Si existe alergia o contraindicacion, se muestra alerta y el medico puede corregir o cancelar.
7. Si no existe riesgo, se capturan dosis, frecuencia, via, duracion e indicaciones.
8. La prescripcion se guarda asociada a paciente, medico, nota SOAP y medicamento.
9. Se registra trazabilidad en auditoria y el expediente queda actualizado.

## Integracion con el Sistema Hospitalario

### Antes de Prescripciones

- Autenticacion del usuario.
- Validacion de tenant.
- Seleccion del paciente.
- Consulta o apertura de la atencion clinica.
- Elaboracion de la nota SOAP en el expediente medico.

### Informacion que recibe

- `patient_id`
- `doctor_id`
- `soap_note_id`
- Contexto de tenant.
- Catalogo de medicamentos activos.
- Alergias activas del paciente.

### Modulos que consulta

- Pacientes.
- Expediente medico / SOAP notes.
- Alergias.
- Medicamentos.
- Auditoria.
- Notificaciones, cuando se active una alerta clinica.

### Informacion que genera

- Prescripcion electronica registrada.
- Estado `blocked` o `false` segun la validacion.
- Motivo de bloqueo si existe riesgo.
- Firma electronica y fecha de firma cuando procede.
- Registro de auditoria.

### Despues de Prescripciones

- El expediente medico se actualiza.
- El medico puede continuar con otra decision clinica.
- Si se requiere, el flujo puede pasar a laboratorio o a seguimiento clinico.

## Diagrama individual

- Archivo editable: `proceso-prescripciones.puml`
- Imagen PNG: no generada porque PlantUML no esta disponible en el entorno.

## Diagrama GLOBAL

- Archivo editable: `proceso-global.puml`
- Imagen PNG: no generada porque PlantUML no esta disponible en el entorno.

## Justificacion

Prescripciones Electronicas aparece despues de la consulta medica y de la revision del expediente porque la tabla `prescriptions` se relaciona con `soap_note_id`, `patient_id`, `doctor_id` y `medication_id`. La validacion de alergias depende de `allergies`, y el catalogo de medicamentos depende de `medications`. Por eso el modulo no va al inicio del HIS, sino dentro de la atencion clinica, como decision terapeutica posterior a la evaluacion del paciente.

## Trazabilidad

### Proyecto general usado como referencia

- `README.md`
- `docs/weekly-plan.md`
- `docs/README-INSTALACION-BACKEND.md`
- `routes/api.php`
- `database/migrations/2026_04_26_100000_create_admission_catalogs.php`
- `database/migrations/2026_04_26_110000_create_admissions_and_appointments.php`
- `database/migrations/2026_04_26_120000_create_emr_tables.php`
- `database/migrations/2026_04_26_130000_create_laboratory_tables.php`
- `database/migrations/2026_04_26_140000_create_audit_and_notifications.php`
- `app/Models/Patient.php`
- `app/Models/Admission.php`
- `app/Models/MedicalRecord.php`
- `app/Models/SoapNote.php`
- `app/Models/Allergy.php`
- `app/Models/Medication.php`
- `app/Models/Prescription.php`
- `app/Models/LabOrder.php`
- `app/Models/LabResult.php`
- `app/Models/Doctor.php`
- `app/Models/User.php`
- `app/Http/Middleware/TenantMiddleware.php`
- `app/Http/Middleware/JwtAuth.php`
- `database/seeders/RoleSeeder.php`
- `database/seeders/DemoDataSeeder2026.php`

### Proyecto del modulo ASII-15

- `README.md`
- `docs/modules/asii-15-Prescripciones-electrónicas/Semana-01.md`
- `docs/modules/asii-15-Prescripciones-electrónicas/Semana-02.md`
- `database/migrations/2026_04_26_100000_create_admission_catalogs.php`
- `database/migrations/2026_04_26_120000_create_emr_tables.php`
- `app/Models/Patient.php`
- `app/Models/Allergy.php`
- `app/Models/Medication.php`
- `app/Models/Prescription.php`
- `database/seeders/DemoDataSeeder2026.php`
- `routes/api.php`

## Supuestos

- El proyecto general de referencia tiene solo la API de autenticacion expuesta; los flujos clinicos siguen soportados por el esquema y la documentacion.
- El modulo ASII-15 no tiene aun endpoints clinicos propios; el proceso se deduce de tablas, modelos, seeders y documentos de semanas 1 y 2.
- No se genero PNG porque la herramienta PlantUML no esta instalada en el entorno.
