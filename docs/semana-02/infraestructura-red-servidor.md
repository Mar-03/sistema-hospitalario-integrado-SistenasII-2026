# Infraestructura de Red y Servidores - Semana 2

## Objetivo

Definir una infraestructura base para el Sistema Hospitalario Integrado que soporte el modulo de prescripciones con validacion de alergias, manteniendo seguridad, separacion por tenant y facilidad de crecimiento.

## Supuestos de uso

- El sistema se consume via navegador web por usuarios internos del hospital.
- La API del HIS expone `/api/v1` y usa JWT mas la cabecera `X-Tenant-ID`.
- El modulo de prescripciones compartira la misma base de datos del HIS, pero con acceso restringido por red y credenciales.
- Los datos son ficticios y la plataforma no requiere alta disponibilidad de nivel empresarial para la entrega academica.

## Arquitectura propuesta

Se recomienda una arquitectura en 4 zonas logicas:

1. **Zona publica / DMZ**: recibe trafico HTTPS desde Internet o la red institucional.
2. **Zona de aplicacion**: aloja la API del HIS y la interfaz web compilada.
3. **Zona de datos**: contiene la base de datos, Redis y respaldos logicos.
4. **Zona de administracion**: acceso restringido para soporte, monitoreo y mantenimiento.

## Servidores y roles

| Componente | Rol | Dimension sugerida | Observaciones |
|---|---|---|---|
| Reverse proxy / firewall perimetral | Terminar TLS, enrutar solicitudes y limitar trafico | 2 vCPU, 2 GB RAM | Nginx o equivalente; expone solo 443 y redirige 80 a 443 |
| Servidor de aplicacion | Ejecutar Laravel, API, validaciones y UI web | 4 vCPU, 8 GB RAM | PHP-FPM, colas y cron en el mismo nodo para una version inicial |
| Servidor de base de datos | Guardar pacientes, alergias, medicamentos y prescripciones | 4 vCPU, 8 a 16 GB RAM, SSD | MySQL o PostgreSQL en red privada |
| Redis | Cache y cola de trabajos | 1 vCPU, 2 GB RAM | Acelera sesiones, colas y tareas diferidas |
| Repositorio de backups | Respaldo de base de datos y archivos | Espacio segun retencion | Puede ser almacenamiento objeto, NAS o snapshot del proveedor |
| Monitoreo y logs | Observabilidad y auditoria tecnica | 1 vCPU, 2 GB RAM | Grafana, Prometheus o stack equivalente |

## Segmentacion de red

| Red | Rango sugerido | Uso |
|---|---|---|
| Publica | `10.10.10.0/24` | Trafico HTTPS entrante hacia el proxy |
| Aplicacion | `10.10.20.0/24` | Servidor Laravel y procesos de negocio |
| Datos | `10.10.30.0/24` | Base de datos, Redis y respaldos |
| Administracion | `10.10.40.0/24` | VPN, bastion, monitoreo y acceso de soporte |

## Flujo de trafico

- El usuario ingresa por HTTPS al proxy.
- El proxy valida reglas basicas y reenvia al servidor de aplicacion.
- La aplicacion consulta la base de datos y Redis solo por la red privada.
- La base de datos no expone puertos a Internet ni a la red publica.
- El acceso administrativo se realiza por VPN o bastion con MFA si esta disponible.

## Puertos permitidos

| Origen | Destino | Puerto | Motivo |
|---|---|---|---|
| Internet | Proxy | 443 | Acceso web seguro |
| Internet | Proxy | 80 | Redireccion a HTTPS |
| Proxy | App | 8080 o 9000 | Trafico interno de aplicacion |
| App | DB | 3306 o 5432 | Persistencia de datos |
| App | Redis | 6379 | Cache y colas |
| Administracion | Todos los nodos | Solo via VPN | Mantenimiento controlado |

## Seguridad aplicada

- TLS obligatorio en la capa de entrada.
- Firewall con politica de denegacion por defecto.
- Credenciales separadas por servicio y sin uso de cuentas compartidas.
- Base de datos y Redis solo en red privada.
- Respaldo diario automatico y prueba de restauracion periodica.
- Registro centralizado de errores y eventos relevantes.
- Alineacion con el control por tenant ya descrito en la semana 2.

## Dimension minima recomendada para el proyecto

Para una entrega academica o piloto interno, la opcion mas practica es:

- 1 VM para proxy y aplicacion, o 2 VMs si se desea separar frontend y API.
- 1 VM o servicio administrado para la base de datos.
- 1 servicio ligero para Redis si se usan colas o cache.
- 1 repositorio de respaldos externo.

## Justificacion

Este diseno separa la capa publica de la capa de datos, reduce el riesgo de exposicion directa de informacion sensible y permite escalar sin reescribir el sistema. Ademas, encaja con la arquitectura del modulo: el controlador y el caso de uso viven en la capa de aplicacion, mientras que Eloquent, la base de datos y Redis quedan como detalles de infraestructura.
