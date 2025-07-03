<aside class="p-3 shadow-sm border-end h-100" style="background-color: #f7efff; min-height: 100vh;">
    <h5 class="text-center mb-4 text-dark fw-semibold">Nuestro catálogo</h5>

    {{-- Buscador --}}
    <form action="{{ route('buscar.productos') }}" method="GET" class="d-grid gap-2 mb-4 px-2">
        <input type="text" name="query" class="form-control form-control-sm rounded-pill" placeholder="Buscar..." required>
        <button type="submit" class="btn btn-sm w-100 fw-semibold" style="background-color: #d8b4f8; color: #212529;">
            <i class="bi bi-search me-2"></i>Buscar
        </button>
    </form>

    {{-- Categorías --}}
    <div class="d-grid gap-2 px-2">
        @php
    $categorias = [
        'Accesorios Varios' => 10,
        'Artículos de Belleza' => 5,
        'Carteras y Morrales' => 1,
        'Cartucheras y Monederos' => 12,
        'Llaveros' => 7,
        'Mochilas' => 3,
        'Papelería Kawaii' => 4,
        'Prendas y Calzados' => 9,
        'Servicios' => 11,
        'Tomatodos y Tazas' => 8,
        'Utensilios de Cocina' => 13,
    ];
@endphp
        @foreach ($categorias as $nombre => $id)
            <a href="{{ url('/categorias/id/' . $id) }}" class="btn btn-sm rounded-pill text-dark" style="background-color: #fbe9ff; border: none;">
                {{ $nombre }}
            </a>
        @endforeach
    </div>

    {{-- Redes sociales --}}
    <div class="d-flex justify-content-center gap-3 mt-4">
        <span class="fs-5 text-muted">📷</span>
        <span class="fs-5 text-muted">🎵</span>
        <span class="fs-5 text-muted">📘</span>
    </div>
</aside>
