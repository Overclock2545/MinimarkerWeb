# Cuentas y métricas de demostración

La versión local incluye acceso con correo y contraseña en `/acceso` y registro en `/crear-cuenta`. Las cuentas nuevas siempre reciben el rol `usuario`; solo un administrador puede consultar `/interno/metricas`. El catálogo y la cotización siguen accesibles sin cuenta. El carrito se guarda en la pestaña y las propuestas se recuperan mediante su enlace privado; no están vinculados a la cuenta.

La base independiente `storage/app/b2-demostracion.sqlite` se preparó localmente con 240 solicitudes identificadas con el prefijo `B2-DEMO-`, 60 referencias, 160 encuestas y 80 preferencias de llamada. Empresas, teléfonos, precios y eventos son ficticios; no son ventas. Los modelos de celulares son comerciales, pero los precios y la disponibilidad son simulados.

Para ejecutar esta base local en PowerShell desde `backend`:

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\iniciar-demo.ps1
```

El script utiliza la base SQLite local y almacena la sesión y el caché en archivos. Usar las cuentas de demostración facilitadas durante la preparación, o crear otra cuenta desde la interfaz. Para crear un administrador adicional en la base configurada, ejecutar `php artisan b2:crear-admin correo@ejemplo.test`; el comando solicita la contraseña de forma interactiva y no modifica cuentas ya existentes.

La base SQLite local no forma parte del repositorio ni se transfiere a Render. Para otro entorno, inspeccionar primero la base de destino y su historial de migraciones, aplicar únicamente la nueva migración `2026_11_23_000000_create_b2_usuarios_table.php` y crear las cuentas. La carga opcional `php artisan db:seed --class=DatosDemostracionB2Seeder --force` añade hasta 240 registros identificados sin eliminar registros existentes; repetirla no duplica las solicitudes. No ejecutar migraciones o cargas sobre una base diferente sin verificar su destino.

En la revisión del 23 de noviembre de 2026 (Lima) se verificó en Render la tabla de cuentas y se cargaron 240 solicitudes ficticias. El acceso publicado del administrador y el rechazo al usuario normal en métricas se comprobaron por HTTP. El antiguo acceso HTTP Basic de métricas sigue disponible como mecanismo de compatibilidad cuando `B2_METRICAS_CLAVE` está configurada.
