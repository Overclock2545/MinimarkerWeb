@extends('layouts.adminplantilla')

@section('title', 'Carrito de ' . $usuario->name)

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4" style="color: #a855f7;">🛒 Carrito de {{ $usuario->name }}</h2>

    @if ($carrito->isEmpty())
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle-fill"></i> Este usuario no tiene productos en su carrito.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle shadow-sm">
                <thead class="table-light text-center">
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($carrito as $item)
                        <tr>
                            <td>{{ $item->product->nombre }}</td>
                            <td>S/ {{ number_format($item->product->precio, 2) }}</td>
                            <td>{{ $item->cantidad }}</td>
                            <td>S/ {{ number_format($item->cantidad * $item->product->precio, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection
