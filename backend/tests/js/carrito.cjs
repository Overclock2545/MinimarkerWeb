const fs = require('fs'), vm = require('vm'), assert = require('assert');
const code = fs.readFileSync('public/js/carrito-b2.js', 'utf8');
const memory = {};
const storage = {getItem: key => memory[key] || null, setItem: (key, value) => memory[key] = value};
function btn(id) { return {dataset:{cartAdd:id},addEventListener(_,fn){this.click=fn}}; }
const monthly=btn('internet'), single=btn('router');
const count={textContent:''}; const notice={textContent:'',classList:{add(){},remove(){}}};
const catalog={textContent:JSON.stringify({internet:{nombre:'Internet',ofertas:[{id:'internet',nombre:'Plan',precio:99.9,periodo:'mensual'}]},equipos:{nombre:'Equipos',ofertas:[{id:'router',nombre:'Router',precio:249,periodo:'único'}]}})};
const target={innerHTML:'VACÍO',querySelectorAll(){return []}};
const document={getElementById:id=>({'cart-content':target,'cart-catalog-data':catalog,aviso:notice})[id]||null,querySelectorAll:q=>q==='[data-cart-add]'?[monthly,single]:q==='[data-cart-count]'?[count]:[]};
vm.runInNewContext(code,{document,sessionStorage:storage,window:{},setTimeout:()=>1,clearTimeout:()=>{},Object,Number,JSON});
assert.equal(target.innerHTML,'VACÍO'); monthly.click(); monthly.click(); single.click();
assert.equal(count.textContent,3); assert.equal(JSON.parse(memory['b2-d2-cart'])[0].quantity,2);
assert.match(target.innerHTML,/Mensual/); assert.match(target.innerHTML,/199[,.]80/); assert.match(target.innerHTML,/249[,.]00/); assert.match(target.innerHTML,/Pago único/);
console.log('Carrito: estado vacío, cantidades, selección temporal y totales por periodicidad verificados.');
