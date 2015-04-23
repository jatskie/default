<?php
/**
 * Howes functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Howes
 * @since Howes 1.0
 */

/*
 * Set up the content width value based on the theme's design.
 *
 * @see howes_content_width() for template-specific adjustments.
 */
if ( ! isset( $content_width ) ){
	$content_width = 727;
}

/**
 * Howes only works in WordPress 3.6 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '3.6-alpha', '<' ) ){
	require get_template_directory() . '/inc/back-compat.php';
}


/*
 * Some functions that help to achive small functionality
 */
require_once('inc/tools.php');



/*
 *  Show message that SAFE MODE is active.
 */
function tm_admin_notice() {
	if( ini_get('safe_mode') ){
    ?>
    <div class="error">
        <p><?php _e( '<p><strong>SAFE MODE is active on your hosting</strong></p> <p>Some options in <strong>Howes theme</strong> may not work including "Demo content installation" and "Theme Options settings". Please contact your hosting service provider and ask them to disable SAFE MODE.</p>', 'howes' ); ?></p>
    </div>
    <?php
	}
}
add_action( 'admin_notices', 'tm_admin_notice' );



/**
 * To make Breadcrumb NavXT plugin to WPML Ready 
 */
if(function_exists('bcn_display')){
	//Hook into the Breadcrumb NavXT title filter, want the 4.2+ version with 2 args
	add_filter('bcn_breadcrumb_title', 'bcn_ext_title_translater', 10, 2);
	/**
	 * This function is a filter for the bcn_breadcrumb_title filter, it runs through
	 * the SitePress::the_category_name_filter function
	 * 
	 * @param string $title The title to be filtered (translated)
	 * @param array $context The breadcrumb type array
	 * @return string The string filtered through SitePress::the_category_name_filter
	 */
	function bcn_ext_title_translater($title, $context){
		//Need to make sure we have a taxonomy and that the SitePress object is available
		if(is_array($context) && isset($context[0]) && taxonomy_exists($context[0]) && class_exists('SitePress')){
			//This may be a little dangerous due to the internal recursive calls for the function
			$title = SitePress::the_category_name_filter($title);
		}
		return $title;
	}
}



add_action('admin_init', 'tm_change_maxmegamenu_setting');
function tm_change_maxmegamenu_setting() {

	global $howes;
	$breakpoint = '1200';
	if( isset($howes['menu_breakpoint']) && isset($howes['menu_breakpoint_custom']) ){
		if( $howes['menu_breakpoint']=='custom' ){
			$breakpoint = $howes['menu_breakpoint_custom'];
		} else {
			$breakpoint = $howes['menu_breakpoint'];
		}
	}

	$themes['default'] = array(
            'title'                                     => __("Default", "megamenu"),
            'container_background_from'                 => '#222',
            'container_background_to'                   => '#222',
            'container_padding_left'                    => '0px',
            'container_padding_right'                   => '0px',
            'container_padding_top'                     => '0px',
            'container_padding_bottom'                  => '0px',
            'container_border_radius_top_left'          => '0px',
            'container_border_radius_top_right'         => '0px',
            'container_border_radius_bottom_left'       => '0px',
            'container_border_radius_bottom_right'      => '0px',
            'arrow_up'                                  => 'dash-f142',
            'arrow_down'                                => 'dash-f140',
            'arrow_left'                                => 'dash-f141',
            'arrow_right'                               => 'dash-f139',
            'menu_item_background_from'                 => 'transparent',
            'menu_item_background_to'                   => 'transparent',
            'menu_item_background_hover_from'           => '#333',
            'menu_item_background_hover_to'             => '#333',
            'menu_item_spacing'                         => '0px',
            'menu_item_link_font'                       => 'inherit',
            'menu_item_link_font_size'                  => '14px',
            'menu_item_link_height'                     => '40px',
            'menu_item_link_color'                      => '#ffffff',
            'menu_item_link_weight'                     => 'normal',
            'menu_item_link_text_transform'             => 'normal',
            'menu_item_link_color_hover'                => '#ffffff',
            'menu_item_link_weight_hover'               => 'normal',
            'menu_item_link_padding_left'               => '10px',
            'menu_item_link_padding_right'              => '10px',
            'menu_item_link_padding_top'                => '0px',
            'menu_item_link_padding_bottom'             => '0px',
            'menu_item_link_border_radius_top_left'     => '0px',
            'menu_item_link_border_radius_top_right'    => '0px',
            'menu_item_link_border_radius_bottom_left'  => '0px',
            'menu_item_link_border_radius_bottom_right' => '0px',
            'panel_background_from'                     => '#f1f1f1',
            'panel_background_to'                       => '#f1f1f1',
            'panel_width'                               => '100%',
			'panel_border_color'                        => '#fff',
            'panel_border_left'                         => '0px',
            'panel_border_right'                        => '0px',
            'panel_border_top'                          => '0px',
            'panel_border_bottom'                       => '0px',
            'panel_border_radius_top_left'              => '0px',
            'panel_border_radius_top_right'             => '0px',
            'panel_border_radius_bottom_left'           => '0px',
            'panel_border_radius_bottom_right'          => '0px',
            'panel_header_color'                        => '#555',
            'panel_header_text_transform'               => 'uppercase',
            'panel_header_font'                         => 'inherit',
            'panel_header_font_size'                    => '16px',
            'panel_header_font_weight'                  => 'bold',
            'panel_header_padding_top'                  => '0px',
            'panel_header_padding_right'                => '0px',
            'panel_header_padding_bottom'               => '5px',
            'panel_header_padding_left'                 => '0px',
            'panel_padding_left'                        => '0px',
            'panel_padding_right'                       => '0px',
            'panel_padding_top'                         => '0px',
            'panel_padding_bottom'                      => '0px',
            'panel_widget_padding_left'                 => '15px',
            'panel_widget_padding_right'                => '15px',
            'panel_widget_padding_top'                  => '15px',
            'panel_widget_padding_bottom'               => '15px',
            'flyout_width'                              => '150px',
			'flyout_border_color'                        => '#ffffff',
            'flyout_border_left'                         => '0px',
            'flyout_border_right'                        => '0px',
            'flyout_border_top'                          => '0px',
            'flyout_border_bottom'                       => '0px',
            'flyout_link_padding_left'                  => '10px',
            'flyout_link_padding_right'                 => '10px',
            'flyout_link_padding_top'                   => '0px',
            'flyout_link_padding_bottom'                => '0px',
            'flyout_link_weight'                        => 'normal',
            'flyout_link_weight_hover'                  => 'normal',
            'flyout_link_height'                        => '35px',
            'flyout_background_from'                    => '#f1f1f1',
            'flyout_background_to'                      => '#f1f1f1',
            'flyout_background_hover_from'              => '#dddddd',
            'flyout_background_hover_to'                => '#dddddd',
            'font_size'                                 => '14px',
            'font_color'                                => '#666',
            'font_family'                               => 'inherit',
            'responsive_breakpoint'                     => $breakpoint.'px',
            'line_height'                               => '1.7',
            'z_index'                                   => '999',
            'custom_css'                                => '
#{$wrap} #{$menu} {
    /** Custom styles should be added below this line **/
}
#{$wrap} { 
    clear: both;
}'
        );
		
	$megamenu_themes = get_option('megamenu_themes');
	//var_dump($megamenu_themes);
	if( is_array($megamenu_themes) && isset($megamenu_themes["default"]['responsive_breakpoint']) ){
		if( $megamenu_themes["default"]['responsive_breakpoint'] != $breakpoint.'px' ){
			$megamenu_themes["default"]['responsive_breakpoint'] = $breakpoint.'px';
			update_option('megamenu_themes', $megamenu_themes);
			
			// Generate Cache CSS of MaxMegaMenu
			if( class_exists('Mega_Menu_Style_Manager') ){
				$Mega_Menu_Style_Manager = new Mega_Menu_Style_Manager;
				$Mega_Menu_Style_Manager->generate_css( 'scss_formatter_compressed' );
			}
			
		}
	} else {
		update_option('megamenu_themes', $themes);
		
		// Generate Cache CSS of MaxMegaMenu
		if( class_exists('Mega_Menu_Style_Manager') ){
			$Mega_Menu_Style_Manager = new Mega_Menu_Style_Manager;
			$Mega_Menu_Style_Manager->generate_css( 'scss_formatter_compressed' );
		}
		
	}
}


/*
 * Team Member search: redirect to archive-search.php
 */
/*function thememount_template_chooser($template){
	global $wp_query;
	$post_type = get_query_var('post_type');
	if( $wp_query->is_search && $post_type == 'team_member' ){
		return locate_template('archive-team_member.php');
	}
	return $template;
}
add_filter('template_include', 'thememount_template_chooser');*/



/*
 * Custom option in taxonomy
 */
//include_once('inc/taxonomy-metadata.php');


/*
 * Function to get count of total sidebar
 */
function thememount_get_widgets_count( $sidebar_id ){
	$sidebars_widgets = wp_get_sidebars_widgets();
	if( isset($sidebars_widgets[ $sidebar_id ]) ){
		return (int) count( (array) $sidebars_widgets[ $sidebar_id ] );
	}
}
function thememount_class_for_widgets_count( $count=0 ){
	$return = '';
	if( $count<1 ){ $count = 1; }
	if( $count>4 ){ $count = 4; }
	switch( $count ){
		case 1:
			$return = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
			break;
		case 2:
			$return = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
			break;
		case 3:
			$return = 'col-xs-12 col-sm-6 col-md-4 col-lg-4';
			break;
		case 4:
			$return = 'col-xs-12 col-sm-6 col-md-3 col-lg-3';
			break;
	}
	return $return;
}




/*
 * Wrap DIV to the Read More link in blog
 */
function thememount_wrap_readmore($more_link) {
    return '<div class="thememount-post-readmore">'.$more_link.'</div>';
}
add_filter('the_content_more_link', 'thememount_wrap_readmore', 10, 1);


/*
 * Shortcode list and their calls
 */
$shortcodeList = array(
	'blogbox',
	'clients',
	'contactbox',
	'current-year',
	'facts_in_digits',
	'heading',
	'icon',
	'icontext',
	'languageswitcher',
	'thememounticonseparator',
	'thememount-social-links',
	'portfoliobox',
	'eventsbox',
	'servicebox',
	'site-tagline',
	'site-title',
	'site-url',
	'skincolor',
	'team',
	'testimonial',
	'twitterbox',
);
foreach( $shortcodeList as $shortcode ){
	include_once('inc/shortcodes/'.$shortcode.'.php');
}



	

/*
 * Disable dynamic style and echo all style in header
 */
