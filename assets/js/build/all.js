/*!
Waypoints Inview Shortcut - 4.0.0
Copyright © 2011-2015 Caleb Troughton
Licensed under the MIT license.
https://github.com/imakewebthings/waypoints/blog/master/licenses.txt
*/
!function(){"use strict";function t(){}function e(t){this.options=i.Adapter.extend({},e.defaults,t),this.axis=this.options.horizontal?"horizontal":"vertical",this.waypoints=[],this.element=this.options.element,this.createWaypoints()}var i=window.Waypoint;e.prototype.createWaypoints=function(){for(var t={vertical:[{down:"enter",up:"exited",offset:"100%"},{down:"entered",up:"exit",offset:"bottom-in-view"},{down:"exit",up:"entered",offset:0},{down:"exited",up:"enter",offset:function(){return-this.adapter.outerHeight()}}],horizontal:[{right:"enter",left:"exited",offset:"100%"},{right:"entered",left:"exit",offset:"right-in-view"},{right:"exit",left:"entered",offset:0},{right:"exited",left:"enter",offset:function(){return-this.adapter.outerWidth()}}]},e=0,i=t[this.axis].length;i>e;e++){var n=t[this.axis][e];this.createWaypoint(n)}},e.prototype.createWaypoint=function(t){var e=this;this.waypoints.push(new i({context:this.options.context,element:this.options.element,enabled:this.options.enabled,handler:function(t){return function(i){e.options[t[i]].call(e,i)}}(t),offset:t.offset,horizontal:this.options.horizontal}))},e.prototype.destroy=function(){for(var t=0,e=this.waypoints.length;e>t;t++)this.waypoints[t].destroy();this.waypoints=[]},e.prototype.disable=function(){for(var t=0,e=this.waypoints.length;e>t;t++)this.waypoints[t].disable()},e.prototype.enable=function(){for(var t=0,e=this.waypoints.length;e>t;t++)this.waypoints[t].enable()},e.defaults={context:window,enabled:!0,enter:t,entered:t,exit:t,exited:t},i.Inview=e}();
/* Modernizr 2.8.3 (Custom Build) | MIT & BSD
 * Build: http://modernizr.com/download/#-flexbox-rgba-cssanimations-csstransitions-hashchange-video-geolocation-inlinesvg-svg-touch-shiv-mq-cssclasses-teststyles-testprop-testallprops-hasevent-prefixes-domprefixes-load
 */
