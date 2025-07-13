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
            <tr style="background-color: #f3f4f6;">
                <th>ID</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio base</th>
                <th>Precio oferta</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedido->items as $item)
                <tr>
                    <td>{{ $item->product->id }}</td>
                    <td>{{ $item->product->nombre }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>S/ {{ number_format($item->product->precio, 2) }}</td>
                    <td>
                        @if($item->precio_unitario < $item->product->precio)
                            <span style="color: green;">S/ {{ number_format($item->precio_unitario, 2) }}</span><br>
                            <small style="color: red;">
                                (Descuento: S/ {{ number_format($item->product->precio - $item->precio_unitario, 2) }})
                            </small>
                        @elseif($item->precio_unitario == $item->product->precio)
                            -
                        @else
                            S/ {{ number_format($item->precio_unitario, 2) }}
                        @endif
                    </td>
                    <td>S/ {{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="section-title">💳 Resumen de Montos</p>
    <table>
        <tr>
            <td>Monto total (sin descuento):</td>
            <td>S/ {{ number_format($pedido->total + $descuentoTotal, 2) }}</td>
        </tr>
        <tr>
            <td>Descuento aplicado:</td>
            <td>- S/ {{ number_format($descuentoTotal, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Total a pagar:</strong></td>
            <td><strong>S/ {{ number_format($pedido->total, 2) }}</strong></td>
        </tr>
        <tr>
            <td><strong>Método de pago:</strong></td>
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
