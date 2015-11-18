!function(t,i,s,n){function e(n,e){this.options=t.extend({},o,e),this._container=t(this.options.items),this._container.length&&(this.jQwindow=t(i),this.jQdocument=t(s),this._holder=t(n),this._nav={},this._first=t(this.options.first),this._prev=t(this.options.prev),this._next=t(this.options.next),this._last=t(this.options.last),this._items=this._container.children(":visible"),this._itemsShowing=t([]),this._itemsHiding=t([]),this._numPages=Math.ceil(this._items.length/this.options.perPage),this._currentPageNum=this.options.startPage,this._clicked=!1,this._cssAnimSupport=this.getCSSAnimationSupport(),this.init())}var a="pagination",h=null,o={items:"",first:!1,prev:"Prev",next:"Next",last:!1,links:"numeric",startPage:1,perPage:5,midRange:10,startRange:1,endRange:1,keyBrowse:!1,scrollBrowse:!1,pause:0,clickStop:!1,delay:50,direction:"forward",animation:"",fallback:500,minHeight:!1,callback:n};e.prototype={constructor:e,getCSSAnimationSupport:function(){var t=!1,i="animation",s="",e="Webkit Moz O ms Khtml".split(" "),a="",h=this._container.get(0);if(h.style.animationName&&(t=!0),t===!1)for(var o=0;o<e.length;o++)if(h.style[e[o]+"AnimationName"]!==n){a=e[o],i=a+"Animation",s="-"+a.toLowerCase()+"-",t=!0;break}return t},init:function(){this.setStyles(),this.setNav(),this.paginate(this._currentPageNum),this.setMinHeight()},setStyles:function(){var i="<style>.gts-pagination-invisible { visibility: hidden !important; } .gts-pagination-hidden { display: none !important; }</style>";t(i).appendTo("head"),this._cssAnimSupport&&this.options.animation.length?this._items.addClass("animated gts-pagination-hidden"):this._items.hide()},setNav:function(){var i=this.writeNav();this._holder.each(this.bind(function(s,n){var e=t(n);e.html(i),this.cacheNavElements(e,s),this.bindNavHandlers(s),this.disableNavSelection(n)},this)),this.options.keyBrowse&&this.bindNavKeyBrowse(),this.options.scrollBrowse&&this.bindNavScrollBrowse()},writeNav:function(){var t,i=1;for(t=this.writeBtn("first")+this.writeBtn("prev");i<=this._numPages;i++){switch(1===i&&0===this.options.startRange&&(t+="<span>...</span>"),t+=i>this.options.startRange&&i<=this._numPages-this.options.endRange?"<a href='#' class='gts-pagination-hidden'>":"<a>",this.options.links){case"numeric":t+=i;break;case"blank":break;case"title":var s=this._items.eq(i-1).attr("data-title");t+=s!==n?s:""}t+="</a>",(i===this.options.startRange||i===this._numPages-this.options.endRange)&&(t+="<span>...</span>")}return t+=this.writeBtn("next")+this.writeBtn("last")+"</div>"},writeBtn:function(i){return this.options[i]===!1||t(this["_"+i]).length?"":"<a class='gts-pagination-"+i+"'>"+this.options[i]+"</a>"},cacheNavElements:function(i,s){this._nav[s]={},this._nav[s].holder=i,this._nav[s].first=this._first.length?this._first:this._nav[s].holder.find("a.gts-pagination-first"),this._nav[s].prev=this._prev.length?this._prev:this._nav[s].holder.find("a.gts-pagination-prev"),this._nav[s].next=this._next.length?this._next:this._nav[s].holder.find("a.gts-pagination-next"),this._nav[s].last=this._last.length?this._last:this._nav[s].holder.find("a.gts-pagination-last"),this._nav[s].fstBreak=this._nav[s].holder.find("span:first"),this._nav[s].lstBreak=this._nav[s].holder.find("span:last"),this._nav[s].pages=this._nav[s].holder.find("a").not(".gts-pagination-first, .gts-pagination-prev, .gts-pagination-next, .gts-pagination-last"),this._nav[s].permPages=this._nav[s].pages.slice(0,this.options.startRange).add(this._nav[s].pages.slice(this._numPages-this.options.endRange,this._numPages)),this._nav[s].pagesShowing=t([]),this._nav[s].currentPage=t([])},bindNavHandlers:function(i){var s=this._nav[i];s.holder.bind("click.pagination",this.bind(function(i){var n=this.getNewPage(s,t(i.target));this.validNewPage(n)&&(this._clicked=!0,this.paginate(n)),i.preventDefault()},this)),this._first.length&&this._first.bind("click.pagination",this.bind(function(){this.validNewPage(1)&&(this._clicked=!0,this.paginate(1))},this)),this._prev.length&&this._prev.bind("click.pagination",this.bind(function(){var t=this._currentPageNum-1;this.validNewPage(t)&&(this._clicked=!0,this.paginate(t))},this)),this._next.length&&this._next.bind("click.pagination",this.bind(function(){var t=this._currentPageNum+1;this.validNewPage(t)&&(this._clicked=!0,this.paginate(t))},this)),this._last.length&&this._last.bind("click.pagination",this.bind(function(){this.validNewPage(this._numPages)&&(this._clicked=!0,this.paginate(this._numPages))},this))},disableNavSelection:function(t){"undefined"!=typeof t.onselectstart?t.onselectstart=function(){return!1}:"undefined"!=typeof t.style.MozUserSelect?t.style.MozUserSelect="none":t.onmousedown=function(){return!1}},bindNavKeyBrowse:function(){this.jQdocument.bind("keydown.pagination",this.bind(function(t){var i=t.target.nodeName.toLowerCase();if(this.elemScrolledIntoView()&&"input"!==i&&"textarea"!=i){var s=this._currentPageNum;37==t.which&&(s=this._currentPageNum-1),39==t.which&&(s=this._currentPageNum+1),this.validNewPage(s)&&(this._clicked=!0,this.paginate(s))}},this))},elemScrolledIntoView:function(){var t,i,s,n;return t=this.jQwindow.scrollTop(),i=t+this.jQwindow.height(),s=this._container.offset().top,n=s+this._container.height(),n>=t&&i>=s},bindNavScrollBrowse:function(){this._container.bind("mousewheel.pagination DOMMouseScroll.pagination",this.bind(function(t){var i=(t.originalEvent.wheelDelta||-t.originalEvent.detail)>0?this._currentPageNum-1:this._currentPageNum+1;return this.validNewPage(i)&&(this._clicked=!0,this.paginate(i)),t.preventDefault(),!1},this))},getNewPage:function(t,i){return i.is(t.currentPage)?this._currentPageNum:i.is(t.pages)?t.pages.index(i)+1:i.is(t.first)?1:i.is(t.last)?this._numPages:i.is(t.prev)?t.pages.index(t.currentPage):i.is(t.next)?t.pages.index(t.currentPage)+2:void 0},validNewPage:function(t){return t!==this._currentPageNum&&t>0&&t<=this._numPages},paginate:function(i){var s,n;s=this.updateItems(i),n=this.updatePages(i),this._currentPageNum=i,t.isFunction(this.options.callback)&&this.callback(i,s,n),this.updatePause()},updateItems:function(t){var i=this.getItemRange(t);return this._itemsHiding=this._itemsShowing,this._itemsShowing=this._items.slice(i.start,i.end),this._cssAnimSupport&&this.options.animation.length?this.cssAnimations(t):this.jQAnimations(t),i},getItemRange:function(t){var i={};return i.start=(t-1)*this.options.perPage,i.end=i.start+this.options.perPage,i.end>this._items.length&&(i.end=this._items.length),i},cssAnimations:function(t){clearInterval(this._delay),this._itemsHiding.removeClass(this.options.animation+" gts-pagination-invisible").addClass("gts-pagination-hidden"),this._itemsShowing.removeClass("gts-pagination-hidden").addClass("gts-pagination-invisible"),this._itemsOriented=this.getDirectedItems(t),this._index=0,this._delay=setInterval(this.bind(function(){this._index===this._itemsOriented.length?clearInterval(this._delay):this._itemsOriented.eq(this._index).removeClass("gts-pagination-invisible").addClass(this.options.animation),this._index=this._index+1},this),this.options.delay)},jQAnimations:function(t){clearInterval(this._delay),this._itemsHiding.addClass("gts-pagination-hidden"),this._itemsShowing.fadeTo(0,0).removeClass("gts-pagination-hidden"),this._itemsOriented=this.getDirectedItems(t),this._index=0,this._delay=setInterval(this.bind(function(){this._index===this._itemsOriented.length?clearInterval(this._delay):this._itemsOriented.eq(this._index).fadeTo(this.options.fallback,1),this._index=this._index+1},this),this.options.delay)},getDirectedItems:function(i){var s;switch(this.options.direction){case"backwards":s=t(this._itemsShowing.get().reverse());break;case"random":s=t(this._itemsShowing.get().sort(function(){return Math.round(Math.random())-.5}));break;case"auto":s=i>=this._currentPageNum?this._itemsShowing:t(this._itemsShowing.get().reverse());break;default:s=this._itemsShowing}return s},updatePages:function(t){var i,s,n;i=this.getInterval(t);for(s in this._nav)this._nav.hasOwnProperty(s)&&(n=this._nav[s],this.updateBtns(n,t),this.updateCurrentPage(n,t),this.updatePagesShowing(n,i),this.updateBreaks(n,i));return i},getInterval:function(t){var i,s,n,e;return i=Math.ceil(this.options.midRange/2),s=this._numPages-this.options.midRange,n=t>i?Math.max(Math.min(t-i,s),0):0,e=t>i?Math.min(t+i-(this.options.midRange%2>0?1:0),this._numPages):Math.min(this.options.midRange,this._numPages),{start:n,end:e}},updateBtns:function(t,i){1===i&&(t.first.addClass("gts-pagination-disabled"),t.prev.addClass("gts-pagination-disabled")),i===this._numPages&&(t.next.addClass("gts-pagination-disabled"),t.last.addClass("gts-pagination-disabled")),1===this._currentPageNum&&i>1&&(t.first.removeClass("gts-pagination-disabled"),t.prev.removeClass("gts-pagination-disabled")),this._currentPageNum===this._numPages&&i<this._numPages&&(t.next.removeClass("gts-pagination-disabled"),t.last.removeClass("gts-pagination-disabled"))},updateCurrentPage:function(t,i){t.currentPage.removeClass("gts-pagination-current"),t.currentPage=t.pages.eq(i-1).addClass("gts-pagination-current")},updatePagesShowing:function(t,i){var s=t.pages.slice(i.start,i.end).not(t.permPages);t.pagesShowing.not(s).addClass("gts-pagination-hidden"),s.not(t.pagesShowing).removeClass("gts-pagination-hidden"),t.pagesShowing=s},updateBreaks:function(t,i){i.start>this.options.startRange||0===this.options.startRange&&i.start>0?t.fstBreak.removeClass("gts-pagination-hidden"):t.fstBreak.addClass("gts-pagination-hidden"),i.end<this._numPages-this.options.endRange?t.lstBreak.removeClass("gts-pagination-hidden"):t.lstBreak.addClass("gts-pagination-hidden")},callback:function(t,i,s){var n={current:t,interval:s,count:this._numPages},e={showing:this._itemsShowing,oncoming:this._items.slice(i.start+this.options.perPage,i.end+this.options.perPage),range:i,count:this._items.length};n.interval.start=n.interval.start+1,e.range.start=e.range.start+1,this.options.callback(n,e)},updatePause:function(){if(this.options.pause&&this._numPages>1){if(clearTimeout(this._pause),this.options.clickStop&&this._clicked)return;this._pause=setTimeout(this.bind(function(){this.paginate(this._currentPageNum!==this._numPages?this._currentPageNum+1:1)},this),this.options.pause)}},setMinHeight:function(){this.options.minHeight&&!this._container.is("table, tbody")&&setTimeout(this.bind(function(){this._container.css({"min-height":this._container.css("height")})},this),1e3)},bind:function(t,i){return function(){return t.apply(i,arguments)}},destroy:function(){this.jQdocument.unbind("keydown.pagination"),this._container.unbind("mousewheel.pagination DOMMouseScroll.pagination"),this.options.minHeight&&this._container.css("min-height",""),this._cssAnimSupport&&this.options.animation.length?this._items.removeClass("animated gts-pagination-hidden gts-pagination-invisible "+this.options.animation):this._items.removeClass("gts-pagination-hidden").fadeTo(0,1),this._holder.unbind("click.pagination").empty()}},t.fn[a]=function(i){var s=t.type(i);return"object"===s?(this.length&&!t.data(this,a)&&(h=new e(this,i),this.each(function(){t.data(this,a,h)})),this):"string"===s&&"destroy"===i?(h.destroy(),this.each(function(){t.removeData(this,a)}),this):"number"===s&&i%1===0?(h.validNewPage(i)&&h.paginate(i),this):this}}(jQuery,window,document);