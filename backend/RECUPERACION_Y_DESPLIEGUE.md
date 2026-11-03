# Recuperación e instalación

La base original no se encuentra en este repositorio. Las migraciones incluyen una reconstrucción inferida de las tablas de usuarios, categorías, productos y carrito, además de las migraciones existentes de pedidos, ofertas y contenido. No recuperan datos originales ni garantizan reproducir exactamente el esquema perdido. No se han creado usuarios o productos ficticios.

Antes de crear una base nueva, busque copias SQL, archivos de datos de MySQL/MariaDB, copias del servidor, alojamiento o respaldos personales. Preserve los archivos originales y trabaje sobre copias. Este proyecto no contiene un respaldo SQL o SQLite identificado durante la revisión.

## Preparación local

1. Instale PHP 8.2 o superior, Composer, Node.js y las extensiones PHP necesarias. Ejecute `composer install` y `npm ci` dentro de `backend`.
2. Copie `.env.example` a `.env` y configure la conexión a una **base nueva y vacía**. Para MySQL/MariaDB cree antes la base y defina `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` y `DB_PASSWORD`. Para SQLite cree el archivo y configure `DB_DATABASE` con su ruta absoluta.
3. Ejecute `php artisan key:generate`, `php artisan migrate` y `php artisan storage:link`. Compile recursos con `npm run build` o use `npm run dev` en desarrollo.
4. Configure el correo para enviar códigos de verificación. Configure Cloudinary si se utilizará la carga de imágenes mediante ese servicio. El número de WhatsApp se encuentra actualmente en `CarritoController` y debe ajustarse al negocio.

No use `migrate:fresh` en una base con datos que desee conservar: elimina las tablas. No ejecute estas migraciones sobre una base existente sin revisar previamente su esquema y contar con una copia.

Para obtener el primer administrador, registre y verifique una cuenta y cambie su rol de forma controlada en la base de datos a `admin`. No hay una contraseña predeterminada. El registro requiere un correo funcional.

## Docker

Construya la imagen desde este directorio. El contenedor compila los recursos y arranca Apache, pero no ejecuta migraciones automáticamente. Configure las variables de entorno y ejecute `php artisan migrate --force` como paso explícito del despliegue una vez disponible la base. Conserve `storage` en almacenamiento persistente para no perder archivos subidos.

## Comprobación

Ejecute `php artisan test` sobre una base de pruebas independiente y valide el registro, catálogo, carrito y ciclo de pedidos. Las migraciones reconstruidas y las integraciones deben verificarse en el motor y entorno concretos antes de utilizarse con datos reales.
