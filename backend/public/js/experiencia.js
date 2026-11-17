(() => {
  const guidance = {
    portabilidad: ['Empieza por portabilidad', 'Revisa y compara planes móviles con diferentes cantidades de datos.'],
    internet: ['Empieza por internet', 'Explora velocidades y características de conexión fija para tu negocio.'],
    equipos: ['Empieza por equipos', 'Conoce dispositivos móviles y routers de demostración.'],
  };

  const guideButtons = document.querySelectorAll('[data-guide]');
  const guideResult = document.querySelector('[data-guide-result]');
  guideButtons.forEach(button => button.addEventListener('click', () => {
    const choice = guidance[button.dataset.guide];
    if (!choice || !guideResult) return;
    guideButtons.forEach(item => item.setAttribute('aria-pressed', String(item === button)));
    const title = document.createElement('strong');
    const description = document.createElement('span');
    const link = document.createElement('a');
    title.textContent = choice[0];
    description.textContent = choice[1];
    link.textContent = 'Explorar esta categoría →';
    link.href = button.dataset.guideUrl;
    guideResult.replaceChildren(title, description, link);
  }));

  const search = document.querySelector('[data-catalog-search]');
  if (search) {
    const input = search.querySelector('input');
    const clear = search.querySelector('[data-search-clear]');
    const status = search.querySelector('[data-search-status]');
    const empty = document.querySelector('[data-search-empty]');
    const sections = [...document.querySelectorAll('[data-catalog-section]')];
    const normalize = value => value.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
    const filter = () => {
      const query = normalize(input.value);
      let count = 0;
      sections.forEach(section => {
        let sectionCount = 0;
        section.querySelectorAll('[data-catalog-card]').forEach(card => {
          const matches = normalize(`${card.dataset.categoryName} ${card.textContent}`).includes(query);
          card.hidden = !matches;
          if (matches) { count++; sectionCount++; }
        });
        section.hidden = sectionCount === 0;
      });
      empty.hidden = count !== 0;
      clear.hidden = !query;
      status.textContent = `${count} ${count === 1 ? 'opción' : 'opciones'}`;
    };
    search.hidden = false;
    input.addEventListener('input', filter);
    clear.addEventListener('click', () => { input.value = ''; filter(); input.focus(); });
    filter();
  }

  const dock = document.querySelector('[data-selection-dock]');
  if (dock) {
    const read = key => {
      try { const value = JSON.parse(sessionStorage.getItem(key) || '[]'); return Array.isArray(value) ? value : []; }
      catch (_) { return []; }
    };
    const refresh = () => {
      const comparison = read('b2-d2-selection').length;
      const cart = read('b2-d2-cart').reduce((total, item) => total + (Number.isInteger(item.quantity) && item.quantity > 0 ? item.quantity : 0), 0);
      dock.querySelector('[data-dock-compare]').textContent = comparison;
      dock.querySelector('[data-dock-cart]').textContent = cart;
      dock.querySelector('[data-dock-summary]').textContent = `${comparison} para comparar · ${cart} en carrito`;
      dock.hidden = comparison === 0 && cart === 0;
    };
    document.addEventListener('click', event => {
      if (event.target.closest && event.target.closest('[data-add], [data-cart-add]')) setTimeout(refresh, 0);
    });
    window.addEventListener('pageshow', refresh);
    refresh();
  }
})();
