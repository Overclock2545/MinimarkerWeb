<aside class="sidebar">
      <h3>Nuestro catálogo</h3>
      <form action="{{ route('buscar.productos') }}" method="GET" style="display: flex; gap: 5px; flex-direction: column;">
  <input type="text" name="query" placeholder="Buscar..." required>

  <button type="submit">🔍 Buscar</button>
</form>

      <a href="{{ url('/categorias/id/10') }}"><button>Accesorios Varios</button></a>
<a href="{{ url('/categorias/id/5') }}"><button>Artículos de Belleza</button></a>
<a href="{{ url('/categorias/id/1') }}"><button>Carteras y Morrales</button></a>
<a href="{{ url('/categorias/id/12') }}"><button>Cartucheras y Monederos</button></a>
<a href="{{ url('/categorias/id/7') }}"><button>Llaveros</button></a>
<a href="{{ url('/categorias/id/3') }}"><button>Mochilas</button></a>
<a href="{{ url('/categorias/id/4') }}"><button>Papelería Kawaii</button></a>
<a href="{{ url('/categorias/id/9') }}"><button>Prendas y Calzados</button></a>
<a href="{{ url('/categorias/id/11') }}"><button>Servicios</button></a>
<a href="{{ url('/categorias/id/8') }}"><button>Tomatodos y Tazas</button></a>
<a href="{{ url('/categorias/id/13') }}"><button>Utensilios de Cocina</button></a>


      <div class="social">
        <span>📷</span>
        <span>🎵</span>
        <span>📘</span>
      </div>
    </aside>