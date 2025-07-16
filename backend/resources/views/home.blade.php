@extends('layouts.plantilla')

@section('title', 'I LIKE YOU - Inicio')

@section('content')

@php
    use Carbon\Carbon;
@endphp

<style>
    h2.text-center {
        background: linear-gradient(90deg, #a855f7, #ec4899);
        color: white;
        padding: 12px 20px;
        border-radius: 10px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    }

    .product-card {
        border: 1px solid #d1d5db;
        border-radius: 12px;
        background-color: #fff;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
    }

    .product-image-frame {
        border: 2px solid #e0d7ff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(147, 51, 234, 0.1);
        padding: 10px;
        background-color: white;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .img-thumbnail:hover {
        border-color: #9333ea !important;
        transform: scale(1.05);
        transition: transform 0.2s ease;
    }

    #imagenPrincipal {
        border-radius: 6px;
        transition: transform 0.3s ease;
    }

    #imagenPrincipal:hover {
        transform: scale(1.03);
    }

    .btn-dark {
        background-color: #4c1d95;
        border: none;
    }

    .btn-dark:hover {
        background-color: #6d28d9;
    }

    .btn i {
        transition: transform 0.2s ease;
    }

    .btn:hover i {
        transform: scale(1.2);
    }

    .btn-favorito {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 0.9rem;
        padding: 6px 10px;
    }
</style>

<h2 class="text-center mb-4">
    {{ $titulo ?? ($producto->nombre ?? 'Bienvenido a I LIKE YOU') }}
</h2>

@if(isset($producto))
    @php
        $enOferta = $producto->oferta_activa &&
                    is_numeric($producto->precio_oferta) &&
                    (!$producto->fecha_fin_oferta || Carbon::parse($producto->fecha_fin_oferta)->gte(Carbon::now()));
    @endphp

    <div class="container mb-5">
        <div class="row justify-content-center align-items-start g-4">
            <div class="col-md-5 d-flex flex-column align-items-center">
                @if($producto->imagenes && $producto->imagenes->count())
                    <div class="d-flex flex-wrap justify-content-center mb-3 gap-2">
                        <img src="{{ asset($producto->imagen) }}" class="img-thumbnail border border-primary" style="width: 70px; height: 70px; object-fit: cover;" onclick="cambiarImagen('{{ asset($producto->imagen) }}')">
                        @foreach($producto->imagenes as $img)
                            <img src="{{ asset($img->ruta) }}" class="img-thumbnail" style="width: 70px; height: 70px; object-fit: cover;" onclick="cambiarImagen('{{ asset($img->ruta) }}')">
                        @endforeach
                    </div>
                @endif

                <div class="product-image-frame" style="width: 100%; height: 350px;">
                    <img id="imagenPrincipal" src="{{ $producto->imagen ? asset($producto->imagen) : 'https://via.placeholder.com/350' }}" alt="{{ $producto->nombre }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                </div>

                <div class="text-center mt-3">
                    <h4 class="mb-1">
                        {{ $producto->nombre }}
                        @if($producto->stock == 0)
                            <span class="badge bg-secondary ms-2">Sin existencias</span>
                        @endif
                    </h4>

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

            <div class="col-md-7">
                <div class="product-card p-4">
                    <h5>Descripción del producto</h5>
                    <p style="min-height: 180px; max-height: 300px; overflow-y: auto;">
                        {{ $producto->descripcion ?? 'Este producto no tiene una descripción.' }}
                    </p>

                    @if($producto->stock > 0)
                        @if(auth()->check())
                            <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST" class="mt-4">
                                @csrf
                                <input type="hidden" name="cantidad" value="1" id="cantidad-input">
                                <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                                    <label class="form-label mb-0">Cantidad:</label>
                                    <button type="button" class="btn btn-outline-secondary" onclick="cambiarCantidad(-1)">-</button>
                                    <input type="number" id="cantidad" value="1" min="1" class="form-control text-center" style="width: 70px;" readonly>
                                    <button type="button" class="btn btn-outline-secondary" onclick="cambiarCantidad(1)">+</button>
                                    <span class="text-muted small">({{ $producto->stock }} existencias)</span>
                                </div>
                                <div class="mb-2">
                                    <button type="submit" class="btn btn-dark w-100">
                                        <i class="bi bi-cart-plus-fill me-1"></i> Añadir al carrito
                                    </button>
                                </div>
                            </form>

                            <form method="POST" action="{{ route('favoritos.agregar', $producto->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-favorito w-100">
                                    @if(isset($favoritos) && in_array($producto->id, $favoritos))
                                        <i class="bi bi-heart-fill me-1"></i> En favoritos
                                    @else
                                        <i class="bi bi-heart me-1"></i> Agregar a favoritos
                                    @endif
                                </button>
                            </form>
                        @else
                            <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                                <label class="form-label mb-0">Cantidad:</label>
                                <button type="button" class="btn btn-outline-secondary" onclick="cambiarCantidad(-1)">-</button>
                                <input type="number" id="cantidad" value="1" min="1" class="form-control text-center" style="width: 70px;" readonly>
                                <button type="button" class="btn btn-outline-secondary" onclick="cambiarCantidad(1)">+</button>
                                <span class="text-muted small">({{ $producto->stock }} existencias)</span>
                            </div>
                            <div class="mb-2">
                                <button type="button" class="btn btn-dark w-100" onclick="mostrarLoginModal()">
                                    <i class="bi bi-cart-plus-fill me-1"></i> Añadir al carrito
                                </button>
                            </div>
                            <button type="button" class="btn btn-outline-danger btn-favorito w-100" onclick="mostrarLoginModal()">
                                <i class="bi bi-heart me-1"></i> Agregar a favoritos
                            </button>
                        @endif
                    @endif
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

        function mostrarLoginModal() {
            const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.show();
        }
    </script>

