/**
 * Functionality specific to Howes.
 *
 * Provides helper functions to enhance the theme experience.
 */



/*
 * jQuery resize event - v1.1 - 3/14/2010
 * http://benalman.com/projects/jquery-resize-plugin/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
(function($,h,c){var a=$([]),e=$.resize=$.extend($.resize,{}),i,k="setTimeout",j="resize",d=j+"-special-event",b="delay",f="throttleWindow";e[b]=250;e[f]=true;$.event.special[j]={setup:function(){if(!e[f]&&this[k]){return false}var l=$(this);a=a.add(l);$.data(this,d,{w:l.width(),h:l.height()});if(a.length===1){g()}},teardown:function(){if(!e[f]&&this[k]){return false}var l=$(this);a=a.not(l);l.removeData(d);if(!a.length){clearTimeout(i)}},add:function(l){if(!e[f]&&this[k]){return false}var n;function m(s,o,p){var q=$(this),r=$.data(this,d);r.w=o!==c?o:q.width();r.h=p!==c?p:q.height();n.apply(this,arguments)}if($.isFunction(l)){n=l;return m}else{n=l.handler;l.handler=m}}};function g(){i=h[k](function(){a.each(function(){var n=$(this),m=n.width(),l=n.height(),o=$.data(this,d);if(m!==o.w||l!==o.h){n.trigger(j,[o.w=m,o.h=l])}});g()},e[b])}})(jQuery,this);
 
/* One Page Navigation
	   --------------------------------------------------------- */	
	   
