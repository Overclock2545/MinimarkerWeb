const fs = require('fs');
const vm = require('vm');
const assert = require('assert');
const script = fs.readFileSync('public/js/cotizacion.js', 'utf8');
function run(cart, prices = [39.90, 249]) {
  const fields = {children: [], appendChild(item) {this.children.push(item)}};
  const summary = {innerHTML: ''};
  const submit = {disabled: true};
  const catalog = {portabilidad:{nombre:'Portabilidad',unidad:'Líneas',ofertas:[{id:'plan',nombre:'Plan',precio:prices[0],periodo:'mensual'}]},equipos:{nombre:'Equipos',unidad:'Equipos',ofertas:[{id:'router',nombre:'Router',precio:prices[1],periodo:'único'}]}};
  const elements = {'quote-form':{},'quote-catalog':{textContent:JSON.stringify(catalog)},'quote-old-items':{textContent:'[]'},'quote-items-fields':fields,'quote-summary':summary,'quote-submit':submit};
  const document = {getElementById:id => elements[id],createElement:() => ({})};
  const sessionStorage = {getItem:() => JSON.stringify(cart)};
  vm.runInNewContext(script, {document, sessionStorage, Object, Number, JSON});
  return {fields, summary, submit};
}
const empty = run([]); assert.equal(empty.submit.disabled, true);
const filled = run([{id:'plan',quantity:2},{id:'router',quantity:1}]);
assert.equal(filled.submit.disabled, false); assert.equal(filled.fields.children.length, 4);
assert.match(filled.summary.innerHTML, /Líneas: 2/); assert.match(filled.summary.innerHTML, /79[,.]80/); assert.match(filled.summary.innerHTML, /249[,.]00/);
const incomplete = run([{id:'plan',quantity:1}], [null,249]); assert.match(incomplete.summary.innerHTML, /Precio por definir/); assert.match(incomplete.summary.innerHTML, /parciales/);
console.log('Cotización: selección, cantidades y precios referenciales verificados.');