add_action( 'init', 'thememount_dynamic_style' );
function thememount_dynamic_style(){
	global $howes;
	if( isset($howes['dynamic-style-position']) && $howes['dynamic-style-position']=='internal' ){
		add_action('wp_head','thememount_hook_dynamic_css');
	}
}
function thememount_hook_dynamic_css(){
	/* Fetching dynamic-style.php output and store in a variable */
	ob_start(); // begin collecting output
	include get_template_directory().'/css/dynamic-style.php';
	$css    = ob_get_clean(); // retrieve output from myfile.php, stop buffering
	
	/* Now add the dynamic-style.php style in header */
	$output = "<style> $css </style>";
	echo $output;
}




/*
 *  Dynamic content linking with JS code. Declaring variables.
 */
add_action('wp_head','thememount_js_vars');
function thememount_js_vars(){
	global $howes;
	$breakpoint = ( isset($howes['menu_breakpoint']) && trim($howes['menu_breakpoint'])!='' ) ? trim($howes['menu_breakpoint']) : '1200' ;
	?>
	
	<script type="text/javascript">
		var tm_breakpoint = <?php echo $breakpoint ?>;
	</script>
	
	<?php
}


/*
 * Add some special classes on <body> tag.
 */
if( !function_exists('thememount_body_classes') ){
function thememount_body_classes($bodyClass){
	global $howes;
	
	// check if dark background set for container.
	if( isset($howes['inner_background']['background-color']) && trim($howes['inner_background']['background-color'])!='' && tm_check_dark_color($howes['inner_background']['background-color']) ){
		$bodyClass[] = 'tm-dark-layout';
	}
	
	// show/hide separator line between links in dropdown menu
	if( isset($howes['dropdown_menu_separator']) && trim($howes['dropdown_menu_separator'])=='0' ){
		$bodyClass[] = 'tm-dropmenu-hide-sepline';
	}
	
	//Responsive ON / OFF
	if($howes['responsive']=='1'){
		$bodyClass[] = 'thememount-responsive-on';
	} else {
		$bodyClass[] = 'thememount-responsive-off';
	}

	// Sticky Fotoer ON/OFF
	if( isset($howes['stickyfooter']) && $howes['stickyfooter']=='1' ){
		$bodyClass[] = 'thememount-sticky-footer';
	}
	
	// Single Portfolio
	if( is_singular('portfolio') ){
		$portfolioView        = $howes['portfolio_viewstyle']; // Global view
		$portfolioView_single = get_post_meta( get_the_ID(), '_thememount_portfolio_view_viewstyle', true); // Single portfolio view
		if( is_array($portfolioView_single) ){ $portfolioView_single = $portfolioView_single[0]; }
		if( trim($portfolioView_single)!='' && trim($portfolioView_single)!='global' ){
			$portfolioView = $portfolioView_single;
		}
		$bodyClass[] = sanitize_html_class('thememount-portfolio-view-'.$portfolioView);
	}
	
	// Boxed / Wide
	if( trim($howes['layout'])!='' ){
		$bodyClass[] = sanitize_html_class( 'thememount-'.trim($howes['layout']));
		if( $howes['layout']=='fullwide' ){
			if( isset($howes['full_wide_elements']['content']) && $howes['full_wide_elements']['content']=='1' ){
				$bodyClass[] = 'tm-layout-container-full';
			}
		}
		
	} else {
		$bodyClass[] = 'thememount-wide';
	}
	
	$thememount_retina_logo = 'off';
	if( isset($howes['logoimg_retina']['url']) && $howes['logoimg_retina']['url']!=''){
		$thememount_retina_logo = 'on';
	}

	
	// Header Style
	$headerstyle        = '';
	$headerstyle_global = '';
	$headerstyle_page   = '';
	if( isset($howes['headerstyle']) && trim($howes['headerstyle'])!='' ){
		$headerstyle_global = trim($howes['headerstyle']);
	}
	if( is_page() ){
		$headerstyle_page = trim(get_post_meta(get_the_ID(), 'headerstyle', true));
	}
	if( $headerstyle_page!='' ){
		$headerstyle = $headerstyle_page;
	} else {
		$headerstyle = $headerstyle_global;
	}
	
	switch( $headerstyle ){
		case '1':
		case '2':
		case '3':
			$hClass = 'thememount-header-style-'.trim($headerstyle);
			break;
		case '4':
			$overlayClass = ' tm-header-overlay';
			if( is_page() ){
				global $post;
				$slidertype   = get_post_meta( $post->ID, '_thememount_page_options_slidertype', true );
				if( is_array($slidertype) ){ $slidertype = $slidertype[0];}
				$hidetitlebar = get_post_meta( $post->ID, '_thememount_page_options_hidetitlebar', true );
				
				if( trim($slidertype)=='' && $hidetitlebar=='on' ){
					$overlayClass = '';
				}
			}
			$hClass = 'thememount-header-style-1' . $overlayClass;
			break;
		case '5':
			$overlayClass = ' tm-header-overlay';
			if( is_page() ){
				global $post;
				$slidertype   = get_post_meta( $post->ID, '_thememount_page_options_slidertype', true );
				if( is_array($slidertype) ){ $slidertype = $slidertype[0];}
				$hidetitlebar = get_post_meta( $post->ID, '_thememount_page_options_hidetitlebar', true );
				
				if( trim($slidertype)=='' && $hidetitlebar=='on' ){
					$overlayClass = '';
				}
			}
			$hClass = 'thememount-header-style-2' . $overlayClass;
			break;
		case '6':
			$overlayClass = ' tm-header-overlay';
			if( is_page() ){
				global $post;
				$slidertype   = get_post_meta( $post->ID, '_thememount_page_options_slidertype', true );
				if( is_array($slidertype) ){ $slidertype = $slidertype[0];}
				$hidetitlebar = get_post_meta( $post->ID, '_thememount_page_options_hidetitlebar', true );
				
				if( trim($slidertype)=='' && $hidetitlebar=='on' ){
					$overlayClass = '';
				}
			}
			$hClass = 'thememount-header-style-3' . $overlayClass;
			break;
		case '7':
			$overlayClass = ' tm-header-overlay';
			if( is_page() ){
				global $post;
				$slidertype   = get_post_meta( $post->ID, '_thememount_page_options_slidertype', true );
				if( is_array($slidertype) ){ $slidertype = $slidertype[0];}
				$hidetitlebar = get_post_meta( $post->ID, '_thememount_page_options_hidetitlebar', true );
				
				if( trim($slidertype)=='' && $hidetitlebar=='on' ){
					$overlayClass = '';
				}
			}
			$hClass = 'thememount-header-style-4' . $overlayClass;
			break;
	}
	$bodyClass[] = $hClass;
	
	

	// Sidebar Class
	$sidebar = $howes['sidebar_page']; // Global settings
	if( (is_page()) ){
		$sidebarposition = get_post_meta( get_the_ID(), '_thememount_page_options_sidebarposition', true);
		if( is_array($sidebarposition) ){ $sidebarposition = $sidebarposition[0]; } // Converting to String if Array
		// Page settings
		if( trim($sidebarposition) != '' ){
			$sidebar = $sidebarposition;
		}
	}
	if( (is_home()) ){
		$sidebarposition = get_post_meta( get_option('page_for_posts'), '_thememount_page_options_sidebarposition', true);
		if( is_array($sidebarposition) ){ $sidebarposition = $sidebarposition[0]; } // Converting to String if Array
		// Page settings
		if( trim($sidebarposition) != '' ){
			$sidebar = $sidebarposition;
		}
	}
	
	
	// WooCommerce sidebar class
	if( function_exists('is_woocommerce') && is_woocommerce() ) {
		$sidebar = isset($howes['sidebar_woocommerce']) ? $howes['sidebar_woocommerce'] : 'right' ;
	}
	
	// BBPress sidebar class
	if( function_exists('is_bbpress') && is_bbpress() ) {
		$sidebar = isset($howes['sidebar_bbpress']) ? $howes['sidebar_bbpress'] : 'right' ;
	}
	
	if( $sidebar=='no' ){
		// The page is full width
		$bodyClass[] = 'thememount-page-full-width';
	} else {
		// Sidebar class for border
		$bodyClass[] = sanitize_html_class( 'thememount-sidebar-'.$sidebar );
	}
	
	// Check if "Max Mega Menu" plugin is active
	if( !function_exists('is_plugin_active') ){
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}
	if ( is_plugin_active( 'megamenu/megamenu.php' ) ) {
		//plugin is activated
		$bodyClass[] = 'thememount-maxmegamenu-active';
	}
	
	// One Page website
	if( isset($howes['one_page_site']) && $howes['one_page_site']=='1' ){
		$bodyClass[] = 'thememount-one-page-site';
	}
	
	

	
	
	
	
	return $bodyClass;
}
}
add_filter('body_class', 'thememount_body_classes');



function thememount_getCSS( $value = array() ) {

	$css = '';

	if ( ! empty( $value ) && is_array( $value ) ) {
		foreach ( $value as $key => $value ) {
			if ( ! empty( $value ) && $key != "media" ) {
				if ( $key == "background-image" ) {
					$css .= $key . ":url('" . $value . "');";
				} else {
					$css .= $key . ":" . $value . ";";
				}
			}
		}
	}

	return $css;
}

/*
 * Login page stylesheet
 */
function thememount_custom_login_css() {
	global $howes;
	$bg_size = '';
	
	// Custom CSS Code for login page only
	$login_custom_css_code = '';
	if( isset($howes['login_custom_css_code']) && trim($howes['login_custom_css_code'])!='' ){
		$login_custom_css_code = $howes['login_custom_css_code'];
	}
	
	// Login page background CSS style
	$bgStyle = thememount_getCSS($howes['login_background']);
	
	$cssCode  = '';
	$cssCode2 = '';
	
	if( !empty($bgStyle) ){
		$cssCode .= 'body.login{'.$bgStyle.'}';
	}
	
	
	
	
	
	if( isset($howes['logoimg']["url"]) && trim($howes['logoimg']["url"])!='' ){
		$cssCode2 .= 'background: transparent url("'.$howes['logoimg']["url"].'") no-repeat center center;';
	}
	
	if( isset($howes['logoimg']["width"]) && trim($howes['logoimg']["width"])!='' ){
		if( $howes['logoimg']["width"] > 320 ){
			$cssCode2 .= 'width: 320px;';
		} else {
			$cssCode2 .= 'width: '.$howes['logoimg']["width"].'px;';
		}
	}
	
	if( isset($howes['logoimg']["height"]) && trim($howes['logoimg']["height"])!='' ){
		// 320px : max-width
		$width  = $howes['logoimg']["width"];
		$height = $howes['logoimg']["height"];
		if( $width > 320 ){
			$bg_size   = 'background-size: 100%;';
			$newheight = ceil( ($height / $width) * 320 );
		} else {
			$newheight = $height;
		}
		
		$cssCode2 .= 'height: '.$newheight.'px;';
	}
	
	// Submit button to skin color
	$otherCSS = '.wp-core-ui #login .button-primary{ background: '.$howes['skincolor'].';}';
	
	
	echo '<style>
		.login #login form{background-color: #f7f7f7; box-shadow: none;}
		'.$cssCode.'
		.login #login h1 a{
			'.$cssCode2.'
			'.$bg_size.'
			/*max-width:100%;*/
		}
		'.$otherCSS.'
		'.$login_custom_css_code.'
		</style>';
}
add_action('login_head', 'thememount_custom_login_css');