jQuery( document ).ready(function($) {
	
	"use strict";
	
	/*------------------------------------------------------------------------------*/
	/* One Page setting
	/*------------------------------------------------------------------------------*/	
	if( jQuery('body').hasClass('thememount-one-page-site') ){
		var sections = jQuery('.wpb_row, #tm-header-slider'), 
		nav = jQuery('.mega-menu-wrap, .menu-main-menu-container'), 
		nav_height = nav.outerHeight();	
		jQuery(window).on('scroll', function () {
			if(typeof jQuery(this) != 'undefined'){
				var cur_pos = jQuery(this).scrollTop(); 
				sections.each(function() {
					var top = jQuery(this).offset().top - nav_height,
					bottom = top + jQuery(this).outerHeight(); 
	
					if (cur_pos >= top && cur_pos <= bottom) {
						if( typeof jQuery(this) != 'undefined' && typeof jQuery(this).attr('id')!='undefined' && jQuery(this).attr('id')!='' ){
							var mainThis = jQuery(this);							
							nav.find('a').removeClass('mega-current-menu-item mega-current_page_item current-menu-ancestor current-menu-item current_page_item');						
							jQuery(this).addClass('mega-current-menu-item mega-current_page_item current-menu-ancestor current-menu-item current_page_item');
							var arr = mainThis.attr('id');							
							// Applying active class
							jQuery('#navbar a').parent().removeClass('mega-current-menu-item mega-current_page_item current-menu-ancestor current-menu-item current_page_item');
							nav.find('a').each(function(){
								var menuAttr = jQuery(this).attr('href').split('#')[1];						
								if( menuAttr == arr ){
									jQuery(this).parent().addClass('mega-current-menu-item mega-current_page_item current-menu-ancestor current-menu-item current_page_item');
								}
							})							
						}
					}
				});
			}
	});
	
	nav.find('a').on('click', function () {
	var $el = jQuery(this), 
	id = $el.attr('href');
	var arr=id.split('#')[1];	  
		jQuery('html, body').animate({
			scrollTop: jQuery('#'+ arr).offset().top - nav_height
		  }, 500);  
		  return false;
		});
	}	
		
	if( jQuery("div.search_field.by_treatment select").length > 0 ){
		setEmptySelectBox(jQuery("div.search_field.by_treatment select"));
		// Country dropdown on change
		jQuery("div.search_field.by_treatment select").change(function () {
			setEmptySelectBox( jQuery(this) );
		});
	}

	var teamSearchBoxIconOpen   = 'tmicon-' + jQuery('.thememount-fbar-btn > a').data('openicon'); // Open Icon
	var teamSearchBoxIconClosed = 'tmicon-' + jQuery('.thememount-fbar-btn > a').data('closeicon'); // Close Icon
	thememount_hide_gmap();
	jQuery(".thememount-fbar-btn a").click(function(){
		if( jQuery(".thememount-fbar-box-w").css('display')=='none' ){
			jQuery('.thememount-fbar-btn i').removeClass( teamSearchBoxIconOpen ).addClass( teamSearchBoxIconClosed );			
			jQuery(".thememount-fbar-box-w").slideDown('400', function(){
				thememount_reset_gmap();
				jQuery(".thememount-set-gmap").fadeIn(1000);
			});
		} else {
			jQuery('.thememount-fbar-btn i').removeClass( teamSearchBoxIconClosed ).addClass( teamSearchBoxIconOpen );			
			jQuery(".thememount-set-gmap").hide();			
			jQuery(".thememount-fbar-box-w").slideUp();
		}
		return false;
	});	
	
	
	/*------------------------------------------------------------------------------*/
	/* Add plus icon in menu
	/*------------------------------------------------------------------------------*/ 
	//jQuery( "#site-navigation .nav-menu > li.menu-item-has-children, #site-navigation div.nav-menu > ul > li.page_item_has_children, #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal > li.mega-menu-item-has-children" ).append( "<span class='righticon'><i class='tmicon-fa-plus-square'></i></span>" );	
	
	jQuery('#site-navigation .menu-main-menu-container > ul > li:has(ul), #site-navigation .mega-menu-wrap > ul > li:has(ul)').append("<span class='righticon'><i class='tmicon-fa-plus-square'></i></span>");
	
	jQuery('#site-navigation .menu-main-menu-container > ul > li.menu-item-language, #site-navigation .mega-menu-wrap > ul > li.menu-item-language').addClass("mega-menu-item mega-menu-item-type-custom mega-menu-item-object-custom mega-menu-item-has-children mega-menu-item-13 mega-align-bottom-left mega-menu-flyout");
	
	
	jQuery('#site-navigation .mega-menu-wrap > ul > li.menu-item-language').addClass("mega-menu-item mega-menu-item-type-custom mega-menu-item-object-custom mega-menu-item-has-children mega-menu-item-13 mega-align-bottom-left mega-menu-flyout");	
	jQuery('#site-navigation .mega-menu-wrap > ul > li.menu-item-language ul').addClass("mega-sub-menu");
	
		
	jQuery('#navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal > li.menu-item-language > a').show();
	jQuery('#site-navigation .mega-menu-wrap > ul > li.menu-item-language').hover(
         function () {
			 		 
		   jQuery('#navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-menu-flyout .mega-sub-menu').css("display", "none");	
           jQuery(this).find('ul').show();		   
         }, 
         function () {
           jQuery(this).find('ul').hide();
         }
     );
	
	
	
	jQuery('.menu li.current-menu-item').parents('li.mega-menu-megamenu').addClass('mega-current-menu-ancestor');
	jQuery( ".nav-menu > li:eq(-2), #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal > li.mega-menu-item:eq(-2)" ).addClass( "lastsecond" );
	jQuery( ".nav-menu > li:eq(-1), #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal > li.mega-menu-item:eq(-1)" ).addClass( "last" );
	
	
	/*------------------------------------------------------------------------------*/
	/* Social icon
	/*------------------------------------------------------------------------------*/ 
/*	var images = jQuery('.thememount-fullcolum-true img').attr('src');	
	jQuery('.thememount-row-fullwidth-true .thememount-fullcolum-true.vc_column_container').css('background-image', 'url(' + images + ')');*/
	
	
	jQuery(".thememount-row-fullwidth-true.full-colum-height-widht > .grid_section > .vc_column_container img.vc_single_image-img").each(function() {  
       var imgsrc = jQuery(this).attr("src");
	   jQuery(this).parent().parent().parent().parent().parent('.vc_column_container').css('background-image', 'url(' + imgsrc + ')');       
  	});
	

	

	
	
	
	
	
	
	
	
	
	/*------------------------------------------------------------------------------*/
	/* Google Map in Header area
	/*------------------------------------------------------------------------------*/
	function thememount_reset_gmap(){
		jQuery('.thememount-fbar-box-w > div > aside').each(function(){
			var mainthis = jQuery(this);
			jQuery( 'iframe[src^="https://www.google.com/maps/"], iframe[src^="http://www.google.com/maps/"]',mainthis ).each(function(){
				if( !jQuery(this).hasClass('thememount-set-gmap') ){
					jQuery(this).attr('src',jQuery(this).attr('src')+'');
					jQuery(this).load(function(){
						//console.log('iframe loaded');
						jQuery(this).addClass('thememount-set-gmap').animate({opacity: 1 }, 1000 );
					});	

				}
			})
		});
	}
	function thememount_hide_gmap(){
		jQuery('.thememount-fbar-box-w > div > aside').each(function(){
			var mainthis = jQuery(this);
			jQuery( 'iframe[src^="https://www.google.com/maps/"], iframe[src^="http://www.google.com/maps/"]',mainthis ).each(function(){
				if( !jQuery(this).hasClass('thememount-set-gmap') ){
					jQuery(this).css({opacity: 0});
					//jQuery(this).css('visibility', 'hidden');
					jQuery(this).css('display', 'block');
				}
			})
		});
	}	
	
	//.attr('src',myIframe.attr('src')+'');
	
	
	/*------------------------------------------------------------------------------*/
	/* Search form
	/*------------------------------------------------------------------------------*/
	jQuery( ".search_box a" ).click(function() {
		jQuery(".thememount-header-style-3 #stickable-header .headerlogo, body.thememount-header-style-3 header .thememount-topbar").css('z-index', '9');
		jQuery(".tm-header-overlay .thememount-fbar-btn").css('z-index', '9');
		jQuery(".thememount-fbar-btn").css('z-index', '9');
		jQuery(".site-header, .headerblock").css('z-index', '1000000');
		jQuery(".header-controls").css('z-index', '1000000');
		
		
		
	  jQuery(".k_flying_searchform_wrapper #flying_searchform").fadeIn( 400, function() {
		jQuery(".field.searchform-s").focus();		
	  });
	    
	  return false;
	});	
	
	jQuery( ".w-search-close" ).click(function() {	 
	  jQuery(".k_flying_searchform_wrapper #flying_searchform").fadeOut( 400, function() {
		
		
		 jQuery("body.thememount-header-style-3 header .thememount-topbar, .site-header, .headerblock, .header-controls, .thememount-header-style-3 #stickable-header .headerlogo, .tm-header-overlay .thememount-fbar-btn, .thememount-fbar-btn").removeAttr( "style" );
		 

		 
	
		
	  });	 
	  return false;
	}); 
	 	
	 /*------------------------------------------------------------------------------*/
	 /* Applying prettyPhoto to all images
	 /*------------------------------------------------------------------------------*/
	if( typeof jQuery.fn.prettyPhoto == "function" ){
		jQuery('a[href*=".jpg"], a[href*=".jpeg"], a[href*=".png"], a[href*=".gif"]').each(function(){
			if( jQuery(this).attr('target')!='_blank' ){
				jQuery(this).attr('data-rel','prettyPhoto');
			}
		});
		jQuery("a[data-rel^='prettyPhoto']").prettyPhoto();
	}
		

	/*------------------------------------------------------------------------------*/
	/* Animation on scroll: Number rotator
	/*------------------------------------------------------------------------------*/
	$("[data-appear-animation]").each(function() {
		var self      = $(this);
		var animation = self.data("appear-animation");
		var delay     = (self.data("appear-animation-delay") ? self.data("appear-animation-delay") : 0);
		
		if( $(window).width() > 959 ) {
			self.html('0');
			self.waypoint(function(direction) {
				if( !self.hasClass('completed') ){
					var from = self.data('from');
					var to   = self.data('to');
					self.numinate({
						format: '%counter%',
						from: from,
						to: to,
						runningInterval: 2000,
						stepUnit: 5,
						onComplete: function(elem) {
							self.addClass('completed');
						}
					});
				}
			}, { offset:'85%' });
		} else {
			if( animation == 'animateWidth' ) {
				self.css('width', self.data("width"));
			}
		}
	});

	/*------------------------------------------------------------------------------*/
	/* Scroll to Top
	/*------------------------------------------------------------------------------*/
	var offset   = 85;
    var duration = 500;
    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > offset) {
            jQuery("#totop").fadeIn(duration);
        } else {
            jQuery("#totop").fadeOut(duration);
        }
    });
    jQuery("#totop").click(function(event) {
        event.preventDefault();
        jQuery("html, body").animate({scrollTop: 0}, duration);
        return false;
    })
	
	/*------------------------------------------------------------------------------*/
	/* Set height of boxes inside row-column view of Blog and Portfolio
	/*------------------------------------------------------------------------------*/
	if( jQuery('.thememount-testimonial-box' ).length > 0 ){
		setHeight('.thememount-testimonial-box.col-lg-6.col-sm-6.col-md-6');
		setHeight('.thememount-testimonial-box.col-lg-4.col-sm-6.col-md-4');
		setHeight('.thememount-testimonial-box.col-lg-3.col-sm-6.col-md-3');
	}	
	
	/*------------------------------------------------------------------------------*/
	/* Sticky
	/*------------------------------------------------------------------------------*/
	if( jQuery('.masthead-header-stickyOnScroll').length > 0 ){
		//jQuery(".masthead-header-stickyOnScroll").sticky({topSpacing:0});
		tm_sticky();
	}	

	/*------------------------------------------------------------------------------*/
	/* Return Fasle when # Url
	/*------------------------------------------------------------------------------*/
	$('#site-navigation a[href="#"]').click(function(){return false;});	
	
	/*------------------------------------------------------------------------------*/
	/* Tooltip
	/*------------------------------------------------------------------------------*/
	$('.thememount-team-social-links li a').tooltip({'placement': 'top'});
	$('.site-header .social-icons li a').tooltip({'placement': 'bottom'});
	$('.site-footer .social-icons li a').tooltip({'placement': 'bottom'});
	$('.thememount-pf-navbar-wrapper a').tooltip({'placement': 'top'});
	$('.thememount-clients a').tooltip({'placement': 'top'});
	
	/*------------------------------------------------------------------------------*/
	/* Welcome bar close button
	/*------------------------------------------------------------------------------*/
	$(".thememount-close-icon").click(function(){
		$("#page").css('padding-top', (parseInt($("#page").css('padding-top')) - parseInt($(".thememount-wbar").height()) ) + 'px' );
		$(".thememount-wbar").slideUp();
		thememount_setCookie('kw_hidewbar','1',1);
	});
	
	/*------------------------------------------------------------------------------*/
	/* PrettyPhoto
	/*------------------------------------------------------------------------------*/
	jQuery("a[rel^='prettyPhoto']").prettyPhoto();
	//jQuery(".gallery-item .gallery-icon a").prettyPhoto();
	jQuery('.gallery-item .gallery-icon a[href*=".jpg"], .gallery-item .gallery-icon a[href*=".jpeg"], .gallery-item .gallery-icon a[href*=".png"], .gallery-item .gallery-icon a[href*=".gif"]').prettyPhoto();

	/*------------------------------------------------------------------------------*/
	/* Removing BR tag added by shortcode generator
	/*------------------------------------------------------------------------------*/
	var galleryHTML = jQuery(".gallery-size-full br").each(function(){
		jQuery(this).remove();
	});	

	/*------------------------------------------------------------------------------*/
	/* Setting carousel in Clients section
	/*------------------------------------------------------------------------------*/
	jQuery(".thememount-client-view-carousel .thememount-clients").owlCarousel({
		//navigation : false, // Show next and prev buttons
		//pagination: true
	});
	

	/*------------------------------------------------------------------------------*/
	/* Settting for lightbox content in Blog
	/*------------------------------------------------------------------------------*/
	jQuery("a.thememount-open-gallery").click(function(){
		var href   = jQuery(this).attr('href');
		var id     = href.replace("#thememount-embed-code-", "");
		var currid = window[ 'api_images_' + id ];
		jQuery.prettyPhoto.open( window[ 'api_images_' + id ] , window[ 'api_titles_' + id ] , window[ 'api_desc_' + id ] );
	});
	
	
	
	
