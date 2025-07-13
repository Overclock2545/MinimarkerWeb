<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta - {{ $pedido->codigo_pedido }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            margin: 30px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #7c3aed;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .header img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin-bottom: 5px;
        }
        .section-title {
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 5px;
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        th, td {
            border: 1px solid #bbb;
            padding: 6px;
            text-align: left;
        }
        .totales td {
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-style: italic;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo">
        <h2>I LIKE YOU (Importaciones)</h2>
        <p>RUC: 10066737042</p>
        <h3>BOLETA DE VENTA</h3>
        <p><strong>N° {{ $pedido->codigo_pedido }}</strong></p>
    </div>

    <p class="section-title">🧑 Datos del Cliente</p>
    <table>
        <tr><td><strong>Nombre:</strong></td><td>{{ $pedido->usuario->name ?? 'N/A' }}</td></tr>
        <tr><td><strong>DNI:</strong></td><td>{{ $pedido->usuario->dni ?? 'N/A' }}</td></tr>
        <tr><td><strong>Correo:</strong></td><td>{{ $pedido->usuario->email ?? 'N/A' }}</td></tr>
        <tr><td><strong>Fecha de emisión:</strong></td><td>{{ $pedido->created_at->format('d/m/Y') }}</td></tr>
    </table>

    <p class="section-title">📦 Detalles del Pedido</p>
    <table>
        <thead>
            <tr>
                <th>ID Producto</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedido->items as $item)
                <tr>
                    <td>{{ $item->producto->id ?? '—' }}</td>
                    <td>{{ $item->producto->nombre ?? 'Producto eliminado' }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>S/ {{ number_format($item->subtotal / $item->cantidad, 2) }}</td>
                    <td>S/ {{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="section-title">💳 Resumen de Montos</p>
    <table>
        <tr>
            <td><strong>Subtotal:</strong></td>
            <td>S/ {{ number_format($pedido->subtotal ?? $pedido->items->sum('subtotal'), 2) }}</td>
        </tr>
        <tr>
            <td><strong>Descuento:</strong></td>
            <td>S/ {{ number_format($pedido->descuento ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Total a Pagar:</strong></td>
            <td>S/ {{ number_format($pedido->total, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Método de Pago:</strong></td>
            <td>{{ ucfirst($pedido->metodo_pago ?? 'Coordinado por WhatsApp') }}</td>
        </tr>
    </table>

    <div class="footer">
        ¡Gracias por tu compra!  
        <br>
        I LIKE YOU (Importaciones)
    </div>

</body>
</html>
