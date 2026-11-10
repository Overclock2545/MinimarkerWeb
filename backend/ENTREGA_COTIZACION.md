# Entregable: cotización empresarial

El formulario registra RUC, razón social, nombre de contacto y teléfono, además de las ofertas y cantidades seleccionadas en el carrito. Utiliza datos ficticios durante la demostración. Para portabilidad la cantidad representa líneas; para internet, conexiones; y para equipos, unidades.

El servidor valida todos los campos y cantidades (1 a 99), verifica las referencias contra `config/catalogo_b2.php` y calcula los importes referenciales con sus propios precios. No confía en precios enviados por el navegador. Los importes mensuales y únicos se mantienen separados. Si una oferta no tiene una regla de precio válida, se señala que los importes son parciales.

Cada solicitud se guarda en la tabla `solicitudes_cotizacion`, con origen `web`, fecha y copia de las ofertas y precios vigentes al momento del envío. La confirmación muestra un código y una propuesta recuperable mediante un enlace aleatorio. El enlace no contiene datos personales y la base solo guarda el hash del token. Quien tenga el enlace podrá consultar la propuesta, por lo que debe compartirse únicamente con las personas correspondientes.

No se envían mensajes, no hay pagos, activaciones, contratos ni integración con CRM. El carrito y el comparador siguen siendo temporales en la pestaña; la solicitud registrada sí persiste en la base propia. Si falla el guardado, se muestra un error y se conserva el contenido del formulario para reintentar.

## Preparación local

1. Iniciar MySQL y comprobar que la conexión configurada en `backend/.env` apunta a la base propia correcta. Para mantener el formulario disponible cuando la base no responda, utilizar `SESSION_DRIVER=file` y `CACHE_STORE=file` en el entorno local. No compartir el archivo ni sus credenciales.
2. Desde `backend`, aplicar la migración **específica**: `php artisan migrate --path=database/migrations/2026_11_10_000000_create_solicitudes_cotizacion_table.php`.
3. Iniciar con `php artisan serve`; seleccionar ofertas en el catálogo, ajustar cantidades en el carrito y usar **Solicitar cotización**.
4. Registrar con datos ficticios, copiar el enlace de confirmación y abrirlo o recargarlo para recuperar el resumen. Si se pierde el enlace, esta versión no dispone de otro mecanismo de recuperación.

La tabla debe crearse en la base configurada para cada entorno. En Render se requiere una base propia persistente y una sesión que sobreviva a varias peticiones; consulta `DESPLIEGUE_RENDER.md`. La migración no se ejecuta automáticamente para evitar afectar otras bases.

## Pruebas automatizadas

Ejecutar `php artisan test --filter=CotizacionTest`, `php artisan test --filter=CatalogoB2Test` y `node tests/js/cotizacion.cjs`. Las pruebas usan SQLite en memoria y cubren registro y recuperación, validación de campos y cantidades, referencias inválidas o duplicadas, precios manipulados, oferta sin precio y fallo simulado de guardado. También se comprobó el registro HTTP, CSRF y recuperación con SQLite temporal. La revisión visual del recorrido en escritorio y móvil sigue siendo necesaria.