/*	jQuery( window ).scroll(function() {		
	  	if (jQuery('#navbar-sticky-wrapper').hasClass('is-sticky')){
			jQuery( '.thememount-header-style-3.tm-header-overlay .headerblock, .thememount-header-style-3.tm-header-overlay .site-header' ).css( "zIndex", "auto" );
		}else{
			jQuery( '.thememount-header-style-3.tm-header-overlay .headerblock, .thememount-header-style-3.tm-header-overlay .site-header' ).css( "zIndex", "2000" );
		}
	});
	*/
		

	/*------------------------------------------------------------------------------*/
	/* Carousel effect in Blog and Portfolio section
	/*------------------------------------------------------------------------------*/
	if ( jQuery('.thememount-effect-carousel').length > 0 ) {
		jQuery('.thememount-effect-carousel').each(function(){
			
			// Default: Three Column
			var itemsColumns = [
								[0, 1],
								[479, 2],
								[768, 2],
								[1200, 3]
							];
			
			/* Responsive array for "Owl Carousel 2"
			 * http://owlcarousel.owlgraphic.com/index.html
			 */
			var itemsColumns2 = {
				0:{
					items:1
				},
				479:{
					items:2
				},
				768:{
					items:2
				},
				1200:{
					items:3
				}
			};
			
			if( jQuery(this).hasClass('thememount-carousel-col-one') ){
				// One Column
				itemsColumns = [
								[0, 1],
								[479, 1],
								[768, 1],
								[1200, 1]
							];
				
				/* Responsive array for "Owl Carousel 2"
				 * http://owlcarousel.owlgraphic.com/index.html
				 */
				itemsColumns2 = {
					0:{
						items:1
					},
					479:{
						items:1
					},
					768:{
						items:1
					},
					1200:{
						items:1
					}
				};

			} else if( jQuery(this).hasClass('thememount-carousel-col-two') ){
				// Two Column
				itemsColumns = [
								[0, 1],
								[479, 2],
								[768, 2],
								[1200, 2]
							];
				
				/* Responsive array for "Owl Carousel 2"
				 * http://owlcarousel.owlgraphic.com/index.html
				 */			
				itemsColumns2 = {
					0:{
						items:1
					},
					479:{
						items:2
					},
					768:{
						items:2
					},
					1200:{
						items:2
					}
				};
				
			} else if( jQuery(this).hasClass('thememount-carousel-col-four') ){
				// Four Column
				itemsColumns = [
								[0, 1],
								[479, 2],
								[768, 2],
								[1200, 4]
							];
				
				/* Responsive array for "Owl Carousel 2"
				 * http://owlcarousel.owlgraphic.com/index.html
				 */
				itemsColumns2 = {
					0:{
						items:1
					},
					479:{
						items:2
					},
					768:{
						items:2
					},
					1200:{
						items:4
					}
				};
				
			} // IF
			
			var owlWrap = jQuery(this);
			
			// Show/Hide pagination in Owl Carousel
			var paginationOption = false;
			if( jQuery(this).hasClass('thememount-with-pagination') ){
				paginationOption = true;
			}
			
			// checking if the dom element exists
			if (owlWrap.length > 0) {
				// check if plugin is loaded
				if (jQuery().owlCarousel) {
					owlWrap.each(function(){
						var carousel = $(this).find('.thememount-carousel-items-wrapper'),
						navigation   = $(this).find('.thememount-carousel-controls-inner'),
						nextBtn      = navigation.find('a.thememount-carousel-next'),
						prevBtn      = navigation.find('a.thememount-carousel-prev');
						//slideshowBtn = navigation.find('.thememount-carousel-slideshow'),
						//stopBtn      = navigation.find('.stop');
						
						/* Options for "Owl Carousel 2"
						 * http://owlcarousel.owlgraphic.com/index.html
						 */
						var rtloption = false;
						if( jQuery('body').hasClass('rtl') ){
							rtloption = true;
						}
						//console.log('RTL:' + rtloption);
						
						
						carousel.owlCarousel({
							/*margin      : 30,
							itemsCustom : itemsColumns,
							navigation  : false,
							pagination  : paginationOption,
							stopOnHover : true,
							autoplay    : true,
							autoplayTimeout : 4500,
							autoplaySpeed : 800,
							navRewind   : 1000,
							//autoplayHoverPause : true,
							autoHeight  : false*/ /*,
							rtl         : true*/
							
							/* Options for "Owl Carousel 2"
							 * http://owlcarousel.owlgraphic.com/index.html
							 */
							autoplay        : true,
							dots            : paginationOption,
							autoplayTimeout : 4500,
							autoplaySpeed   : 800,
							navRewind       : 1000,
							rtl             : rtloption,
							loop            : false,
							margin          : 30,
							nav             : false,
							responsive      : itemsColumns2
							
						});
						carousel.trigger('owl.play', 4500); //owl.play event accept autoPlay speed as second parameter

						
						// Custom Navigation Events
						nextBtn.click(function(){
							/* Options for "Owl Carousel 2"
							 * http://owlcarousel.owlgraphic.com/index.html
							 */
							carousel.trigger('next.owl.carousel');
							
							//carousel.trigger('owl.next');
							
							return false;
						});
						prevBtn.click(function(){
							/* Options for "Owl Carousel 2"
							 * http://owlcarousel.owlgraphic.com/index.html
							 */
							carousel.trigger('prev.owl.carousel');
							
							//carousel.trigger('owl.prev');
							
							return false;
						});

						
						carousel.on('changed.owl.carousel', function(event) {
							/*
							// Provided by the core
							var element   = event.target;         // DOM element, in this example .owl-carousel
							var name      = event.type;           // Name of the event, in this example dragged
							var namespace = event.namespace;      // Namespace of the event, in this example owl.carousel
							var items     = event.item.count;     // Number of items
							var item      = event.item.index;     // Position of the current item
							// Provided by the navigation plugin
							var pages     = event.page.count;     // Number of pages
							var page      = event.page.index;     // Position of the current page
							var size      = event.page.size;      // Number of items per page
							*/
							var newindex = event.item.index + event.page.size;
							//console.log(newindex + ' OF ' + event.item.count + '  Per Page ' + event.page.size );
							//console.log(event.item);

							if( newindex == event.item.count ){
								/*
								to.owl.carousel
								Type: triggerable 
								Parameter: [position, speed] 
								Goes to postion.
								*/
								//console.log(carousel);
								setTimeout(function(){
									carousel.trigger('to.owl.carousel', [0,0,true] );
								}, 4500);
								
								//console.log('to Triggered');
								//console.log('Curent: '+ event.item.index);
							}
							
						})

						
						/*slideshowBtn.click(function(){
							var nexticon = 'tmicon-angle-right'; // Sample: "tmicon-angle-right"
							var previcon = 'tmicon-angle-left';  // Sample: "tmicon-angle-left"
							var playicon = 'tmicon-fa-play';     // Sample: "tmicon-fa-play"
							var stopicon = 'tmicon-fa-pause';    // Sample: "tmicon-fa-pause"
							if( jQuery('i', this).hasClass( playicon ) ){
								jQuery('i', this).removeClass( playicon ).addClass( stopicon );
								carousel.trigger('owl.play', 4500); //owl.play event accept autoPlay speed as second parameter
							} else {
								jQuery('i', this).removeClass( stopicon ).addClass( playicon );
								carousel.trigger('owl.stop');
							}
						});*/
					});
				};
			};
		});
	}
	
	/*-----------------------------------------------------------------------------------*/
	/*	Isotope
	/*-----------------------------------------------------------------------------------*/
	var gallery_item = $('.portfolio-wrapper'),
	filterLinks      = $('.portfolio-sortable-list a');

	function isotope() {
		gallery_item.isotope({
			animationEngine : 'best-available'
		})
		filterLinks.click(function(e){
			var selector = $(this).attr('data-filter');
			gallery_item.isotope({
				filter : selector,
				itemSelector : '.isotope-item'
			});

			filterLinks.removeClass('selected');
			$('#filter-by li').removeClass('current-cat');
			$(this).addClass('selected');
			e.preventDefault();
		});
	};

	if( jQuery().isotope ){
		$(window).load(function () {
			isotope();	
			thememount_blogmasonry();		
		});
		$(window).resize(function(){
			isotope();
		});
	}
	
	/*------------------------------------------------------------------------------*/
	/* Setup Post Likes
	/*------------------------------------------------------------------------------*/
	$('.thememount-portfolio-likes').on('click', function(e){
		e.preventDefault();
		var link = $(this);
		if(link.hasClass('like-active')) return false;
		
		$(this).html('<i class="tmicon-fa-circle-o-notch tmicon-fa-spin"></i>');
		
		var id = $(this).attr('id');

		$.post(ajaxurl, {action: 'thememount-portfolio-likes', likes_id: id}, function(data){
			$( 'i.tmicon-fa-heart-o', link ).removeClass('tmicon-fa-heart-o').addClass('tmicon-fa-heart');
			link.html(data).addClass('like-active');
		});
	});
	
	
	/*------------------------------------------------------------------------------*/
	/* Sticky Footer
	/*------------------------------------------------------------------------------*/
	jQuery('footer#colophon').resize(function(){
		thememount_stickyFooter();
	});
	thememount_stickyFooter();	
	
} ); // END of  document.ready



