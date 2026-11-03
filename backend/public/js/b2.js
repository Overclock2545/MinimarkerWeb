(() => {
  const key = 'b2-d2-selection';
  const comparisonTarget = document.getElementById('comparison-content');
  const emptyMarkup = comparisonTarget ? comparisonTarget.innerHTML : '';
  let selected = [];
  try { const saved = JSON.parse(sessionStorage.getItem(key) || '[]'); if (Array.isArray(saved)) selected = saved.filter(x => x && typeof x.id === 'string' && typeof x.category === 'string').slice(0, 2); } catch (_) {}
  const save = () => { try { sessionStorage.setItem(key, JSON.stringify(selected)); } catch (_) {} update(); };
  const announce = text => { const el = document.getElementById('aviso'); el.textContent = text; el.classList.add('show'); clearTimeout(window.b2Toast); window.b2Toast = setTimeout(() => el.classList.remove('show'), 4500); };
  function update() {
    document.querySelectorAll('[data-count]').forEach(el => el.textContent = selected.length);
    document.querySelectorAll('[data-add]').forEach(btn => { const exists = selected.some(x => x.id === btn.dataset.add); btn.setAttribute('aria-pressed', String(exists)); btn.textContent = exists ? '✓ Añadido' : (btn.classList.contains('btn') ? '+ Añadir a comparación' : '+ Comparar'); });
    renderComparison();
  }
  document.querySelectorAll('[data-add]').forEach(btn => btn.addEventListener('click', () => {
    const item = {id: btn.dataset.add, category: btn.dataset.category};
    if (selected.some(x => x.id === item.id)) { selected = selected.filter(x => x.id !== item.id); save(); announce('Opción retirada de la comparación.'); return; }
    if (selected.length && selected[0].category !== item.category) { announce('Para comparar otra categoría, primero retira las opciones seleccionadas.'); return; }
    if (selected.length >= 2) { announce('Puedes comparar hasta dos opciones. Retira una para elegir otra.'); return; }
    selected.push(item); save(); announce(selected.length === 1 ? 'Opción añadida. Elige una segunda de la misma categoría.' : 'Dos opciones listas para comparar.');
  }));
  function renderComparison() {
    const target = document.getElementById('comparison-content'); const dataEl = document.getElementById('catalog-data');
    if (!target || !dataEl) return;
    let data; try { data = JSON.parse(dataEl.textContent); } catch (_) { return; }
    const valid = selected.map(x => { const category = data[x.category]; const offer = category && category.ofertas.find(o => o.id === x.id); return offer ? {category, offer} : null; }).filter(Boolean);
    if (!valid.length) { target.innerHTML = emptyMarkup; return; }
    const escape = s => String(s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    const cat = valid[0].category;
    const rows = cat.atributos.map((label, i) => {
      const different = valid.length === 2 && valid[0].offer.valores[i] !== valid[1].offer.valores[i];
      return `<div class="comparison-row${different ? ' different' : ''}"><span>${escape(label)}${different ? '<small> · DIFERENCIA</small>' : ''}</span>${valid.map(x => `<strong>${escape(x.offer.valores[i])}</strong>`).join('')}${valid.length < 2 ? '<strong>—</strong>' : ''}</div>`;
    }).join('');
    target.innerHTML = `<div class="compare-category">${escape(cat.nombre)} <span>· ${valid.length} de 2 opciones</span></div>${valid.length < 2 ? '<div class="notice">Elige una segunda opción de esta categoría para completar la comparación.</div>' : ''}<div class="comparison-table"><div class="comparison-row comparison-names"><span>OFERTA</span>${valid.map(x => `<div><h3>${escape(x.offer.nombre)}</h3><button type="button" data-remove="${escape(x.offer.id)}">Retirar ×</button></div>`).join('')}${valid.length < 2 ? '<div class="placeholder">Segunda opción pendiente</div>' : ''}</div><div class="comparison-row"><span>Precio referencial</span>${valid.map(x => `<strong>S/ ${Number(x.offer.precio).toFixed(2)} <small>/ ${escape(x.offer.periodo)}</small></strong>`).join('')}${valid.length < 2 ? '<strong>—</strong>' : ''}</div>${rows}</div><a class="btn btn-dark" href="${escape(document.querySelector('.compare-title a').href)}">${valid.length < 2 ? 'Elegir segunda opción' : 'Explorar más opciones'} ↗</a>`;
    target.querySelectorAll('[data-remove]').forEach(btn => btn.addEventListener('click', () => { selected = selected.filter(x => x.id !== btn.dataset.remove); save(); }));
  }
  update();
})();