@elseif(isset($products))
    @php
        $favoritos = auth()->check() ? auth()->user()->favoritos->pluck('id')->toArray() : [];
    @endphp

    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
            @foreach($products as $product)
                @php
                    $enOferta = $product->oferta_activa &&
                                is_numeric($product->precio_oferta) &&
                                (!$product->fecha_fin_oferta || Carbon::parse($product->fecha_fin_oferta)->gte(Carbon::now()));
                    $isFavorito = in_array($product->id, $favoritos);
                @endphp

                <div class="col">
                    <div class="card product-card h-100 d-flex flex-column">
                        <div style="height: 200px; background-color: #fdf6ff; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                            <a href="{{ route('producto.ver', $product->id) }}" class="d-block w-100 h-100 d-flex align-items-center justify-content-center">
                                <div class="product-image-frame">
                                    <img src="{{ $product->imagen ? asset($product->imagen) : 'https://via.placeholder.com/150' }}"
                                        alt="{{ $product->nombre }}"
                                        style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                </div>
                            </a>
                        </div>

                        <div class="card-body d-flex flex-column justify-content-between text-center p-3" style="min-height: 230px;">
                            <div>
                                <h6 class="mb-1">
                                    {{ $product->nombre }}
                                    @if($product->stock == 0)
                                        <span class="badge bg-secondary" style="font-size: 0.7rem;">Sin existencias</span>
                                    @endif
                                </h6>

                                @if ($enOferta)
                                    <p class="mb-1">
                                        <span class="badge bg-success d-block mb-1">¡En oferta!</span>
                                        <span class="text-success fw-bold">S/. {{ number_format($product->precio_oferta, 2) }}</span>
                                        <small class="text-muted text-decoration-line-through">S/. {{ number_format($product->precio, 2) }}</small>
                                    </p>
                                @else
                                    <p class="mb-1 text-dark fw-bold">S/. {{ number_format($product->precio, 2) }}</p>
                                @endif

                                <small class="text-muted d-block mb-2">Categoría: {{ $product->categoria->nombre ?? 'Sin categoría' }}</small>
                            </div>

                            <div class="mt-auto">
                                @if(auth()->check())
                                    @if($product->stock > 0)
                                        <form method="POST" action="{{ route('carrito.agregar', $product->id) }}" class="mb-2">
                                            @csrf
                                            <button type="submit" class="btn btn-dark w-100">
                                                <i class="bi bi-cart-plus-fill me-1"></i> Añadir al carrito
                                            </button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('favoritos.agregar', $product->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-favorito w-100">
                                            <i class="bi bi-heart{{ $isFavorito ? '-fill' : '' }} me-1"></i>
                                            {{ $isFavorito ? 'En favoritos' : 'Agregar a favoritos' }}
                                        </button>
                                    </form>
                                @else
                                    @if($product->stock > 0)
                                        <button type="button" class="btn btn-dark w-100 mb-2" onclick="mostrarLoginModal()">
                                            <i class="bi bi-cart-plus-fill me-1"></i> Añadir al carrito
                                        </button>
                                    @endif

                                    <button type="button" class="btn btn-outline-danger btn-favorito w-100" onclick="mostrarLoginModal()">
                                        <i class="bi bi-heart me-1"></i> Agregar a favoritos
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <p class="text-center text-muted">No hay productos disponibles.</p>
@endif

@endsection