jQuery(window).load(function(){

	"use strict";
	
	/*------------------------------------------------------------------------------*/
	/* Hide page-loader on load.
	/*------------------------------------------------------------------------------*/
	jQuery('#pageoverlay').fadeOut(500);
	
	
	
	/*------------------------------------------------------------------------------*/
	/* IsoTope
	/*------------------------------------------------------------------------------*/
	var $container = jQuery('.portfolio-wrapper');
	$container.isotope({
		filter: '*',
		animationOptions: {
			duration: 750,
			easing: 'linear',
			queue: false,
		}
	});
	jQuery('nav.portfolio-sortable-list ul li a').click(function(){
		var selector = jQuery(this).attr('data-filter');
		$container.isotope({
			filter: selector,
			animationOptions: {
				duration: 750,
				easing: 'linear',
				queue: false,
			}
		});
		// Selected class
		jQuery('nav.portfolio-sortable-list').find('a.selected').removeClass('selected');
		jQuery(this).addClass('selected'); 
		return false;
	});
	
	
	
	
	/*------------------------------------------------------------------------------*/
	/* Nivo Slider
	/*------------------------------------------------------------------------------*/
	if( jQuery('.thememount-slider-wrapper .nivoSlider').length>0 ){
		jQuery('.thememount-slider-wrapper .nivoSlider').nivoSlider();
	}
	
	
	
	/*------------------------------------------------------------------------------*/
	/* Flex Slider
	/*------------------------------------------------------------------------------*/
	if( jQuery('.thememount-slider-wrapper .flexslider').length > 0 ){
		jQuery('.thememount-slider-wrapper .flexslider').flexslider({
			animation   : "slide",
			controlNav  : false,
			directionNav: true,
			start: function(){
				thememount_blogmasonry();
			}
			/*prevText    : "<i class='tmicon-fa-arrow-left'></i>",
			nextText    : "<i class='tmicon-fa-arrow-right'></i>"*/
		});
	}
	
	
	


	 
	/*------------------------------------------------------------------------------*/
	/* Enables menu toggle for small screens.
	/*------------------------------------------------------------------------------*/ 
	 
	( function() {
		var nav = jQuery( '#site-navigation' ), button, menu;
		if ( ! nav )
			return;

		button = nav.find( '.menu-toggle' );
		if ( ! button )
			return;

		// Hide button if menu is missing or empty.
		menu = nav.find( '.nav-menu' );
		if ( ! menu || ! menu.children().length ) {
			button.hide();
			return;
		}

		jQuery( '.menu-toggle' ).on( 'click.howes', function() {
			nav.toggleClass( 'toggled-on' );
		} );
	} )();
	
	
	
	
	
	
	/*------------------------------------------------------------------------------*/
	/* Responsive Menu
	/*------------------------------------------------------------------------------*/
	jQuery('.righticon').click(function() {
		if(jQuery(this).siblings('.sub-menu, .children, .mega-sub-menu').hasClass('open')){
			jQuery(this).siblings('.sub-menu, .children, .mega-sub-menu').removeClass('open');
			jQuery( 'i', jQuery(this) ).removeClass('tmicon-fa-minus-square').addClass('tmicon-fa-plus-square');
		} else {
			jQuery(this).siblings('.sub-menu, .children, .mega-sub-menu').addClass('open');
			//jQuery(this).find('.righticon i').removeClass('tmicon-plus-circled-2').addClass('tmicon-minus-circle-1');
			jQuery( 'i', jQuery(this) ).removeClass('fa-plus-square').addClass('tmicon-fa-minus-square');
		}
		return false;
 	});
	
	

	
	
	
	/*------------------------------------------------------------------------------*/
	/* Responsive Menu : Open by clicking on the menu text too
	/*------------------------------------------------------------------------------*/
	jQuery('.righticon').each(function() {
		var mainele = this;
		if( jQuery( mainele ).prev().prev().length > 0 ){
			if( jQuery( mainele ).prev().prev().attr('href')=='#' ){
				jQuery( mainele ).prev().prev().click(function(){
					jQuery( mainele ).trigger( "click" );
				});
			}
		}
	});
	
	
	
	/*------------------------------------------------------------------------------*/
	/* Blog masonry view for 2, 3 and 4 columns
	/*------------------------------------------------------------------------------*/
	thememount_blogmasonry();

}); // END of window.load




