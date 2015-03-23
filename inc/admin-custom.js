/**
 * Functionality specific to Howes admin panel.
 *
 * Provides helper functions to enhance the admin experience.
 */

jQuery( document ).ready(function() {
	"use strict";
	
	// Redux: Remove loader on document.ready
	jQuery(".redux-main").css('background','#FCFCFC');
	
	// Redux: Add class for special option
	jQuery( '.redux-container-thememount_one_click_demo_content' ).parent().parent().addClass('thememount-special-toption');
	
	// Disable to un-check the FontAwesome library
	jQuery("#howes_fonticonlibrary_fontawesome_0").attr("disabled","true");
	jQuery("#howes_fonticonlibrary_fontawesome_0").prop('checked', true);
	
	// Redux: Adding thumb images for background gradient patterns
	var html = '<div class="thememount-bg-pattern-wrapper"> \
	<ul> \
	<li class="thememount-bg-pattern-1"><a href="#"></a></li> \
	<li class="thememount-bg-pattern-2"><a href="#"></a></li> \
	<li class="thememount-bg-pattern-3"><a href="#"></a></li> \
	<li class="thememount-bg-pattern-4"><a href="#"></a></li> \
	<li class="thememount-bg-pattern-5"><a href="#"></a></li> \
	<li class="thememount-bg-pattern-6"><a href="#"></a></li> \
	<li class="thememount-bg-pattern-7"><a href="#"></a></li> \
	<li class="thememount-bg-pattern-8"><a href="#"></a></li> \
	<li class="thememount-bg-pattern-9"><a href="#"></a></li> \
	<li class="thememount-bg-pattern-10"><a href="#"></a></li> \
	</ul> \
	</div>';
	jQuery("#opt-background-position-select").after(html);
	
	
	
	
	jQuery(".thememount-bg-pattern-wrapper li a").click(function(){
		var Class = jQuery(this).parent().attr('class');
		//console.log(Class);
		var number = Class.replace('thememount-bg-pattern-','');
		console.log(number);
		return false;
	});
	
	
	// Remove extra BR tag from sidebar option on pages
	var sliderPosWrapper = jQuery('#_thememount_page_options_sidebarposition_').parent();
	jQuery("br", sliderPosWrapper).remove();
	
	// Set width of sidebar options
	jQuery('#_thememount_page_options_sidebarposition_').parent().attr('id', 'thememount_page_options_sidebarposition_wrapper');
	
	
	
	// Icon dropdown in menu
	jQuery("select.edit-menu-item-icon").custom_select2(); 
	jQuery('a.item-edit').on("click",function(){
	//jQuery('a.item-edit').click(function(){
		//alert('TT');
		jQuery("select.edit-menu-item-icon").custom_select2(); 
	});
	
	// Skin Color picker
	if( jQuery('.redux-container-thememount_skin_color .redux-color').length > 0 ){
		jQuery('.redux-container-thememount_skin_color .redux-color').wpColorPicker();
	}
	
	// Page Options
	thememount_pages_slder_options();
	thememount_post_hide_breadcrumb_options('page');
	jQuery('input[name="cuztom[_thememount_page_options_slidertype][]"]:radio').change(function(e) {
		thememount_pages_slder_options();
	});
	jQuery('input[name="cuztom[_thememount_page_options_hidetitlebar]"]').change(function(e) {
		thememount_post_hide_breadcrumb_options('page');
	});
	
	// Post Options
	thememount_post_hide_breadcrumb_options('post');
	jQuery('input[name="cuztom[_thememount_post_options_hidetitlebar]"]').change(function(e) {
		thememount_post_hide_breadcrumb_options('post');
	});
	
	/** Page Titlebar: Background Image **/
	jQuery('select[name="cuztom[_thememount_page_options_titlebar_bg_image]"]').change(function(e){
		thememount_breadcrumb_image_option('page');
	});
	jQuery('select[name="cuztom[_thememount_post_options_titlebar_bg_image]"]').change(function(e){
		thememount_breadcrumb_image_option('post');
	});
	
	
	
	// Portfolio Options
	thememount_portfolio_slder_options();
	jQuery('input[name="cuztom[_thememount_portfolio_featured_featuredtype][]"]:radio').change(function(e) {
		//console.log('1');
		thememount_portfolio_slder_options();
		//console.log('2');
	});
	
	// Post Options
	thememount_post_hide_breadcrumb_options('post');
	jQuery('input[name="cuztom[_thememount_post_options_hidetitlebar]"]').change(function(e) {
		thememount_post_hide_breadcrumb_options('post');
	});
	
	// Skin Selector
	if( jQuery('.thememount-skin-color-list').length != 0 ){
		jQuery( '.thememount-skin-color-list a' ).click(function() {
			//console.log('TTTT');
			var color = jQuery(this).css('background-color');
			//console.log(color);
			jQuery('.redux-container-thememount_skin_color .redux-color-init').iris('color', color);
			return false;
		});
	}
	
	
	
	// Increase or decrease Header height on click of the Header icons
	
	jQuery('fieldset[data-id="headerstyle"] .redux-image-select img').click(function(){
		//console.log('Header click');
		
		//var tBarHeight    = jQuery('input[name="howes[tbar-height]"]').val();
		var normalHeight  = '141';
		var overlayHeight = '400';
		
		/*if( tBarHeight==normalHeight || tBarHeight==overlayHeight ){*/
		
			var headerID = jQuery(this).parent().attr('for');
			headerID     = headerID.replace('headerstyle_','');
			//console.log(headerID);
			
			/*if( (headerID=='1' || headerID=='2' || headerID=='3') && tBarHeight==overlayHeight ){
				jQuery('div[data-id="tbar-height"]').val(normalHeight);
				jQuery('#tbar-height').val(normalHeight);  // Fallback mode
			} else if( (headerID=='4' || headerID=='5' || headerID=='6' || headerID=='7') && tBarHeight!=normalHeight ){
				jQuery('div[data-id="tbar-height"]').val(overlayHeight);
				jQuery('#tbar-height').val(overlayHeight);  // Fallback mode
			}*/
			
			if( (headerID=='1' || headerID=='2' || headerID=='3') ){
				jQuery('div[data-id="tbar-height"]').val(normalHeight);
				jQuery('#tbar-height').val(normalHeight);  // Fallback mode
			} else if( (headerID=='4' || headerID=='5' || headerID=='6' || headerID=='7') ){
				jQuery('div[data-id="tbar-height"]').val(overlayHeight);
				jQuery('#tbar-height').val(overlayHeight);  // Fallback mode
			}
		/*}*/
	});

});





