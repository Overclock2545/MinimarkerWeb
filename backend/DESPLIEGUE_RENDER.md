# Despliegue de la demostración comercial en Render

La aplicación usa un catálogo local y guarda temporalmente el carrito y el comparador en el navegador. Para registrar y recuperar solicitudes de cotización necesita una base de datos propia y persistente accesible desde Render. La imagen incluye controladores de MySQL y PostgreSQL. Las funciones antiguas de administración y compra no están activas.

## Preparar el repositorio

1. Sube los cambios del proyecto, incluido `render.yaml` en la raíz del repositorio y los archivos nuevos de `backend`, a un repositorio de GitHub accesible para Render.
2. No subas `backend/.env`, credenciales, bases de datos ni archivos de clientes. `.dockerignore` también excluye archivos locales sensibles y datos de ejecución del contexto de la imagen.
3. Genera en tu equipo una clave nueva y exclusiva para este despliegue:

   ```powershell
   php -r "echo 'base64:'.base64_encode(random_bytes(32));"
   ```

   Conserva el resultado en un lugar seguro. No lo guardes en el repositorio ni lo compartas en capturas.

## Actualizar un servicio ya conectado

Si el proyecto ya tiene un servicio conectado a GitHub en Render, utiliza ese servicio. No necesitas crear otro Blueprint: `render.yaml` no cambia automáticamente la configuración de un servicio que no fue creado mediante ese Blueprint.

1. Comprueba en Render que el servicio utiliza la rama que contiene los cambios y que el último despliegue corresponde al commit deseado. Si el despliegue automático está desactivado o aún no se ha iniciado, usa **Manual Deploy → Deploy latest commit**.
2. En la configuración del servicio revisa que utilice Docker y que el directorio raíz de construcción sea `backend` (con `Dockerfile` dentro). Conserva los demás valores del servicio si ya funcionan.
3. En **Environment**, revisa `APP_ENV=production`, `APP_DEBUG=false`, `LOG_CHANNEL=stderr`, `SESSION_DRIVER=file`, `CACHE_STORE=array` y `QUEUE_CONNECTION=sync`. El controlador de sesión `array` no conserva la sesión entre solicitudes HTTP y no sirve para el formulario con CSRF. Comprueba que exista una `APP_KEY` válida y estable; consérvala y no publiques su valor.
4. Configura la conexión a una base de datos propia y persistente: `DB_CONNECTION=mysql` y `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`; o `DB_CONNECTION=pgsql` y `DB_URL` con la conexión PostgreSQL. La base MySQL de `127.0.0.1` en tu computadora no es accesible desde Render mediante esa dirección.
5. Ejecuta en el entorno con acceso a esa base la migración específica: `php artisan migrate --path=database/migrations/2026_11_10_000000_create_solicitudes_cotizacion_table.php --force`. Revisa el destino antes de ejecutarla. El inicio del contenedor no ejecuta migraciones automáticamente.
6. Abre la URL del servicio y prueba el recorrido completo con datos ficticios. Guarda el enlace de confirmación y verifica que siga funcionando tras recargar. Si el despliegue o guardado falla, revisa los logs en Render sin compartir credenciales.

El repositorio contiene un Blueprint opcional para crear un servicio nuevo; no es necesario para actualizar el servicio existente.

## Crear un servicio nuevo con Blueprint

1. En el panel de Render, selecciona **New → Blueprint** y conecta el repositorio y la rama donde subiste los cambios.
2. Render detectará `render.yaml`, que configura un Web Service Docker gratuito, el directorio `backend` y la comprobación `/up`.
3. Cuando lo solicite, proporciona el valor generado para `APP_KEY` y crea el servicio.
4. Espera a que finalice la construcción y abre la URL `onrender.com`. El contenedor escucha el puerto asignado por Render automáticamente.
5. Comprueba inicio, las tres categorías, detalle, comparación y carrito en escritorio y celular. Las selecciones son privadas de cada pestaña y se pierden al cerrarla.

Si ya tienes un servicio creado, configura manualmente `APP_KEY` en sus variables de entorno: Render solicita los valores `sync: false` durante la creación inicial de un Blueprint. No compartas la clave del `.env` local.

No es necesario indicar `PORT`. Para las solicitudes sí se requiere una base externa persistente y aplicar la migración específica. El sistema de archivos de Render Free es temporal: las sesiones de archivo sirven para el formulario, pero se pierden al reiniciar y no son adecuadas para múltiples instancias. El servicio gratuito se suspende después de un periodo sin tráfico y puede tardar en responder al despertar. Consulta los límites vigentes en https://render.com/docs/free.

## Verificación local opcional con Docker

Con Docker Desktop ejecutándose, desde `backend`:

```powershell
docker build -t b2-solutions-d2 .
docker run --rm -p 10000:10000 -e APP_ENV=local -e APP_DEBUG=false -e APP_KEY=TU_CLAVE_DE_PRUEBA -e SESSION_DRIVER=file -e CACHE_STORE=array -e QUEUE_CONNECTION=sync b2-solutions-d2
```

Sustituye `TU_CLAVE_DE_PRUEBA` por una clave generada para la prueba. Esta orden permite revisar el catálogo; para guardar solicitudes añade una conexión a una base de prueba accesible desde el contenedor y aplica la migración. No uses la clave de producción en la línea de comandos ni la pegues en conversaciones. Visita `http://localhost:10000`.