jQuery(window).resize(function() {

	/*------------------------------------------------------------------------------*/
	/* onResize: Set height of boxes inside row-column view of Blog and Portfolio
	/*------------------------------------------------------------------------------*/
	if( jQuery('.thememount-testimonial-box' ).length > 0 ){
		setHeight('.thememount-testimonial-box.col-lg-4.col-sm-6.col-md-4');
		setHeight('.thememount-testimonial-box.col-lg-6.col-sm-6.col-md-6');
		setHeight('.thememount-testimonial-box.col-lg-3.col-sm-6.col-md-3');
	}
	
	/*------------------------------------------------------------------------------*/
	/* Unstick the sticky
	/*------------------------------------------------------------------------------*/
	tm_sticky();
	//console.log('Resized');
		
	
});  // END of window.resize




/**********************  Some Extra Functions ****************************/


function tm_sticky(){
	if( jQuery('.masthead-header-stickyOnScroll').length > 0 ){
	
		// Returns width of browser viewport
		var pageWidth = jQuery( window ).width();

		var selector       = jQuery('.masthead-header-stickyOnScroll');
		var selectorParent = 'stickable-header-sticky-wrapper';
		
		if( jQuery('body').hasClass('thememount-header-style-3') || jQuery('body').hasClass('thememount-header-style-6') ){
			selector       = jQuery('#navbar');
			selectorParent = 'navbar-sticky-wrapper';
		}
		
		if( parseInt(pageWidth) > parseInt(tm_breakpoint) ){
			if( jQuery(selector).parent().attr('id')!=selectorParent ){
				jQuery(selector).sticky({topSpacing:0});
				//console.log('STICK ==============');
			} else {
				//console.log('NO NEED TO STICK ==============');
			}
		} else {
			if( jQuery(selector).parent().attr('id')==selectorParent ){
				jQuery(selector).unstick();
				//console.log('UN-STICK -------------------');
			} else {
				//console.log('NO NEED TO UN-STICK -------------------');
			}
		}
	}
}