/* Options show/hide for Post Type: Pages */
function thememount_pages_slder_options(){
	selected = jQuery('input[name="cuztom[_thememount_page_options_slidertype][]"]:checked').val();
	//console.log(selected);
	
	// Hide all options by default
	jQuery('select[name="cuztom[_thememount_page_options_revslider_slider]"]').parent().parent().hide();
	jQuery('select[name="cuztom[_thememount_page_options_slidercat]"]').parent().parent().hide();
	jQuery('input[name="cuztom[_thememount_page_options_slidersize][]"]').parent().parent().parent().hide();
	
	if( selected == 'revslider' ){
		jQuery('select[name="cuztom[_thememount_page_options_revslider_slider]"]').parent().parent().show();
		jQuery('select[name="cuztom[_thememount_page_options_slidercat]"]').parent().parent().hide();
		jQuery('input[name="cuztom[_thememount_page_options_slidersize][]"]').parent().parent().parent().show();
	} else if( selected == 'nivo' || selected == 'flex' ){
		jQuery('select[name="cuztom[_thememount_page_options_revslider_slider]"]').parent().parent().hide();
		jQuery('select[name="cuztom[_thememount_page_options_slidercat]"]').parent().parent().show();
		jQuery('input[name="cuztom[_thememount_page_options_slidersize][]"]').parent().parent().parent().show();
	}
}




/* Options show/hide for Post Type: Portfolio */
function thememount_portfolio_slder_options(){
	selected = jQuery('input[name="cuztom[_thememount_portfolio_featured_featuredtype][]"]:checked').val();
	
	// Hide all options by default
	jQuery('textarea[name="cuztom[_thememount_portfolio_featured_videourl]"]').parent().parent().hide(); // YouTube or Video URL
	jQuery('input[name="cuztom[_thememount_portfolio_featured_videofile_mp4]"]').parent().parent().hide(); // SoundCloud Embed Code
	jQuery('input[name="cuztom[_thememount_portfolio_featured_videofile_webm]"]').parent().parent().hide(); // SoundCloud Embed Code
	jQuery('input[name="cuztom[_thememount_portfolio_featured_videofile_ogv]"]').parent().parent().hide(); // SoundCloud Embed Code
	jQuery('textarea[name="cuztom[_thememount_portfolio_featured_audiocode]"]').parent().parent().hide(); // SoundCloud Embed Code
	jQuery('input[name="cuztom[_thememount_portfolio_featured_audiofile_mp3]"]').parent().parent().hide(); // SoundCloud Embed Code
	jQuery('input[name="cuztom[_thememount_portfolio_featured_audiofile_wav]"]').parent().parent().hide(); // SoundCloud Embed Code
	jQuery('input[name="cuztom[_thememount_portfolio_featured_audiofile_oga]"]').parent().parent().hide(); // SoundCloud Embed Code
	
	// Hide all images for slider
	for (var i = 1; i <= 10; i++) { jQuery('*[name="cuztom[_thememount_portfolio_featured_slideimage'+i+']"]').parent().parent().hide(); /* SoundCloud Embed Code */ }
	
	
	if( selected == 'video' ){
		jQuery('textarea[name="cuztom[_thememount_portfolio_featured_videourl]"]').parent().parent().show(); // YouTube or Video URL
	} else if( selected == 'videoplayer' ){
		jQuery('input[name="cuztom[_thememount_portfolio_featured_videofile_mp4]"]').parent().parent().show(); // SoundCloud Embed Code
		jQuery('input[name="cuztom[_thememount_portfolio_featured_videofile_webm]"]').parent().parent().show(); // SoundCloud Embed Code
		jQuery('input[name="cuztom[_thememount_portfolio_featured_videofile_ogv]"]').parent().parent().show(); // SoundCloud Embed Code
	} else if( selected == 'audioembed' ){
		jQuery('textarea[name="cuztom[_thememount_portfolio_featured_audiocode]"]').parent().parent().show(); // SoundCloud Embed Code
	} else if( selected == 'audioplayer' ){
		jQuery('input[name="cuztom[_thememount_portfolio_featured_audiofile_mp3]"]').parent().parent().show(); // SoundCloud Embed Code
		jQuery('input[name="cuztom[_thememount_portfolio_featured_audiofile_wav]"]').parent().parent().show(); // SoundCloud Embed Code
		jQuery('input[name="cuztom[_thememount_portfolio_featured_audiofile_oga]"]').parent().parent().show(); // SoundCloud Embed Code
	} else if( selected == 'slider' ){
		// Hide all images for slider
		for (var i = 1; i <= 10; i++) { jQuery('*[name="cuztom[_thememount_portfolio_featured_slideimage'+i+']"]').parent().parent().show(); /* SoundCloud Embed Code */ }
	}
}


