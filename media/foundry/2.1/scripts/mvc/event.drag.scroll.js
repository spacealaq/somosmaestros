(function(){var e=function(e){var t=this;e.require().script("mvc/event.drop").done(function(){var n=function(){e.Drag.prototype.scrolls=function(t,n){var t=e(t);for(var r=0;r<t.length;r++)this.constructor.responder._elements.push(t.eq(r).data("_dropData",new e.Scrollable(t[r],n))[0])},e.Scrollable=function(t,n){this.element=e(t),this.options=e.extend({distance:30,delta:function(e,t){return(t-e)/2},direction:"xy"},n),this.x=this.options.direction.indexOf("x")!=-1,this.y=this.options.direction.indexOf("y")!=-1},e.extend(e.Scrollable.prototype,{init:function(t){this.element=e(t)},callHandlers:function(e,t,n,r){this[e](t||this.element[0],n,this,r)},dropover:function(){},dropon:function(){this.clear_timeout()},dropout:function(){this.clear_timeout()},dropinit:function(){},dropend:function(){},clear_timeout:function(){this.interval&&(clearTimeout(this.interval),this.interval=null)},distance:function(e){return(30-e)/2},dropmove:function(t,n,r,i){this.clear_timeout();var s=n.vector(),o=e(t==document.documentElement?window:t),u=o.dimensionsv("outer"),a=o.offsetv(),f=a.y()+u.y()-s.y(),l=s.y()-a.y(),c=a.x()+u.x()-s.x(),h=s.x()-a.x(),p=0,d=0,v=this.options.distance;f<v&&this.y?d=this.options.delta(f,v):l<v&&this.y&&(d=-this.options.delta(l,v)),c<v&&this.options&&this.x?p=this.options.delta(c,v):h<v&&this.x&&(p=-this.options.delta(h,v));if(p||d){var m=this;this.interval=setTimeout(function(){m.move(e(t),i.movingElement,p,d,n,n.clientX,n.clientY,n.screenX,n.screenY)},15)}},move:function(t,n,r,i,s){t.scrollTop(t.scrollTop()+i),t.scrollLeft(t.scrollLeft()+r),n.trigger(e.event.fix({type:"mousemove",clientX:s.clientX,clientY:s.clientY,screenX:s.screenX,screenY:s.screenY,pageX:s.pageX,pageY:s.pageY}))}})};n(),t.resolveWith(n)})};dispatch("mvc/event.drag.scroll").containing(e).to("Foundry/2.1 Modules")})();