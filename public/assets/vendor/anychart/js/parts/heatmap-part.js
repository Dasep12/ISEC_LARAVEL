if(!_.heatmap_part){_.heatmap_part=1;(function($){var iO=function(a){$.MA.call(this,a)},jO=function(a,b,c){if(c){var d=b==$.hm?"normal":b==$.Ao?"hover":"select";b=a.o(d+"X");var e=a.o(d+"Y"),f=a.o(d+"Width");a=a.o(d+"Height");a=new $.I(b,e,f,a);c.rect.Pf(a);c.hatchRect.Pf(a)}},kO=function(a,b,c,d,e){$.vB.call(this,a,b,c,d,e);$.Pu(this.Qa().labels(),"same");this.Qa().labels().kb(this);this.b=$.dm("stroke",2,!0);this.ca.Fm("stroke",[1024,65,4294967295])},lO=function(a,b,c,d,e){if(a=a.hA([a.Qa().labels,a.lb().labels,a.selected().labels],[],["label",
"hoverLabel","selectLabel"],a.gE(),!0,null,b,c,!1))if(c=$.Vu(a),c.adjustByHeight||c.adjustByHeight){var f=b.o(d+"Width");b=b.o(d+"Height");d=(new $.Iu).N(c.padding);f-=d.g("left")+d.g("right");b-=d.g("top")+d.g("bottom");$.pd(d);b=$.kv(a,f,b,c.minFontSize,c.maxFontSize,c.adjustByWidth,c.adjustByHeight);e=Math.min(e||window.Infinity,b)}return e},mO=function(a,b){$.UB.call(this,!1);this.Ga("heatMap");this.re="heat-map";this.ta("defaultSeriesType","heat-map");this.Sa=this.Ae(this.g("defaultSeriesType"),
a||null,b);$.T(this.ua,[["labelsDisplayMode",32768,1,0,function(){this.Sa.B(256)}]])},nO=function(a,b){var c={},d=0,e=a.values(),f=[];if(e)for(var h=0;h<e.length;h++){var k=e[h],l=a.transform(k,0),m=a.transform(k,1);if(!b||1>=Math.min(l,m)&&0<=Math.max(l,m))c[$.vo(k)]=d++,f.push(String(k))}return{values:c,names:f}},oO=function(a,b){var c=new mO(a,b);c.aP(c.vf("colorScale"),c.au());c.Wg();c.$c();return c};$.H(iO,$.MA);$.VG[30]=iO;$.g=iO.prototype;$.g.type=30;$.g.flags=512;$.g.Mp=["y"];
$.g.Hh={rect:"rect",hatchRect:"rect"};$.g.ug=function(a,b){var c=this.bd.ed(b);jO(a,b,c)};$.g.OB=function(a,b){var c=a.o("shapes");jO(a,b,c)};$.H(kO,$.vB);$.g=kO.prototype;$.g.oQ=1.3E-5;$.g.mF={"%XValue":"x"};$.g.Ta=function(a){var b=this.ya.Ta(a);return $.n(a)?this:b};
$.g.IQ=function(){var a=this.Qa().labels(),b=this.lb().labels(),c=this.selected().labels(),d=a.enabled(),e=d||b.enabled(),f=d||c.enabled(),h=a.bC();e=(h||b.bC())&&e;f=(h||c.bC())&&f;h=d&&h;var k,l;d=k=l=window.NaN;$.VN(a,null);$.VN(b,null);$.VN(c,null);if(h||e||f){var m=this.$();for(m.reset();m.advance();)m.o("missing")||(h&&(d=lO(this,m,$.hm,"normal",d)),e&&(k=lO(this,m,$.Ao,"hover",k)),f&&(l=lO(this,m,$.Bo,"select",l)))}h?$.VN(a,d):$.VN(a,null);e?$.VN(b,k):$.VN(b,null);f?$.VN(c,l):$.VN(c,null)};
$.g.qha=function(a,b,c,d){b=a.o("left");var e=a.o("right");c=a.o("top");var f=a.o("bottom"),h=this.b(this,$.hm),k=this.b(this,$.Ao),l=this.b(this,$.Bo);h=$.cc(h)/2;k=$.cc(k)/2;l=$.cc(l)/2;e-=b;f-=c;a.o("normalX",b+h);a.o("normalY",c+h);a.o("normalWidth",e-h-h);a.o("normalHeight",f-h-h);a.o("hoverX",b+k);a.o("hoverY",c+k);a.o("hoverWidth",e-k-k);a.o("hoverHeight",f-k-k);a.o("selectX",b+l);a.o("selectY",c+l);a.o("selectWidth",e-l-l);a.o("selectHeight",f-l-l);return d};
$.g.ND=function(a){var b=this.rl(),c=this.bb(),d=a.get("x"),e=a.get("y"),f=b.transform(d,0),h=b.transform(d,1),k=c.transform(e,0);c=c.transform(e,1);if(0>f&&0>h||0>k&&0>c||1<f&&1<h||1<k&&1<c)return!1;var l=Math.round(this.Re(f,!0)),m=Math.round(this.Re(k,!1)),p=Math.round(this.Re(h,!0)),q=Math.round(this.Re(c,!1));k=this.i/2;f=this.f/2;e=Math.min(l,p);l=Math.max(l,p);p=Math.min(m,q);m=Math.max(m,q);e+=Math.ceil(k);p+=Math.floor(f);l-=1==h?Math.ceil(k):Math.floor(k);m-=1==c?Math.floor(f):Math.ceil(f);
a.o("left",e);a.o("top",p);a.o("right",l);a.o("bottom",m);a.o("x",b.transform(d,.5));return!0};$.g.TI=function(a,b){this.Uj.length=0;this.Uj.push(this.qha);var c=this.$();for(c.reset();c.advance();)this.RA(c,a,b);this.Uj.length=0};$.g.hG=function(a){var b=this.$(),c=b.o("left"),d=b.o("top"),e=b.o("right");b=b.o("bottom");a=$.Jo(new $.I(c,d,e-c,b-d),a);a.x=Math.floor(a.x);a.y=Math.floor(a.y);return a};
$.g.tf=function(a,b,c){var d=this.ya.g("labelsDisplayMode"),e=this.hA([this.Qa().labels,this.lb().labels,this.selected().labels],[],["label","hoverLabel","selectLabel"],this.gE(),!0,null,a,b,!1);if(e){var f=b==$.hm?"normal":b==$.Ao?"hover":"select";b=a.o(f+"X");var h=a.o(f+"Y"),k=a.o(f+"Width");f=a.o(f+"Height");h=$.nn(b,h,k,f);b=this.Qa().labels();"drop"==d&&(k=$.Vu(e),k.width=null,k.height=null,k=b.measure(e.Gf(),e.jc(),k),h.left>k.left+.5||h.cb()<k.cb()-.5||h.top>k.top+.5||h.Ua()<k.Ua()-.5)&&(b.clear(e.ma()),
e=null);e&&((d="always-show"==d?this.ga:$.ob(this.ga,h))?(e.clip(d),c&&e.W()):b.clear(e.ma()))}a.o("label",e)};$.g.PX=function(a,b,c,d,e,f,h){$.cv(a,$.so([h,0,f,$.oo,d,0,c,$.oo,a,$.oo,f||c,$.qo,f,$.po,a,$.qo,c,$.po]))};$.g.jE=function(){var a=this.wc();a=$.Ga(a.Yg,a.Zg);for(var b=0,c=0,d=0,e=a.length;d<e;d++){var f=a[d];if(f&&f.enabled()){var h=$.cc(f.g("stroke"));f.Nb()?h>c&&(c=h):h>b&&(b=h)}}this.i=b;this.f=c;kO.u.jE.call(this)};
$.g.N_=function(a){var b=this.ga,c=b.Ua()-this.Pp().bottom();b=b.Vb()+this.Pp().top();return $.Za(a,b,c)};$.g.wS=function(){return[this,this.wc()]};$.g.RT=function(){return{}};
$.g.vm=function(a,b){var c={chart:{value:this.wc(),type:""},series:{value:this,type:""},scale:{value:this.Ra(),type:""},index:{value:b.ma(),type:"number"},x:{value:b.get("x"),type:"string"},y:{value:b.get("y"),type:"string"},heat:{value:b.get("heat"),type:"number"},seriesName:{value:this.name(),type:"string"}},d=this.wc().kd();if(d){var e=b.get("heat");if($.J(d,$.iz)){var f=d.Cn(e);f&&(c.colorRange={value:{color:f.color,end:f.end,name:f.name,start:f.start,index:f.sourceIndex},type:""});c.color={value:d.Pq(e),
type:""}}}return c};$.g.He=function(a,b,c){b=kO.u.He.call(this,a,b,c);c=$.pv(b);var d=b.lg();c.x={value:d.get("x"),type:"string"};c.y={value:d.get("y"),type:"string"};c.heat={value:d.get("heat"),type:"number"};var e;a=a||this.g("color")||"blue";var f=this.wc().kd();f&&(d=d.get("heat"),$.n(d)&&(e=f.Pq(d)),c.scaledColor={value:e,type:""});c.colorScale={value:f,type:""};c.sourceColor={value:e||a,type:""};return $.qv(b,c)};var pO=kO.prototype;pO.tooltip=pO.Ta;$.H(mO,$.UB);mO.prototype.sa=$.UB.prototype.sa|-2147483648;var qO={};qO["heat-map"]={Fb:30,Kb:2,Lb:[{name:"rect",Qb:"rect",Yb:"fill",Zb:"stroke",ac:!0,Ib:!1,zIndex:0},{name:"hatchRect",Qb:"rect",Yb:"hatchFill",Zb:null,ac:!0,Ib:!0,zIndex:1E-6}],Ob:null,Jb:null,Cb:$.WG|5767168,Ab:"y",zb:"y"};mO.prototype.fj=qO;var rO=["normal","hovered","selected"],sO=["data","tooltip"];
(function(){function a(a,b){for(var c=[],d=1;d<arguments.length;d++)c.push(arguments[d]);d=this.zi(0);d=d[a].apply(d,c);return $.n(c[0])?this:d}for(var b=0;b<rO.length;b++){var c=rO[b];mO.prototype[c]=$.qa(a,c)}})();$.Jq(mO,["fill","stroke","hatchFill","labels","markers"],"normal");var tO={};$.uq(tO,0,"labelsDisplayMode",$.XN);$.U(mO,tO);$.g=mO.prototype;$.g.Rs=function(){return"heat-map"};$.g.Tv=function(a){return this.tj()?null:mO.u.Tv.call(this,a)};
$.g.Ft=function(a,b){return new kO(this,this,a,b,!0)};$.g.xA=function(){return $.dt};$.g.tD=function(){return["HeatMap chart scale","ordinal"]};$.g.kH=function(){return"ordinal"};$.g.vu=function(){this.Sa.B(1024);this.B(8421376,1)};$.g.kd=function(a){if($.n(a)){if(null===a&&this.vb)this.vb=null,this.B(-2147483136,1);else if(a=$.lt(this.vb,a,null,48,["HeatMap chart color scale","ordinal-color, linear-color"],this.Vp,this)){var b=this.vb==a;this.vb=a;this.vb.da(b);b||this.B(-2147483136,1)}return this}return this.vb};
$.g.Vp=function(a){$.X(a,6)&&this.B(-2147483136,1)};$.g.Ll=function(a){var b,c=[];if("categories"==a){this.ob();var d=this.kd();if(d&&$.J(d,$.iz)){var e=this.Sa,f=d.qr();a=0;for(b=f.length;a<b;a++){var h=f[a];"default"!==h.name&&c.push({text:h.name,iconEnabled:!0,iconType:"square",iconFill:h.color,disabled:!this.enabled(),sourceUid:$.oa(this),sourceKey:a,meta:{X:e,scale:d,xe:h}})}}}return c};$.g.Ls=function(a){return"categories"==a};
$.g.xr=function(a,b){var c=a.o();if("categories"==this.eg().g("itemsSourceMode")){var d=c.X;var e=c.scale;if(e&&d){var f=[];c=c.xe;for(var h=d.Dc();h.advance();){var k=h.get("heat");c==e.Cn(k)&&f.push(h.ma())}if(e=$.xo(b.domTarget))"single"==this.gd().g("hoverMode")?e.fg={X:d,vd:f}:e.fg=[{X:d,vd:f,Kn:f[f.length-1],Ee:{index:f[f.length-1],Sf:0}}]}}};
$.g.vq=function(a,b){var c=a.o();if("categories"==this.eg().g("itemsSourceMode")){var d=c.X;var e=c.scale;if(e&&d){var f=c.xe,h=d.Dc();for(c=[];h.advance();){var k=h.get("heat");f==e.Cn(k)&&c.push(h.ma())}if(e=$.xo(b.domTarget))"single"==this.gd().g("hoverMode")?e.fg={X:d,vd:c}:e.fg=[{X:d,vd:c,Kn:c[c.length-1],Ee:{index:c[c.length-1],Sf:0}}]}}};$.g.uq=function(a,b){var c=a.o();if("categories"==this.eg().g("itemsSourceMode")&&"single"==this.gd().g("hoverMode")){var d=$.xo(b.domTarget);d&&(d.X=c.X)}};
$.g.fG=function(a,b){for(var c=[],d=0,e=a.length;d<e;d++){var f=a[d],h;f.Ee?h={index:f.Ee.index,distance:f.Ee.Sf}:h={index:window.NaN,distance:window.NaN};c.push({series:f.X,points:b?[]:f.vd?$.Ha(f.vd):[],nearestPointToCursor:h})}return c};$.g.TD=function(a,b,c){a=mO.u.TD.call(this,a,b,c);a.series=this;return a};$.g.be=function(a){return this.Sa.be(a)};$.g.Tu=function(){return!0};$.g.Qk=function(){return this.Sa.Qk()};
$.g.VR=function(){var a=this.J(327680);mO.u.VR.call(this);if(a){var b=null,c=null,d=this.bb(),e=this.Ra(),f=$.Ut(e),h=$.Ut(d);if(f||h){if(f){var k=f;b=[]}if(h){var l=h;c=[]}for(var m=this.Sa.Dc();m.advance();){if(f){a=e.Wv(m.get("x"));var p=m.get(k);$.n(b[a])||(b[a]=p||m.get("x")||m.get("heat"))}h&&(a=d.Wv(m.get("y")),p=m.get(l),$.n(c[a])||(c[a]=p||m.get("y")||m.get("heat")))}f&&(e.Nk=b);h&&(d.Nk=c)}this.B(-2147483648)}if(this.J(-2147483648)){if(this.vb&&this.vb.Nf()){this.vb.Ag();m=this.Sa.$();for(m.reset();m.advance();)this.vb.Xc(m.get("heat"));
this.vb.Hg()}this.Sa&&this.Sa.B(2048);this.B(32768);this.I(-2147483648)}};$.g.data=function(a,b){if($.n(a)){if(a){var c=a.title||a.caption;c&&this.title(c);a.rows&&(a=a.rows)}this.Sa.data(a,b);return this}return this.Sa.data()};$.g.Sj=function(a){this.Sa.Sj(a);return this};$.g.select=function(a){this.Sa.select(a);return this};
$.g.xM=function(a){this.ob();var b="selected"==a,c=nO(this.Ra(),b);a=c.values;var d=c.names;c=nO(this.bb(),b);b=c.values;var e=c.names;c=[];for(var f=0;f<e.length;f++)c.push([e[f]]);for(e=this.Sa.bg();e.advance();){f=a[$.vo(e.get("x"))];var h=b[$.vo(e.get("y"))],k=String(e.get("heat"));(0,window.isNaN)(f)||(0,window.isNaN)(h)||(c[h][f+1]=k)}d.unshift("#");return{headers:d,data:c}};
$.g.F=function(){var a=mO.u.F.call(this),b=a.chart;delete b.barsPadding;delete b.barGroupsPadding;delete b.crosshair;delete b.defaultSeriesType;return a};$.g.aP=function(a,b){if($.ea(a))var c=b[a];else $.z(a)?(c=$.ft(a,null))||(c=b[a]):$.C(a)?(c=$.ft(a.type,null))&&c.N(a):c=null;c&&this.kd(c)};$.g.ft=function(a,b,c){this.aP(a.colorScale,b);mO.u.ft.call(this,a,b,c);$.Oq(this,tO,a)};$.g.et=function(a,b,c){mO.u.et.call(this,a,b,c);$.Wq(this,tO,a);$.bA(a,"colorScale",this.kd(),b,c)};
$.g.cP=function(a,b,c){b={};var d=rO,e;for(e=0;e<d.length;e++){var f=d[e];$.n(a[f])&&(b[f]=a[f])}d=sO;for(e=0;e<d.length;e++)f=d[e],$.n(a[f])&&(b[f]=a[f]);this.Sa.U(b,c)};$.g.XO=function(a){var b=this.Sa.F(),c=rO,d;for(d=0;d<c.length;d++){var e=c[d];$.n(b[e])&&(a[e]=b[e])}c=sO;for(d=0;d<c.length;d++)e=c[d],$.n(b[e])&&(a[e]=b[e])};$.g.R=function(){mO.u.R.call(this);this.Sa=null};var uO=mO.prototype;uO.getType=uO.Ma;uO.xGrid=uO.im;uO.yGrid=uO.km;uO.xAxis=uO.Zh;uO.yAxis=uO.ij;uO.xScale=uO.Ra;
uO.yScale=uO.bb;uO.hover=uO.Sj;uO.select=uO.select;uO.unhover=uO.Ld;uO.unselect=uO.ie;uO.data=uO.data;uO.colorScale=uO.kd;uO.xZoom=uO.Sq;uO.yZoom=uO.Tq;uO.xScroller=uO.Lp;uO.yScroller=uO.Rr;uO.annotations=uO.Lk;$.Wp["heat-map"]=oO;$.F("anychart.heatMap",oO);}).call(this,$)}