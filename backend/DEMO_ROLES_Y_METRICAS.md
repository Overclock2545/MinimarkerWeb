# Cuentas y métricas de demostración

La versión local incluye acceso con correo y contraseña en `/acceso` y registro en `/crear-cuenta`. Las cuentas nuevas siempre reciben el rol `usuario`; solo un administrador puede consultar `/interno/metricas`. El catálogo y la cotización siguen accesibles sin cuenta. El carrito se guarda en la pestaña y las propuestas se recuperan mediante su enlace privado; no están vinculados a la cuenta.

La base independiente `storage/app/b2-demostracion.sqlite` se preparó localmente con 240 solicitudes identificadas con el prefijo `B2-DEMO-`, 60 referencias, 160 encuestas y 80 preferencias de llamada. Empresas, teléfonos, precios y eventos son ficticios; no son ventas. Los modelos de celulares son comerciales, pero los precios y la disponibilidad son simulados.

Para ejecutar esta base local en PowerShell desde `backend`:

```powershell
$env:DB_CONNECTION='sqlite'
$env:DB_DATABASE=Join-Path (Get-Location) 'storage/app/b2-demostracion.sqlite'
$env:SESSION_DRIVER='file'
$env:CACHE_STORE='file'
php artisan serve
```

Esta configuración afecta únicamente a la terminal actual. Usar las cuentas de demostración facilitadas durante la preparación, o crear otra cuenta desde la interfaz. Para crear un administrador adicional en la base configurada, ejecutar `php artisan b2:crear-admin correo@ejemplo.test`; el comando solicita la contraseña de forma interactiva y no modifica cuentas ya existentes.

La base SQLite local no forma parte del repositorio ni se transfiere a Render. Para otro entorno, inspeccionar primero la base de destino y su historial de migraciones, aplicar únicamente la nueva migración `2026_11_23_000000_create_b2_usuarios_table.php` y crear las cuentas. La carga opcional `php artisan db:seed --class=DatosDemostracionB2Seeder --force` añade hasta 240 registros identificados sin eliminar registros existentes; repetirla no duplica las solicitudes. No ejecutar migraciones o cargas sobre una base diferente sin verificar su destino.

Para el entorno publicado deben desplegarse los archivos nuevos, configurar y aplicar la migración y crear el administrador; hasta entonces el acceso con correo y los datos locales no estarán disponibles allí. El antiguo acceso HTTP Basic de métricas sigue disponible como mecanismo de compatibilidad cuando `B2_METRICAS_CLAVE` está configurada.
