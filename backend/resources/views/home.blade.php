@extends('layouts.plantilla')

@section('title', 'I LIKE YOU - Inicio')

@section('content')

@php
    use Carbon\Carbon;
@endphp

<h2 class="text-center mb-4" style="background-color: rgba(255, 255, 255, 0.5); padding: 10px; border-radius: 8px;">
    {{ $titulo ?? ($producto->nombre ?? 'GRANDES OFERTAS') }}
</h2>

@if(isset($producto))
    @php
        $enOferta = $producto->oferta_activa &&
                    is_numeric($producto->precio_oferta) &&
                    (!$producto->fecha_fin_oferta || Carbon::parse($producto->fecha_fin_oferta)->gte(Carbon::now()));
    @endphp

    <div class="container mb-5">
        <div class="row justify-content-center align-items-start g-4">

            <!-- Columna de imagenes -->
            <div class="col-md-5 d-flex flex-column align-items-center">

                <!-- Miniaturas -->
@if($producto->imagenes && $producto->imagenes->count())
    <div class="d-flex flex-wrap justify-content-center mb-3 gap-2">
        <!-- Miniatura de imagen principal -->
        <img src="{{ asset($producto->imagen) }}"
             alt="Imagen principal"
             class="img-thumbnail border border-primary"
             style="width: 70px; height: 70px; cursor: pointer;"
             onclick="cambiarImagen('{{ asset($producto->imagen) }}')">

        <!-- Miniaturas adicionales -->
        @foreach($producto->imagenes as $img)
            <img src="{{ asset($img->ruta) }}"
                 alt="Miniatura"
                 class="img-thumbnail"
                 style="width: 70px; height: 70px; cursor: pointer;"
                 onclick="cambiarImagen('{{ asset($img->ruta) }}')">
        @endforeach
    </div>
@endif

                <!-- Imagen principal -->
                <div class="bg-light rounded p-3 shadow-sm" style="width: 100%; max-height: 350px; display: flex; align-items: center; justify-content: center;">
                    <img id="imagenPrincipal"
                         src="{{ $producto->imagen ? asset($producto->imagen) : 'https://via.placeholder.com/350' }}"
                         alt="{{ $producto->nombre }}"
                         class="img-fluid"
                         style="object-fit: contain; max-height: 300px;">
                </div>

                <!-- Nombre y precio -->
                <div class="text-center mt-3">
                    <h4 class="mb-1">{{ $producto->nombre }}</h4>

                    @if ($enOferta)
                        <p class="mb-1 fs-5">
                            <span class="badge bg-success mb-1">¡En oferta!</span><br>
                            <span class="text-success fw-bold">S/. {{ number_format($producto->precio_oferta, 2) }}</span>
                            <small class="text-muted text-decoration-line-through">S/. {{ number_format($producto->precio, 2) }}</small>
                        </p>
                    @else
                        <p class="text-dark fw-bold fs-5">S/. {{ number_format($producto->precio, 2) }}</p>
                    @endif
                </div>
            </div>

            <!-- Columna de descripción y botones -->
            <div class="col-md-7">
                <div class="bg-white border rounded shadow-sm p-4">
                    <h5>Descripción del producto</h5>
                    <p style="min-height: 180px; max-height: 300px; overflow-y: auto;">
                        {{ $producto->descripcion ?? 'Este producto no tiene una descripción.' }}
                    </p>

                    <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="cantidad" value="1" id="cantidad-input">

                        <div class="d-flex align-items-center gap-2 mb-3">
                            <label class="form-label mb-0">Cantidad:</label>
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

        function cambiarImagen(ruta) {
            document.getElementById('imagenPrincipal').src = ruta;
        }
    </script>

@else
    {{-- Vista en modo lista --}}
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
        @foreach($products as $product)
            @php
                $enOferta = $product->oferta_activa &&
                            is_numeric($product->precio_oferta) &&
                            (!$product->fecha_fin_oferta || Carbon::parse($product->fecha_fin_oferta)->gte(Carbon::now()));
            @endphp

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

                            @if ($enOferta)
                                <p class="mb-1">
                                    <span class="badge bg-success d-block mb-1">¡En oferta!</span>
                                    <span class="text-success fw-bold">S/. {{ number_format($product->precio_oferta, 2) }}</span>
                                    <small class="text-muted text-decoration-line-through">S/. {{ number_format($product->precio, 2) }}</small>
                                </p>
                            @else
                                <p class="mb-1 text-dark fw-bold">S/. {{ number_format($product->precio, 2) }}</p>
                            @endif

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
@endif

@endsection
