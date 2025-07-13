@extends('layouts.plantilla')

@section('titulo', 'Mis Favoritos')

@section('content')
@php
    use Carbon\Carbon;
@endphp

<div class="container mt-4 mb-5">
    <h4 class="text-center mb-4 py-2 px-3 rounded-3 shadow-sm fw-semibold"
        style="background: linear-gradient(90deg, #a855f7, #ec4899); color: white;">
        <i class="bi bi-heart-fill me-2"></i> Mis favoritos
    </h4>

    @if ($favoritos->isEmpty())
        <p class="text-center text-muted fs-5">No tienes productos en tu lista de favoritos.</p>
    @else
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
            @foreach($favoritos as $favorito)
                @if ($favorito->producto)
                    @php
                        $product = $favorito->producto;
                        $enOferta = $product->oferta_activa &&
                                    is_numeric($product->precio_oferta) &&
                                    (!$product->fecha_fin_oferta || Carbon::parse($product->fecha_fin_oferta)->gte(Carbon::now()));
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

                                    <small class="text-muted d-block mb-2">Categoría: {{ $product->categoria->nombre ?? 'Sin categoría' }}</small>
                                </div>

                                <div class="mt-auto">
                                    @if ($product->stock > 0)
                                        <form method="POST" action="{{ route('carrito.agregar', $product->id) }}" class="mb-2">
                                            @csrf
                                            <button type="submit" class="btn btn-dark w-100">
                                                <i class="bi bi-cart-plus-fill me-1"></i> Añadir al carrito
                                            </button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('favoritos.eliminar', $product->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger w-100 btn-favorito">
                                            <i class="bi bi-heartbreak-fill me-1"></i> Quitar de favoritos
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-danger">⚠️ Un producto de tu lista fue eliminado.</p>
                @endif
            @endforeach
        </div>
    @endif
</div>

<style>
    .product-card {
        border: 1px solid #d1d5db;
        border-radius: 12px;
        background-color: #fff;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .product-card:hover {
        transform: translateY(-6px);
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
        font-size: 0.9rem;
        padding: 6px 10px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-body {
        min-height: 230px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
</style>
@endsection
