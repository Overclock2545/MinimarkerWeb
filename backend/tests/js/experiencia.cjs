const assert = require('assert');
const fs = require('fs');
const vm = require('vm');

const script = fs.readFileSync('public/js/experiencia.js', 'utf8');
const events = {};
function button(choice, url) {
  return {dataset: {guide: choice, guideUrl: url}, attrs: {}, addEventListener(event, fn) { this[event] = fn; }, setAttribute(key, value) { this.attrs[key] = value; }};
}
const mobile = button('portabilidad', '/catalogo?categoria=portabilidad');
const internet = button('internet', '/catalogo?categoria=internet');
const guideResult = {replaceChildren(...children) { this.children = children; }};
const input = {value: '', addEventListener(event, fn) { this[event] = fn; }, focus() { this.focused = true; }};
const clear = {hidden: true, addEventListener(event, fn) { this[event] = fn; }};
const status = {textContent: ''};
const search = {hidden: true, querySelector(query) { return query === 'input' ? input : query === '[data-search-clear]' ? clear : status; }};
const phone = {dataset: {categoryName: 'Portabilidad'}, textContent: 'Plan móvil 25 GB', hidden: false};
const fiber = {dataset: {categoryName: 'Internet'}, textContent: 'Conexión fija 300 Mbps', hidden: false};
const sections = [phone, fiber].map(card => ({hidden: false, querySelectorAll: () => [card]}));
const empty = {hidden: true};
const dockChildren = {'[data-dock-compare]': {}, '[data-dock-cart]': {}, '[data-dock-summary]': {}};
const dock = {hidden: true, querySelector: query => dockChildren[query]};
const store = {};
const document = {
  querySelectorAll(query) { return query === '[data-guide]' ? [mobile, internet] : query === '[data-catalog-section]' ? sections : []; },
  querySelector(query) { return ({'[data-guide-result]': guideResult, '[data-catalog-search]': search, '[data-search-empty]': empty, '[data-selection-dock]': dock})[query] || null; },
  createElement() { return {}; },
  addEventListener(event, fn) { events[event] = fn; },
};
const window = {addEventListener() {}};
const sessionStorage = {getItem: key => store[key] || null};
vm.runInNewContext(script, {document, window, sessionStorage, setTimeout: fn => fn(), JSON, Number});

mobile.click();
assert.equal(mobile.attrs['aria-pressed'], 'true');
assert.equal(internet.attrs['aria-pressed'], 'false');
assert.equal(guideResult.children[2].href, '/catalogo?categoria=portabilidad');
input.value = 'movil'; input.input();
assert.equal(phone.hidden, false); assert.equal(fiber.hidden, true); assert.equal(status.textContent, '1 opción');
input.value = 'sin coincidencias'; input.input();
assert.equal(empty.hidden, false); assert.equal(sections[0].hidden, true);
clear.click(); assert.equal(empty.hidden, true); assert.equal(input.focused, true);
store['b2-d2-selection'] = JSON.stringify([{id: 'plan', category: 'portabilidad'}]);
store['b2-d2-cart'] = JSON.stringify([{id: 'plan', quantity: 2}]);
events.click({target: {closest: () => true}});
assert.equal(dock.hidden, false); assert.equal(dockChildren['[data-dock-compare]'].textContent, 1); assert.equal(dockChildren['[data-dock-cart]'].textContent, 2);
console.log('Guía, búsqueda y resumen de selección verificados.');
