/* Modernizr 2.6.2 (Custom Build) | MIT & BSD
 * Build: http://modernizr.com/download/#-fontface-backgroundsize-borderimage-borderradius-boxshadow-flexbox-hsla-multiplebgs-opacity-rgba-textshadow-cssanimations-csscolumns-generatedcontent-cssgradients-cssreflections-csstransforms-csstransforms3d-csstransitions-applicationcache-canvas-canvastext-draganddrop-hashchange-history-audio-video-indexeddb-input-inputtypes-localstorage-postmessage-sessionstorage-websockets-websqldatabase-webworkers-geolocation-inlinesvg-smil-svg-svgclippaths-touch-webgl-shiv-mq-cssclasses-addtest-prefixed-teststyles-testprop-testallprops-hasevent-prefixes-domprefixes-load
 */
;window.Modernizr=function(a,b,c){function D(a){j.cssText=a}function E(a,b){return D(n.join(a+";")+(b||""))}function F(a,b){return typeof a===b}function G(a,b){return!!~(""+a).indexOf(b)}function H(a,b){for(var d in a){var e=a[d];if(!G(e,"-")&&j[e]!==c)return b=="pfx"?e:!0}return!1}function I(a,b,d){for(var e in a){var f=b[a[e]];if(f!==c)return d===!1?a[e]:F(f,"function")?f.bind(d||b):f}return!1}function J(a,b,c){var d=a.charAt(0).toUpperCase()+a.slice(1),e=(a+" "+p.join(d+" ")+d).split(" ");return F(b,"string")||F(b,"undefined")?H(e,b):(e=(a+" "+q.join(d+" ")+d).split(" "),I(e,b,c))}function K(){e.input=function(c){for(var d=0,e=c.length;d<e;d++)u[c[d]]=c[d]in k;return u.list&&(u.list=!!b.createElement("datalist")&&!!a.HTMLDataListElement),u}("autocomplete autofocus list placeholder max min multiple pattern required step".split(" ")),e.inputtypes=function(a){for(var d=0,e,f,h,i=a.length;d<i;d++)k.setAttribute("type",f=a[d]),e=k.type!=="text",e&&(k.value=l,k.style.cssText="position:absolute;visibility:hidden;",/^range$/.test(f)&&k.style.WebkitAppearance!==c?(g.appendChild(k),h=b.defaultView,e=h.getComputedStyle&&h.getComputedStyle(k,null).WebkitAppearance!=="textfield"&&k.offsetHeight!==0,g.removeChild(k)):/^(search|tel)$/.test(f)||(/^(url|email)$/.test(f)?e=k.checkValidity&&k.checkValidity()===!1:e=k.value!=l)),t[a[d]]=!!e;return t}("search tel url email datetime date month week time datetime-local number range color".split(" "))}var d="2.6.2",e={},f=!0,g=b.documentElement,h="modernizr",i=b.createElement(h),j=i.style,k=b.createElement("input"),l=":)",m={}.toString,n=" -webkit- -moz- -o- -ms- ".split(" "),o="Webkit Moz O ms",p=o.split(" "),q=o.toLowerCase().split(" "),r={svg:"http://www.w3.org/2000/svg"},s={},t={},u={},v=[],w=v.slice,x,y=function(a,c,d,e){var f,i,j,k,l=b.createElement("div"),m=b.body,n=m||b.createElement("body");if(parseInt(d,10))while(d--)j=b.createElement("div"),j.id=e?e[d]:h+(d+1),l.appendChild(j);return f=["&#173;",'<style id="s',h,'">',a,"</style>"].join(""),l.id=h,(m?l:n).innerHTML+=f,n.appendChild(l),m||(n.style.background="",n.style.overflow="hidden",k=g.style.overflow,g.style.overflow="hidden",g.appendChild(n)),i=c(l,a),m?l.parentNode.removeChild(l):(n.parentNode.removeChild(n),g.style.overflow=k),!!i},z=function(b){var c=a.matchMedia||a.msMatchMedia;if(c)return c(b).matches;var d;return y("@media "+b+" { #"+h+" { position: absolute; } }",function(b){d=(a.getComputedStyle?getComputedStyle(b,null):b.currentStyle)["position"]=="absolute"}),d},A=function(){function d(d,e){e=e||b.createElement(a[d]||"div"),d="on"+d;var f=d in e;return f||(e.setAttribute||(e=b.createElement("div")),e.setAttribute&&e.removeAttribute&&(e.setAttribute(d,""),f=F(e[d],"function"),F(e[d],"undefined")||(e[d]=c),e.removeAttribute(d))),e=null,f}var a={select:"input",change:"input",submit:"form",reset:"form",error:"img",load:"img",abort:"img"};return d}(),B={}.hasOwnProperty,C;!F(B,"undefined")&&!F(B.call,"undefined")?C=function(a,b){return B.call(a,b)}:C=function(a,b){return b in a&&F(a.constructor.prototype[b],"undefined")},Function.prototype.bind||(Function.prototype.bind=function(b){var c=this;if(typeof c!="function")throw new TypeError;var d=w.call(arguments,1),e=function(){if(this instanceof e){var a=function(){};a.prototype=c.prototype;var f=new a,g=c.apply(f,d.concat(w.call(arguments)));return Object(g)===g?g:f}return c.apply(b,d.concat(w.call(arguments)))};return e}),s.flexbox=function(){return J("flexWrap")},s.canvas=function(){var a=b.createElement("canvas");return!!a.getContext&&!!a.getContext("2d")},s.canvastext=function(){return!!e.canvas&&!!F(b.createElement("canvas").getContext("2d").fillText,"function")},s.webgl=function(){return!!a.WebGLRenderingContext},s.touch=function(){var c;return"ontouchstart"in a||a.DocumentTouch&&b instanceof DocumentTouch?c=!0:y(["@media (",n.join("touch-enabled),("),h,")","{#modernizr{top:9px;position:absolute}}"].join(""),function(a){c=a.offsetTop===9}),c},s.geolocation=function(){return"geolocation"in navigator},s.postmessage=function(){return!!a.postMessage},s.websqldatabase=function(){return!!a.openDatabase},s.indexedDB=function(){return!!J("indexedDB",a)},s.hashchange=function(){return A("hashchange",a)&&(b.documentMode===c||b.documentMode>7)},s.history=function(){return!!a.history&&!!history.pushState},s.draganddrop=function(){var a=b.createElement("div");return"draggable"in a||"ondragstart"in a&&"ondrop"in a},s.websockets=function(){return"WebSocket"in a||"MozWebSocket"in a},s.rgba=function(){return D("background-color:rgba(150,255,150,.5)"),G(j.backgroundColor,"rgba")},s.hsla=function(){return D("background-color:hsla(120,40%,100%,.5)"),G(j.backgroundColor,"rgba")||G(j.backgroundColor,"hsla")},s.multiplebgs=function(){return D("background:url(https://),url(https://),red url(https://)"),/(url\s*\(.*?){3}/.test(j.background)},s.backgroundsize=function(){return J("backgroundSize")},s.borderimage=function(){return J("borderImage")},s.borderradius=function(){return J("borderRadius")},s.boxshadow=function(){return J("boxShadow")},s.textshadow=function(){return b.createElement("div").style.textShadow===""},s.opacity=function(){return E("opacity:.55"),/^0.55$/.test(j.opacity)},s.cssanimations=function(){return J("animationName")},s.csscolumns=function(){return J("columnCount")},s.cssgradients=function(){var a="background-image:",b="gradient(linear,left top,right bottom,from(#9f9),to(white));",c="linear-gradient(left top,#9f9, white);";return D((a+"-webkit- ".split(" ").join(b+a)+n.join(c+a)).slice(0,-a.length)),G(j.backgroundImage,"gradient")},s.cssreflections=function(){return J("boxReflect")},s.csstransforms=function(){return!!J("transform")},s.csstransforms3d=function(){var a=!!J("perspective");return a&&"webkitPerspective"in g.style&&y("@media (transform-3d),(-webkit-transform-3d){#modernizr{left:9px;position:absolute;height:3px;}}",function(b,c){a=b.offsetLeft===9&&b.offsetHeight===3}),a},s.csstransitions=function(){return J("transition")},s.fontface=function(){var a;return y('@font-face {font-family:"font";src:url("https://")}',function(c,d){var e=b.getElementById("smodernizr"),f=e.sheet||e.styleSheet,g=f?f.cssRules&&f.cssRules[0]?f.cssRules[0].cssText:f.cssText||"":"";a=/src/i.test(g)&&g.indexOf(d.split(" ")[0])===0}),a},s.generatedcontent=function(){var a;return y(["#",h,"{font:0/0 a}#",h,':after{content:"',l,'";visibility:hidden;font:3px/1 a}'].join(""),function(b){a=b.offsetHeight>=3}),a},s.video=function(){var a=b.createElement("video"),c=!1;try{if(c=!!a.canPlayType)c=new Boolean(c),c.ogg=a.canPlayType('video/ogg; codecs="theora"').replace(/^no$/,""),c.h264=a.canPlayType('video/mp4; codecs="avc1.42E01E"').replace(/^no$/,""),c.webm=a.canPlayType('video/webm; codecs="vp8, vorbis"').replace(/^no$/,"")}catch(d){}return c},s.audio=function(){var a=b.createElement("audio"),c=!1;try{if(c=!!a.canPlayType)c=new Boolean(c),c.ogg=a.canPlayType('audio/ogg; codecs="vorbis"').replace(/^no$/,""),c.mp3=a.canPlayType("audio/mpeg;").replace(/^no$/,""),c.wav=a.canPlayType('audio/wav; codecs="1"').replace(/^no$/,""),c.m4a=(a.canPlayType("audio/x-m4a;")||a.canPlayType("audio/aac;")).replace(/^no$/,"")}catch(d){}return c},s.localstorage=function(){try{return localStorage.setItem(h,h),localStorage.removeItem(h),!0}catch(a){return!1}},s.sessionstorage=function(){try{return sessionStorage.setItem(h,h),sessionStorage.removeItem(h),!0}catch(a){return!1}},s.webworkers=function(){return!!a.Worker},s.applicationcache=function(){return!!a.applicationCache},s.svg=function(){return!!b.createElementNS&&!!b.createElementNS(r.svg,"svg").createSVGRect},s.inlinesvg=function(){var a=b.createElement("div");return a.innerHTML="<svg/>",(a.firstChild&&a.firstChild.namespaceURI)==r.svg},s.smil=function(){return!!b.createElementNS&&/SVGAnimate/.test(m.call(b.createElementNS(r.svg,"animate")))},s.svgclippaths=function(){return!!b.createElementNS&&/SVGClipPath/.test(m.call(b.createElementNS(r.svg,"clipPath")))};for(var L in s)C(s,L)&&(x=L.toLowerCase(),e[x]=s[L](),v.push((e[x]?"":"no-")+x));return e.input||K(),e.addTest=function(a,b){if(typeof a=="object")for(var d in a)C(a,d)&&e.addTest(d,a[d]);else{a=a.toLowerCase();if(e[a]!==c)return e;b=typeof b=="function"?b():b,typeof f!="undefined"&&f&&(g.className+=" "+(b?"":"no-")+a),e[a]=b}return e},D(""),i=k=null,function(a,b){function k(a,b){var c=a.createElement("p"),d=a.getElementsByTagName("head")[0]||a.documentElement;return c.innerHTML="x<style>"+b+"</style>",d.insertBefore(c.lastChild,d.firstChild)}function l(){var a=r.elements;return typeof a=="string"?a.split(" "):a}function m(a){var b=i[a[g]];return b||(b={},h++,a[g]=h,i[h]=b),b}function n(a,c,f){c||(c=b);if(j)return c.createElement(a);f||(f=m(c));var g;return f.cache[a]?g=f.cache[a].cloneNode():e.test(a)?g=(f.cache[a]=f.createElem(a)).cloneNode():g=f.createElem(a),g.canHaveChildren&&!d.test(a)?f.frag.appendChild(g):g}function o(a,c){a||(a=b);if(j)return a.createDocumentFragment();c=c||m(a);var d=c.frag.cloneNode(),e=0,f=l(),g=f.length;for(;e<g;e++)d.createElement(f[e]);return d}function p(a,b){b.cache||(b.cache={},b.createElem=a.createElement,b.createFrag=a.createDocumentFragment,b.frag=b.createFrag()),a.createElement=function(c){return r.shivMethods?n(c,a,b):b.createElem(c)},a.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+l().join().replace(/\w+/g,function(a){return b.createElem(a),b.frag.createElement(a),'c("'+a+'")'})+");return n}")(r,b.frag)}function q(a){a||(a=b);var c=m(a);return r.shivCSS&&!f&&!c.hasCSS&&(c.hasCSS=!!k(a,"article,aside,figcaption,figure,footer,header,hgroup,nav,section{display:block}mark{background:#FF0;color:#000}")),j||p(a,c),a}var c=a.html5||{},d=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,e=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,f,g="_html5shiv",h=0,i={},j;(function(){try{var a=b.createElement("a");a.innerHTML="<xyz></xyz>",f="hidden"in a,j=a.childNodes.length==1||function(){b.createElement("a");var a=b.createDocumentFragment();return typeof a.cloneNode=="undefined"||typeof a.createDocumentFragment=="undefined"||typeof a.createElement=="undefined"}()}catch(c){f=!0,j=!0}})();var r={elements:c.elements||"abbr article aside audio bdi canvas data datalist details figcaption figure footer header hgroup mark meter nav output progress section summary time video",shivCSS:c.shivCSS!==!1,supportsUnknownElements:j,shivMethods:c.shivMethods!==!1,type:"default",shivDocument:q,createElement:n,createDocumentFragment:o};a.html5=r,q(b)}(this,b),e._version=d,e._prefixes=n,e._domPrefixes=q,e._cssomPrefixes=p,e.mq=z,e.hasEvent=A,e.testProp=function(a){return H([a])},e.testAllProps=J,e.testStyles=y,e.prefixed=function(a,b,c){return b?J(a,b,c):J(a,"pfx")},g.className=g.className.replace(/(^|\s)no-js(\s|$)/,"$1$2")+(f?" js "+v.join(" "):""),e}(this,this.document),function(a,b,c){function d(a){return"[object Function]"==o.call(a)}function e(a){return"string"==typeof a}function f(){}function g(a){return!a||"loaded"==a||"complete"==a||"uninitialized"==a}function h(){var a=p.shift();q=1,a?a.t?m(function(){("c"==a.t?B.injectCss:B.injectJs)(a.s,0,a.a,a.x,a.e,1)},0):(a(),h()):q=0}function i(a,c,d,e,f,i,j){function k(b){if(!o&&g(l.readyState)&&(u.r=o=1,!q&&h(),l.onload=l.onreadystatechange=null,b)){"img"!=a&&m(function(){t.removeChild(l)},50);for(var d in y[c])y[c].hasOwnProperty(d)&&y[c][d].onload()}}var j=j||B.errorTimeout,l=b.createElement(a),o=0,r=0,u={t:d,s:c,e:f,a:i,x:j};1===y[c]&&(r=1,y[c]=[]),"object"==a?l.data=c:(l.src=c,l.type=a),l.width=l.height="0",l.onerror=l.onload=l.onreadystatechange=function(){k.call(this,r)},p.splice(e,0,u),"img"!=a&&(r||2===y[c]?(t.insertBefore(l,s?null:n),m(k,j)):y[c].push(l))}function j(a,b,c,d,f){return q=0,b=b||"j",e(a)?i("c"==b?v:u,a,b,this.i++,c,d,f):(p.splice(this.i++,0,a),1==p.length&&h()),this}function k(){var a=B;return a.loader={load:j,i:0},a}var l=b.documentElement,m=a.setTimeout,n=b.getElementsByTagName("script")[0],o={}.toString,p=[],q=0,r="MozAppearance"in l.style,s=r&&!!b.createRange().compareNode,t=s?l:n.parentNode,l=a.opera&&"[object Opera]"==o.call(a.opera),l=!!b.attachEvent&&!l,u=r?"object":l?"script":"img",v=l?"script":u,w=Array.isArray||function(a){return"[object Array]"==o.call(a)},x=[],y={},z={timeout:function(a,b){return b.length&&(a.timeout=b[0]),a}},A,B;B=function(a){function b(a){var a=a.split("!"),b=x.length,c=a.pop(),d=a.length,c={url:c,origUrl:c,prefixes:a},e,f,g;for(f=0;f<d;f++)g=a[f].split("="),(e=z[g.shift()])&&(c=e(c,g));for(f=0;f<b;f++)c=x[f](c);return c}function g(a,e,f,g,h){var i=b(a),j=i.autoCallback;i.url.split(".").pop().split("?").shift(),i.bypass||(e&&(e=d(e)?e:e[a]||e[g]||e[a.split("/").pop().split("?")[0]]),i.instead?i.instead(a,e,f,g,h):(y[i.url]?i.noexec=!0:y[i.url]=1,f.load(i.url,i.forceCSS||!i.forceJS&&"css"==i.url.split(".").pop().split("?").shift()?"c":c,i.noexec,i.attrs,i.timeout),(d(e)||d(j))&&f.load(function(){k(),e&&e(i.origUrl,h,g),j&&j(i.origUrl,h,g),y[i.url]=2})))}function h(a,b){function c(a,c){if(a){if(e(a))c||(j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}),g(a,j,b,0,h);else if(Object(a)===a)for(n in m=function(){var b=0,c;for(c in a)a.hasOwnProperty(c)&&b++;return b}(),a)a.hasOwnProperty(n)&&(!c&&!--m&&(d(j)?j=function(){var a=[].slice.call(arguments);k.apply(this,a),l()}:j[n]=function(a){return function(){var b=[].slice.call(arguments);a&&a.apply(this,b),l()}}(k[n])),g(a[n],j,b,n,h))}else!c&&l()}var h=!!a.test,i=a.load||a.both,j=a.callback||f,k=j,l=a.complete||f,m,n;c(h?a.yep:a.nope,!!i),i&&c(i)}var i,j,l=this.yepnope.loader;if(e(a))g(a,0,l,0);else if(w(a))for(i=0;i<a.length;i++)j=a[i],e(j)?g(j,0,l,0):w(j)?B(j):Object(j)===j&&h(j,l);else Object(a)===a&&h(a,l)},B.addPrefix=function(a,b){z[a]=b},B.addFilter=function(a){x.push(a)},B.errorTimeout=1e4,null==b.readyState&&b.addEventListener&&(b.readyState="loading",b.addEventListener("DOMContentLoaded",A=function(){b.removeEventListener("DOMContentLoaded",A,0),b.readyState="complete"},0)),a.yepnope=k(),a.yepnope.executeStack=h,a.yepnope.injectJs=function(a,c,d,e,i,j){var k=b.createElement("script"),l,o,e=e||B.errorTimeout;k.src=a;for(o in d)k.setAttribute(o,d[o]);c=j?h:c||f,k.onreadystatechange=k.onload=function(){!l&&g(k.readyState)&&(l=1,c(),k.onload=k.onreadystatechange=null)},m(function(){l||(l=1,c(1))},e),i?k.onload():n.parentNode.insertBefore(k,n)},a.yepnope.injectCss=function(a,c,d,e,g,i){var e=b.createElement("link"),j,c=i?h:c||f;e.href=a,e.rel="stylesheet",e.type="text/css";for(j in d)e.setAttribute(j,d[j]);g||(n.parentNode.insertBefore(e,n),m(c,0))}}(this,document),Modernizr.load=function(){yepnope.apply(window,[].slice.call(arguments,0))};
;// Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

