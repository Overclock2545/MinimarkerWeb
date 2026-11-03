<?php

return [
    'portabilidad' => [
        'nombre' => 'Portabilidad', 'numero' => '01', 'icono' => '↗', 'descripcion' => 'Planes móviles para mantener a tu equipo conectado.', 'atributos' => ['Datos', 'Llamadas', 'Ideal para'],
        'ofertas' => [
            ['id'=>'conecta-25','nombre'=>'Conecta MYPE 25','descripcion'=>'Conectividad móvil para empezar con lo esencial.','precio'=>39.90,'periodo'=>'mensual','valores'=>['25 GB','Nacionales','Uso diario'],'detalle'=>'Una alternativa para negocios que necesitan mantenerse disponibles durante el día.'],
            ['id'=>'conecta-45','nombre'=>'Conecta MYPE 45','descripcion'=>'Más datos para un ritmo de trabajo en movimiento.','precio'=>54.90,'periodo'=>'mensual','valores'=>['45 GB','Nacionales','Equipos móviles'],'detalle'=>'Pensado para comparar una capacidad intermedia de datos para tu negocio.'],
            ['id'=>'conecta-80','nombre'=>'Conecta MYPE 80','descripcion'=>'Mayor capacidad para compartir y colaborar.','precio'=>74.90,'periodo'=>'mensual','valores'=>['80 GB','Nacionales','Datos compartibles'],'detalle'=>'Una opción referencial para equipos que necesitan más capacidad móvil.'],
        ],
    ],
    'internet' => [
        'nombre' => 'Internet', 'numero' => '02', 'icono' => '⌁', 'descripcion' => 'Conexiones fijas para las actividades de tu negocio.', 'atributos' => ['Velocidad', 'Conexión', 'Incluye'],
        'ofertas' => [
            ['id'=>'internet-150','nombre'=>'Internet Negocio 150','descripcion'=>'Conexión para las tareas esenciales de tu oficina.','precio'=>99.90,'periodo'=>'mensual','valores'=>['150 Mbps','Fija','Router Wi-Fi'],'detalle'=>'Una alternativa de demostración para navegar y gestionar tu negocio.'],
            ['id'=>'internet-300','nombre'=>'Internet Negocio 300','descripcion'=>'Mayor velocidad para equipos y tareas simultáneas.','precio'=>139.90,'periodo'=>'mensual','valores'=>['300 Mbps','Fija','Soporte remoto'],'detalle'=>'Una opción intermedia para comparar capacidades de conexión fija.'],
            ['id'=>'internet-600','nombre'=>'Internet Negocio 600','descripcion'=>'Más capacidad para una oficina conectada.','precio'=>189.90,'periodo'=>'mensual','valores'=>['600 Mbps','Fija','Mayor capacidad'],'detalle'=>'Una alternativa referencial para negocios con más equipos conectados.'],
        ],
    ],
    'equipos' => [
        'nombre' => 'Equipos', 'numero' => '03', 'icono' => '▧', 'descripcion' => 'Dispositivos para acompañar tu forma de trabajar.', 'atributos' => ['Tipo', 'Característica', 'Uso'],
        'ofertas' => [
            ['id'=>'equipo-essential','nombre'=>'Equipo MYPE Essential','descripcion'=>'Un equipo móvil para las tareas del día a día.','precio'=>699.00,'periodo'=>'único','valores'=>['Móvil','128 GB','Cámara principal'],'detalle'=>'Un dispositivo de demostración para comunicación y tareas cotidianas.'],
            ['id'=>'equipo-pro','nombre'=>'Equipo MYPE Pro','descripcion'=>'Mayor capacidad para acompañar tu jornada.','precio'=>1099.00,'periodo'=>'único','valores'=>['Móvil','256 GB','Batería de alta capacidad'],'detalle'=>'Una alternativa ficticia para comparar almacenamiento y autonomía.'],
            ['id'=>'router-negocio','nombre'=>'Router Negocio Wi-Fi','descripcion'=>'Conectividad inalámbrica para espacios de trabajo.','precio'=>249.00,'periodo'=>'único','valores'=>['Router','Doble banda','Conectividad de oficina'],'detalle'=>'Un router referencial para evaluar conectividad inalámbrica en una oficina.'],
        ],
    ],
];
