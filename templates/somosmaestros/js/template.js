//var jQuery = jQuery.noConflict();
jQuery(document).ready(function($) {
	var h3_1 =jQuery(".moduletablemodulo-musica h3");
	var txtMod1 = jQuery(".moduletablemodulo-musica h3").text();
	h3_1.html('<span>'+txtMod1+'</span>');

	var h3_2 =jQuery(".moduletablemodulo-arte h3");
	var txtMod2 = jQuery(".moduletablemodulo-arte h3").text();
	h3_2.html('<span>'+txtMod2+'</span>');

	var h3_3 =jQuery(".moduletablemodulo-otras h3");
	var txtMod3 = jQuery(".moduletablemodulo-otras h3").text();
	h3_3.html('<span>'+txtMod3+'</span>');


	jQuery('#bxslider').bxSlider({
		mode: 'fade',
		captions: true,
		resize: true
	});	

});

