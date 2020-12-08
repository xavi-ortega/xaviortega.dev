!function(e){var t={};function n(r){if(t[r])return t[r].exports;var i=t[r]={i:r,l:!1,exports:{}};return e[r].call(i.exports,i,i.exports,n),i.l=!0,i.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var i in e)n.d(r,i,function(t){return e[t]}.bind(null,i));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="/",n(n.s=29)}({29:function(e,t,n){e.exports=n(30)},30:function(e,t,n){"use strict";function r(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}n.r(t);var i=function(){function e(t){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.form=document.getElementById(t),this.fields={},this.rules={}}var t,n,i;return t=e,(n=[{key:"addField",value:function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"";this.fields[e]=t}},{key:"addRule",value:function(e,t){this.rules[e]=t}},{key:"isValid",value:function(){var e=this;return this.fetchValues(),Object.keys(this.rules).every((function(t){return e.fields[t]?e.rules[t](e.fields[t]):e.rules[t]()}))}},{key:"getErrors",value:function(){var e=this;return Object.keys(this.rules).map((function(t){if(e.fields[t]){if(!e.rules[t](e.fields[t]))return t}else if(console.log(t),!e.rules[t]())return t}),[])}},{key:"onSubmit",value:function(e){var t=this;document.removeEventListener("submit",this.form),this.form.addEventListener("submit",(function(n){n.preventDefault(),t.fetchValues(),e(t.fields)}))}},{key:"fetchValues",value:function(){this.fields=Object.keys(this.fields).reduce((function(e,t){return e[t]=document.querySelector(".form-control[name='".concat(t,"']")).value,e}),{})}},{key:"reset",value:function(){Object.keys(this.fields).forEach((function(e){document.querySelector(".form-control[name=".concat(e,"]")).value=""}))}}])&&r(t.prototype,n),i&&r(t,i),e}(),o=document.getElementById("thumbs-up"),a=document.getElementById("thumbs-down"),s=document.querySelector("input[name='article_id']").value,u=new i("comment-form");u.addField("author"),u.addField("body"),u.addRule("body",(function(e){return e&&e.length})),u.addRule("userMustVote",(function(){return c||l}));var c=!1,l=!1;o.addEventListener("click",(function(){if(l){l=!1,a.classList.remove("text-danger");var e=parseInt(a.nextSibling.textContent.trim());e--,a.nextSibling.textContent=" ".concat(e)}if(!c){c=!0,o.classList.add("text-primary");var t=parseInt(o.nextSibling.textContent.trim());t++,o.nextSibling.textContent=" ".concat(t)}})),a.addEventListener("click",(function(){if(c){c=!1,o.classList.remove("text-primary");var e=parseInt(o.nextSibling.textContent.trim());e--,o.nextSibling.textContent=" ".concat(e)}if(!l){l=!0,a.classList.add("text-danger");var t=parseInt(a.nextSibling.textContent.trim());t++,a.nextSibling.textContent=" ".concat(t)}}));var d=document.getElementById("error-feedback");u.onSubmit((function(e){u.isValid()?(d.innerHTML="",d.style.display="none",c?e.pleased=!0:l&&(e.pleased=!1),axios.post("article/".concat(s,"/comment"),e).then((function(t){if(t.data.success){var n=document.createElement("div");n.classList.add("comment","mb-3");var r='<div class="comment-header mb-3">\n                    <div class="comment-metadata">\n                        <span>'.concat(e.author||"Annonymous","</span> &nbsp;•&nbsp; Now\n                    </div>");e.pleased?r+='<i class="fas fa-thumbs-up text-primary" title="'.concat(e.author||"Annonyous",' loved the article" id="thumbs-up"></i>'):r+='<i class="fas fa-thumbs-down text-danger" title="'.concat(e.author||"Annonyous",' wasn\'t pleased by article" id="thumbs-down"></i>'),r+='</div>\n                <div class="comment-body">\n                    '.concat(e.body,"\n                </div>"),n.innerHTML=r,u.form.after(n),u.reset(),c=!1,l=!1,o.classList.remove("text-primary"),a.classList.remove("text-danger")}}))):function(e){d.innerHTML="",d.style.display="block",e.includes("body")&&(d.innerHTML+="<p>Please, leave an opinion before submitting</p>");e.includes("userMustVote")&&(d.innerHTML+='<p>Please, react to the article (<i class="fas fa-thumbs-up"></i> or <i class="fas fa-thumbs-down"></i>) before leaving an opinion</p>')}(u.getErrors())}))}});