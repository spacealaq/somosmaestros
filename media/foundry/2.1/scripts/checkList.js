(function(){var e=function(e){var t=this,n=function(){e.fn.checkList=function(t){var n={checkbox:".checkbox",masterCheckbox:".master-checkbox",check:function(){},uncheck:function(){},change:function(){}},t=e.extend({},n,t),r=this,i=r.find(t.checkbox),s=r.find(t.masterCheckbox),o=!1,u=function(){if(!o){var e=i.filter(":checked"),n=i.not(":checked");e.length<1&&s.removeAttr("checked"),e.length==i.length&&s.attr("checked",!0),t.change.call(r,e,n)}};return i.checked(function(){t.check.apply(r),u()},function(){t.uncheck.apply(r),u()}),s.checked(function(){o=!0,i.checked(!0),o=!1,u()},function(){o=!0,i.checked(!1),o=!1,u()}),this}};n(),t.resolveWith(n)};dispatch("checkList").containing(e).to("Foundry/2.1 Modules")})();