;window.Modernizr=function(a,b,c){function C(a){j.cssText=a}function D(a,b){return C(m.join(a+";")+(b||""))}function E(a,b){return typeof a===b}function F(a,b){return!!~(""+a).indexOf(b)}function G(a,b){for(var d in a){var e=a[d];if(!F(e,"-")&&j[e]!==c)return b=="pfx"?e:!0}return!1}function H(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:E(f,"function")?f.bind(d||b):f}return!1}function I(a,b,c){var d=a.charAt(0).toUpperCase()+a.slice(1),e=(a+" "+o.join(d+" ")+d).split(" ");return E(b,"string")||E(b,"undefined")?G(e,b):(e=(a+" "+p.join(d+" ")+d).split(" "),H(e,b,c))}var d="2.8.3",e={},f=!0,g=b.documentElement,h="modernizr",i=b.createElement(h),j=i.style,k,l={}.toString,m=" -webkit- -moz- -o- -ms- ".split(" "),n="Webkit Moz O ms",o=n.split(" "),p=n.toLowerCase().split(" "),q={svg:"http://www.w3.org/2000/svg"},r={},s={},t={},u=[],v=u.slice,w,x=function(a,c,d,e){var f,i,j,k,l=b.createElement("div"),m=b.body,n=m||b.createElement("body");if(parseInt(d,10))while(d--)j=b.createElement("div"),j.id=e?e[d]:h+(d+1),l.appendChild(j);return f=["&#173;",'<style id="s',h,'">',a,"</style>"].join(""),l.id=h,(m?l:n).innerHTML+=f,n.appendChild(l),m||(n.style.background="",n.style.overflow="hidden",k=g.style.overflow,g.style.overflow="hidden",g.appendChild(n)),i=c(l,a),m?l.parentNode.removeChild(l):(n.parentNode.removeChild(n),g.style.overflow=k),!!i},y=function(b){var c=a.matchMedia||a.msMatchMedia;if(c)return c(b)&&c(b).matches||!1;var d;return x("@media "+b+" { #"+h+" { position: absolute; } }",function(b){d=(a.getComputedStyle?getComputedStyle(b,null):b.currentStyle)["position"]=="absolute"}),d},z=function(){function d(d,e){e=e||b.createElement(a[d]||"div"),d="on"+d;var f=d in e;return f||(e.setAttribute||(e=b.createElement("div")),e.setAttribute&&e.removeAttribute&&(e.setAttribute(d,""),f=E(e[d],"function"),E(e[d],"undefined")||(e[d]=c),e.removeAttribute(d))),e=null,f}var a={select:"input",change:"input",submit:"form",reset:"form",error:"img",load:"img",abort:"img"};return d}(),A={}.hasOwnProperty,B;!E(A,"undefined")&&!E(A.call,"undefined")?B=function(a,b){return A.call(a,b)}:B=function(a,b){return b in a&&E(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=v.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(v.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(v.call(arguments)))};return e}),r.flexbox=function(){return I("flexWrap")},r.touch=function(){var c;return"ontouchstart"in a||a.DocumentTouch&&b instanceof DocumentTouch?c=!0:x(["@media (",m.join("touch-enabled),("),h,")","{#modernizr{top:9px;position:absolute}}"].join(""),function(a){c=a.offsetTop===9}),c},r.geolocation=function(){return"geolocation"in navigator},r.hashchange=function(){return z("hashchange",a)&&(b.documentMode===c||b.documentMode>7)},r.rgba=function(){return C("background-color:rgba(150,255,150,.5)"),F(j.backgroundColor,"rgba")},r.cssanimations=function(){return I("animationName")},r.csstransitions=function(){return I("transition")},r.video=function(){var a=b.createElement("video"),c=!1;try{if(c=!!a.canPlayType)c=new Boolean(c),c.ogg=a.canPlayType('video/ogg; codecs="theora"').replace(/^no$/,""),c.h264=a.canPlayType('video/mp4; codecs="avc1.42E01E"').replace(/^no$/,""),c.webm=a.canPlayType('video/webm; codecs="vp8, vorbis"').replace(/^no$/,"")}catch(d){}return c},r.svg=function(){return!!b.createElementNS&&!!b.createElementNS(q.svg,"svg").createSVGRect},r.inlinesvg=function(){var a=b.createElement("div");return a.innerHTML="<svg/>",(a.firstChild&&a.firstChild.namespaceURI)==q.svg};for(var J in r)B(r,J)&&(w=J.toLowerCase(),e[w]=r[J](),u.push((e[w]?"":"no-")+w));return e.addTest=function(a,b){if(typeof a=="object")for(var d in a)B(a,d)&&e.addTest(d,a[d]);else{a=a.toLowerCase();if(e[a]!==c)return e;b=typeof b=="function"?b():b,typeof f!="undefined"&&f&&(g.className+=" "+(b?"":"no-")+a),e[a]=b}return e},C(""),i=k=null,function(a,b){function l(a,b){var c=a.createElement("p"),d=a.getElementsByTagName("head")[0]||a.documentElement;return c.innerHTML="x<style>"+b+"</style>",d.insertBefore(c.lastChild,d.firstChild)}function m(){var a=s.elements;return typeof a=="string"?a.split(" "):a}function n(a){var b=j[a[h]];return b||(b={},i++,a[h]=i,j[i]=b),b}function o(a,c,d){c||(c=b);if(k)return c.createElement(a);d||(d=n(c));var g;return d.cache[a]?g=d.cache[a].cloneNode():f.test(a)?g=(d.cache[a]=d.createElem(a)).cloneNode():g=d.createElem(a),g.canHaveChildren&&!e.test(a)&&!g.tagUrn?d.frag.appendChild(g):g}function p(a,c){a||(a=b);if(k)return a.createDocumentFragment();c=c||n(a);var d=c.frag.cloneNode(),e=0,f=m(),g=f.length;for(;e<g;e++)d.createElement(f[e]);return d}function q(a,b){b.cache||(b.cache={},b.createElem=a.createElement,b.createFrag=a.createDocumentFragment,b.frag=b.createFrag()),a.createElement=function(c){return s.shivMethods?o(c,a,b):b.createElem(c)},a.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+m().join().replace(/[\w\-]+/g,function(a){return b.createElem(a),b.frag.createElement(a),'c("'+a+'")'})+");return n}")(s,b.frag)}function r(a){a||(a=b);var c=n(a);return s.shivCSS&&!g&&!c.hasCSS&&(c.hasCSS=!!l(a,"article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}")),k||q(a,c),a}var c="3.7.0",d=a.html5||{},e=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,f=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,g,h="_html5shiv",i=0,j={},k;(function(){try{var a=b.createElement("a");a.innerHTML="<xyz></xyz>",g="hidden"in a,k=a.childNodes.length==1||function(){b.createElement("a");var a=b.createDocumentFragment();return typeof a.cloneNode=="undefined"||typeof a.createDocumentFragment=="undefined"||typeof a.createElement=="undefined"}()}catch(c){g=!0,k=!0}})();var s={elements:d.elements||"abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output progress section summary template time video",version:c,shivCSS:d.shivCSS!==!1,supportsUnknownElements:k,shivMethods:d.shivMethods!==!1,type:"default",shivDocument:r,createElement:o,createDocumentFragment:p};a.html5=s,r(b)}(this,b),e._version=d,e._prefixes=m,e._domPrefixes=p,e._cssomPrefixes=o,e.mq=y,e.hasEvent=z,e.testProp=function(a){return G([a])},e.testAllProps=I,e.testStyles=x,g.className=g.className.replace(/(^|\s)no-js(\s|$)/,"$1$2")+(f?" js "+u.join(" "):""),e}(this,this.document),function(a,b,c){function d(a){return"[object Function]"==o.call(a)}function e(a){return"string"==typeof a}function f(){}function g(a){return!a||"loaded"==a||"complete"==a||"uninitialized"==a}function h(){var a=p.shift();q=1,a?a.t?m(function(){("c"==a.t?B.injectCss:B.injectJs)(a.s,0,a.a,a.x,a.e,1)},0):(a(),h()):q=0}function i(a,c,d,e,f,i,j){function k(b){if(!o&&g(l.readyState)&&(u.r=o=1,!q&&h(),l.onload=l.onreadystatechange=null,b)){"img"!=a&&m(function(){t.removeChild(l)},50);for(var d in y[c])y[c].hasOwnProperty(d)&&y[c][d].onload()}}var j=j||B.errorTimeout,l=b.createElement(a),o=0,r=0,u={t:d,s:c,e:f,a:i,x:j};1===y[c]&&(r=1,y[c]=[]),"object"==a?l.data=c:(l.src=c,l.type=a),l.width=l.height="0",l.onerror=l.onload=l.onreadystatechange=function(){k.call(this,r)},p.splice(e,0,u),"img"!=a&&(r||2===y[c]?(t.insertBefore(l,s?null:n),m(k,j)):y[c].push(l))}function j(a,b,c,d,f){return q=0,b=b||"j",e(a)?i("c"==b?v:u,a,b,this.i++,c,d,f):(p.splice(this.i++,0,a),1==p.length&&h()),this}function k(){var a=B;return a.loader={load:j,i:0},a}var l=b.documentElement,m=a.setTimeout,n=b.getElementsByTagName("script")[0],o={}.toString,p=[],q=0,r="MozAppearance"in l.style,s=r&&!!b.createRange().compareNode,t=s?l:n.parentNode,l=a.opera&&"[object Opera]"==o.call(a.opera),l=!!b.attachEvent&&!l,u=r?"object":l?"script":"img",v=l?"script":u,w=Array.isArray||function(a){return"[object Array]"==o.call(a)},x=[],y={},z={timeout:function(a,b){return b.length&&(a.timeout=b[0]),a}},A,B;B=function(a){function b(a){var a=a.split("!"),b=x.length,c=a.pop(),d=a.length,c={url:c,origUrl:c,prefixes:a},e,f,g;for(f=0;f<d;f++)g=a[f].split("="),(e=z[g.shift()])&&(c=e(c,g));for(f=0;f<b;f++)c=x[f](c);return c}function g(a,e,f,g,h){var i=b(a),j=i.autoCallback;i.url.split(".").pop().split("?").shift(),i.bypass||(e&&(e=d(e)?e:e[a]||e[g]||e[a.split("/").pop().split("?")[0]]),i.instead?i.instead(a,e,f,g,h):(y[i.url]?i.noexec=!0:y[i.url]=1,f.load(i.url,i.forceCSS||!i.forceJS&&"css"==i.url.split(".").pop().split("?").shift()?"c":c,i.noexec,i.attrs,i.timeout),(d(e)||d(j))&&f.load(function(){k(),e&&e(i.origUrl,h,g),j&&j(i.origUrl,h,g),y[i.url]=2})))}function h(a,b){function c(a,c){if(a){if(e(a))c||(j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}),g(a,j,b,0,h);else if(Object(a)===a)for(n in m=function(){var b=0,c;for(c in a)a.hasOwnProperty(c)&&b++;return b}(),a)a.hasOwnProperty(n)&&(!c&&!--m&&(d(j)?j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}:j[n]=function(a){return function(){var b=[].slice.call(arguments);a&&a.apply(this,b),l()}}(k[n])),g(a[n],j,b,n,h))}else!c&&l()}var h=!!a.test,i=a.load||a.both,j=a.callback||f,k=j,l=a.complete||f,m,n;c(h?a.yep:a.nope,!!i),i&&c(i)}var i,j,l=this.yepnope.loader;if(e(a))g(a,0,l,0);else if(w(a))for(i=0;i<a.length;i++)j=a[i],e(j)?g(j,0,l,0):w(j)?B(j):Object(j)===j&&h(j,l);else Object(a)===a&&h(a,l)},B.addPrefix=function(a,b){z[a]=b},B.addFilter=function(a){x.push(a)},B.errorTimeout=1e4,null==b.readyState&&b.addEventListener&&(b.readyState="loading",b.addEventListener("DOMContentLoaded",A=function(){b.removeEventListener("DOMContentLoaded",A,0),b.readyState="complete"},0)),a.yepnope=k(),a.yepnope.executeStack=h,a.yepnope.injectJs=function(a,c,d,e,i,j){var k=b.createElement("script"),l,o,e=e||B.errorTimeout;k.src=a;for(o in d)k.setAttribute(o,d[o]);c=j?h:c||f,k.onreadystatechange=k.onload=function(){!l&&g(k.readyState)&&(l=1,c(),k.onload=k.onreadystatechange=null)},m(function(){l||(l=1,c(1))},e),i?k.onload():n.parentNode.insertBefore(k,n)},a.yepnope.injectCss=function(a,c,d,e,g,i){var e=b.createElement("link"),j,c=i?h:c||f;e.href=a,e.rel="stylesheet",e.type="text/css";for(j in d)e.setAttribute(j,d[j]);g||(n.parentNode.insertBefore(e,n),m(c,0))}}(this,document),Modernizr.load=function(){yepnope.apply(window,[].slice.call(arguments,0))};
/*!
 * selectivizr v1.0.2 - (c) Keith Clark, freely distributable under the terms of the MIT license.
 * selectivizr.com
 */
