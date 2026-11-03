const fs = require('fs');
const vm = require('vm');
const assert = require('assert');
const store = {};
const messages = {textContent:'', classList:{add(){},remove(){}}};
const count = {textContent:''};
function button(id, category) { return {dataset:{add:id,category}, classList:{contains(){return false;}}, setAttribute(k,v){this[k]=v}, addEventListener(_,fn){this.click=fn}}; }
const one=button('a','internet'), two=button('b','internet'), three=button('c','internet'), other=button('d','equipos');
const buttons=[one,two,three,other];
const storage={getItem:k=>store[k]||null,setItem:(k,v)=>store[k]=v};
const doc={getElementById:id=>id==='aviso'?messages:null,querySelectorAll:q=>q==='[data-add]'?buttons:q==='[data-count]'?[count]:[]};
vm.runInNewContext(fs.readFileSync('public/js/b2.js','utf8'),{document:doc,sessionStorage:storage,window:{},setTimeout:()=>1,clearTimeout:()=>{}});
one.click(); assert.equal(count.textContent,1); assert.match(messages.textContent,/segunda/);
other.click(); assert.equal(count.textContent,1); assert.match(messages.textContent,/categoría/);
two.click(); assert.equal(count.textContent,2); three.click(); assert.equal(count.textContent,2); assert.match(messages.textContent,/dos opciones/);
one.click(); assert.equal(count.textContent,1); assert.equal(JSON.parse(store['b2-d2-selection'])[0].id,'b');
console.log('Comparador: selección, límite, categoría y almacenamiento temporal verificados.');
