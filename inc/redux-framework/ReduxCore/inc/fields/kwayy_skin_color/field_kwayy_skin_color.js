jQuery( document ).ready(function($) {
	jQuery( '.thememount-skin-color-list a' ).click(function() {
		color = jQuery(this).css('background-color');
		jQuery('.redux-container-thememount_skin_color .redux-color-init').iris('color', color);
		return false;
	});
});
