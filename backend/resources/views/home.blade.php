@extends('layouts.plantilla')

@section('title', 'I LIKE YOU - Inicio')

@section('content')

<h2 class="text-center mb-4" style="background-color: rgba(255, 255, 255, 0.5); padding: 10px; border-radius: 8px;">
    {{ $titulo ?? ($producto->nombre ?? 'GRANDES OFERTAS') }}
</h2>

@isset($producto)
<div class="container mb-5">
    <div class="row justify-content-center align-items-start g-4">

        <!-- Imagen del producto -->
        <div class="col-md-5 d-flex flex-column align-items-center">
            <div class="bg-light rounded p-3 shadow-sm" style="width: 100%; max-height: 350px; display: flex; align-items: center; justify-content: center;">
                <img src="{{ $producto->imagen ? asset($producto->imagen) : 'https://via.placeholder.com/350' }}"
                     alt="{{ $producto->nombre }}"
                     class="img-fluid"
                     style="object-fit: contain; max-height: 300px;">
            </div>

            <!-- Nombre y precio -->
            <div class="text-center mt-3">
                <h4 class="mb-1">{{ $producto->nombre }}</h4>
                <p class="text-success fw-bold fs-5">S/. {{ number_format($producto->precio, 2) }}</p>
            </div>
        </div>

        <!-- Descripción + botones -->
        <div class="col-md-7">
            <div class="bg-white border rounded shadow-sm p-4" style="min-height: 100%;">
                <h5>Descripción del producto</h5>
                <p style="min-height: 180px; max-height: 300px; overflow-y: auto;">

                    {{ $producto->descripcion ?? 'Este producto no tiene una descripción.' }}
                </p>

                <!-- Cantidad + botones -->
                <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="cantidad" value="1" id="cantidad-input">

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <label for="cantidad" class="form-label mb-0">Cantidad:</label>
                        <button type="button" class="btn btn-outline-secondary" onclick="cambiarCantidad(-1)">-</button>
                        <input type="number" id="cantidad" value="1" min="1" class="form-control text-center" style="width: 70px;" readonly>
                        <button type="button" class="btn btn-outline-secondary" onclick="cambiarCantidad(1)">+</button>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-dark flex-fill">🛒 Añadir al carrito</button>
                    </div>
                </form>

                <form method="POST" action="{{ route('favoritos.agregar', $producto->id) }}" class="mt-2">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100">❤ Agregar a favoritos</button>
                </form>
            </div>
        </div>
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
<div style="height: 200px; background-color: #fdf6ff; display: flex; align-items: center; justify-content: center; border-top-left-radius: .5rem; border-top-right-radius: .5rem;">
    <img src="{{ $product->imagen ? asset($product->imagen) : 'https://via.placeholder.com/150' }}"
         alt="{{ $product->nombre }}"
         style="max-height: 100%; max-width: 100%; object-fit: contain;">
</div>


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