/**
 * Login page logo link
 */
function tm_loginpage_custom_link() {
	return esc_url( home_url( '/' ) );
}
add_filter('login_headerurl','tm_loginpage_custom_link');


/**
 * Login page logo link title
 */
function tm_change_title_on_logo() {
	return esc_attr( get_bloginfo( 'name', 'display' ) );
}
add_filter('login_headertitle', 'tm_change_title_on_logo');



/**
 * Login page CSS script
 */
function thememount_login_stylesheet() {
    wp_enqueue_style( 'howes-login-style', get_template_directory_uri() . '/style-login.css' );
}
add_action( 'login_enqueue_scripts', 'thememount_login_stylesheet' );



/**
 * Howes setup.
 *
 * Sets up theme defaults and registers the various WordPress features that
 * Howes supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add Visual Editor stylesheets.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, and post thumbnails.
 * @uses register_nav_menu() To add support for a navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Howes 1.0
 *
 * @return void
 */
function howes_setup() {
	/*
	 * Makes Howes available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Howes, use a find and
	 * replace to change 'howes' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'howes', get_template_directory() . '/languages' );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
	
	// Adding WooCommerce Support
	add_theme_support( 'woocommerce' );

	/*
	 * Switches default core markup for search form, comment form,
	 * and comments to output valid HTML5.
	 */
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	/*
	 * This theme supports all available post formats by default.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Navigation Menu', 'howes' ) );
	register_nav_menu( 'footer' , __( 'Footer Menu', 'howes' ) );

	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 727, 409, true );
	
	// Adding Image sizes
	add_image_size( 'portfolio-two-column',   1110, 624, true );
	add_image_size( 'portfolio-three-column', 720, 406, true );
	add_image_size( 'portfolio-four-column',  750, 422, true );
	add_image_size( 'woocommerce-catalog',    520, 520, true );
	add_image_size( 'woocommerce-single',     800, 800, true );
	add_image_size( 'woocommerce-thumbnail',  120, 120, true );
	
	
	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
	
	// Run Shortcode in Widget Title
	add_filter('widget_title', 'do_shortcode');
	
	// Run Shortcode in text widget
	add_filter('widget_text', 'do_shortcode');
	
	
	// CF Post Format
	// include_once('inc/plugins/cf-post-formats/cf-post-formats.php');
	
	
	// Widgets
	include_once('inc/widgets/thememountWidgetRecentPosts.php');
	include_once('inc/widgets/thememountWidgetFlickr.php');
	include_once('inc/widgets/thememountWidgetContact.php');
	//include_once('inc/widgets/thememountWidgetTabs.php');

}
add_action( 'after_setup_theme', 'howes_setup' );



// Visual Composer Theme integration
add_action( 'init', 'thememount_vcSetAsTheme' );
add_action( 'vc_before_init', 'thememount_vcSetAsTheme' );
function thememount_vcSetAsTheme() {
	if( function_exists('vc_set_as_theme') ){ vc_set_as_theme(true); }
	if( function_exists('vc_set_default_editor_post_types') ){ vc_set_default_editor_post_types(array('page', 'portfolio', 'team_member')); }
}
// Slider Revoluiton Theme integration

add_action( 'init', 'thememount_set_rs_as_theme' );
function thememount_set_rs_as_theme() {
	// Setting options to hide Revoluiton Slider message
	if(get_option('revSliderAsTheme') != 'true'){
		update_option('revSliderAsTheme', 'true');
	}
	if(get_option('revslider-valid-notice') != 'false'){
		update_option('revslider-valid-notice', 'false');
	}
	if( function_exists('set_revslider_as_theme') ){	
		set_revslider_as_theme();
	}
}





/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Howes 1.0
 *
 * @return void
 */
function howes_scripts_styles() {
	global $howes;
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ){
		wp_enqueue_script( 'comment-reply' );
	}
	
	/*
	 * Adds RTL CSS file
	 */
	if ( is_rtl() ) {
		wp_enqueue_style(  'howes-rtl',  get_template_directory_uri() . '/rtl.css' );
	}
	
	// Add page translation effect
	if( isset($howes['pagetranslation']) && $howes['pagetranslation']!='no'){
		wp_enqueue_script( 'animsition', get_template_directory_uri() . '/js/jquery.animsition.min.js', array( 'jquery' ) );
		wp_enqueue_style( 'animsition', get_template_directory_uri() . '/css/animsition.min.css' );
	}
	
	// Loads JavaScript file with functionality specific to Howes.
	wp_enqueue_script( 'howes-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery', 'isotope' ), '2013-07-18', true );
	
	// Hover effect
	wp_enqueue_style( 'hover', get_template_directory_uri() . '/css/hover.min.css' );
	
	// IsoTope
	wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array( 'jquery' ) );
	
	// Flex Slider
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery' ) );
	wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/css/flexslider.css' );
	
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery', 'howes-script' ) );
	// Tooltip
	wp_enqueue_script( 'bootstrap-tooltip', get_template_directory_uri() . '/js/bootstrap-tooltip.min.js', array( 'jquery', 'howes-script' ) );
	
	// Sticky
	if( $howes['stickyheader']=='y' ){
		wp_enqueue_script( 'sticky', get_template_directory_uri() . '/js/jquery.sticky.js', array( 'jquery' ) );
	}
	
	// Load font icon library CSS files
	if( isset($howes['fonticonlibrary']) && is_array($howes['fonticonlibrary']) && count($howes['fonticonlibrary'])>0 ){
		foreach( $howes['fonticonlibrary'] as $library=>$val ){
			if( $library!='fontawesome' ){
				if( $val == '1' ){
					wp_enqueue_style( $library, get_template_directory_uri() . '/css/fonticon-library/'.$library.'/css/thememount-'.$library.'.css' );
				}
				
			}
		}
	}
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/fonticon-library/font-awesome/css/font-awesome.css' ); // Font Awesome
	
	// Nivo Slider
	wp_enqueue_script( 'nivo-slider', get_template_directory_uri() . '/js/jquery.nivo.slider.pack.js', array( 'jquery' ) );
	wp_enqueue_style( 'nivo-slider-css', get_template_directory_uri() . '/css/nivo-slider/nivo-slider.css' );
	wp_enqueue_style( 'nivo-slider-theme', get_template_directory_uri() . '/css/nivo-slider/default.css' );
	
	// Numinate plugin
	if ( !wp_script_is( 'waypoints', 'registered' ) ) { // If Waypoints library is not registered
		wp_register_script( 'waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array( 'jquery' ) );
	}
	wp_register_script( 'numinate', get_template_directory_uri() . '/js/numinate.1.0.1.min.js', array( 'jquery' ) );
	
	// owl carousel
	wp_enqueue_script( 'owlcarousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' )  );
	wp_enqueue_style( 'owlcarousel', get_template_directory_uri() . '/css/owl.carousel.css' );
	
	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'howes-ie', get_template_directory_uri() . '/css/ie.css' );
	wp_style_add_data( 'howes-ie', 'conditional', 'lt IE 10' );
	
	// Swipebox
	wp_enqueue_script( 'prettyphoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array( 'jquery' ) );
	wp_enqueue_style( 'prettyphoto', get_template_directory_uri() . '/css/prettyPhoto.css' );
	
	// Pace Loader
	//wp_enqueue_script( 'pace', get_template_directory_uri() . '/js/pace.min.js', array( 'jquery' ) );
	//wp_enqueue_style( 'pace', get_template_directory_uri() . '/css/prettyPhoto.css' );
	
	global $howes;
	if( isset($howes['scroller_enable']) ){
		if( $howes['scroller_enable']=='1'){
			// NiceScroll
			wp_enqueue_script( 'nicescroll', get_template_directory_uri() . '/js/jquery.nicescroll.min.js', array( 'jquery' ) );
			wp_enqueue_script( 'nicescroll-plus', get_template_directory_uri() . '/js/jquery.nicescroll.plus.js', array( 'jquery' , 'nicescroll' ) );
		} else if( $howes['scroller_enable']=='2'){
			// SmoothScroll
			wp_enqueue_script( 'SmoothScroll', get_template_directory_uri() . '/js/SmoothScroll.js', array( 'jquery' ) );
		}
	}
	
}
add_action( 'wp_enqueue_scripts', 'howes_scripts_styles', 10 );




