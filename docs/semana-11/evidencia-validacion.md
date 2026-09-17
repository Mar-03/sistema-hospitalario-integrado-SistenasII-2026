# Semana 11 - Evidencia de validacion

## 1. Baseline inicial

```text
php bin/console.php migrate:fresh --seed
Migration completed

php bin/console.php test
Tests: 6, Failed: 0

php bin/console.php test --filter=Mod15PrescriptionTest
Tests: 5, Failed: 0
```

## 2. Baseline final

Ejecutado despues de crear los artefactos S11 con `C:\Users\Omega20\Documents\tools\php-8.3\php.exe`:

```text
Test-Path "C:\Users\Omega20\Documents\tools\php-8.3\php.exe"
True

& "C:\Users\Omega20\Documents\tools\php-8.3\php.exe" bin\console.php migrate:fresh --seed
Migration completed

& "C:\Users\Omega20\Documents\tools\php-8.3\php.exe" bin\console.php test
Tests: 6, Failed: 0

& "C:\Users\Omega20\Documents\tools\php-8.3\php.exe" bin\console.php test --filter=Mod15PrescriptionTest
Tests: 5, Failed: 0
```

## 3. Validacion de mockup

- `docs/semana-11/mockups/prescripcion.html` existe.
- `docs/semana-11/mockups/styles.css` existe.
- CSS enlazado localmente.
- Sin JavaScript.
- Sin solicitudes de red.
- Sin integracion API real.
- Sin dependencias externas.
- Estados requeridos representados.
- Campos coinciden con contrato real.
- La alerta indica que la prescripcion no fue registrada.
- La excepcion usa `reason` y `authorized_by`.
- Responsive CSS incluido.
- Semanas 8, 9 y 10 no se modifican.
- Backend intacto.

## 4. Revision estatica esperada

- HTML con etiquetas cerradas.
- IDs unicos.
- Labels asociados a controles.
- Anclas internas validas.
- Botones sin envio real.
- CSS sin referencias externas.
- Media query del prototipo alrededor de `768px`.

## 5. Revision estatica ejecutada

Busqueda sin resultados en `docs/semana-11/mockups/` para:

```text
fetch\(|XMLHttpRequest|axios|/api/|localStorage|sessionStorage|<script|script src|<form[^>]+action=|method="post"
https?://|@import|cdn|bootstrap|tailwind|googleapis|fonts\.gstatic
```

Comprobaciones HTML/CSS:

```text
stylesheetLinked=True
hasScript=False
hasFormAction=False
hasPost=False
buttonSubmit=False
duplicateIds=
missingAnchors=
missingLabelTargets=
hasMediaQuery=True
```

Revision visual con navegador local: no ejecutada; `msedge`, `chrome` y `firefox` no estan disponibles como comandos en este entorno.
