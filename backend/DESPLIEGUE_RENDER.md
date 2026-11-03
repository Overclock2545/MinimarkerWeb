# Despliegue de la demostración D2 en Render

La configuración incluida despliega la aplicación Laravel con Docker. El catálogo es local y el carrito y comparador se guardan temporalmente en el navegador; esta demostración no necesita MySQL ni migraciones. Las funciones antiguas de administración y compra no están activas.

## Preparar el repositorio

1. Sube los cambios del proyecto, incluido `render.yaml` en la raíz del repositorio y los archivos nuevos de `backend`, a un repositorio de GitHub accesible para Render.
2. No subas `backend/.env`, credenciales, bases de datos ni archivos de clientes. `.dockerignore` también excluye archivos locales sensibles y datos de ejecución del contexto de la imagen.
3. Genera en tu equipo una clave nueva y exclusiva para este despliegue:

   ```powershell
   php -r "echo 'base64:'.base64_encode(random_bytes(32));"
   ```

   Conserva el resultado en un lugar seguro. No lo guardes en el repositorio ni lo compartas en capturas.

## Crear el servicio con Blueprint

1. En el panel de Render, selecciona **New → Blueprint** y conecta el repositorio y la rama donde subiste los cambios.
2. Render detectará `render.yaml`, que configura un Web Service Docker gratuito, el directorio `backend` y la comprobación `/up`.
3. Cuando lo solicite, proporciona el valor generado para `APP_KEY` y crea el servicio.
4. Espera a que finalice la construcción y abre la URL `onrender.com`. El contenedor escucha el puerto asignado por Render automáticamente.
5. Comprueba inicio, las tres categorías, detalle, comparación y carrito en escritorio y celular. Las selecciones son privadas de cada pestaña y se pierden al cerrarla.

Si ya tienes un servicio creado, configura manualmente `APP_KEY` en sus variables de entorno: Render solicita los valores `sync: false` durante la creación inicial de un Blueprint. No compartas la clave del `.env` local.

No es necesario indicar `PORT`, configurar una base de datos ni ejecutar `migrate` para D2. El sistema de archivos de Render Free es temporal; no lo uses para guardar datos o archivos que deban conservarse. El servicio gratuito se suspende después de un periodo sin tráfico y puede tardar en responder al despertar. Consulta los límites vigentes en https://render.com/docs/free.

## Verificación local opcional con Docker

Con Docker Desktop ejecutándose, desde `backend`:

```powershell
docker build -t b2-solutions-d2 .
docker run --rm -p 10000:10000 -e APP_ENV=production -e APP_DEBUG=false -e APP_KEY=TU_CLAVE_DE_PRUEBA -e SESSION_DRIVER=array -e CACHE_STORE=array -e QUEUE_CONNECTION=sync b2-solutions-d2
```

Sustituye `TU_CLAVE_DE_PRUEBA` por una clave generada para la prueba. La imagen está configurada para HTTPS cuando `APP_ENV=production`; para acceder directamente por HTTP en una prueba local usa `-e APP_ENV=local` en lugar de `-e APP_ENV=production`. No uses la clave de producción en la línea de comandos ni la pegues en conversaciones. Visita `http://localhost:10000`.