function howes_scripts_styles_15() {
	if( defined( 'WPB_VC_VERSION' ) ){
		wp_enqueue_style( 'howes-main-style', get_stylesheet_directory_uri() . '/style.css' , array('js_composer_front') );
	} else {
		wp_enqueue_style( 'howes-main-style', get_stylesheet_directory_uri() . '/style.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'howes_scripts_styles_15', 15 );


function howes_scripts_styles_16() {
	global $howes;
	// Dynamic Stylesheet
	if( isset($howes['dynamic-style-position']) && $howes['dynamic-style-position']=='internal' ){
		// Do nothing
	} else {
		wp_enqueue_style( 'howes-dynamic-style', get_template_directory_uri() . '/css/dynamic-style.php' );
	}
}
add_action( 'wp_enqueue_scripts', 'howes_scripts_styles_16', 16 );


function howes_scripts_styles_17() {
	// Responsive
	global $howes;
	
	if($howes['responsive']=='1'){
		wp_enqueue_style( 'howes-responsive-style', get_template_directory_uri() . '/css/responsive.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'howes_scripts_styles_17', 17 );








/******************* Order Testimonials by date *******************/
/* Sort posts in wp_list_table by column in ascending or descending order. */
function thememount_custom_post_order($query){
	/* 
	Set post types.
	_builtin => true returns WordPress default post types. 
	_builtin => false returns custom registered post types. 
	*/
	$post_types = get_post_types(array('_builtin' => false), 'names');
	
	/* The current post type. */
	$post_type = $query->get('testimonial');
	
	/* Check post types. */
	if(in_array($post_type, $post_types)){
		/* Post Column: e.g. title */
		if($query->get('orderby') == ''){
			$query->set('orderby', 'date');
		}
		/* Post Order: ASC / DESC */
		if($query->get('order') == ''){
			$query->set('order', 'DESC');
		}
	}
}
if(is_admin()){
	add_action('pre_get_posts', 'thememount_custom_post_order');
}
/******************************************************/



/**
 * Enqueue scripts and styles for the admin section.
 *
 * @since Howes 1.0
 *
 * @return void
 */
function howes_custom_wp_admin_style() {
	wp_register_script('custom-select2-js', get_template_directory_uri() . '/inc/custom-select2/custom-select2.js', array( 'jquery' ), time(), true);
	wp_register_style('custom-select2-css', get_template_directory_uri() . '/inc/custom-select2/custom-select2.css', array(), time(), 'all');
		
		
	// Load font icon library CSS files
	global $howes;
	if( isset($howes['fonticonlibrary']) && is_array($howes['fonticonlibrary']) && count($howes['fonticonlibrary'])>0 ){
		foreach( $howes['fonticonlibrary'] as $library=>$val ){
			if( $library!='fontawesome' ){
				if( $val == '1' ){
					wp_enqueue_style( $library, get_template_directory_uri() . '/css/fonticon-library/'.$library.'/css/thememount-'.$library.'.css' );
				}
			}
		}
	}
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/fonticon-library/font-awesome/css/font-awesome.css' ); // Font Awesome
		
		
	wp_enqueue_script('custom-select2-js');
	wp_enqueue_style('custom-select2-css');
	wp_enqueue_style('thememount-font-css');
	
	wp_enqueue_style( 'howes_custom_wp_admin_css', get_template_directory_uri() . '/inc/admin-style.css', false, '1.0.0' );
	wp_enqueue_script( 'howes_custom_js', get_template_directory_uri() . '/inc/admin-custom.js', array( 'jquery' ) );
}
add_action( 'admin_enqueue_scripts', 'howes_custom_wp_admin_style' );


/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Howes 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep   Optional separator.
 * @return string The filtered title.
 */
function howes_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'howes' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'howes_wp_title', 10, 2 );

/**
 * Register two widget areas.
 *
 * @since Howes 1.0
 *
 * @return void
 */
function howes_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Left Sidebar for Blog', 'howes' ),
		'id' => 'sidebar-left-blog',
		'description' => __( 'This is left sidebar for blog section', 'howes' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Right Sidebar for Blog', 'howes' ),
		'id' => 'sidebar-right-blog',
		'description' => __( 'This is right sidebar for blog section', 'howes' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Left Sidebar for Pages', 'howes' ),
		'id' => 'sidebar-left-page',
		'description' => __( 'This is left sidebar for pages', 'howes' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Right Sidebar for Pages', 'howes' ),
		'id' => 'sidebar-right-page',
		'description' => __( 'This is right sidebar for pages', 'howes' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Left Sidebar for Search', 'howes' ),
		'id' => 'sidebar-left-search',
		'description' => __( 'This is left sidebar for search', 'howes' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Right Sidebar for search', 'howes' ),
		'id' => 'sidebar-right-search',
		'description' => __( 'This is right sidebar for search', 'howes' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// Floating bar widgets
	$class = thememount_class_for_widgets_count( thememount_get_widgets_count( 'floating-header-widgets' ) );
	register_sidebar( array(
		'name'          => __( 'Floating Header Widgets', 'howes' ),
		'id'            => 'floating-header-widgets',
		'description'   => __( 'Set widgets for Floating Header area.', 'howes' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s '.$class.'">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	// WooCommerce
	register_sidebar( array(
		'name' => __( 'WooCommerce Shop', 'howes' ),
		'id' => 'sidebar-woocommerce',
		'description' => __( 'This is sidebar for WooCommerce shop pages.', 'howes' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// BBPress
	register_sidebar( array(
		'name'          => __( 'BBPress Sidebar', 'howes' ),
		'id'            => 'sidebar-bbpress',
		'description'   => __( 'This is sidebar for BBPress.', 'howes' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	
	
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'howes' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'This is first footer widget area.', 'howes' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'howes' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'This is second footer widget area.', 'howes' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'howes' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'This is third footer widget area.', 'howes' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'howes' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'This is fourth footer widget area.', 'howes' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// Dynamic Sidebars (Unlimited Sidebars)
	global $howes;
	if( isset($howes['sidebars']) && is_array($howes['sidebars']) && count($howes['sidebars'])>0 ){
		foreach( $howes['sidebars'] as $custom_sidebar ){
			if( trim($custom_sidebar)!='' ){
				$custom_sidebar_key = str_replace('-','_',sanitize_title($custom_sidebar));
				register_sidebar( array(
					'name'          => $custom_sidebar,
					'id'            => $custom_sidebar_key,
					'description'   => __( 'This is custom widget developed from "Appearance > Theme Options".', 'howes' ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>',
				) );
			}
		}
	}
	
}
add_action( 'widgets_init', 'howes_widgets_init' );



/*
 * Display pagination to set of posts when applicable.
 */
if ( ! function_exists( 'howes_paging_nav' ) ) :
	function howes_paging_nav($return = false, $wp_query_data=false) {
		if( $wp_query_data==false ){
			global $wp_query;
		} else {
			$wp_query = $wp_query_data;
		}
		
		$result = '';
		
		
		// Array to check if pagination data exists
		$paginateLinks = paginate_links( array(
			'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'    => '?paged=%#%',
			'current'   => max( 1, get_query_var('paged') ),
			'total'     => $wp_query->max_num_pages,
			'type'      => 'array',
			'prev_text' => __(' <i class="tmicon-fa-angle-left"></i> '),
			'next_text' => __(' <i class="tmicon-fa-angle-right"></i> '),
		) );
		
		
		if( $paginateLinks!=NULL ){
			$big = 999999999; // need an unlikely integer
			$result .= '<div class="thememount-pagination">';
			$result .= paginate_links( array(
				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'    => '?paged=%#%',
				'current'   => max( 1, get_query_var('paged') ),
				'total'     => $wp_query->max_num_pages,
				'prev_text' => __(' <i class="tmicon-fa-angle-left"></i> '),
				'next_text' => __(' <i class="tmicon-fa-angle-right"></i> '),
			) );
			$result .= '</div>';
		}
		
		if( $return==true ){
			return $result;
		} else {
			echo $result;
		}
	}
endif;





if ( ! function_exists( 'howes_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
*
* @since Howes 1.0
*
* @return void
*/
function howes_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'howes' ); ?></h1>
		<div class="nav-links">

			<?php previous_post_link( '%link', __( '<span class="meta-nav"></span> Previous', 'howes' ) ); ?>
			<?php next_post_link( '%link', __( 'Next <span class="meta-nav"></span>', 'howes' ) ); ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'thememount_entry_meta' ) ) :
/**
 * Print HTML with meta information for current post: categories, tags, permalink and author.
 *
 * Create your own thememount_entry_meta() to override in a child theme.
 *
 * @since Howes 1.0
 *
 * @return void
 */
function thememount_entry_meta($echo = true) {
	$return = '';
	
	global $post;
	
	if( isset($post->post_type) && $post->post_type=='page' ){
		return;
	}
	
	
	$postFormat = get_post_format();
	
	// Post author
	$categories_list = get_the_category_list( __( ', ', 'howes' ) ); // Translators: used between list items, there is a space after the comma.
	$tag_list        = get_the_tag_list( '', __( ', ', 'howes' ) ); // Translators: used between list items, there is a space after the comma.
	$num_comments    = get_comments_number();
	
	$return .= '<div class="thememount-meta-details">';
		// Date
		$return .= '<span class="tm-date-wrapper"><i class="tmicon-fa-clock-o"></i> ' . get_the_date() . '</span>';

		if ( 'post' == get_post_type() ) {
			if( !is_single() ){
				$return .= sprintf( '<div class="thememount-post-user"><span class="author vcard"><i class="tmicon-fa-user"></i> <a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span></div>',
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					esc_attr( sprintf( __( 'View all posts by %s', 'howes' ), get_the_author() ) ),
					get_the_author()
				);
			}
		}
		if ( $tag_list ) { $return .= '<span class="tags-links"><i class="tmicon-fa-tags"></i> ' . $tag_list . '</span>'; };
		if ( $categories_list ) { $return .= '<span class="categories-links"><i class="tmicon-fa-folder-open"></i> ' . $categories_list . '</span>'; };
		if( !is_sticky() && comments_open() && ($num_comments>0) ){
			$return .= '<span class="comments"><i class="tmicon-fa-comments"></i> ';
			$return .= $num_comments;
			$return .= '</span>';
		}

	$return .= '</div>';
	
	if( $echo == true ){
		echo $return;
	} else {
		return $return;
	}
	
	
}
endif;


if ( ! function_exists( 'thememount_entry_date' ) ) :
/**
 * Print HTML with date information for current post.
 *
 * Create your own thememount_entry_date() to override in a child theme.
 *
 * @since Howes 1.0
 *
 * @param boolean $echo (optional) Whether to echo the date. Default true.
 * @return string The HTML-formatted post date.
 */
function thememount_entry_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) ){
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'howes' );
	} else {
		$format_prefix = '%2$s';
	}
	
	
	$date = '<div class="thememount-post-date-wrapper">';
		$date .= sprintf( '<div class="thememount-entry-date-wrapper"><span class="thememount-entry-date"><time class="entry-date" datetime="%1$s" >%2$s<span class="entry-month entry-year">%3$s<span class="entry-year">%4$s</span></span></time></span><div class="thememount-entry-icon">%5$s</div></div>',
			get_the_date( 'c' ),
			get_the_date( 'j' ),
			get_the_date( 'M' ),
			get_the_date( ', Y' ),
			thememount_entry_icon()
		);
	$date .= '</div>';
	
	if ( $echo ){
		echo $date;
	} else {
		return $date;
	}
}
endif;





if ( ! function_exists( 'thememount_entry_box_date' ) ) :
/**
 * Print HTML with date information for current post.
 *
 * Create your own thememount_entry_box_date() to override in a child theme.
 *
 * @since Howes 1.0
 *
 * @param boolean $echo (optional) Whether to echo the date. Default true.
 * @return string The HTML-formatted post date.
 */
function thememount_entry_box_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) ){
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'howes' );
	} else {
		$format_prefix = '%2$s';
	}
	
	
	$date = '<div class="thememount-post-box-date-wrapper">';
		$date .= sprintf( '<div class="thememount-entry-date-wrapper">
								<span class="thememount-entry-date">
									<time class="entry-date" datetime="%1$s" >
										<span class="entry-date">%2$s</span> 
										<span class="entry-month">%3$s</span> 
										<span class="entry-year">%4$s</span> 
									</time>
								</span>
							</div>',
			get_the_date( 'c' ),
			get_the_date( 'j' ),
			get_the_date( 'M' ),
			get_the_date( ', Y' )
		);
	$date .= '</div>';
	
	if ( $echo ){
		echo $date;
	} else {
		return $date;
	}
}
endif;









if ( ! function_exists( 'thememount_entry_icon' ) ) :
/**
 * Print HTML with icon for current post.
 *
 * Create your own thememount_entry_icon() to override in a child theme.
 *
 * @since Howes 1.0
 *
 */
function thememount_entry_icon( $echo = false ) {
	$postFormat = get_post_format();
	if( is_sticky() ){ $postFormat = 'sticky'; }
	$icon = 'pencil';
	switch($postFormat){
		case 'sticky':
			$icon = 'thumb-tack';
			break;
		case 'aside':
			$icon = 'thumb-tack';
			break;
		case 'audio':
			$icon = 'music';
			break;
		case 'chat':
			$icon = 'comments';
			break;
		case 'gallery':
			$icon = 'files-o';
			break;
		case 'image':
			$icon = 'photo';
			break;
		case 'link':
			$icon = 'link';
			break;
		case 'quote':
			$icon = 'quote-left';
			break;
		case 'status':
			$icon = 'envelope-o';
			break;
		case 'video':
			$icon = 'film';
			break;
	}
	
	$iconCode = '<div class="thememount-post-icon-wrapper">';
		$iconCode .= '<i class="tmicon-fa-'.$icon.'"></i>';
	$iconCode .= '</div>';
	
	
	
	
	
	if ( $echo ){
		echo $iconCode;
	} else {
		return $iconCode;
	}
}
endif;




/**
 * Adding DIV to show loading effect after clicking on any link.
 * @since Howes 1.7
 * @return void
 */
/*function thememount_footer_code() {
    echo '<div class="pageoverlay-static"></div>';
}
add_action('wp_footer', 'thememount_footer_code', 30);*/





if ( ! function_exists( 'howes_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since Howes 1.0
 *
 * @return void
 */
function howes_the_attached_image() {
	/**
	 * Filter the image attachment size to use.
	 *
	 * @since Howes 1.0
	 *
	 * @param array $size {
	 *     @type int The attachment height in pixels.
	 *     @type int The attachment width in pixels.
	 * }
	 */
	$attachment_size     = apply_filters( 'howes_attachment_size', array( 724, 724 ) );
	$next_attachment_url = wp_get_attachment_url();
	$post                = get_post();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Return the post URL.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since Howes 1.0
 *
 * @return string The Link format URL.
 */
function howes_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

if ( ! function_exists( 'howes_body_class' ) ) :
/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Active widgets in the sidebar to change the layout and spacing.
 * 3. When avatars are disabled in discussion settings.
 *
 * @since Howes 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function howes_body_class( $classes ) {
	global $howes;
	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	if ( ! get_option( 'show_avatars' ) )
		$classes[] = 'no-avatars';
	
	if($howes['responsive']=='1'){
		$classes[] = 'thememount-responsive-on';
	} else {
		$classes[] = 'thememount-responsive-off';
	}
	
	return $classes;
}
endif;
add_filter( 'body_class', 'howes_body_class' );

/**
 * Adjust content_width value for video post formats and attachment templates.
 *
 * @since Howes 1.0
 *
 * @return void
 */
function howes_content_width() {
	global $content_width;

	if ( is_attachment() )
		$content_width = 724;
	elseif ( has_post_format( 'audio' ) )
		$content_width = 484;
}
add_action( 'template_redirect', 'howes_content_width' );








/*************** Icon List *****************/
require_once( dirname( __FILE__ ) . '/inc/icons-list.php' );


/*************** Cuztom Framework: Custom Post Type, Texonomy etc. *****************/
require_once( dirname( __FILE__ ) . '/inc/posttype-slides.php' );
require_once( dirname( __FILE__ ) . '/inc/cuztom-helper-framework/cuztom.php' );
require_once( dirname( __FILE__ ) . '/inc/posttype-portfolio.php' );
require_once( dirname( __FILE__ ) . '/inc/posttype-page.php' );
require_once( dirname( __FILE__ ) . '/inc/posttype-team.php' );
require_once( dirname( __FILE__ ) . '/inc/posttype-post.php' );
require_once( dirname( __FILE__ ) . '/inc/posttype-testimonial.php' );
require_once( dirname( __FILE__ ) . '/inc/posttype-client.php' );



/*************** Extra addons in Visual Composer *****************/
if( function_exists('vc_map') && class_exists('WPBMap') ){
	require_once( dirname( __FILE__ ) . '/inc/visual-composer.php' );
}


/*************** Redux Framework: Theme Options *****************/
if ( !class_exists( 'ReduxFramework' ) ) {
	require_once( dirname( __FILE__ ) . '/inc/redux-framework/ReduxCore/framework.php' );
	//require_once( dirname( __FILE__ ) . '/inc/extension-boilerplate-master/custom_field/extension_custom_field.php' );
}

/* Add custom field */
add_action('admin_init', 'tm_redux');
function tm_redux(){
	add_filter( "redux/howes/field/class/thememount_skin_color", "thememount_redux_skin_color" ); // Adds the local field
	add_filter( "redux/howes/field/class/thememount_one_click_demo_content", "thememount_redux_one_click_demo_content" ); // Adds the local field
	add_filter( "redux/howes/field/class/thememount_pre_color_packages", "thememount_redux_pre_color_packages" ); // Adds the local field
	add_filter( "redux/howes/field/class/thememount_icon_select", "thememount_redux_icon_select" ); // Adds the local field
}
function thememount_redux_skin_color($field) {
	return get_template_directory().'/inc/redux-framework/redux_custom_fields/thememount_skin_color/field_thememount_skin_color.php';
}
function thememount_redux_one_click_demo_content($field) {
	return get_template_directory().'/inc/redux-framework/redux_custom_fields/thememount_one_click_demo_content/field_thememount_one_click_demo_content.php';
}
function thememount_redux_pre_color_packages($field) {
	return get_template_directory().'/inc/redux-framework/redux_custom_fields/thememount_pre_color_packages/field_thememount_pre_color_packages.php';
}
function thememount_redux_icon_select($field) {
	return get_template_directory().'/inc/redux-framework/redux_custom_fields/thememount_icon_select/field_thememount_icon_select.php';
}

require_once( dirname( __FILE__ ) . '/inc/redux-options.php' );

/***************************** END Redux Framework **********************************/


add_filter( 'admin_body_class', 'admin_interface_version_body_class' );
function admin_interface_version_body_class( $classes ) {
	// check wp_version
	if ( version_compare( $GLOBALS['wp_version'], '3.8-alpha', '>' ) ) {
		// check admin_color
		//var_dump(get_user_option( 'admin_color' )); die;
		if ( get_user_option( 'admin_color' ) === 'light' ) {
			$classes .= 'light-admin-ui'; // custom new admin interface
		} else {
			$classes .= 'dark-admin-ui'; // new admin interface
		}
	} else {
		$classes .= 'light-admin-ui'; // old admin interface
	}
	$classes .= ' admin-color-fresh'; // new admin interface
	return $classes;
}








/********************** Custom Menus Icon ***********************/
//require_once( dirname( __FILE__ ) . '/inc/custom-menus-icon/custom-menus-icon.php');



/** Post Like ajax **/
add_action('wp_ajax_thememount-portfolio-likes', 'thememount_ajax_callback' );
add_action('wp_ajax_nopriv_thememount-portfolio-likes', 'thememount_ajax_callback' );

function thememount_ajax_callback(){
	if(isset($_POST['likes_id'])){
		$post_id = str_replace('pid-', '', $_POST['likes_id']);
		echo thememount_update_like( $post_id );
	}/*else{
		$post_id = str_replace('stag-likes-', '', $_POST['post_id']);
		echo $this->like_this($post_id, 'get');
	}*/
	exit;
}



function thememount_update_like( $post_id ){
	if(!is_numeric($post_id)) return;

	$return = '';
	$likes = get_post_meta($post_id, 'thememount_likes', true);
	if(!$likes){ $likes = 0; }
	$likes++;
	update_post_meta($post_id, 'thememount_likes', $likes);
	setcookie('thememount_likes_'.$post_id, $post_id, time()*20, '/');
	return '<i class="tmicon-fa-heart"></i> '.$likes.'</i>';
	break;
}




/* Header Topbar spacing */
function thememount_topbar_padding(){
	global $howes;
	$headerHeight = ( isset($howes['header-height']) && trim($howes['header-height'])!='' ) ? trim($howes['header-height']) : '79' ;
	
	// Global Settings
	$topbarHeight = 40;
	if( $howes['topbarhide']=='1' ){
		$topbarHeight = 0;
	}
	
	// Page wise settings
	if( is_page() ){
		global $post;
		$pageTopbarHide = get_post_meta( $post->ID, '_thememount_page_topbar_topbarhide', true );
		if( $pageTopbarHide == '1' ){
			$topbarHeight = 0;
		}
	}
	?>
<style type="text/css">
.tm-header-overlay .thememount-titlebar-wrapper .thememount-titlebar-inner-wrapper{	
	padding-top: <?php echo ($headerHeight+$topbarHeight) ?>px;
}
.thememount-header-style-3.tm-header-overlay .thememount-titlebar-wrapper .thememount-titlebar-inner-wrapper{
	padding-top: <?php echo ($headerHeight+$topbarHeight+55) ?>px;
}
</style>
		
	<?php
}
add_action('wp_head','thememount_topbar_padding');



/*** Theme Customizer: Write inline style for live customizer ****/
function thememount_customizer_script(){
	global $wp_customize;
	if ( isset( $wp_customize ) ) {
		global $howes;
		?>
		<style type="text/css">
		header .thememount-topbar{
			background-color: <?php echo $howes['topbarbgcolor']; ?>;
		}
		header .headerblock .header-inner, #stickable-header-sticky-wrapper{
			background-color: <?php echo $howes['headerbgcolor']; ?>;
		}
		footer.site-footer > div.footer{
			background-color: <?php echo $howes['footerwidget_bgcolor']; ?>;
		}
		footer.site-footer > div.site-info{
			background-color: <?php echo $howes['footertext_bgcolor']; ?>;
		}
		</style>
		
		<?php
	}
}
add_action('wp_head','thememount_customizer_script');





/*********** Required Plugins *************/
// Plugin auto-installer
require_once('inc/class-tgm-plugin-activation.php');
add_action( 'tgmpa_register', 'howes_register_required_plugins' );

// Install Plugins when activate theme
function howes_register_required_plugins(){
	
	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'     				=> 'Revolution Slider', // The plugin name
			'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory() . '/inc/plugins/revslider.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'WPBakery Visual Composer', // The plugin name
			'slug'     				=> 'js_composer', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory() . '/inc/plugins/js_composer.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '4.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'CF Post Formats', // The plugin name
			'slug'     				=> 'cf-post-formats', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory() . '/inc/plugins/cf-post-formats.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Envato WordPress Toolkit', // The plugin name
			'slug'     				=> 'envato-wordpress-toolkit-master', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory() . '/inc/plugins/envato-wordpress-toolkit-master.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name' => 'Breadcrumb NavXT',
			'slug' => 'breadcrumb-navxt',
			'required' => true,
		),
		array(
			'name' => 'Contact Form 7',
			'slug' => 'contact-form-7',
			'required' => true,
		),
		array(
			'name' => 'Max Mega Menu',
			'slug' => 'megamenu',
			'required' => false,
		),
		array(
			'name' => 'Easy Pricing Tables Lite by Fatcat Apps',
			'slug' => 'easy-pricing-tables',
			'required' => false,
		),
	);

	// Change this to your theme text domain, used for internationalising strings
	//$theme_text_domain = 'howes';

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> 'howes',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', 'howes' ),
			'menu_title'                       			=> __( 'Install Plugins', 'howes' ),
			'installing'                       			=> __( 'Installing Plugin: %s', 'howes' ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'howes' ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', 'howes' ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'howes' ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'howes' ), // %1$s = dashboard link
		)
	);
	tgmpa( $plugins, $config );
}
/********************************************************/



/**************** WooCommerce Settings ******************/
if( function_exists('is_woocommerce') ){  /* Check if WooCommerce plugin activated */
	
	// Remove breadcrumb from woocommerce_before_main_content
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
	remove_action( 'woocommerce_before_main_content', 'woocommerce_page_title', 20);
	
	// Remove Page Title
	function thememount_wc_title(){return '';}
	add_action( 'woocommerce_show_page_title', 'thememount_wc_title' );
	
	
	// Change number or products per row to 3
	add_filter('loop_shop_columns', 'loop_columns');
	if (!function_exists('loop_columns')){
		function loop_columns() {
			global $howes;
			$woocommerce_column = ( isset($howes['woocommerce-column']) && trim($howes['woocommerce-column'])!='' ) ? trim($howes['woocommerce-column']) :3 ;
			return $woocommerce_column; // 3 products per row
		}
	}
	
	
	// Remove "product" class from product thumb LI
	if( !function_exists('thememount_wc_remove_product_class') ){
		function thememount_wc_remove_product_class($classes) {
			$classes = array_diff($classes, array("product"));
			return $classes;
		}
	}
	
	
	
	
		
		
	/**
	 * WooCommerce Extra Feature
	 * --------------------------
	 *
	 * Change number of related products on product page
	 * Set your own value for 'posts_per_page'
	 *
	 */ 
	/*function woo_related_products_limit2() {
		global $product;
		$args['posts_per_page'] = 3;
		return $args;
	}*/
	
	
	/*
	 *  WooCommerce : Settings for related products on single page
	 */
	$wc_single_showRelated = (isset($howes['wc-single-show-related']) && trim($howes['wc-single-show-related'])!='') ? $howes['wc-single-show-related'] : '1' ;
	//var_dump($wc_single_showRelated);
	if( $wc_single_showRelated=='0' ){
		// Remove Related Products
		//echo 'NO PRODUCTTT';
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
	} else {
		//echo 'SHOW PRODUCTTT';
		// Show Related Products
		
		
		
		
		// Single product related products : Column
		add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args' );
		function jk_related_products_args( $args ) {
			global $howes;
			$wc_related_column = ( isset($howes['wc-single-related-column']) && trim($howes['wc-single-related-column'])!='' ) ? intval(trim($howes['wc-single-related-column'])) : 3 ;
			//var_dump($howes['wc-single-related-column']);
			$args['columns'] = $wc_related_column; // arranged in 2 columns
			return $args;
		}
		
		
		
		function woo_related_products_limit() {
			//$posts_per_page = 4;
			global $product, $woocommerce_loop, $howes;
			$related = $product->get_related();
			if ( sizeof( $related ) == 0 ) return;
			
			$wc_related_count = ( isset($howes['wc-single-related-count']) && trim($howes['wc-single-related-count'])!='' ) ? intval(trim($howes['wc-single-related-count'])) : 3 ;
			
			$args = array(
				'post_type'        		=> 'product',
				'no_found_rows'    		=> 1,
				'posts_per_page'   		=> $wc_related_count,
				'ignore_sticky_posts' 	=> 1,
				'orderby'             	=> 'rand',
				'post__in'            	=> $related,
				'post__not_in'        	=> array($product->id)
			);
			return $args;
		}
		add_filter( 'woocommerce_related_products_args', 'woo_related_products_limit' );
		
		


		// change the number of upsell products within your WooCommerce shop. Upsell products are displayed at the bottom of a product description page under the â€œYou may also likeâ€¦â€� section
		function woocommerce_upsell_display( $posts_per_page = 4, $columns = 3, $orderby = 'rand' ) {
			global $howes;
			$wc_related_column = ( isset($howes['wc-single-related-column']) && trim($howes['wc-single-related-column'])!='' ) ? intval(trim($howes['wc-single-related-column'])) : 3 ;
			$wc_related_count = ( isset($howes['wc-single-related-count']) && trim($howes['wc-single-related-count'])!='' ) ? intval(trim($howes['wc-single-related-count'])) : 3 ;
			
			woocommerce_get_template( 'single-product/up-sells.php', array(
				'posts_per_page' => $wc_related_count,
				'orderby' => $orderby,
				'columns' => $wc_related_column
			) );
		}

		
		
	}

	
	
	
	// Display xx products per page. Goes in functions.php
	global $howes;
	$wc_productPerPage = ( isset($howes['woocommerce-product-per-page']) && trim($howes['woocommerce-product-per-page'])!='' ) ? trim($howes['woocommerce-product-per-page']) : 9 ;
	add_filter( 'loop_shop_per_page', create_function( '$cols', 'return '.$wc_productPerPage.';' ), 20 );


}




/**
 * Define image sizes
 */
function thememount_woocommerce_image_dimensions() {
  	$catalog = array(
		'width' 	=> '520',	// px
		'height'	=> '520',	// px
		'crop'		=> 1 		// true
	);

	$single = array(
		'width' 	=> '800',	// px
		'height'	=> '800',	// px
		'crop'		=> 1 		// true
	);

	$thumbnail = array(
		'width' 	=> '120',	// px
		'height'	=> '120',	// px
		'crop'		=> 0 		// false
	);

	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}
add_action( 'init', 'thememount_woocommerce_image_dimensions', 1 );

// WooCommerce: Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	?>
	<span class="cart-contents"><?php echo $woocommerce->cart->cart_contents_count ?></span>
	<?php
	$fragments['span.cart-contents'] = ob_get_clean();
	return $fragments;
}


// Add SPAN to numbers in Categories widget
function thememount_add_span_cat_count($links) {
	$links = str_replace('</a> (', '</a> <span>(', $links);
	$links = str_replace(')', ')</span>', $links);
	return $links;
}
add_filter('wp_list_categories', 'thememount_add_span_cat_count');



// Add NiceScroll Options in header
if( isset($howes['scroller_enable']) && $howes['scroller_enable']=='1'){
	add_action('wp_head','thememount_nicescroll');
	if( !function_exists('thememount_nicescroll') ){
		function thememount_nicescroll() {
			global $howes;
			?>
			<script type="text/javascript">
				jQuery( document ).ready(function($) {
					jQuery("html").niceScroll({
						styler:"fb",
						cursorcolor:'#616b74',
						cursorborder:'0',
						zindex:9999,
						horizrailenabled:false,
						mousescrollstep:<?php echo $howes['scroller_speed']; ?>,
						cursorwidth:10
					});
				});
			</script>
			<?php
		}
	}
}



// Add page translation effect
if( isset($howes['pagetranslation']) && $howes['pagetranslation']!='no'){
	add_action('wp_head','thememount_pagetranslation');
	if( !function_exists('thememount_pagetranslation') ){
		function thememount_pagetranslation() {
			global $howes;
			$pagetranslation = explode('|',$howes['pagetranslation']);
			$starteffect = $pagetranslation[0];
			$endeffect   = $pagetranslation[1];
			?>
			<script type="text/javascript">
				jQuery( document ).ready(function($) {
					$(".animsition").animsition({
						inClass               :   '<?php echo $starteffect; ?>',
						outClass              :   '<?php echo $endeffect; ?>',
						inDuration            :    1500,
						outDuration           :    800,
						//linkElement         :   '.animsition-link', 
						linkElement           :   'a:not([target="_blank"]):not([href^=#]):not("a.comment-reply-link"):not("#cancel-comment-reply-link"):not([rel^="prettyPhoto"]):not([data-rel^="prettyPhoto"]):not([rel^="lightbox"]):not([href^="javascript:void(0)"]):not([href^="mailto"]):not(".button.add_to_cart_button"):not(".tribe-events-ical.tribe-events-button"):not(".lang_sel_sel")',
						// e.g. linkElement   :   'a:not([target="_blank"]):not([href^=#])'
						touchSupport          :    true, 
						loading               :    true,
						loadingParentElement  :   'body', //animsition wrapper element
						loadingClass          :   'pageoverlay',
						unSupportCss          : [ 'animation-duration',
												  '-webkit-animation-duration',
												  '-o-animation-duration'
						]
						//"unSupportCss" option allows you to disable the "animsition" in case the css property in the array is not supported by your browser. 
						//The default setting is to disable the "animsition" in a browser that does not support "animation-duration". 
					});
				});
			</script>
			<?php
		}
	}
}



/* ajaxurl */add_action('wp_head','pluginname_ajaxurl');function pluginname_ajaxurl() { ?>	<script type="text/javascript">	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';	</script><?php }

/**
 *  Start of Jat's custom codes
 */
function install_satarah_tables()
{
	global $wpdb;
	
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
	
	$strPayinTableName = $wpdb->prefix . "satarah_payin";
	$strPayinHistoryTableName = $wpdb->prefix . "satarah_payin_history";
	$strSchemeTableName = $wpdb->prefix . "satarah_scheme";
	$strReferralTableName = $wpdb->prefix . "satarah_referral";
	$strProductList = $wpdb->prefix . "satarah_product_list";
	$strProductClaim = $wpdb->prefix . "satarah_product_claim";
	
	// DROP TABLE IF EXISTS `satarah_payin`;
	
	$strSQL = "CREATE TABLE $strPayinTableName (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `userid` int(11),
				  `amount` bigint(20),
				  `entry_date` bigint(20),
				  `type` int(11),
				  `rate` int(11),
				  `split` int(11),
				  `scheme` int(11),
				  `is_active` int(11),
				  PRIMARY KEY(`id`)
				)
				ENGINE=INNODB
				CHARACTER SET utf8 
				COLLATE utf8_unicode_ci ;
 		
	 		  CREATE TABLE $strPayinHistoryTableName (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `payin_id` int(11),
				  `amount` float(9,2),
				  `points` int(11),
				  `status` int(11),
				  `payout_date` int(11),
				  `remarks` varchar(50),
				  `is_active` int(11),
				  PRIMARY KEY(`id`)
				)
				ENGINE=INNODB
				CHARACTER SET utf8 
				COLLATE utf8_unicode_ci ;
 		
	 		  CREATE TABLE $strSchemeTableName (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `description` varchar(50),
				  `rate` float(9,2),
				  `split` int(11),
				  `points` float(9,2),
				  `referrer_cash_rate` float(9,2),
				  `referrer_product_rate` float(9,2),
				  `date_created` int(11),
				  `created_by` int(11),
				  `date_modified` int(11),
				  `modified_by` int(11),
				  `is_active` int(11),
				  PRIMARY KEY(`id`)
				)
				ENGINE=INNODB
				CHARACTER SET utf8 
				COLLATE utf8_unicode_ci ;
				
			CREATE TABLE $strReferralTableName (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `referrer` int(11),
				  `referree` int(11),
				  `cash_commission` float(9,2),
				  `cash_commission_status` int(11),
				  `product_commission` float(9,2),
				  `product_commission_status` int(11),
				  `tax` float(9,2),
				  `release_date` int(11),
				  PRIMARY KEY(`id`)
				)
				ENGINE=INNODB
				CHARACTER SET utf8 
				COLLATE utf8_unicode_ci ;
				
			CREATE TABLE $strProductList (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `product_details` varchar(50),
			  `product_value` float(9,2),
			  PRIMARY KEY(`id`)
			)
			ENGINE=INNODB
			CHARACTER SET utf8 
			COLLATE utf8_unicode_ci ;
			
			CREATE TABLE $strProductClaim (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `userid` int(11),
			  `product_id` int(11),
			  `product_amount` int(11),
			  `date_claimed` int(11),
			  PRIMARY KEY(`id`)
			)
			ENGINE=INNODB
			CHARACTER SET utf8 
			COLLATE utf8_unicode_ci ;
 	";
	
	dbDelta( $strSQL );	
}

add_action('after_switch_theme', 'install_satarah_tables');

/**
 * Update payout from account profile
 * AJAX
 */
function update_payout()
{
	global $wpdb;
	$strPayinHistoryTable = $wpdb->prefix . 'satarah_payin_history';
	
	$arrData = $_POST;
	
	if((int)$arrData['status'] == 1)
	{
		$boolIsActive = 0;
	}
	else
	{
		$boolIsActive = 1;
	}
	
	$arrUpdateData = array(
		'status' 	  => (int) $arrData['status'],
		'payout_date' => strtotime($arrData['payout_date']),
		'remarks'	  => $arrData['remarks'],
		'is_active'	  => $boolIsActive
	);
	
	$arrWhere = array(
		'id'		=> (int) $arrData['id'],
		'payin_id'	=> (int) $arrData['payin_id']
	);
	
	$boolResult = $wpdb->update($strPayinHistoryTable, $arrUpdateData, $arrWhere);
	
	if(false == $boolResult)
	{
		$arrResult = array(
			'success' => false,
			'message' => "Error: Update failed." 
		); 
	}
	else
	{
		$arrResult = array(
			'success' => true,
			'message' => "Updated successfully" 
		);
	}
	 
	echo json_encode($arrResult);
	die();
}
add_action('wp_ajax_update_payout', 'update_payout');

/**
 * Modify the default role name of wordpress
 */
function change_role_name() 
{
	global $wp_roles;
	
	if ( ! isset( $wp_roles ) )
		$wp_roles = new WP_Roles();
	//You can use any of the roles "administrator" "editor", "author", "contributor" or "subscriber"...
	$wp_roles->roles['editor']['name'] = 'Auditor';
	$wp_roles->role_names['editor'] = 'Auditor';
	$wp_roles->roles['author']['name'] = 'Cashier';
	$wp_roles->role_names['author'] = 'Cashier';
	$wp_roles->roles['contributor']['name'] = 'Release Officer';
	$wp_roles->role_names['contributor'] = 'Release Officer';
	$wp_roles->roles['subscriber']['name'] = 'Investor';
	$wp_roles->role_names['subscriber'] = 'Investor';
}
add_action('init', 'change_role_name');

function get_control_number($aStrType = "payin")
{
	global $wpdb;
	
	switch ($aStrType)
	{
		case "claim":
			$strTable = $wpdb->prefix . 'satarah_product_claim';
			break;
		case "payin":
		default:
			$strTable = $wpdb->prefix . 'satarah_payin';
			break;
	}	
	
	$strControlNumber = date('Y', time()) . '-';
	
	$objResults = $wpdb->get_row("SELECT * FROM $strTable ORDER BY id DESC LIMIT 1");
	
	if(null == $objResults)
	{
		$strControlNumber .= str_pad('1', 5, 0, STR_PAD_LEFT);
	}
	else
	{
		$strControlNumber .= str_pad(($objResults->id + 1), 5, 0, STR_PAD_LEFT);
	}
	return $strControlNumber;
}


function add_payin_schemes($aArrData)
{
	global $wpdb;
	$strSchemeTable = $wpdb->prefix . 'satarah_scheme';
	$intUserid = get_current_user_id();
	
	unset($aArrData['posttype']);
	unset($aArrData['id']);
	
	$intUserid = get_current_user_id();
	foreach ($aArrData as $strKey => $strData)
	{
		if($strKey == 'description')
		{
			continue;
		}
		
		$aArrData[$strKey] = (int) $strData;
	}
	
	$aArrData['created_by'] = $intUserid;
	$aArrData['date_created'] = time();
	$aArrData['is_active'] = 1;
	
	$objData = $wpdb->get_row("SELECT id FROM $strSchemeTable ORDER BY date_created DESC LIMIT 1");
			
	if(false != $objData)
	{
		$updateData = array(
			'date_modified' => time(),
			'modified_by' => $intUserid,
			'is_active' => 0				
		);
		
		$whereData = array(
			'id' => $objData->id
		);
		
		$wpdb->update($strSchemeTable, $updateData, $whereData);
	}
		
	$boolResult = $wpdb->insert($strSchemeTable, $aArrData);		
	
	return $boolResult;
}

function update_payin_scheme($aArrData)
{
	global $wpdb;
	$strSchemeTable = $wpdb->prefix . 'satarah_scheme';	
	
	unset($aArrData['posttype']);

	$intSchemeid = $aArrData['id'];
	unset($aArrData['id']);

	$intUserid = get_current_user_id();
	
	$aArrData['modified_by'] = $intUserid;
	$aArrData['date_modified'] = time();
	
	foreach ($aArrData as $strKey => $strData)
	{
		if($strKey == 'description')
		{
			continue;
		}
	
		$aArrData[$strKey] = (int) $strData;
	}
	
	$arrWhereData = array(
		'id' => $intSchemeid 	
	);
	
	$boolResult = $wpdb->update($strSchemeTable, $aArrData, $arrWhereData);
	
	return $boolResult;
}

function get_payin_schemes($aBoolEditScreen = false)
{
	global $wpdb;
	$strSchemeTable = $wpdb->prefix . 'satarah_scheme';
	
	$arrSchemes = array();	
	
	if($aBoolEditScreen == false)
	{
		$strWhere = "WHERE is_active = 1 ORDER BY date_created DESC LIMIT 1";
	}
	else
	{
		$strWhere = "";
	}
	
	$arrResults = $wpdb->get_results("SELECT * FROM $strSchemeTable $strWhere");
	
	foreach ($arrResults as $objResult)
	{
		$strSchemeCode = "SPC-";
		$strSchemeCode .= str_pad($objResult->id, 5, 0, STR_PAD_LEFT);

		$objCreator = get_user_by('id', $objResult->created_by);

		$objModifier = get_user_by('id', $objCreator->modified_by);
		
		$arrSchemes[] = array(
				'name' 			=> $strSchemeCode,
				'value' 		=> $objResult->id,
				'description'	=> $objResult->description,
				'rate'			=> $objResult->rate,
				'split' 		=> $objResult->split,
				'points'		=> $objResult->points,
				'referrer_cash_rate'    => $objResult->referrer_cash_rate,
				'referrer_product_rate' => $objResult->referrer_product_rate,
				'date_created' 	=> date('F-d-Y', $objResult->date_created),
				'created_by' 	=> $objCreator->display_name,
				'date_modified'	=> date('F-d-Y', $objResult->date_modified),
				'modified_by'	=> $objModifier->display_name,
				'is_active'		=> $objResult->is_active
		);	
	}
	return $arrSchemes;
}

function add_new_payin($aArrData)
{
	global $wpdb;
	$strPayinTable = $wpdb->prefix . 'satarah_payin';
	
	$aArrData['entry_date'] = time();
	$aArrData['is_active'] = 1;	
	
	$intReferer = $aArrData['referrer'];
	if($intReferer > 0)
	{
		$arrReferralData = array(
			'referrer' => $aArrData['referrer'],
			'referrer_cash_rate' => $aArrData['referrer_cash_rate'],
			'referrer_product_rate' => $aArrData['referrer_product_rate'],
			'referree' => $aArrData['userid'],
			'referree_invesment' => $aArrData['amount'],
			'type' => $aArrData['type']
		);
		unset($aArrData['referrer']);
		unset($aArrData['referrer_cash_rate']);
		unset($aArrData['referrer_product_rate']);
		
		process_referral($arrReferralData);
	}
	else 
	{
		unset($aArrData['referrer']);
		unset($aArrData['referrer_cash_rate']);
		unset($aArrData['referrer_product_rate']);
	}
	
	$boolPoints = 0;
	if(isset($aArrData['points']))
	{
		$boolPoints = $aArrData['points'];
		unset($aArrData['points']);
	}
	
	$boolSuccess = $wpdb->insert($strPayinTable, $aArrData);
	
	if(false == $boolSuccess)
	{
		return "2";
	}
	else
	{
		$objPayinId = $wpdb->get_row("SELECT id FROM $strPayinTable ORDER BY id DESC LIMIT 1");
		$aArrData['payin_id'] = $objPayinId->id;
		$aArrData['points'] = $boolPoints;
		process_payout_order($aArrData);
	}
	
	return "3";
}

function process_payout_order($aArrData)
{
	global $wpdb;
	$strPayinHistoryTable = $wpdb->prefix . 'satarah_payin_history';	
	
	$intInvestmentEntry = $aArrData['amount'];
	$intRate = $aArrData['rate'];
	$intSplit = $aArrData['split'];
	$intCtr = 1;
	
	$flPayoutAmount = $intInvestmentEntry * ($intRate / 100);	
		
	// Check and set points to award
	$intPoints = 0;	
	if(1 == $aArrData['points'])
	{
		$intPoints = $intInvestmentEntry * (.03 / 100);		
	}
	
	// Check split if base six; process if not
	if($intSplit < 6)
	{
		$flPayoutAmount = $flPayoutAmount + ($flPayoutAmount / $intSplit);
	}
	else if ($intSplit > 6)
	{
		$flPayoutAmount = $flPayoutAmount - ($flPayoutAmount / $intSplit);
	}
	
	if(1 == $aArrData['type'])
	{
		$intStatus = 2;
	}
	else
	{
		$intStatus = 0;
	}
	
	$arrData = array(
			'payin_id' 		=> $aArrData['payin_id'],
			'amount'		=> $flPayoutAmount,
			'points'		=> $intPoints,
			'status'		=> $intStatus,
			'payout_date'	=> 0,
			'remarks'		=> '',
			'is_active'		=> 1
			 
	);
	
	// Insert split amount
	while ($intCtr < $intSplit)
	{
		$wpdb->insert($strPayinHistoryTable, $arrData);
		++$intCtr;	
	}
	// Insert final investment amount
	$intEndPayoutAmount = $intInvestmentEntry + $flPayoutAmount;
	
	$arrData = array(
			'payin_id' 		=> $aArrData['payin_id'],
			'amount'		=> $intEndPayoutAmount,
			'points'		=> $intPoints,
			'status'		=> 0,
			'payout_date'	=> 0,
			'remarks'		=> '',
			'is_active'		=> 1
	
	);
	$boolResult = $wpdb->insert($strPayinHistoryTable, $arrData);
	
	if($boolResult == false)
	{
		return "4";
	}
}

function process_referral($aArrData)
{
	global $wpdb;
	$strReferralTable = $wpdb->prefix . "satarah_referral";	
	
	$intCashCommission = $aArrData['referree_invesment'] * ($aArrData['referrer_cash_rate'] / 100) * .7;
	$intProductCommission = $aArrData['referree_invesment'] * ($aArrData['referrer_product_rate'] / 100) * .2;
	$intTaxRate = $aArrData['referree_invesment'] * ($aArrData['referrer_cash_rate'] / 100) * .1;
	
	if(1 == $aArrData['type'])
	{
		$intStatus = 2;
	}
	else
	{
		$intStatus = 0;
	}
	
	$arrData = array(
		'referrer' =>  $aArrData['referrer'],
		'referree' =>  $aArrData['referree'],
		'cash_commission' => $intCashCommission,
		'cash_commission_status' => $intStatus,
		'product_commission' => $intProductCommission,
		'product_commission_status' => $intStatus,
		'tax' => $intTaxRate,
		'release_date' => 0		
	);
	
	$boolResult = $wpdb->insert($strReferralTable, $arrData);	
}


function get_payout_data($aIntUserid, $aIntPayinid = 0)
{
	global $wpdb;
	$strPayinHistoryTable = $wpdb->prefix . "satarah_payin_history";
	$strPayinTable = $wpdb->prefix . "satarah_payin";	
	
	if(0 == $aIntPayinid)
	{
		$strPayinOption = '';
	}
	else
	{
		$strPayinOption = "AND history.payin_id = $aIntPayinid";
	}
	
	$arrPayoutData = $wpdb->get_results("SELECT history.id,
												history.payin_id,
												history.amount,
												history.points,
												history.status,
												history.payout_date,
												history.remarks
										 FROM $strPayinHistoryTable history
										 LEFT JOIN $strPayinTable payin
										 ON history.payin_id = payin.id
										 WHERE payin.userid = $aIntUserid										 
										 $strPayinOption
	");
	
	return $arrPayoutData;
}

function get_total_investment($aIntUserid)
{
	global $wpdb;
	$strPayinTable = $wpdb->prefix . "satarah_payin";
	
	$arrResults = $wpdb->get_results("SELECT amount FROM $strPayinTable WHERE userid = $aIntUserid");
	
	$intTotalInvestment = 0;
	
	foreach ($arrResults as $objResult)
	{
		$intTotalInvestment += $objResult->amount;
	}
	
	$intTotalInvestment = number_format($intTotalInvestment, 2);
	
	return $intTotalInvestment;
}

function get_total_points($aIntUserid)
{
	global $wpdb;
	$strPayinTable = $wpdb->prefix . "satarah_payin";
	$strPayinHistoryTable = $wpdb->prefix . "satarah_payin_history";
	
	$arrResults = $wpdb->get_results("SELECT SUM(ph.points) FROM $strPayinHistoryTable ph INNER JOIN $strPayinTable p ON ph.payin_id = p.id WHERE p.userid = $aIntUserid");		
	
	foreach ($arrResults as $objResult)
	{
		foreach ($objResult as $intPoints)
		{
			if("" == $intPoints)
			{
				return "0";
			}
			else 
			{
				return $intPoints;
			}
		}
	}	
}

function get_total_cash_commission($aIntUserid)
{
	global $wpdb;
	$strReferralTable = $wpdb->prefix . "satarah_referral";
	
	$arrResults = $wpdb->get_results("SELECT SUM(cash_commission) FROM $strReferralTable WHERE referrer = $aIntUserid");
	
	if(empty($arrResults))
	{
		return number_format(0,2);
	}
	
	foreach ($arrResults as $objResult)
	{
		foreach ($objResult as $intResult)
		{
			return number_format($intResult, 2);
		}
	}
}

function get_payout_timeframe($aIntUserid)
{
	global $wpdb;
	$strPayinTable = $wpdb->prefix . "satarah_payin";
	$arrOptions = array();
	
	$arrResults = $wpdb->get_results("SELECT * FROM $strPayinTable WHERE is_active = 1 AND userid = $aIntUserid");
	
	foreach ($arrResults as $objResult)
	{
		$arrOptions[] = array(
			'name' => date('F-d-Y', $objResult->entry_date),
			'payin_id' => $objResult->id
		);	
	}
	
	return $arrOptions;
}

function get_previous_payin($aIntUserid)
{
	global $wpdb;
	$strPayinTable = $wpdb->prefix . "satarah_payin";
	
	$objData = $wpdb->get_row("SELECT * FROM $strPayinTable WHERE userid = $aIntUserid ORDER BY entry_date DESC LIMIT 1");
	
	return $objData;
}

function get_previous_last_payout($aIntUserid)
{
	global $wpdb;
	$strPayinHistoryTable = $wpdb->prefix . "satarah_payin_history";
	
	$objPayinData = get_previous_payin($aIntUserid);
	
	$objData = $wpdb->get_row("SELECT amount FROM $strPayinHistoryTable WHERE payin_id = $objPayinData->id ORDER BY amount DESC LIMIT 1");
	
	return format_number($objData->amount);
}

function format_number($aIntNumber)
{
	return number_format($aIntNumber, 2);
}

function get_referrers()
{
	global $wpdb;
	
	$arrUsers = $wpdb->get_results("SELECT * FROM $wpdb->users");
	$arrUserOptions = array();
	
	foreach ($arrUsers as $objUser)
	{
		$arrUserOptions[] = array(
			'value' => $objUser->ID,
			'name'	=> $objUser->display_name
		);	
	}
	
	return $arrUserOptions;
}

function get_referrals($aIntUserid)
{
	global $wpdb;
	$strReferralTable = $wpdb->prefix . "satarah_referral";
	
	$arrReferals = $wpdb->get_results("SELECT * FROM $strReferralTable WHERE referrer = $aIntUserid");
	
	return $arrReferals;
}

function process_dates($aIntUnixtime)
{
	if($aIntUnixtime > 0)
	{
		return date('F-d-Y', $aIntUnixtime);
	}
	else
	{
		return "Not set";
	}
}

function process_status($aIntStatus)
{
	$arrStatus = array();
	
	switch ($aIntStatus)
	{
		case 0:
			$arrStatus = array(
				'pending' => 'selected',
				'claimed' => '',
				'queued' => '',
				'name'   => 'Pending'
			);
			break;
		case 1:
			$arrStatus = array(
				'pending' => '',
				'claimed' => 'selected',
				'queued' => '',
				'name'   => 'Claimed'
			);
			break;
		case 2:
			$arrStatus = array(
				'pending' => '',
				'claimed' => '',
				'queued' => 'selected',
				'name'   => 'Queued'
			);
			break;
	}
	
	return $arrStatus;
}

function get_recent_payinid($aIntUserid)
{
	global $wpdb;
	$strPayinTable = $wpdb->prefix . "satarah_payin";
	
	$objPayinid = $wpdb->get_row("SELECT * FROM $strPayinTable WHERE userid = $aIntUserid ORDER BY entry_date DESC");
	
	return $objPayinid->id;
}

function get_claimed_products($aIntUserid)
{
	global $wpdb;
	$strProductClaim = $wpdb->prefix . "satarah_product_claim";
	
	$arrProductsClaimed = $wpdb->get_results("SELECT * FROM $strProductClaim WHERE userid = $aIntUserid");
	
	return $arrProductsClaimed;	
}

function get_product_details($aIntProductid = 0)
{
	global $wpdb;
	$strProductList = $wpdb->prefix . "satarah_product_list";
	$strWhere = "";
	
	if(0 != $aIntProductid)
	{
		$strWhere = "WHERE id = $aIntProductid";
	}
	
	$arrProductsClaimed = $wpdb->get_results("SELECT * FROM $strProductList $strWhere");
	
	if(0 != $aIntProductid)
	{
		return $arrProductsClaimed[0]->product_details;
	}
	else
	{
		return $arrProductsClaimed;
	}
}

function add_claim($aArrData)
{
	global $wpdb;
	$strProductClaimTable = $wpdb->prefix . "satarah_product_claim";
	
	return $boolResult = $wpdb->insert($strProductClaimTable, $aArrData);
		
}

function add_product($aArrData)
{
	global $wpdb;
	$strProductListTable = $wpdb->prefix . "satarah_product_list";
	
	return $boolResult = $wpdb->insert($strProductListTable, $aArrData);
}