/*------------------------------------------------------------------------------*/
/* Function to set cookie
/*------------------------------------------------------------------------------*/
function thememount_setCookie(c_name,value,exdays){
	var now  = new Date();
	var time = now.getTime();
	time    += (3600 * 1000) * 24;
	now.setTime(time);

	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+now.toGMTString() );
	document.cookie=c_name + "=" + c_value;
} // END function thememount_setCookie



/*------------------------------------------------------------------------------*/
/* Function to set dynamic height of Testimonial columns
/*------------------------------------------------------------------------------*/
function setHeight(column) {
    var maxHeight = 0;
    //Get all the element with class = col
    column = jQuery(column);
    column.css('height', 'auto');
	
	// Responsive condition: Work only in tablet, desktop and other bigger devices.
	if( jQuery( window ).width() > 479 ){
		
		//Loop all the column
		column.each(function() {       
			//Store the highest value
			if(jQuery(this).height() > maxHeight) {
				maxHeight = jQuery(this).height();
			}
		});
		//Set the height
		column.height(maxHeight);
		
	} // if( jQuery( window ).width() > 479 )
} // END function setHeight
/**************************************************************************/


/*------------------------------------------------------------------------------*/
/* Function to Set Blog Masonry view
/*------------------------------------------------------------------------------*/
function thememount_blogmasonry(){
	if( jQuery().isotope ){
		if( jQuery('#content.thememount-blog-col-page').length > 0 ){
			
			jQuery('#content.thememount-blog-col-page').masonry();
			jQuery('#content.thememount-blog-col-page').isotope({
					itemSelector: '.post-box',
					masonry: {
						/*columnWidth: 1,
						isFitWidth: true,
						columnWidth: 500*/
					},
					sortBy : 'original-order'
			});
		}
	}
}


/*------------------------------------------------------------------------------*/
/* Function to set margin bottom for sticky footer
/*------------------------------------------------------------------------------*/
function thememount_stickyFooter(){
	if( jQuery('body').hasClass('thememount-sticky-footer') && jQuery('body').hasClass('thememount-wide')  ){
		jQuery('div#main').css( 'marginBottom', jQuery('footer#colophon').height() );
	}
}


/*------------------------------------------------------------------------------*/
/* Function to add class to select box if default option selected
/*------------------------------------------------------------------------------*/
function setEmptySelectBox(element){
	if(jQuery(element).val() == ""){
		jQuery(element).addClass("empty");
	} else {
		jQuery(element).removeClass("empty");
	}
}



function tm_hide_togle_link(){
	if( jQuery('#navbar div.mega-menu-wrap ul.mega-menu').length > 0 ){
		jQuery('h3.menu-toggle').css('display','none');
	}
}






