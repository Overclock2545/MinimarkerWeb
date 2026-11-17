const assert = require('assert');
const fs = require('fs');
const vm = require('vm');
const store = {};
const code = 'ab'.repeat(16);
const storage = {setItem: (key, value) => {store[key] = value;}, getItem: key => store[key] || null};
vm.runInNewContext(fs.readFileSync('public/js/referido.js', 'utf8'), {
  document: {getElementById: () => ({textContent: JSON.stringify(code)})}, sessionStorage: storage,
});
assert.equal(store['b2-referral'], code);
const input = {value: ''};
const fields = {appendChild() {}};
const summary = {innerHTML: ''};
const submit = {disabled: true};
const catalog = {portabilidad: {nombre: 'Portabilidad', unidad: 'Líneas', ofertas: [{id: 'plan', nombre: 'Plan', precio: 10, periodo: 'mensual'}]}};
const elements = {'quote-form': {}, 'quote-referral': input, 'quote-catalog': {textContent: JSON.stringify(catalog)},
  'quote-old-items': {textContent: '[]'}, 'quote-items-fields': fields, 'quote-summary': summary, 'quote-submit': submit};
storage.setItem('b2-d2-cart', JSON.stringify([{id: 'plan', quantity: 1}]));
vm.runInNewContext(fs.readFileSync('public/js/cotizacion.js', 'utf8'), {
  document: {getElementById: id => elements[id], createElement: () => ({})}, sessionStorage: storage, Object, Number, JSON,
});
assert.equal(input.value, code);
assert.equal(submit.disabled, false);
console.log('Referencia conservada en la pestaña y transferida a la cotización.');
