jQuery( document ).ready(function($) {
	
	
	jQuery( 'a.import-demo-thumb' ).click(function() {
		
		jQuery('.import-demo-data-layout a').removeClass('import-demo-thumb-active');
		jQuery(this).addClass('import-demo-thumb-active');
		
		var layout = jQuery(this).data('layout');
		jQuery( 'input#import-layout-color' ).val(layout);
		return false;
	});
	
	
}); // document.ready END