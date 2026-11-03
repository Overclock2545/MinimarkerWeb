(() => {
  const key = 'b2-d2-cart';
  const target = document.getElementById('cart-content');
  const empty = target ? target.innerHTML : '';
  let cart = [];
  try {
    const saved = JSON.parse(sessionStorage.getItem(key) || '[]');
    if (Array.isArray(saved)) cart = saved.filter(x => x && typeof x.id === 'string' && Number.isInteger(x.quantity) && x.quantity > 0 && x.quantity <= 99).slice(0, 100);
  } catch (_) {}
  const escape = s => String(s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
  const money = cents => `S/ ${(cents / 100).toLocaleString('es-PE', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
  function announce(message) {
    const el = document.getElementById('aviso');
    if (!el) return;
    el.textContent = message; el.classList.add('show');
    clearTimeout(window.cartToast); window.cartToast = setTimeout(() => el.classList.remove('show'), 4500);
  }
  function save() {
    let stored = true;
    try { sessionStorage.setItem(key, JSON.stringify(cart)); } catch (_) { stored = false; }
    update();
    return stored;
  }
  function update() {
    const count = cart.reduce((sum, item) => sum + item.quantity, 0);
    document.querySelectorAll('[data-cart-count]').forEach(el => el.textContent = count);
    render();
  }
  document.querySelectorAll('[data-cart-add]').forEach(button => button.addEventListener('click', () => {
    const id = button.dataset.cartAdd;
    const existing = cart.find(item => item.id === id);
    if (existing && existing.quantity >= 99) { announce('El máximo es 99 unidades por opción.'); return; }
    if (existing) existing.quantity++; else cart.push({id, quantity: 1});
    if (save()) announce('Opción añadida al carrito de demostración.');
    else announce('El navegador no permite guardar la selección entre páginas.');
  }));
  function render() {
    const data = document.getElementById('cart-catalog-data');
    if (!target || !data) return;
    let categories; try { categories = JSON.parse(data.textContent); } catch (_) { return; }
    const offers = Object.values(categories).flatMap(category => category.ofertas.map(offer => ({...offer, categoria: category.nombre})));
    const valid = cart.map(item => ({...item, offer: offers.find(offer => offer.id === item.id)})).filter(item => item.offer);
    if (!valid.length) { target.innerHTML = empty; return; }
    const totals = {mensual: 0, 'único': 0};
    const rows = valid.map(({offer, quantity}) => {
      const cents = Math.round(Number(offer.precio) * 100) * quantity;
      if (Object.hasOwn(totals, offer.periodo)) totals[offer.periodo] += cents;
      return `<article class="cart-item"><div><span class="section-number">${escape(offer.categoria)} · DEMOSTRACIÓN</span><h3>${escape(offer.nombre)}</h3><p>${money(Math.round(Number(offer.precio)*100))} / ${escape(offer.periodo)} por unidad</p></div><div class="cart-controls"><button type="button" data-cart-decrease="${escape(offer.id)}" aria-label="Reducir cantidad de ${escape(offer.nombre)}">−</button><span aria-label="Cantidad">${quantity}</span><button type="button" data-cart-increase="${escape(offer.id)}" aria-label="Aumentar cantidad de ${escape(offer.nombre)}">+</button><strong>${money(cents)} <small>/ ${escape(offer.periodo)}</small></strong><button class="cart-remove" type="button" data-cart-remove="${escape(offer.id)}">Retirar</button></div></article>`;
    }).join('');
    target.innerHTML = `<div class="cart-list">${rows}</div><div class="cart-summary"><div><span>Resumen referencial</span><p>Los montos mensuales y únicos se muestran por separado.</p></div><div><p>Mensual <strong>${money(totals.mensual)} / mes</strong></p><p>Pago único <strong>${money(totals['único'])}</strong></p></div></div>`;
    target.querySelectorAll('[data-cart-remove]').forEach(btn => btn.addEventListener('click', () => { cart = cart.filter(item => item.id !== btn.dataset.cartRemove); save(); }));
    target.querySelectorAll('[data-cart-decrease]').forEach(btn => btn.addEventListener('click', () => { const item = cart.find(x => x.id === btn.dataset.cartDecrease); if (item.quantity === 1) cart = cart.filter(x => x !== item); else item.quantity--; save(); }));
    target.querySelectorAll('[data-cart-increase]').forEach(btn => btn.addEventListener('click', () => { const item = cart.find(x => x.id === btn.dataset.cartIncrease); if (item.quantity >= 99) { announce('El máximo es 99 unidades por opción.'); return; } item.quantity++; save(); }));
  }
  update();
})();
