@extends('layouts.adminplantilla')

@section('title', 'Carrito de ' . $usuario->name)

@section('content')
    <h2>Carrito de {{ $usuario->name }}</h2>

    @if ($carrito->isEmpty())
        <p>Este usuario no tiene productos en su carrito.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($carrito as $item)
                    <tr>
                        <td>{{ $item->product->nombre }}</td>
                        <td>S/ {{ $item->product->precio }}</td>
                        <td>{{ $item->cantidad }}</td>
                        <td>S/ {{ $item->cantidad * $item->product->precio }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