// loads up livereload for dev
var loadReload = function() {

    var lr = document.createElement("script");
        lr.type = "text/javascript";
        lr.src = "//localhost:35729/livereload.js";

    if (jQuery('#global_footer')) {
        jQuery('#global_footer').append(lr);
        console.log('livereload is locked and loaded!!');
    }
}
;jQuery(document).ready(function($){

	//var localDev = true;
	
	//if(localDev == true) {
	//	loadReload();
	//	$('body').css('opacity', '1');
	//}

	$('.search_icon, .mobile_search').click(function(e) {
		e.preventDefault();
		$('.header_search_box').fadeToggle();
	});
	
	$('.mobile_nav_btn').click(function(e){
		e.preventDefault();
		if($(this).hasClass('mm-open') == false) {
			$('.mobile-nav').animate({
				left: '0px'
			}, function(){
				$(this).addClass('mm-open');
				$('body,html').addClass('noscroll');
			});
		} else {
			$('.mobile-nav').animate({
				left: '-999px'
			});
		}
	});
	
	$('.close').click(function(e){
		e.preventDefault();
		$('.mobile-nav').animate({
			left: '-999px'
		});
		$('.mobile_nav_btn').removeClass('mm-open');
		$('body,html').removeClass('noscroll');
	});
	
	var collectionID;
	
	$('.main_menu > li').mouseenter(function() {
		collectionID = $(this).attr('class').split(' ');
		collectionID = collectionID[0];
		$('.header_collections').removeClass('dropdown_open');
		$('#' + collectionID).addClass('dropdown_open');
		$('.main_menu > li').removeClass('menu_arrow');
		if($('#' + collectionID).length) {
			$(this).addClass('menu_arrow');
		}
		$('.header_dropdown').css('display', 'block');
	});
	
	$('.top_nav').mouseenter(function(){
		$('.header_dropdown').css('display', 'none');
		$('.main_menu > li').removeClass('menu_arrow');
	});
	
	$('.header_dropdown').mouseleave(function(){
		$(this).css('display', 'none');
		$(this).removeClass('dropdown_open');
		$('.main_menu > li').removeClass('menu_arrow');
		$('.header_collections').removeClass('dropdown_open');
	});
	
	var mySwiper = new Swiper('.swiper-container' ,{
		effect : 'fade',
		pagination: '.swiper-pagination',
		paginationClickable: true,
		nextButton: '.swiper-button-next',
		prevButton: '.swiper-button-prev',
		speed: 500,
		autoplay: 5000, 
		preloadImages: true,
		loop: true
	});
	
	$('.column h2').click(function(e){
		if($(this).hasClass('js-filter-open') == false) {
			$(this).siblings('.column_row').slideDown(500, function(){
				$(this).siblings('h2').addClass('js-filter-open');
			});
		} else {
			$(this).siblings('.column_row').slideUp(500, function(){
				$(this).siblings('h2').removeClass('js-filter-open');
			});
		}
	});
	
	$(window).resize(function(){
		var windowWidth = $(window).width();
		
		if(windowWidth > 782) {
			$('.column_row').css('display', 'block');
		} else if(windowWidth < 782) {
			$('.column_row').css('display', 'none');
			$('.last_column .column_row').css('display', 'block');
		}
		
	});

	$('#slider-range').noUiSlider({
		start: [ $('#min_price').val(), $('#max_price').val() ],
		range: {
			'min': 330,
			'max': 66000
		},

		format: wNumb({
			decimals: 0,
			thousand: ',',
			prefix: '$',
		})
	});

	$("#slider-range").Link('lower').to( $('#min_price') );
	$("#slider-range").Link('upper').to( $('#max_price') );
	

	$('.cat_filter a').click(function(e){
		e.preventDefault();
		if(!$(this).hasClass('filter_open')) {
			$('.cat_filter a').addClass('filter_open');
			$('.cat_filter .filters').slideDown();
			$('.cat_filter .arrow').removeClass('down');
		} else {
			$('.cat_filter a').removeClass('filter_open');
			$('.cat_filter .filters').slideUp();
			$('.cat_filter .arrow').addClass('down');
		}
	});

	if ($('.wish-list-product a.remove').length) {
		$('.wish-list-product a.remove').click( function(e) {
			e.preventDefault();
			var productToRemove = $(e.target).data('product-id');
			removeWishListItem(productToRemove);
			$('.product-id-'+productToRemove).remove();
			var newCount = parseInt($('.wish-list-count').text()) - 1;
			$('.wish-list-count').text(newCount);
		});			
	}
	
	if($('.js_add_to_wish_list').length) {
		
		$(".js_add_to_wish_list").click( function(e) {
			e.preventDefault();
		
			if($(this).hasClass('selected')) { // Remove item from list
				if(getCookie("wishlist")) { 
					var productToRemove = $(this).data('product-id');
					removeWishListItem(productToRemove);
					$('a[data-product-id='+productToRemove+']').removeClass('selected');
						
				} else {
					alert("Error: Invalid Cookie Data (no items to remove)")
				}
			} else { // Move on and add to the list..
				var newProductId = $(this).data('product-id');

				// do we have a cookie?	
				if(getCookie("wishlist")) {
					// Read current items
					var currentItems = JSON.parse(getCookie('wishlist'));

					// check if the new ID already exists in the list and it's not a invalid request..
					if (($.inArray(newProductId, currentItems) == -1) && (typeof newProductId !== "undefined")) {
						
						if(currentItems.length < 7){
							// add to the list
							currentItems.push(newProductId);
							setCookie("wishlist", JSON.stringify(currentItems), 365);
							$('a[data-product-id='+newProductId+']').addClass('selected');

							if(!$(".right_menu a:contains(Wish List)").parent().hasClass('has-wishlist-items')) {
								$(".right_menu a:contains(Wish List)").parent().addClass('has-wishlist-items');
							}
						} else {
							alert("You can only have up to 7 items in your wishlist. Please remove one before adding this item.");
						}
					}
				} else {
					// initialize cookie and add the first product..
					setCookie("wishlist", JSON.stringify([newProductId]), 365);
					$('a[data-product-id='+newProductId+']').addClass('selected');
					$(".right_menu a:contains(Wish List)").parent().addClass('has-wishlist-items');
				}
			}
		});	
	}

	$('#gform_3 .gform_fields li, #gform_4 .gform_fields li, #gform_5 .gform_fields li').each(function() {
		var label = $(this).find('label').text().replace(':', '');
		$(this).find('input, textarea').attr('placeholder', label);
	});

	$('.filters .column_row label').on('click', function() {
		if (!$(this).hasClass('checked')) {
			$(this).addClass('checked');
			$(this).prev().prop('checked', true);
		} else {
			$(this).removeClass('checked');
			$(this).prev().prop('checked', false);
		}
	});

	$('.reset_filters').on('click', function() {
		$('.filters .column_row label').removeClass('checked');
		$('.filters .column_row label').prev().prop('checked', false);
		
		$('#center_stone option[selected="selected"]').each(
			    function() {
			        $(this).removeAttr('selected');
			    }
			);
		$("#center_stone option:first").attr('selected','selected');
		$('#min_price').val("$330");
		$('#max_price').val("$66,000");
		$("#slider-range").val([330, 66000]);
	});
	
	$('#radius_in_submit .slp_ui_button').val('GO');
	$('.slp_ui_button').css('display', 'block');
	
	$('.gfield select').each(function(e) {
	    var selectID = $(this).attr('id');
	    var selectName = $(this).attr('name');
	    $('#'+selectID).ddslick({
	        width: '100%',
	        background: '#ffffff',
	        onSelected: function(data){
	            $('#'+selectID+' .dd-selected-value').attr('name', selectName);
	        }
	    });
	});
	
	/*
	var onlineDeskText = $('.footer_col.service ul.menu li.online_desk a').text();
	$('.footer_col.service ul.menu li.online_desk').empty();
	$('.footer_col.service .online_desk_link a').html(onlineDeskText);
	$('.footer_col.service .online_desk_link').appendTo($('.footer_col.service ul.menu li.online_desk'));
	$('.footer_col.service .online_desk_link').css('display', 'block');
	*/

});