(function(j){function A(a){return a.replace(B,h).replace(C,function(a,d,b){for(var a=b.split(","),b=0,e=a.length;b<e;b++){var s=D(a[b].replace(E,h).replace(F,h))+o,l=[];a[b]=s.replace(G,function(a,b,c,d,e){if(b){if(l.length>0){var a=l,f,e=s.substring(0,e).replace(H,i);if(e==i||e.charAt(e.length-1)==o)e+="*";try{f=t(e)}catch(k){}if(f){e=0;for(c=f.length;e<c;e++){for(var d=f[e],h=d.className,j=0,m=a.length;j<m;j++){var g=a[j];if(!RegExp("(^|\\s)"+g.className+"(\\s|$)").test(d.className)&&g.b&&(g.b===!0||g.b(d)===!0))h=u(h,g.className,!0)}d.className=h}}l=[]}return b}else{if(b=c?I(c):!v||v.test(d)?{className:w(d),b:!0}:null)return l.push(b),"."+b.className;return a}})}return d+a.join(",")})}function I(a){var c=!0,d=w(a.slice(1)),b=a.substring(0,5)==":not(",e,f;b&&(a=a.slice(5,-1));var l=a.indexOf("(");l>-1&&(a=a.substring(0,l));if(a.charAt(0)==":")switch(a.slice(1)){case "root":c=function(a){return b?a!=p:a==p};break;case "target":if(m==8){c=function(a){function c(){var d=location.hash,e=d.slice(1);return b?d==i||a.id!=e:d!=i&&a.id==e}k(j,"hashchange",function(){g(a,d,c())});return c()};break}return!1;case "checked":c=function(a){J.test(a.type)&&k(a,"propertychange",function(){event.propertyName=="checked"&&g(a,d,a.checked!==b)});return a.checked!==b};break;case "disabled":b=!b;case "enabled":c=function(c){if(K.test(c.tagName))return k(c,"propertychange",function(){event.propertyName=="$disabled"&&g(c,d,c.a===b)}),q.push(c),c.a=c.disabled,c.disabled===b;return a==":enabled"?b:!b};break;case "focus":e="focus",f="blur";case "hover":e||(e="mouseenter",f="mouseleave");c=function(a){k(a,b?f:e,function(){g(a,d,!0)});k(a,b?e:f,function(){g(a,d,!1)});return b};break;default:if(!L.test(a))return!1}return{className:d,b:c}}function w(a){return M+"-"+(m==6&&N?O++:a.replace(P,function(a){return a.charCodeAt(0)}))}function D(a){return a.replace(x,h).replace(Q,o)}function g(a,c,d){var b=a.className,c=u(b,c,d);if(c!=b)a.className=c,a.parentNode.className+=i}function u(a,c,d){var b=RegExp("(^|\\s)"+c+"(\\s|$)"),e=b.test(a);return d?e?a:a+o+c:e?a.replace(b,h).replace(x,h):a}function k(a,c,d){a.attachEvent("on"+c,d)}function r(a,c){if(/^https?:\/\//i.test(a))return c.substring(0,c.indexOf("/",8))==a.substring(0,a.indexOf("/",8))?a:null;if(a.charAt(0)=="/")return c.substring(0,c.indexOf("/",8))+a;var d=c.split(/[?#]/)[0];a.charAt(0)!="?"&&d.charAt(d.length-1)!="/"&&(d=d.substring(0,d.lastIndexOf("/")+1));return d+a}function y(a){if(a)return n.open("GET",a,!1),n.send(),(n.status==200?n.responseText:i).replace(R,i).replace(S,function(c,d,b,e,f){return y(r(b||f,a))}).replace(T,function(c,d,b){d=d||i;return" url("+d+r(b,a)+d+") "});return i}function U(){var a,c;a=f.getElementsByTagName("BASE");for(var d=a.length>0?a[0].href:f.location.href,b=0;b<f.styleSheets.length;b++)if(c=f.styleSheets[b],c.href!=i&&(a=r(c.href,d)))c.cssText=A(y(a));q.length>0&&setInterval(function(){for(var a=0,c=q.length;a<c;a++){var b=q[a];if(b.disabled!==b.a)b.disabled?(b.disabled=!1,b.a=!0,b.disabled=!0):b.a=b.disabled}},250)}if(!/*@cc_on!@*/true){var f=document,p=f.documentElement,n=function(){if(j.XMLHttpRequest)return new XMLHttpRequest;try{return new ActiveXObject("Microsoft.XMLHTTP")}catch(a){return null}}(),m=/MSIE (\d+)/.exec(navigator.userAgent)[1];if(!(f.compatMode!="CSS1Compat"||m<6||m>8||!n)){var z={NW:"*.Dom.select",MooTools:"$$",DOMAssistant:"*.$",Prototype:"$$",YAHOO:"*.util.Selector.query",Sizzle:"*",jQuery:"*",dojo:"*.query"},t,q=[],O=0,N=!0,M="slvzr",R=/(\/\*[^*]*\*+([^\/][^*]*\*+)*\/)\s*/g,S=/@import\s*(?:(?:(?:url\(\s*(['"]?)(.*)\1)\s*\))|(?:(['"])(.*)\3))[^;]*;/g,T=/\burl\(\s*(["']?)(?!data:)([^"')]+)\1\s*\)/g,L=/^:(empty|(first|last|only|nth(-last)?)-(child|of-type))$/,B=/:(:first-(?:line|letter))/g,C=/(^|})\s*([^\{]*?[\[:][^{]+)/g,G=/([ +~>])|(:[a-z-]+(?:\(.*?\)+)?)|(\[.*?\])/g,H=/(:not\()?:(hover|enabled|disabled|focus|checked|target|active|visited|first-line|first-letter)\)?/g,P=/[^\w-]/g,K=/^(INPUT|SELECT|TEXTAREA|BUTTON)$/,J=/^(checkbox|radio)$/,v=m>6?/[\$\^*]=(['"])\1/:null,E=/([(\[+~])\s+/g,F=/\s+([)\]+~])/g,Q=/\s+/g,x=/^\s*((?:[\S\s]*\S)?)\s*$/,i="",o=" ",h="$1";(function(a,c){function d(){try{p.doScroll("left")}catch(a){setTimeout(d,50);return}b("poll")}function b(d){if(!(d.type=="readystatechange"&&f.readyState!="complete")&&((d.type=="load"?a:f).detachEvent("on"+d.type,b,!1),!e&&(e=!0)))c.call(a,d.type||d)}var e=!1,g=!0;if(f.readyState=="complete")c.call(a,i);else{if(f.createEventObject&&p.doScroll){try{g=!a.frameElement}catch(h){}g&&d()}k(f,"readystatechange",b);k(a,"load",b)}})(j,function(){for(var a in z){var c,d,b=j;if(j[a]){for(c=z[a].replace("*",a).split(".");(d=c.shift())&&(b=b[d]););if(typeof b=="function"){t=b;U();break}}}})}}})(this);
/*
 Sticky-kit v1.1.2 | WTFPL | Leaf Corcoran 2015 | http://leafo.net
 */
(function(){var b,f;b=this.jQuery||window.jQuery;f=b(window);b.fn.stick_in_parent=function(d){var A,w,J,n,B,K,p,q,k,E,t;null==d&&(d={});t=d.sticky_class;B=d.inner_scrolling;E=d.recalc_every;k=d.parent;q=d.offset_top;p=d.spacer;w=d.bottoming;null==q&&(q=0);null==k&&(k=void 0);null==B&&(B=!0);null==t&&(t="is_stuck");A=b(document);null==w&&(w=!0);J=function(a,d,n,C,F,u,r,G){var v,H,m,D,I,c,g,x,y,z,h,l;if(!a.data("sticky_kit")){a.data("sticky_kit",!0);I=A.height();g=a.parent();null!=k&&(g=g.closest(k));
    if(!g.length)throw"failed to find stick parent";v=m=!1;(h=null!=p?p&&a.closest(p):b("<div />"))&&h.css("position",a.css("position"));x=function(){var c,f,e;if(!G&&(I=A.height(),c=parseInt(g.css("border-top-width"),10),f=parseInt(g.css("padding-top"),10),d=parseInt(g.css("padding-bottom"),10),n=g.offset().top+c+f,C=g.height(),m&&(v=m=!1,null==p&&(a.insertAfter(h),h.detach()),a.css({position:"",top:"",width:"",bottom:""}).removeClass(t),e=!0),F=a.offset().top-(parseInt(a.css("margin-top"),10)||0)-q,
            u=a.outerHeight(!0),r=a.css("float"),h&&h.css({width:a.outerWidth(!0),height:u,display:a.css("display"),"vertical-align":a.css("vertical-align"),"float":r}),e))return l()};x();if(u!==C)return D=void 0,c=q,z=E,l=function(){var b,l,e,k;if(!G&&(e=!1,null!=z&&(--z,0>=z&&(z=E,x(),e=!0)),e||A.height()===I||x(),e=f.scrollTop(),null!=D&&(l=e-D),D=e,m?(w&&(k=e+u+c>C+n,v&&!k&&(v=!1,a.css({position:"fixed",bottom:"",top:c}).trigger("sticky_kit:unbottom"))),e<F&&(m=!1,c=q,null==p&&("left"!==r&&"right"!==r||a.insertAfter(h),
            h.detach()),b={position:"",width:"",top:""},a.css(b).removeClass(t).trigger("sticky_kit:unstick")),B&&(b=f.height(),u+q>b&&!v&&(c-=l,c=Math.max(b-u,c),c=Math.min(q,c),m&&a.css({top:c+"px"})))):e>F&&(m=!0,b={position:"fixed",top:c},b.width="border-box"===a.css("box-sizing")?a.outerWidth()+"px":a.width()+"px",a.css(b).addClass(t),null==p&&(a.after(h),"left"!==r&&"right"!==r||h.append(a)),a.trigger("sticky_kit:stick")),m&&w&&(null==k&&(k=e+u+c>C+n),!v&&k)))return v=!0,"static"===g.css("position")&&g.css({position:"relative"}),
        a.css({position:"absolute",bottom:d,top:"auto"}).trigger("sticky_kit:bottom")},y=function(){x();return l()},H=function(){G=!0;f.off("touchmove",l);f.off("scroll",l);f.off("resize",y);b(document.body).off("sticky_kit:recalc",y);a.off("sticky_kit:detach",H);a.removeData("sticky_kit");a.css({position:"",bottom:"",top:"",width:""});g.position("position","");if(m)return null==p&&("left"!==r&&"right"!==r||a.insertAfter(h),h.remove()),a.removeClass(t)},f.on("touchmove",l),f.on("scroll",l),f.on("resize",
        y),b(document.body).on("sticky_kit:recalc",y),a.on("sticky_kit:detach",H),setTimeout(l,0)}};n=0;for(K=this.length;n<K;n++)d=this[n],J(b(d));return this}}).call(this);
/*!
Waypoints Sticky Element Shortcut - 4.0.0
Copyright © 2011-2015 Caleb Troughton
Licensed under the MIT license.
https://github.com/imakewebthings/waypoints/blog/master/licenses.txt
*/
!function(){"use strict";function t(s){this.options=e.extend({},i.defaults,t.defaults,s),this.element=this.options.element,this.$element=e(this.element),this.createWrapper(),this.createWaypoint()}var e=window.jQuery,i=window.Waypoint;t.prototype.createWaypoint=function(){var t=this.options.handler;this.waypoint=new i(e.extend({},this.options,{element:this.wrapper,handler:e.proxy(function(e){var i=this.options.direction.indexOf(e)>-1,s=i?this.$element.outerHeight(!0):"";this.$wrapper.height(s),this.$element.toggleClass(this.options.stuckClass,i),t&&t.call(this,e)},this)}))},t.prototype.createWrapper=function(){this.options.wrapper&&this.$element.wrap(this.options.wrapper),this.$wrapper=this.$element.parent(),this.wrapper=this.$wrapper[0]},t.prototype.destroy=function(){this.$element.parent()[0]===this.wrapper&&(this.waypoint.destroy(),this.$element.removeClass(this.options.stuckClass),this.options.wrapper&&this.$element.unwrap())},t.defaults={wrapper:'<div class="sticky-wrapper" />',stuckClass:"stuck",direction:"down right"},i.Sticky=t}();
(function($) {

    FastClick.attach(document.body);

    window.isMobile = function() {
        var check = false;
        (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
        return check;
    };

    $(window).load(function(){

        $('.is-clickable').click(function() {
            var url = $(this).closest('article').find('header:first').find('a').attr('href');
            if(url) { window.location = url; }
        });

        $('[data-match="height"]').each(function(index, element) {
            $(element).matchHeight();
        });

        $('[data-fitvids]').fitVids();

    });

    if($('body').hasClass('single') && !isMobile()) {

        if($('body.single .sidebar').length) {
            $('body.single .sidebar').stick_in_parent({
                parent: $('.main'),
                offset_top: 20,

            }).on("sticky_kit:stick", function(e) {
                if ($(e.target).hasClass('sidebar--location-right')) {
	                $(e.target).parent().addClass('sidebar-spacer-sticky-right');
                } else {
	                $(e.target).parent().addClass('sidebar-spacer-sticky-left');
                }
            });
        }

        $('body').on('click', '.internal-navigation li a', function(e){
            e.preventDefault();
            var href = $(this).attr('href').replace('#', '');
            var target = $('[name="'+href+'"]');
            var offset = target.offset().top;
            var windowOffset = $(window).scrollTop();
            $('html, body').animate({'scrollTop': offset - 50}, 600);
        });
    }


    // Shortcuts
    Mousetrap(document).bind(['S', 's'], function(e) {
        e.preventDefault();
        $(window).scrollTop($("#site-content").offset().top);
    });
    Mousetrap(document).bind('0', function(e) {
        e.preventDefault();
        $(window).scrollTop($("#site-footer").offset().top);
    });


    var links = $('nav.primary-navigation ul').find('a');
    Mousetrap(document).bind('1', function(e) {
        e.preventDefault();
        window.location = links[0].href;
    });
    Mousetrap(document).bind('2', function(e) {
        e.preventDefault();
        window.location = links[1].href;
    });
    Mousetrap(document).bind('4', function(e) {
        e.preventDefault();
        $('#search-form-1').focus();
    });

    // WordPress doesn't offer a way of posting empty comments since 4.4, so we fix this with JS.
    $('#commentform').submit(function(e) {
        if($('#commentFormComment').val() === '') {
            $('#commentFormComment').html($('input[name=commentFormEmotion]:checked').val());
        }
    });

    // Allow :active despite removing -webkit-tab-highlight-color http://bit.ly/1WqdsZL
    document.addEventListener("touchstart", function(){}, true);

    // Bosse-fix
    if(($( window ).width())<960){
        $("ul.off-canvas__navigation__list").attr("aria-hidden", "false");
        $("ul.navigation__item").attr("aria-hidden", "true");
        $("div.off-canvas").attr("tabindex", "0");
        $("div.off-canvas").attr("aria-hidden", "false");
    } else {
        $("ul.off-canvas__navigation__item").attr("aria-hidden", "true");
        $("ul.navigation__list").attr("aria-hidden", "false");
        $("div.off-canvas").attr("tabindex", "-1");
        $("div.off-canvas").attr("aria-hidden", "true");
    }

    $(window).bind("resize",function(){
        if(($( window ).width())<960){
            $("ul.off-canvas__navigation__list").attr("aria-hidden", "false");
            $("ul.navigation__list").attr("aria-hidden", "true");
            $("div.off-canvas").attr("tabindex", "0");
            $("div.off-canvas").attr("aria-hidden", "false");
        } else {
            $("ul.off-canvas__navigation__list").attr("aria-hidden", "true");
            $("ul.navigation__list").attr("aria-hidden", "false");
            $("div.off-canvas").attr("tabindex", "-1");
            $("div.off-canvas").attr("aria-hidden", "true");
        }
    });


})(jQuery);
(function($) {

    $(document).ready(function() {

        var $cfa = $('#commentFormAuthor'),
            $cft = $('#commentFormComment'),
            $cfe = $('input[name="commentFormEmotion"]');

        var $cfpa = $('#commentFormPreviewAuthor'),
            $cfpt = $('#commentFormPreviewText'),
            $cfpe = $('#commentFormPreviewEmotion');

        $cfa.on('input', function() {
            if($cfa.val() == '') {
                $cfpa.html('Förnamn Efternamn');
            } else {
                $cfpa.html($cfa.val());
            }
        });

        $cft.on('input', function() {
            if($cft.val() == '') {
                $cfpt.html('Min kommentar...');
            } else {
                $cfpt.html($cft.val());
            }
        });

        $cfe.on('change', function(e) {

            if(!$cfpt.parent().hasClass('has-emotion')) {
                $cfpt.parent().addClass('has-emotion');
            }
            var emotion = this.value;
            $cfpe.attr('src', '/wp-content/themes/wally/assets/icons/twemojis/' + emotion.substr('emotion'.length) + '.svg');
            $cfpe.show();
        });

    });

})(jQuery);
(function($) {

    $(document).ready(function() {

        $('*[data-dd]').each(function(){
            var dd = $(this);
            var drawer = dd.find('*[data-dd-drawer]');
            var $backdrop = $( "<div class='backdrop'/>" );
            var $trigger = dd.find("*[data-dd-trigger]");

            dd.on('open', function(){
                $backdrop.css({
                    zIndex: drawer.css('z-index') - 1,
                    position: 'fixed',
                    top: '0',
                    bottom: '0',
                    left: '0',
                    right: '0'
                });
                //$backdrop.on('click', function(e){
                //    $backdrop.remove();
                //    dd.removeClass('open');
                //    $trigger.focus();
                //});
                $('body').on('click', function(e) {
                    if(!$(e.target).parents('.dropdown').first().is(dd)) {
                        dd.removeClass('open');
                    }
                });

                //$( "body" ).append($backdrop);
                dd.addClass('open');
            });
            dd.on('close', function(){
                //$backdrop.remove();
                dd.removeClass('open');
                $trigger.focus();
            });

            $trigger.on('click', function(e){
                e.preventDefault();
                dd.trigger('open');
            });

            drawer.on('click', 'a', function(e){
                e.preventDefault();
                dd.find('li').removeClass('active');
                $(this).parent().addClass('active');
                dd.find('.value').html($(this).html());

                dd.trigger('close');
            });

            Mousetrap(this).bind(['esc'], function(e) {
                dd.trigger('close');
            });
        });

    });

})(jQuery);
//jQuery.fn.extend({
//    highlight: function(search, insensitive, highlightClass){
//        var regex = new RegExp("(<[^>]*>)|(\\b"+ search.replace(/([-.*+?^${}()|[\]\/\\])/g,"\\$1") +")", insensitive ? "ig" : "g");
//        return this.html(this.html().replace(regex, function(a, b, c){
//            console.log(a,b,c);
//            return (a.charAt(0) == "<") ? a : "<strong class=\""+ highlightClass +"\">" + c + "</strong>";
//        }));
//    }
//});


jQuery.fn.highlight = function(pat) {
    function innerHighlight(node, pat) {
        var skip = 0;
        if (node.nodeType == 3) {
            var pos = node.data.toUpperCase().indexOf(pat);
            pos -= (node.data.substr(0, pos).toUpperCase().length - node.data.substr(0, pos).length);
            if (pos >= 0) {
                var spannode = document.createElement('span');
                spannode.className = 'is-highlighted';
                var middlebit = node.splitText(pos);
                var endbit = middlebit.splitText(pat.length);
                var middleclone = middlebit.cloneNode(true);
                spannode.appendChild(middleclone);
                middlebit.parentNode.replaceChild(spannode, middlebit);
                skip = 1;
            }
        }
        else if (node.nodeType == 1 && node.childNodes && !/(script|style)/i.test(node.tagName)) {
            for (var i = 0; i < node.childNodes.length; ++i) {
                i += innerHighlight(node.childNodes[i], pat);
            }
        }
        return skip;
    }
    return this.length && pat && pat.length ? this.each(function() {
        innerHighlight(this, pat.toUpperCase());
    }) : this;
};

jQuery(document).ready(function($){
    if(typeof(wallySearchQuery) != 'undefined'){
        $("#search-results .article-box").each(function(i, article) {
            $(article).highlight(wallySearchQuery);
        });
    }
});
(function($) {

    $(document).ready(function() {

        var $iframe = $('iframe'),
            $parent = $iframe.parents('article, section').first(),
            $text   = $parent.find('h1, h2, h3').first().text();

        //$iframe.attr('title', 'Ett videoklipp till inlägget ' + $text);

    });

})(jQuery);
'use strict';
(function($) {

    $(document).ready(function() {

        var $listGroups = $('.list-group');
        var $listGroupLinks = $( '.list-group__item a' );
        var $listGroupButtons = $('.list-group__item button');

        $listGroupLinks.each(function(index, link) {
            if($(link).attr('href') != window.location.href && !$(link).parent('li').hasClass('current_page_ancestor')) {
                $(link).removeClass('is-open');

                if($(link).siblings('.list-group__sublist').length) {
                    $(link).siblings('.list-group__sublist').removeClass('is-open');
                }

            } else {
                $(link).parents()
            }
        });
        $listGroupButtons.each(function(index) {

            var subList = $(this).parent().siblings('.list-group__sublist');
            if(subList.length) {

                subList.on('toggle', function(e){

                    if(window.isMobile()) {

                        $(this)
                            .parent()
                            .siblings('.list-group__item')
                            .find('.is-open').each(function() {
                                //$(this).slideUp();
                                $(this).attr('tabindex', '-1');
                                $(this).removeClass('is-open');
                            })
                    }

                    //subList.slideToggle();
                    subList.toggleClass('is-open');
                    $(this).prev('a').toggleClass('is-open');

                    e.stopPropagation();

                });

                subList.on('retract', function(){
                    //subList.slideUp();
                    $(this).attr('tabindex', '-1');
                    subList.removeClass('is-open');
                    $(this).prev('a').removeClass('is-open');
                    
                });

                subList.on('expand', function(){
                    //subList.slideDown();
                    $(this).attr('tabindex', '0');
                    subList.addClass('is-open');
                    $(this).prev('a').addClass('is-open');
                });

                $(this).click(function(e) {
                    e.preventDefault();
                    subList.trigger('toggle');
                });
            }
        });


    });


})(jQuery);
(function($) {

    $(document).ready(function() {

        // Fullscreen images
        $('[data-image]').magnificPopup({
            delegate: '.make-fullscreen',
            type: 'image',
            removalDelay: 300,
            mainClass: 'mfp-fade',
            image: {
                titleSrc: function(item) {
                    return item.el.parents('figure').find('img').first().attr('alt');
                }
            },
            tLoading: '' // Remove "Loading..."
        });

        $('figure[data-image]').each(function(){
            var bg = $(this).data('image');
            $(this).css('background-image', 'url(' + bg + ')').addClass('loaded');
            $(this).append('<img src="' + bg +'" />');
        });

    });

})(jQuery);
(function($) {

    $(document).ready(function() {

        if(isMobile()) {
            var headerHeight = $('#site-header').outerHeight();
            $("#site-header").headroom({
                offset: headerHeight,
                onTop : function() {
                    $('#site-content').css({'padding-top': 0})
                },
                onNotTop : function() {
                    $('#site-content').css({'padding-top': headerHeight})
                }
            });
        }

        var offCanvas = $('.off-canvas');
        var overlay = $('.overlay');

        // Off-canvas navigation
        $('.off-canvas__navigation__toggle').click(function(e) {
            e.preventDefault();
            e.stopPropagation();

            var $subList = $(this).parent().siblings('ul');

            $subList.slideToggle();
            $subList.toggleClass('is-open');
            $(e.target).toggleClass('is-open');

            return false;

        });

        $('.off-canvas__open').click(function() {
            openOffCanvas();
        });

        $('.off-canvas__close, .overlay').click(function() {
            closeOffCanvas();
        });

        function openOffCanvas() {
            if(!offCanvas.hasClass('is-open')) {
                $('body').css({'overflow-y': 'hidden'});
                offCanvas.addClass('is-open');
                overlay.addClass('is-visible');
            }

        }

        function closeOffCanvas() {
            if(offCanvas.hasClass('is-open')) {
                $('body').css({'overflow-y': 'visible'});
                offCanvas.removeClass('is-open');
                overlay.removeClass('is-visible');
            }
        }

    });

})(jQuery);
(function($) {

    $(document).ready(function() {

        $('[data-modal]').each(function(){
            var $modal = $(this);
            var $body = $modal.find('*[data-modal-body]');
            var $backdrop = $( "<div class='modal-backdrop'/>" );
            var $trigger = $modal.find("*[data-modal-trigger]");
            var $close = $modal.find("*[data-modal-close]");

            $modal.on('open', function(){
                console.log('Open');
                $backdrop.css({
                    zIndex: $body.css('z-index') - 1,
                    position: 'fixed',
                    top: '0px',
                    bottom: '0px',
                    left: '0px',
                    right: '0px'
                });

                $backdrop.on('click', function(e){
                    console.log('Backdrop close');
                    $modal.trigger('close');
                });

                $( "body" ).append($backdrop).addClass('lock');
                $modal.addClass('open');
                $body.attr('aria-hidden', 'false');
            });

            $modal.on('close', function(){
                console.log('Close');
                $backdrop.remove();
                $modal.removeClass('open');
                $body.attr('aria-hidden', 'true');
                $('body').removeClass('lock');
            });

            $close.on('click', function(e){
                e.preventDefault();
                e.stopPropagation();
                $modal.trigger('close');
            })

            $trigger.on('click', function(e){
                e.preventDefault();
                e.stopPropagation();
                $modal.trigger('open');
            });


            Mousetrap(this).bind(['esc'], function(e) {
                $modal.trigger('close');
            })
        });

    });

})(jQuery);
(function($, window, document) {

    var $navigation,
        $moreContentListItem,
        $moreContentButton,
        $moreContentSubList;

    $(document).ready(function() {

        /**
         * Setup $navigation
         */

        $verticalLayout = $('body').hasClass('vertical-header');


        $navigation = $('.primary-navigation > ul');

        $navigation.fixOverflowingItems = function() {

            var navigationTotalWidth = $navigation.outerWidth();
            var moreContentListItemWidth = $moreContentListItem.outerWidth();
            var hasHiddenItems = $moreContentListItem.hiddenItemWidths.length;
            var itemsTotalWidth = 0;

            $navigation.children('li').each(function() {
                itemsTotalWidth += $(this).outerWidth();
            });

            if( navigationTotalWidth < itemsTotalWidth && ! $verticalLayout ) {
                // Overflow found

                // Is the moreContentListItem attached?
                if(!$.contains(document, $moreContentListItem[0])) {

                    // If not - attach it
                    $moreContentListItem.appendTo($navigation);
                }

                $moreContentListItem.hidePreviousItem();

                this.fixOverflowingItems();

            } else {
                // Overflow not found
                if(hasHiddenItems) {
                    var hiddenItemWidth = $moreContentListItem.hiddenItemWidths[0];

                    if(hasHiddenItems == 1) {
                        // Only one item hidden? Could it be displayed if we removed the "more content" button?
                        if(navigationTotalWidth >= itemsTotalWidth - moreContentListItemWidth + hiddenItemWidth) {
                            $moreContentListItem.showPreviousItem();
                            $moreContentListItem.detach();
                        }
                    } else {
                        if(navigationTotalWidth >= itemsTotalWidth + hiddenItemWidth) {
                            $moreContentListItem.showPreviousItem();
                        }
                    }

                }

            }

        };

        /**
         * Setup $moreContentButton
         */
        $moreContentButton = $( '<button>', {
            'id': 'moreContentButton',
            'title': 'Mer innehåll',
            'aria-label': 'Tryck på nedåtpilen för att visa mer innehåll.'
        }).html('Mer innehåll <i class="material-icons" aria-label="Nedåtpil" aria-hidden="true">keyboard_arrow_down</i>');

        //
        $moreContentButton.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $moreContentSubList.toggle();
        });
        //Mousetrap($moreContentButton[0]).bind('down', function(e) {
        //    e.preventDefault();
        //
        //    if(!$moreContentSubList.hasClass('is-open')) {
        //        $moreContentSubList.open();
        //    } else {
        //        $moreContentSubList.openAndFocus();
        //    }
        //});
        //
        //// Hide sublist
        //Mousetrap($moreContentButton[0]).bind('click', function(e) {
        //    e.preventDefault();
        //    if($moreContentSubList.hasClass('is-open')) {
        //        $moreContentSubList.removeClass('is-open');
        //        $moreContentButton.focus();
        //    }
        //});

        /**
         * Setup $moreContentSublist
         */
        $moreContentSubList = $( '<ul>', {
            'class': 'navigation__sublist',
            'role': 'menu',
            'aria-hidden': 'true'
        });

        $moreContentSubList.toggle = function() {
            if(this.isOpen) {
                this.close();
            } else {
                this.open();
            }
        };

        $moreContentSubList.open = function() {
            if(!$moreContentSubList.hasClass('is-open')) {
                $moreContentSubList.addClass('is-open');
            }

            this.isOpen = true;
            this.attr('aria-hidden', 'false');
            this.find('a').removeAttr('tabindex');

            this.appendTo($moreContentListItem);

        };

        $moreContentSubList.openAndFocus = function() {
            this.open();
            $moreContentSubList.children().first().children('a').focus();
        };

        $moreContentSubList.close = function() {
            if($moreContentSubList.hasClass('is-open')) {
                $moreContentSubList.removeClass('is-open');
            }
            this.isOpen = false;
            this.attr('aria-hidden', 'true');
            this.find('a').attr('tabindex', '-1');

            this.detach();
        };

        /**
         * Setup $moreContentListItem
         */
        $moreContentListItem = $('<li class="navigation__item">');

        $moreContentListItem.hiddenItemWidths = [];

        // Hide the previous item in $navigation relative to $moreContentListItem
        $moreContentListItem.hidePreviousItem = function() {

            var prevItem = this.prev();

            this.hiddenItemWidths.unshift(prevItem.outerWidth());

            prevItem.removeClass('navigation__item');
            prevItem.addClass('navigation__subitem');

            prevItem.children('a').first().attr('tabindex', -1);

            prevItem.detach().prependTo($moreContentSubList);

            return prevItem;
        };

        // Show the previous item in $navigation relative to $moreContentListItem
        $moreContentListItem.showPreviousItem = function() {

            var prevItem = $moreContentSubList.children().first();

            this.hiddenItemWidths.shift();

            prevItem.removeClass('navigation__subitem');
            prevItem.addClass('navigation__item');

            prevItem.removeAttr('tabindex');

            prevItem.detach().insertBefore(this);

            return prevItem;
        };
        $moreContentListItem.append($moreContentButton);
        $moreContentListItem.append($moreContentSubList);

        $moreContentButton.on('focusout', function(event) {

            if(!$(this).parent() == ($moreContentSubList.parent())) {
                $moreContentSubList.close();
            }

        });

        $(document).click(function() {
            $moreContentSubList.close();
        });

        $navigation.fixOverflowingItems();

    });

    $(window).on('resize', function() {
        $navigation.fixOverflowingItems();
    });


})(jQuery, window, document);
(function($) {

    var currentPage = 2;

    $(document).ready(function() {

        var $pagination = $('[data-pagination]'),
            $button = $( '<button>', {
                'class': 'button button--primary pagination__button icon-load',
                'type': 'button'
            }).html('<span>Ladda fler artiklar</span>'),
            post = $pagination.data('pagination');

        $button.on('click', function(e) {
            var $this = $(this),
                currentText = $this.html(),
                newText = 'Laddar...';

            e.preventDefault();

            $this.html(newText);
            $this.attr('disabled', 'true');
            $this.attr('aria-disabled', 'true');

            $.ajax({
                url: ajax.url,
                data: {
                    action: 'ajax_pagination',
                    page: currentPage,
                    post: post
                },
                dataType: 'json',
                success: function(response) {

                    // The articles are sent in pure HTML
                    var $response = $($.parseHTML(response.articles)),
                        maxNumPages = response.pages;

                    if($pagination.length) {
                        $response.insertBefore($pagination);
                    }

                    if(currentPage >= maxNumPages) {
                        $this.html('Inga fler inlägg');
                    } else {
                        $this.removeAttr('disabled');
                        $this.attr('aria-disabled', 'false');
                        $this.html(currentText);
                    }

                    currentPage++;

                }
            });

        });

        $pagination.empty();
        $button.appendTo($pagination);

    });

})(jQuery);
(function($) {

    $(document).ready(function() {

        $('input[type="search"]').autocomplete({
            serviceUrl: ajax.url,
            params: {
                'action': 'autocomplete'
            },
            onSearchComplete: function(query) {
                //console.log(query);
            },
            beforeRender: function(container) {
                //$('#searchAlert').html('Found '+ (container.children().length) +' results. Use up and down arrows to navigate.');
            },
            onSelect: function(suggestion) {
                $(this).val(suggestion.value);
                $(this).parent('form').submit();
            },
            showNoSuggestionNotice: false,
            triggerSelectOnValidInput: false
        });


    });

})(jQuery);
(function($) {

    $(document).ready(function() {

        $('[data-tabs]').each(function() {

            var $tabs = $(this);

            $tabs.find('a').each(function() {
                $(this).on('click', function(e) {

                    e.preventDefault();

                    var $panel = $($(this).attr('href'));

                    $(this).parent().siblings('.is-active').attr('aria-selected', 'false');
                    $(this).parent().siblings('.is-active').removeClass('is-active');

                    $(this).parent().addClass('is-active');
                    $(this).parent().attr('aria-selected', 'true');

                    $panel.siblings('.is-active').attr('aria-hidden', 'true');
                    $panel.siblings('.is-active').removeClass('is-active');

                    $panel.attr('aria-hidden', 'false');
                    $panel.addClass('is-active');

                    var s = $(window).scrollTop();
                    window.location.hash = $(this).attr('href');
                    $(window).scrollTop(s);

                });
            });

        });

        if(!_.isEmpty(window.location.hash)) {
            var active = $('[href=' + window.location.hash + ']');
            if(active.length) active.click();
        }


    });

})(jQuery);
(function($) {

    $(document).ready(function() {

        $('[data-tooltip]').each(function(){

            var $trigger = $(this),
                $tooltip = $( '<div>', {
                    'class': 'tooltip',
                    'role': 'menu',
                    'aria-hidden': 'false'
                }).html($trigger.data('tooltip')),
                $close = $('<button>', {
                    'class': 'tooltip__close'
                });


            $trigger.attr('tabindex', 0);

            $tooltip.append($close);

            $tooltip.on('open', function(){
                $tooltip.appendTo($trigger);
                setTimeout(function() {
                    $tooltip.addClass('is-open');
                }, 125);
            });

            $tooltip.on('close', function(){
                $tooltip.removeClass('is-open');
                $tooltip.detach();
            });

            $tooltip.on('click', '.tooltip__close', function(e){
                e.preventDefault();
                e.stopPropagation();
                $tooltip.trigger('close');
            });

            $trigger.on('click, focus', function(e){
                $tooltip.trigger('open');
            });

            $trigger.on('focusout', function(e) {
                $tooltip.trigger('close');
            });

            Mousetrap(this).bind(['space', 'enter'], function(e) {
                $tooltip.trigger('open');
            });

            Mousetrap($close.get(0)).bind(['space', 'enter'], function(e) {
                e.preventDefault();
                e.stopPropagation();
                $tooltip.trigger('close');
                $trigger.focus();
            });

        });

    });

})(jQuery);