"use strict";(self.webpackChunkrishiExports_name_=self.webpackChunkrishiExports_name_||[]).push([[4],{2934:function(e,t,n){n.r(t),n.d(t,{mount:function(){return d}});var r=n(9307),a=n(9567),i=n.n(a),o=n(5736);function c(e,t){return function(e){if(Array.isArray(e))return e}(e)||function(e,t){var n=null==e?null:"undefined"!=typeof Symbol&&e[Symbol.iterator]||e["@@iterator"];if(null!=n){var r,a,i=[],_n=!0,o=!1;try{for(n=n.call(e);!(_n=(r=n.next()).done)&&(i.push(r.value),!t||i.length!==t);_n=!0);}catch(e){o=!0,a=e}finally{try{_n||null==n.return||n.return()}finally{if(o)throw a}}return i}}(e,t)||function(e,t){if(e){if("string"==typeof e)return l(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(e):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?l(e,t):void 0}}(e,t)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function l(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n];return r}var s=function(e){var t=e.initialStatus,n=(e.url,e.pluginUrl),a=(e.pluginLink,c((0,r.useState)("installed"),2)),l=a[0],s=a[1],u=c((0,r.useState)(!1),2),m=u[0],f=u[1],d=(0,r.useRef)(null);return(0,r.useEffect)((function(){s(t)}),[]),React.createElement("div",{className:"rt-rishi-plugin-inner",ref:d},React.createElement("button",{onClick:function(){d.current.closest(".notice-rishi-plugin").parentNode.removeChild(d.current.closest(".notice-rishi-plugin")),i().ajax(ajaxurl,{type:"POST",data:{action:"rishi__cb_customizer_dismissed_notice_handler"}})},type:"button",className:"notice-dismiss"},React.createElement("span",{className:"screen-reader-text"},(0,o.__)("Dismiss this notice.","rishi"))),React.createElement("span",{className:"rt-notification-icon"},React.createElement("svg",{xmlns:"http://www.w3.org/2000/svg",width:"55",height:"55",viewBox:"0 0 55 55"},React.createElement("defs",null,React.createElement("linearGradient",{id:"linear-gradient",x1:"1.267",y1:"-1.25",x2:"-0.263",y2:"0.648",gradientUnits:"objectBoundingBox"},React.createElement("stop",{offset:"0.509","stop-color":"#fff"}),React.createElement("stop",{offset:"1","stop-color":"#1c64d1"}))),React.createElement("g",{id:"Group_2","data-name":"Group 2",transform:"translate(-839 -851)"},React.createElement("g",{id:"Ellipse_1","data-name":"Ellipse 1",transform:"translate(839 851)",fill:"#1c64d1",stroke:"#1c64d1",strokeWidth:"1"},React.createElement("circle",{cx:"27.5",cy:"27.5",r:"27.5",stroke:"none"}),React.createElement("circle",{cx:"27.5",cy:"27.5",r:"27",fill:"none"})),React.createElement("g",{id:"site_logo","data-name":"site logo",transform:"translate(854 864)"},React.createElement("path",{id:"Path_6","data-name":"Path 6",d:"M18.1,21.629,0,0V29.393H24.594Z",fill:"#fff"}),React.createElement("path",{id:"Path_7","data-name":"Path 7",d:"M24.494,11.11a11.141,11.141,0,0,1-6.469,10.118L0,0H13.5a10.968,10.968,0,0,1,7.764,3.264A11.2,11.2,0,0,1,24.494,11.11Z",fill:"#fff"}),React.createElement("g",{id:"Group_1","data-name":"Group 1",opacity:"0.7"},React.createElement("path",{id:"Path_8","data-name":"Path 8",d:"M18.112,21.63h0L.014,0V22.64H13.569q.211,0,.422-.008-.211.008-.423.008H.013v6.752H24.607Z",transform:"translate(-0.002 0)",fill:"#fff","fill-rule":"evenodd"}),React.createElement("path",{id:"Path_9","data-name":"Path 9",d:"M24.482,11.112a11.144,11.144,0,0,1-3.227,7.849,11.072,11.072,0,0,1-3.239,2.271L0,0H13.494a10.959,10.959,0,0,1,7.76,3.264A11.209,11.209,0,0,1,24.482,11.112Z",fill:"url(#linear-gradient)"})))))),React.createElement("div",{className:"rt-notification-content"},React.createElement("h2",null,(0,o.__)("Thank you for installing Rishi Theme!","rishi")),React.createElement("p",{dangerouslySetInnerHTML:{__html:(0,o.__)("We strongly recommend you to activate <b>Rishi Companion</b> plugin to get access to features like extensions, demo starter templates and many other essential features.","rishi")}}),React.createElement("div",{className:"notice-actions"},null,React.createElement("button",{className:"button button-primary",disabled:m||"active"===l,onClick:function(){f(!0),setTimeout((function(){})),i().ajax(ajaxurl,{type:"POST",data:{action:"rishi__cb_customizer_notice_button_click"}}).then((function(e){var t=e.success,r=e.data;t&&(s(r.status),"active"===r.status&&location.assign(n)),f(!1)}))}},m?(0,o.__)("Installing & activating...","rishi"):"uninstalled"===l?(0,o.__)("Install Rishi Companion","rishi"):"installed"===l?(0,o.__)("Activate Rishi Companion","rishi"):(0,o.__)("Rishi Companion active!","rishi"),m&&React.createElement("i",{className:"dashicons dashicons-update"})))))};function u(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n];return r}var m=function(e){var t,n,a=e.redirectURL,c=e.nonceToken,l=(t=(0,r.useState)(!1),n=2,function(e){if(Array.isArray(e))return e}(t)||function(e,t){var n=null==e?null:"undefined"!=typeof Symbol&&e[Symbol.iterator]||e["@@iterator"];if(null!=n){var r,a,i=[],_n=!0,o=!1;try{for(n=n.call(e);!(_n=(r=n.next()).done)&&(i.push(r.value),!t||i.length!==t);_n=!0);}catch(e){o=!0,a=e}finally{try{_n||null==n.return||n.return()}finally{if(o)throw a}}return i}}(t,n)||function(e,t){if(e){if("string"==typeof e)return u(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(e):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?u(e,t):void 0}}(t,n)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()),s=(l[0],l[1]),m=(0,r.useRef)(null);return React.createElement("div",{className:"rt-rishi-plugin-inner",ref:m},React.createElement("div",{className:"rt-notification-content"},React.createElement("p",null,(0,o.__)("To receive the automatic notifications of the new version in your dashboard and to enjoy latest features of Rishi Theme, activate this feature. ","rishi"),React.createElement("a",{href:"#",className:"activate-primary",onClick:function(){setTimeout((function(){})),i().ajax(ajaxurl,{type:"POST",data:{action:"rishi_activate_license_updates",nonceToken:c}}).then((function(e){var t=e.success,n=e.data;t?"valid"===n.license&&(s(n.message),location.assign(a)):s(n.message)}))}},(0,o.__)("Activate","rishi")))))};function f(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n];return r}var d=function(e){var t;e.querySelector(".notice-rishi-plugin-root")&&(0,r.render)(React.createElement(s,{initialStatus:e.querySelector(".notice-rishi-plugin-root").dataset.pluginStatus,url:e.querySelector(".notice-rishi-plugin-root").dataset.url,pluginUrl:e.querySelector(".notice-rishi-plugin-root").dataset.pluginUrl,pluginLink:e.querySelector(".notice-rishi-plugin-root").dataset.link}),e.querySelector(".notice-rishi-plugin-root")),e.querySelector(".notice-rishi-theme-activation-root")&&(0,r.render)(React.createElement(m,{redirectURL:e.querySelector(".notice-rishi-theme-activation-root").dataset.link,nonceToken:e.querySelector(".notice-rishi-theme-activation-root").dataset.nonce}),e.querySelector(".notice-rishi-theme-activation-root")),(t=document.querySelectorAll("[data-dismiss]"),function(e){if(Array.isArray(e))return f(e)}(t)||function(e){if("undefined"!=typeof Symbol&&null!=e[Symbol.iterator]||null!=e["@@iterator"])return Array.from(e)}(t)||function(e,t){if(e){if("string"==typeof e)return f(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(e):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?f(e,t):void 0}}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()).map((function(e){e.addEventListener("click",(function(t){t.preventDefault(),e.closest(".notice-rishi-woo-deprecation").remove(),i().ajax(ajaxurl,{type:"POST",data:{action:"rishi__cb_customizer_dismissed_notice_woo_deprecation"}})}))}))}}}]);