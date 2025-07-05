@extends('layouts.plantilla')

@section('title', 'I LIKE YOU - Inicio')

@section('content')

<h2 class="text-center mb-4" style="background-color: rgba(255, 255, 255, 0.5); padding: 10px; border-radius: 8px;">
    {{ $titulo ?? ($producto->nombre ?? 'GRANDES OFERTAS') }}
</h2>

@isset($producto)
    {{-- Vista individual --}}
    <div class="row g-4">
        <div class="col-md-5">
            <img src="{{ $producto->imagen ?? 'https://via.placeholder.com/350' }}"
                 alt="{{ $producto->nombre }}"
                 class="img-fluid rounded"
                 style="object-fit: cover; width: 100%; max-height: 350px;">
            <h4 class="mt-3">{{ $producto->nombre }}</h4>
            <p class="text-success"><strong>S/. {{ $producto->precio }}</strong></p>
            <p>Categoría: {{ $producto->categoria->nombre ?? 'Sin categoría' }}</p>

            <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST" class="mb-2">
                @csrf
                <input type="hidden" name="cantidad" value="1" id="cantidad-input">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <button type="button" class="btn btn-outline-secondary" onclick="cambiarCantidad(-1)">-</button>
                    <input type="number" id="cantidad" value="1" min="1" class="form-control text-center" style="width: 70px;" readonly>
                    <button type="button" class="btn btn-outline-secondary" onclick="cambiarCantidad(1)">+</button>
                </div>
                <button type="submit" class="btn btn-dark w-100">🛒 Agregar al carrito</button>
            </form>

            <form method="POST" action="{{ route('favoritos.agregar', $producto->id) }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100">❤ Agregar a favoritos</button>
            </form>
        </div>

        <div class="col-md-7">
            <h5>Descripción:</h5>
            <p style="max-height: 300px; overflow-y: auto;">
                {{ $producto->descripcion ?? 'Este producto no tiene una descripción.' }}
            </p>
        </div>
    </div>

    <script>
        function cambiarCantidad(cambio) {
            const inputVisible = document.getElementById('cantidad');
            const inputOculto = document.getElementById('cantidad-input');
            let valor = parseInt(inputVisible.value) || 1;
            valor += cambio;
            if (valor < 1) valor = 1;
            inputVisible.value = valor;
            inputOculto.value = valor;
        }
    </script>

@else
    {{-- Vista de lista de productos --}}
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
        @foreach($products as $product)
            <div class="col">
                <div class="card product-card h-100 position-relative">
                    <a href="{{ route('producto.ver', $product->id) }}" class="text-decoration-none text-dark">
                        <img src="{{ $product->imagen ?? 'https://via.placeholder.com/150' }}"
                             alt="{{ $product->nombre }}"
                             class="card-img-top"
                             style="height: 250px; object-fit: contain;">
                        <div class="card-body text-center">
                            <h6 class="mb-1">{{ $product->nombre }}</h6>
                            <p class="mb-1 text-success"><strong>S/. {{ $product->precio }}</strong></p>
                            <small class="text-muted">Categoría: {{ $product->categoria->nombre ?? 'Sin categoría' }}</small>
                        </div>
                    </a>

                    <div class="product-actions p-2">
                        <form method="POST" action="{{ route('carrito.agregar', $product->id) }}" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-dark w-100">🛒 Agregar al carrito</button>
                        </form>
                        <form method="POST" action="{{ route('favoritos.agregar', $product->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100">❤ Agregar a favoritos</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endisset

@endsection
