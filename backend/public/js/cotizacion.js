(() => {
  const form = document.getElementById('quote-form');
  if (!form) return;
  const catalog = JSON.parse(document.getElementById('quote-catalog').textContent);
  const offers = Object.values(catalog).flatMap(category => category.ofertas.map(offer => ({...offer, category: category.nombre, unit: category.unidad})));
  let selected = [];
  try { selected = JSON.parse(sessionStorage.getItem('b2-d2-cart') || '[]'); } catch (_) {}
  if (!Array.isArray(selected)) selected = [];
  const oldItems = JSON.parse(document.getElementById('quote-old-items').textContent);
  if (Array.isArray(oldItems) && oldItems.length) selected = oldItems.map(item => ({id: item.id, quantity: Number(item.cantidad)}));
  const items = selected.map(item => ({...item, offer: offers.find(offer => offer.id === item.id)})).filter(item => item.offer && Number.isInteger(item.quantity) && item.quantity >= 1 && item.quantity <= 99);
  const fields = document.getElementById('quote-items-fields');
  const summary = document.getElementById('quote-summary');
  const escape = value => String(value).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
  const money = cents => `S/ ${(cents / 100).toLocaleString('es-PE', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
  if (!items.length) return;
  const totals = {mensual:0, 'único':0}; let incomplete = false;
  summary.innerHTML = items.map((item, i) => {
    const id = document.createElement('input'); id.type = 'hidden'; id.name = `ofertas[${i}][id]`; id.value = item.id; fields.appendChild(id);
    const quantity = document.createElement('input'); quantity.type = 'hidden'; quantity.name = `ofertas[${i}][cantidad]`; quantity.value = item.quantity; fields.appendChild(quantity);
    const offer = item.offer; const price = Number(offer.precio); const known = offer.precio !== null && offer.precio !== undefined && Number.isFinite(price) && price >= 0 && Object.hasOwn(totals, offer.periodo);
    const subtotal = known ? Math.round(price * 100) * item.quantity : 0;
    if (known) totals[offer.periodo] += subtotal; else incomplete = true;
    return `<div class="quote-line"><div><strong>${escape(offer.nombre)}</strong><small>${escape(offer.category)} · ${escape(offer.unit)}: ${item.quantity}</small></div><b>${known ? `${money(subtotal)} / ${escape(offer.periodo)}` : 'Precio por definir'}</b></div>`;
  }).join('') + `<div class="quote-total"><p>Mensual <strong>${money(totals.mensual)} / mes</strong></p><p>Pago único <strong>${money(totals['único'])}</strong></p>${incomplete ? '<small>Los importes son parciales: hay ofertas sin precio definido.</small>' : ''}</div>`;
  document.getElementById('quote-submit').disabled = false;
})();
