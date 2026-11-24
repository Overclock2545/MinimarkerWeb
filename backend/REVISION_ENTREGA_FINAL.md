# Revisión del entregable final — B2 Solutions

Fecha de revisión: 23 de noviembre de 2026 (Lima). Documento de referencia: `Alcance_y_cronograma_B2_MYPE.docx`.

## Acceso para el profesor

- Sitio publicado: https://minimarkerweb.onrender.com/
- El inicio, catálogo, comparador, carrito y cotización son públicos: no requieren usuario ni contraseña.
- El panel interno está en https://minimarkerweb.onrender.com/interno/metricas. Usa autenticación HTTP básica con usuario `admin` y la contraseña configurada como `B2_METRICAS_CLAVE` en el entorno del servicio. La clave debe tener al menos 16 caracteres. Después de corregir la conexión a PostgreSQL se verificó el acceso del administrador y el rechazo de credenciales incorrectas. No confundir con la cuenta antigua `admin@gmail.com`: el inicio de sesión antiguo no forma parte de las rutas activas.
- Si el panel devuelve 503, el responsable debe configurar una clave en el entorno de Render y desplegar esa configuración; después comprobar el acceso y facilitarla al profesor por un canal privado. No compartir la contraseña de Render ni la base de datos.

## Propuesta de valor y alcance

El canal permite a una MYPE explorar y comparar alternativas de conectividad, seleccionar ofertas y cantidades, registrar una solicitud y retomar su propuesta con un enlace privado. La continuidad ofrece un borrador de WhatsApp y registro de preferencia de llamada; después se puede responder una encuesta o compartir una referencia. Las métricas se alimentan de registros propios de demostración. La combinación del recorrido autogestionado y su continuidad posterior constituye la propuesta de valor demostrable.

El catálogo, los precios y los datos del recorrido son demostrativos. El prototipo no realiza pagos, activaciones ni envíos automáticos; el CRM es una integración futura descrita teóricamente. Un clic en WhatsApp no acredita un mensaje enviado ni una venta.

## Contraste con los hitos

| Hito | Estado observado |
| --- | --- |
| D1–D2: navegación y catálogo | Inicio, tres categorías, detalle, comparador y carrito implementados. Pruebas automatizadas locales satisfactorias. |
| D3: cotización | Formulario, validaciones, cantidades, persistencia y recuperación implementados y probados localmente. |
| D4: propuesta y continuidad | Enlace de recuperación, resumen, borrador de WhatsApp y preferencia de llamada implementados y probados localmente. |
| D5: encuesta, referidos y métricas | Funciones implementadas y cubiertas por pruebas locales. Falta validar acceso y recorrido completo en el sitio publicado. |
| D5–D6: documentación y entrega | Existe informe y manual, pero requieren actualizar el estado, capturas reales y presupuesto estimado; falta comprobar presentación final, evidencias, respaldo y acceso por el profesor. No se ha realizado la entrega. |

## Verificaciones de esta revisión

- Render informa que el servicio `MinimarkerWeb` tiene como versión activa el commit `4899ace`, correspondiente al commit local revisado. El despliegue automático está desactivado.
- La instancia PostgreSQL aparece disponible. Una consulta de solo lectura confirmó las migraciones `2026_11_10_000000_create_solicitudes_cotizacion_table` y `2026_11_16_000000_add_continuidad_y_fidelizacion`.
- Las pruebas específicas del canal y los cinco scripts de JavaScript se ejecutaron localmente. La batería completa también incluye pruebas antiguas de autenticación, perfil y pedidos cuyas rutas no están activas y presenta fallos: no debe presentarse como una batería completamente satisfactoria.
- Se comprobó por HTTP que el inicio, catálogo, comparador, carrito y formulario de cotización responden 200; `/login` responde 404. Tras corregir la configuración de PostgreSQL, el panel de métricas responde 200 con la clave correcta y 401 sin credenciales o con clave incorrecta. El recorrido de principio a fin, la versión móvil y el registro y recuperación no se han verificado en producción.

## Guion para verificar antes de entregar

1. Abrir el sitio publicado en escritorio y celular; explorar las tres categorías y comparar dos ofertas de una categoría.
2. Añadir una oferta al carrito, cambiar su cantidad y solicitar cotización. Usar RUC y datos ficticios.
3. Guardar el código y copiar el enlace privado. Abrirlo en otra sesión y confirmar servicios, cantidades y condiciones.
4. Abrir WhatsApp, revisar que el borrador contenga el código y la selección, sin enviarlo; registrar la preferencia de llamada.
5. Registrar una encuesta y abrir el enlace de referido en otra pestaña. Completar una nueva solicitud en esa pestaña y confirmar su origen en métricas.
6. Entrar al panel interno con la clave configurada, verificar los conteos y comprobar que una clave equivocada no da acceso.
7. Tomar capturas con datos ficticios y sin exponer enlaces privados; revisar que el informe, la presentación y el presupuesto estimado correspondan al prototipo. Confirmar un respaldo de código y datos de prueba, ensayar el recorrido y entregar el enlace y la clave por separado.

Si la base gratuita o el servicio dejan de estar disponibles, usar la alternativa local descrita en `INFORME_MANUAL_D4_D5.md` y comprobar previamente su conexión y migraciones. La instancia PostgreSQL consultada indica expiración el 17 de diciembre de 2026; revisar su vigencia y respaldos en Render.
