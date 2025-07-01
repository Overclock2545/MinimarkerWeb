<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta - {{ $pedido->codigo_pedido }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        h1, h2, h3 { margin: 0; }
        .header { text-align: center; margin-bottom: 20px; }
        .info { margin-bottom: 10px; }
        .tabla { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .tabla th, .tabla td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .totales { margin-top: 20px; text-align: right; }
        .nota { font-size: 12px; color: #666; margin-top: 30px; }
    </style>
</head>
<body>

<div class="header">
    <h2>I LIKE YOU</h2>
    <p>Boleta de Pedido</p>
</div>

<div class="info">
    <strong>Código:</strong> {{ $pedido->codigo_pedido }}<br>
    <strong>Cliente:</strong> {{ $pedido->usuario->name }}<br>
    <strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}<br>
    <strong>Método de pago:</strong> Coordinado por WhatsApp
</div>

<table class="tabla">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio unitario</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pedido->items as $item)
            <tr>
                <td>{{ $item->producto->nombre }}</td>
                <td>{{ $item->cantidad }}</td>
                <td>S/ {{ number_format($item->precio, 2) }}</td>
                <td>S/ {{ number_format($item->cantidad * $item->precio, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="totales">
    <h3>Total: S/ {{ number_format($pedido->total, 2) }}</h3>
</div>

<div class="nota">
    <p><strong>Nota:</strong> Documento sin valor tributario. Solo para fines informativos.</p>
</div>

</body>
</html>
