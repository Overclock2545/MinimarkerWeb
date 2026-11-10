# D2: web comercial y catálogo

> Documento histórico del alcance D2. La implementación posterior agrega registro y recuperación de solicitudes; consulta `ENTREGA_COTIZACION.md` para el comportamiento y los requisitos vigentes.

Demostración académica de B2 Solutions para MYPE. Los nueve servicios y todos sus precios y características son ficticios o referenciales. El catálogo se encuentra en `config/catalogo_b2.php` y no usa la base de datos. La selección del comparador se conserva en `sessionStorage` de la pestaña; no se envía al servidor y se pierde al cerrar la pestaña.

La interfaz integra el controlador de productos, el layout y las vistas del proyecto base, adaptados al recorrido comercial B2. Las vistas anteriores del minimarket se conservan en `resources/views/legacy`; las rutas anteriores permanecen desactivadas durante D2. Las rutas históricas `/inicio`, `/producto/{id}` y `/ofertas` conducen al nuevo recorrido con identificadores de ofertas de demostración.

El carrito de demostración permite añadir y retirar ofertas y ajustar cantidades. Los totales mensuales y de pago único se muestran por separado. Su contenido se guarda solo en `sessionStorage` de la pestaña, sin crear pedidos, pagos ni solicitudes; requiere JavaScript y almacenamiento disponible en el navegador.

## Ejecutar

Desde `backend`, con PHP 8.2 y las dependencias de Composer instaladas:

```powershell
php artisan serve
```

Abrir la dirección indicada por Artisan, normalmente `http://127.0.0.1:8000`. Las páginas D2 no requieren migraciones ni una conexión a MySQL. Si existen cachés anteriores de configuración o rutas, ejecutar `php artisan optimize:clear` antes de iniciar.

## Recorrido para demostrar

1. En Inicio, revisar la propuesta y elegir **Explorar catálogo**.
2. Filtrar por Portabilidad, Internet o Equipos y abrir el detalle de una oferta.
3. Añadir dos ofertas de una misma categoría y abrir **Comparar**. Intentar añadir una tercera o seleccionar otra categoría para ver los límites. Retirar una opción para cambiar la selección.
4. Comprobar el estado vacío y la indicación de que falta una segunda opción. Repetir el recorrido en escritorio y celular.
5. Añadir ofertas al carrito, ajustar cantidades y revisar los importes mensuales y únicos por separado. Cerrar la pestaña para descartar la selección temporal.

No se implementó una cotización funcional, formularios, pagos, CRM, activaciones ni envío de mensajes. Las antiguas rutas del minimarket están conservadas en `routes/legacy_minimarket.php`, pero no están activas en D2. La cuenta administradora anterior permanece en su base de datos, aunque el acceso administrativo anterior no está disponible en esta demostración. Los tests del minimarket se conservan como referencia y corresponden a las rutas anteriores; para validar D2 use los comandos siguientes.

## Comprobación automatizada

```powershell
php artisan test --filter=CatalogoB2Test
node tests/js/comparador.cjs
```

La primera prueba comprueba las pantallas, filtros, ofertas inexistentes y ausencia de la ruta de compra anterior. La segunda comprueba la selección temporal, el límite de dos y la restricción de categoría. Es necesario revisar visualmente el diseño y la interacción con un navegador en escritorio y móvil.
