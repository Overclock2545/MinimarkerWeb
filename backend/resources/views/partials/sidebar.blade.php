<aside class="p-3 shadow-lg border-end h-100" style="background-color: #f7efff; min-height: 100vh; border-radius: 0 10px 10px 0;">
    <h5 class="text-center mb-4 text-dark fw-bold" style="color: #4c1d95;">Nuestro catálogo</h5>

    {{-- Buscador --}}
    <form action="{{ route('buscar.productos') }}" method="GET" class="d-grid gap-2 mb-4 px-2">
        <input type="text" name="query" class="form-control form-control-sm rounded-pill border-0 shadow-sm" placeholder="Buscar..." required>
        <button type="submit" class="btn btn-sm w-100 fw-semibold rounded-pill shadow-sm" style="background-color: #d8b4f8; color: #212529;">
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
            <a href="{{ url('/categorias/id/' . $id) }}" 
               class="btn btn-sm rounded-pill text-dark shadow-sm fw-semibold"
               style="background-color: #fbe9ff; border: none; transition: background-color 0.3s ease;"
               onmouseover="this.style.backgroundColor='#e9d5ff'"
               onmouseout="this.style.backgroundColor='#fbe9ff'">
                {{ $nombre }}
            </a>
        @endforeach
    </div>

    {{-- Redes sociales --}}
    <div class="d-flex justify-content-center gap-3 mt-4">
        <a href="https://www.facebook.com/share/1Dh1tU8A4L/" target="_blank" class="text-dark fs-5">
            <i class="bi bi-facebook"></i>
        </a>

        <a href="https://www.tiktok.com/@ilikeyouimportaciones?_t=ZM-8y0nCghyzg8&_r=1" target="_blank" class="text-dark fs-5">
            <i class="bi bi-tiktok"></i>
        </a>
        
        <a href="https://www.instagram.com/ilikeyouimportaciones?utm_source=qr&igsh=MTEwMm5xbDBpbDk5bg==" target="_blank" class="text-dark fs-5">
            <i class="bi bi-instagram"></i>
        </a>
    </div>
</aside>
