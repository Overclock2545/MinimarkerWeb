# Base de datos propia: guía para la demostración

El proyecto conserva la selección en la pestaña, pero solicitudes, preferencias de llamada y encuestas requieren una base SQL persistente. No se creó ni modificó una base remota desde esta sesión.

## Opción 1: MySQL local con XAMPP

1. Inicia MySQL en XAMPP. El proyecto local estaba configurado para `127.0.0.1`, base `minimarker`; verifica que `backend/.env` siga apuntando a tu base propia. No compartas ese archivo ni sus credenciales.
2. Para que la sesión del formulario y el control de intentos no dependan de MySQL cuando este falle, configura en el entorno local `SESSION_DRIVER=file` y `CACHE_STORE=file`.
3. Desde PowerShell en `backend` aplica estas dos migraciones **en orden**. La primera se omite automáticamente si ya está registrada:

```powershell
php artisan migrate --path=database/migrations/2026_11_10_000000_create_solicitudes_cotizacion_table.php
php artisan migrate --path=database/migrations/2026_11_16_000000_add_continuidad_y_fidelizacion.php
php artisan serve
```

4. Para habilitar `/interno/metricas`, configura `B2_METRICAS_CLAVE` con una clave larga y única de al menos 16 caracteres. El usuario es `admin`. Si se usa caché de configuración, actualízala antes de ejecutar la aplicación. `B2_WHATSAPP_DEMO` puede cambiar el número de prueba.

MySQL local sirve para ensayar desde este equipo. Render no puede acceder a tu propia computadora con `127.0.0.1`; para el sitio público necesitas una base accesible desde Render.

## Opción 2: PostgreSQL administrado en Render

La imagen Docker de este proyecto incluye `pdo_pgsql`. Para pruebas puedes crear una base **New → Postgres** en el mismo workspace y región que tu servicio existente. El plan gratuito de Render tiene límites: caduca a los 30 días, no incluye copias de seguridad y luego del periodo de gracia puede eliminarse con sus datos. Consulta las condiciones actuales: https://render.com/docs/free#free-postgres

1. En la base nueva, abre **Connect**. Copia la **Internal Database URL** solo para pegarla en el panel privado del servicio web de Render, en `DB_URL`. Configura `DB_CONNECTION=pgsql`, `DB_PORT=5432`, `SESSION_DRIVER=file`, `CACHE_STORE=file` y una clave privada larga en `B2_METRICAS_CLAVE`. El almacenamiento temporal de caché de archivo permite limitar intentos entre solicitudes mientras la instancia esté activa. Conserva la `APP_KEY` ya existente. El nombre real de la variable de conexión en este proyecto es `DB_URL`, no `DATABASE_URL`.
2. Guarda la configuración y despliega el commit que contiene las migraciones. El servicio web existente no crea la tabla automáticamente. En el plan gratuito no hay consola Shell en el panel, así que ejecuta las migraciones desde un equipo con acceso externo a la base.
3. En **Connect**, utiliza la **External Database URL**, que debe incluir `sslmode=require`. Restringe el acceso externo a tu IP si la configuración de red lo permite. No pegues la URL ni contraseñas en mensajes, archivos del repositorio o capturas.
4. En PowerShell, desde `backend`, proporciona la URL de forma oculta y configura las variables solo para esa ventana:

```powershell
$dbSecret = Read-Host 'External Database URL' -AsSecureString
$dbPointer = [Runtime.InteropServices.Marshal]::SecureStringToBSTR($dbSecret)
try { $env:DB_URL = [Runtime.InteropServices.Marshal]::PtrToStringBSTR($dbPointer) } finally { [Runtime.InteropServices.Marshal]::ZeroFreeBSTR($dbPointer) }
$env:DB_CONNECTION = 'pgsql'
$env:DB_PORT = '5432'
$env:SESSION_DRIVER = 'file'
$env:CACHE_STORE = 'array'
```

5. El puerto temporal `5432` evita heredar `DB_PORT=3306` de la configuración local de MySQL cuando la URL externa no especifica puerto. Si la URL incluye un puerto explícito, Laravel utiliza el de la URL. La URL externa debe requerir TLS (`sslmode=require`). **Corrección:** el controlador PostgreSQL de este XAMPP carga `libpq 11.4`, una biblioteca anterior a la incorporación de SNI en libpq; aunque `pdo_pgsql` se habilite, puede fallar al conectarse externamente a Render. No sustituyas archivos de XAMPP. Usa una instalación aislada con una biblioteca moderna o Docker Desktop y la imagen del proyecto; sigue las instrucciones de Docker de abajo. La configuración de Laravel no debe estar cacheada con otro destino.

Con Docker Desktop iniciado, fuerza TLS en la URL que ya está en memoria, sin imprimirla:

```powershell
if ($env:DB_URL -match '[?&]sslmode=') {
    $env:DB_URL = $env:DB_URL -replace '([?&]sslmode=)[^&]*', '${1}require'
} elseif ($env:DB_URL.Contains('?')) {
    $env:DB_URL += '&sslmode=require'
} else {
    $env:DB_URL += '?sslmode=require'
}
```

Construye la imagen desde `backend` y ejecuta las migraciones con las mismas variables temporales de PowerShell, una por una:

```powershell
docker build -t b2-render-migraciones .
docker run --rm --env DB_URL --env DB_PORT --env DB_CONNECTION -e SESSION_DRIVER=file -e CACHE_STORE=file b2-render-migraciones php artisan migrate --path=database/migrations/2026_11_10_000000_create_solicitudes_cotizacion_table.php --force
docker run --rm --env DB_URL --env DB_PORT --env DB_CONNECTION -e SESSION_DRIVER=file -e CACHE_STORE=file b2-render-migraciones php artisan migrate --path=database/migrations/2026_11_16_000000_add_continuidad_y_fidelizacion.php --force
```

El parámetro `--env DB_URL` transmite el valor del entorno al contenedor sin escribirlo en la orden. Mantén la URL y las credenciales privadas. Después de completar las migraciones, cierra la ventana de PowerShell o elimina las variables temporales. El procedimiento con Docker está preparado pero todavía no ha sido validado contra la base de Render.

6. Verifica desde el sitio desplegado con datos ficticios: crear cotización, recargar propuesta, registrar llamada y encuesta y comprobar métricas. Si la base no responde, no se debe declarar el entregable validado. No compartas mensajes de error que contengan URLs de conexión u otros secretos.

La URL interna solo funciona para servicios de Render en la misma región; la externa es para el equipo local y usa la política de acceso por IP. Consulta https://render.com/docs/postgresql-creating-connecting. Las sesiones de archivo se pierden al reiniciar y no son adecuadas para múltiples instancias; la base propia conserva las solicitudes mientras el proveedor la mantenga activa. Para uso prolongado se necesita un plan de persistencia y respaldo apropiado.