function setCookie(name, value, days) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = escape(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return unescape(c.substring(nameEQ.length, c.length));
    }
    return null;
}

function removeWishListItem(productToRemove) {
	var currentItems = JSON.parse(getCookie('wishlist'));

	currentItems = removeItem(currentItems, productToRemove);
	setCookie("wishlist", JSON.stringify(currentItems), 365);

	if(currentItems.length == 0){
		jQuery(".right_menu a:contains(Wish List)").parent().removeClass('has-wishlist-items');
	}
}

function removeItem(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}
;jQuery(document).ready(function($) {
	
	/*var productID;
	
	var load_related_product = function() {
		$.ajax({
			type		: "GET",
			data		: {action: "load_related_products", product_id: productID},
			dataType	: "html",
			url			: ajaxObject.ajaxurl,
			beforeSend	: function() {
				loading = true;
			},
			success		: function(data) {
				$data = $(data);
				if($data.length){  
                    $('#product_ajax_wrapper').empty();
                    $('#product_ajax_wrapper').append($data); 
                    $data.fadeIn(0, function(){  
                        $("#temp_load").remove();  
                        loading = false;  
                    });
                    //$data.insertAfter('.related_products_links');
                } else {  
                    $("#temp_load").remove();
                } 
			},
			error		: function(jqXHR, textStatus, errorThrown) {
				$("#temp_load").remove();  
				alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
			}
		});
	};*/
	
	$('.related_product_links a').click(function(e) {
		e.preventDefault();
		
		if(!$(this).hasClass('active')) {
			$('.related_product_links a.active').removeClass('active');
			$(this).addClass('active');
			
			var productType = $(this).attr('href').replace('#', '');
			
			$('.product_type_container').css('display', 'none');
			$('#product-'+productType).css('display', 'block');
			$('#product-'+productType+' .yith_magnifier_gallery .first').trigger('click');
		}
	});
});