jQuery(window).load(function(){
	
	
	
	// Showing image upload box on LOAD
	if( jQuery('#cf-post-format-tabs > ul > li > a.current').attr('href')=='#post-format-gallery' ){
		jQuery('#thememount_post_gallery').show();
	} else {
		jQuery('#thememount_post_gallery').hide();
	}
	
	// Showing image uppload box on CLICK
	jQuery('#cf-post-format-tabs > ul > li > a').click(function(){
		if( jQuery(this).attr('href') == '#post-format-gallery' ){
			jQuery('#thememount_post_gallery').show();
		} else {
			jQuery('#thememount_post_gallery').hide();
		}
	});
	
});













/* POST: Hide Breadcrumb options */
function thememount_post_hide_breadcrumb_options( postType ){
	if( postType=='undefined' ){
		postType = 'page';
	}
	
	if( jQuery('input[name="cuztom[_thememount_'+postType+'_options_hidetitlebar]"]').length > 0 ){
		if( jQuery('input[name="cuztom[_thememount_'+postType+'_options_hidetitlebar]"]').is(':checked') ){
			jQuery('textarea[name="cuztom[_thememount_'+postType+'_options_title]"]').parent().parent().hide(); // Post Title
			jQuery('textarea[name="cuztom[_thememount_'+postType+'_options_subtitle]"]').parent().parent().hide(); // Post Sub Title
			jQuery('input[name="cuztom[_thememount_'+postType+'_options_hidebreadcrumb]"]').parent().parent().parent().hide(); // Hide Breadcrumb
			
			// Titlebar Background Image
			if( jQuery('select[name="cuztom[_thememount_'+postType+'_options_titlebar_bg_image]"]') ){
				jQuery('select[name="cuztom[_thememount_'+postType+'_options_titlebar_bg_image]"]').closest( "tr" ).hide();
			}
			
			// Upload Titlebar Background Image
			if( jQuery('select[name="cuztom[_thememount_'+postType+'_options_titlebar_bg_image_custom]"]') ){
				jQuery('input[name="cuztom[_thememount_'+postType+'_options_titlebar_bg_image_custom]"]').closest( "tr" ).hide();
			}
			
		} else {
			jQuery('textarea[name="cuztom[_thememount_'+postType+'_options_title]"]').parent().parent().show(); // Post Title
			jQuery('textarea[name="cuztom[_thememount_'+postType+'_options_subtitle]"]').parent().parent().show(); // Post Sub Title
			jQuery('input[name="cuztom[_thememount_'+postType+'_options_hidebreadcrumb]"]').parent().parent().parent().show(); // Hide Breadcrumb
			
			// Titlebar Background Image
			if( jQuery('select[name="cuztom[_thememount_'+postType+'_options_titlebar_bg_image]"]') ){
				jQuery('select[name="cuztom[_thememount_'+postType+'_options_titlebar_bg_image]"]').closest( "tr" ).show();
			}
			thememount_breadcrumb_image_option(postType);  // Show/hide image upload box for background
		}
	}
}

function thememount_breadcrumb_image_option(postType){
	console.log('Hii');
	// Custom Background image for Titlebar
	if( jQuery('select[name="cuztom[_thememount_'+postType+'_options_titlebar_bg_image]"]').length > 0 ){
		if( jQuery('select[name="cuztom[_thememount_'+postType+'_options_titlebar_bg_image]"]').val() == 'custom' ){
			jQuery('input[name="cuztom[_thememount_'+postType+'_options_titlebar_bg_image_custom]"]').closest( "tr" ).show();
		} else {
			jQuery('input[name="cuztom[_thememount_'+postType+'_options_titlebar_bg_image_custom]"]').closest( "tr" ).hide();
		}
	}
}