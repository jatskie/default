<?php
$args = array();

// For use with a tab example below
$tabs = array();

ob_start();

$ct = wp_get_theme();
$theme_data = $ct;
$item_name = $theme_data->get('Name'); 
$tags = $ct->Tags;
$screenshot = $ct->get_screenshot();
$class = $screenshot ? 'has-screenshot' : '';
$customize_title = sprintf( __( 'Customize &#8220;%s&#8221;','howes' ), $ct->display('Name') );
?>

<div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
	<?php if ( $screenshot ) : ?>
		<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
		<a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr( $customize_title ); ?>">
			<img src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
		</a>
		<?php endif; ?>
		<img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
	<?php endif; ?>

	<h4>
		<?php echo $ct->display('Name'); ?>
	</h4>

	<div>
		<ul class="theme-info">
			<li><?php printf( __('By %s','howes'), $ct->display('Author') ); ?></li>
			<li><?php printf( __('Version %s','howes'), $ct->display('Version') ); ?></li>
			<li><?php echo '<strong>'.__('Tags', 'howes').':</strong> '; ?><?php printf( $ct->display('Tags') ); ?></li>
		</ul>
		<p class="theme-description"><?php echo $ct->display('Description'); ?></p>
		<?php if ( $ct->parent() ) {
			printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.' ) . '</p>',
				__( 'http://codex.wordpress.org/Child_Themes','howes' ),
				$ct->parent()->display( 'Name' ) );
		} ?>
		
	</div>

</div>

<?php
$item_info = ob_get_contents();
    
ob_end_clean();

$sampleHTML = '';
if( file_exists( dirname(__FILE__).'/info-html.html' )) {
	/** @global WP_Filesystem_Direct $wp_filesystem  */
	global $wp_filesystem;
	if (empty($wp_filesystem)) {
		require_once(ABSPATH .'/wp-admin/includes/file.php');
		WP_Filesystem();
	}  		
	$sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__).'/info-html.html');
}




/*
 *  Disable tracking for Redux Framework
 */
$options                   = get_option( 'redux-framework-tracking' );
$options['allow_tracking'] = 'no';
update_option( 'redux-framework-tracking', $options );




// BEGIN Sample Config

// Setting dev mode to true allows you to view the class settings/info in the panel.
// Default: true
$args['dev_mode']   = false;
$args['customizer'] = false;

// Set the icon for the dev mode tab.
// If $args['icon_type'] = 'image', this should be the path to the icon.
// If $args['icon_type'] = 'iconfont', this should be the icon name.
// Default: info-sign
//$args['dev_mode_icon'] = 'info-sign';

// Set the class for the dev mode tab icon.
// This is ignored unless $args['icon_type'] = 'iconfont'
// Default: null
$args['dev_mode_icon_class'] = 'icon-large';

// Set a custom option name. Don't forget to replace spaces with underscores!
$args['opt_name'] = 'howes';

// Setting system info to true allows you to view info useful for debugging.
// Default: false
//$args['system_info'] = true;


// Set the icon for the system info tab.
// If $args['icon_type'] = 'image', this should be the path to the icon.
// If $args['icon_type'] = 'iconfont', this should be the icon name.
// Default: info-sign
//$args['system_info_icon'] = 'info-sign';

// Set the class for the system info tab icon.
// This is ignored unless $args['icon_type'] = 'iconfont'
// Default: null
//$args['system_info_icon_class'] = 'icon-large';

$theme = wp_get_theme();

$args['display_name'] = $theme->get('Name');
//$args['database'] = "theme_mods_expanded";
$args['display_version'] = $theme->get('Version');

// If you want to use Google Webfonts, you MUST define the api key.
$args['google_api_key'] = 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII';

// Define the starting tab for the option panel.
// Default: '0';
//$args['last_tab'] = '0';

// Define the option panel stylesheet. Options are 'standard', 'custom', and 'none'
// If only minor tweaks are needed, set to 'custom' and override the necessary styles through the included custom.css stylesheet.
// If replacing the stylesheet, set to 'none' and don't forget to enqueue another stylesheet!
// Default: 'standard'
//$args['admin_stylesheet'] = 'standard';

// Setup custom links in the footer for share icons
$args['share_icons']['twitter'] = array(
	'link' => 'https://twitter.com/thememountinfotech',
	'title' => 'Follow us on Twitter', 
	'img' => get_template_directory_uri() . '/inc/images/twitter.png'
);

// Enable the import/export feature.
// Default: true
//$args['show_import_export'] = false;

// Set the icon for the import/export tab.
// If $args['icon_type'] = 'image', this should be the path to the icon.
// If $args['icon_type'] = 'iconfont', this should be the icon name.
// Default: refresh
//$args['import_icon'] = 'refresh';

// Set the class for the import/export tab icon.
// This is ignored unless $args['icon_type'] = 'iconfont'
// Default: null
$args['import_icon_class'] = 'icon-large';

/**
 * Set default icon class for all sections and tabs
 * @since 3.0.9
 */
$args['default_icon_class'] = 'icon-large';


// Set a custom menu icon.
//$args['menu_icon'] = '';

// Set a custom title for the options page.
// Default: Options
$args['menu_title'] = __('Theme Options', 'howes');

// Set a custom page title for the options page.
// Default: Options
$args['page_title'] = __('Theme Options', 'howes');

// Set a custom page slug for options page (wp-admin/themes.php?page=***).
// Default: redux_options
$args['page_slug'] = 'thememount_theme_options';

$args['default_show'] = true;
$args['default_mark'] = '*';

// Set a custom page capability.
// Default: manage_options
//$args['page_cap'] = 'manage_options';

// Set the menu type. Set to "menu" for a top level menu, or "submenu" to add below an existing item.
// Default: menu
//$args['page_type'] = 'submenu';
$args['page_type'] = 'submenu';

// Set the parent menu.
// Default: themes.php
// A list of available parent menus is available at http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
//$args['page_parent'] = 'options_general.php';

// Set a custom page location. This allows you to place your menu where you want in the menu order.
// Must be unique or it will override other items!
// Default: null
//$args['page_position'] = null;

// Set a custom page icon class (used to override the page icon next to heading)
//$args['page_icon'] = 'icon-themes';

// Set the icon type. Set to "iconfont" for Elusive Icon, or "image" for traditional.
// Redux no longer ships with standard icons!
// Default: iconfont
//$args['icon_type'] = 'image';

// Disable the panel sections showing as submenu items.
// Default: true
//$args['allow_sub_menu'] = false;
    
// Set ANY custom page help tabs, displayed using the new help tab API. Tabs are shown in order of definition.
$args['help_tabs'][] = array(
    'id' => 'thememount-opts-1',
    'title' => __('Help and Support', 'howes'),
    'content' => __('<h3>Help and Support</h3>
		<ul>
			<li><a href="http://howes.thememount.com/documentation/index.html" target="_blank">Theme Help Documenation</a></li>
			<li><a href="http://support.thememount.com/" target="_blank">Questions? Ask us here.</a></li>
			<li><a href="http://howes.thememount.com/" target="_blank">Live Demo</a></li>
		</ul>', 'howes')
);
/*$args['help_tabs'][] = array(
    'id' => 'thememount-opts-2',
    'title' => __('Theme Information 2', 'howes'),
    'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'howes')
);*/

// Set the help sidebar for the options page.                                        
//$args['help_sidebar'] = __('<p></p>', 'howes');


// Add HTML before the form.
if (!isset($args['global_variable']) || $args['global_variable'] !== false ) {
	if (!empty($args['global_variable'])) {
		$v = $args['global_variable'];
	} else {
		$v = str_replace("-", "_", $args['opt_name']);
	}
	$args['intro_text'] = sprintf( __('<p>If you have any problem or question than you can <a href="http://howes.thememount.com/documentation/" target="_blank">read theme documentation online by clicking here</a>. If still not working than you can contact us via our <a href="http://support.thememount.com" target="_blank">support ticket system</a>.</p>', 'howes' ), $v );
} else {
	$args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'howes');
}

// Add content after the form.
//$args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'howes');

// Set footer/credit line.
//$args['footer_credit'] = __('<p>This text is displayed in the options panel footer across from the WordPress version (where it normally says \'Thank you for creating with WordPress\'). This field accepts all HTML.</p>', 'howes');


$sections = array();              

//Background Patterns Reader
$sample_patterns_path = ReduxFramework::$_dir . '../../../images/patterns/';
$sample_patterns_url  = get_template_directory_uri() . '/images/patterns/';
$sample_patterns      = array();

//var_dump($sample_patterns_path); die();
//var_dump($sample_patterns_path); die();

if ( is_dir( $sample_patterns_path ) ) :
	if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
		$sample_patterns = array();
		while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {
			if( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
				$name = explode(".", $sample_patterns_file);
				$name = str_replace('.'.end($name), '', $sample_patterns_file);
				$sample_patterns[] = array( 'alt'=>$name,'img' => $sample_patterns_url . $sample_patterns_file );
			}
		}
	endif;
endif;

//var_dump($sample_patterns);



/*****************************************************************************/

// Layout Settings
$sections[] = array(
	'title'  => __('Layout Settings', 'howes'),
	'header' => __('Layout Settings', 'howes'),
	'desc'   => __('Specify theme pages layout, the skin coloring and background', 'howes'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-website',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		/*array(
			'id'       => 'coption',
			'type'     => 'custom_field',
			'title'    => __('Custom Opiton', 'howes'), 
			'subtitle' => __('Specify the layout for the pages', 'howes'),
			'options'  => array('wide' => 'Wide', 'boxed' => 'Boxed'),//Must provide key => value pairs for radio options
			//'desc'   => __('This is the description field, again good for additional info.', 'howes'),
			'default'  => 'wide',
			//'value'  => '2'
		),*/
		array(
			'id'         => 'thememount_one_click_demo_content',
			'type'       => 'thememount_one_click_demo_content',
			'title'      => __('Demo Content Setup', 'howes'), 
			'subtitle'   => __('This is one click demo content setup', 'howes'),
			'customizer' => false,
		),
		array(
			'id'       => 'thememount_pre_color_packages',
			'type'     => 'thememount_pre_color_packages',
			'title'    => __('Dark / Light Color Switcher', 'howes'), 
			'subtitle' => __('You will get Light and Dark color settings in just one click. So you don\'t need to set each options individually. The LIGHT is the default view of the site.', 'howes'),
			//'default'  => '#e85e16',
			//'validate' => 'color',
			'customizer'=> false,
			//'compiler' => 'true',
		),
		array(
			'id'       => 'layout',
			'type'     => 'radio',
			'title'    => __('Pages Layout', 'howes'), 
			'subtitle' => __('Specify the layout for the pages', 'howes'),
			'options'  => array('wide'     => 'Wide',
								'boxed'    => 'Boxed',
								'framed'   => 'Framed',
								'rounded'  => 'Rounded',
								'fullwide' => 'Full Wide',
						),//Must provide key => value pairs for radio options
			//'desc'   => __('This is the description field, again good for additional info.', 'howes'),
			'default'  => 'wide',
			//'customizer'=> true,
			//'value'  => '2'
		),
		array(
			'id'        => 'full_wide_elements',
			'type'      => 'checkbox',
			'title'     => __('Select Elements for Full Wide View (in above option)', 'howes'),
			'subtitle'  => __('Select elements that you want to show in full-wide view.', 'howes'),
			'desc'      => __('Select elements that you want to show in full-wide view.', 'howes'),
			'required'  => array('layout','equals','fullwide'),
			//Must provide key => value pairs for multi checkbox options
			'options'   => array(
				'header'  => __('Header', 'howes'),
				'content' => __('Content Area', 'howes'),
				'footer'  => __('Footer', 'howes'),
			),
			
			//See how std has changed? you also don't need to specify opts that are 0.
			'default'   => array(
				'header'  => '1',
				'content' => '1',
				'footer'  => '1',
			)
		),
		
		array(
			'id'       => 'responsive',
			'type'     => 'switch',
			'title'    => __('Responsive Design', 'howes'), 
			'subtitle' => __('Check this option to enable responsive design to the theme', 'howes'),
			'on'       => 'Yes',
			'off'      => 'No',
			'default'  => '1', // 1 = on | 0 = off
			'customizer'=> false,
		),
		array(
			'id'       => 'skincolor',
			'type'     => 'thememount_skin_color',
			'title'    => __('Skin Color', 'howes'), 
			'subtitle' => __('Custom color for skin. This is color to highlight different elements. Like text links, active tabs, progress bars, active accordion and others.', 'howes'),
			'default'  => '#1abc9c',
			'values'   => array(
				'Mountain Meadow'  => '#1abc9c',
				'Bright Turquoise' => '#21cdec',
				'Tabasco'          => '#ae1010',
				'Emerald'          => '#4abe63',
				'Green'            => '#89c355',
				'Tan'              => '#00bdbd',
				'Yellow'           => '#ffbe00',
				'Brown'            => '#964b00',
				'Cinnabar'         => '#e64d3b',
				'Mongoose'         => '#b8a279',
			),
			'validate'   => 'color',
			//'customizer' => true,
			'compiler'   => 'true',
		),
		
		
		
		
		
		
		array(
			'id'    =>'html-backgroundsettings',
			'type'  => 'info',
			'title' => __('Background Settings', 'howes'), 
			'desc'  => __('Set below background options. Background settings will be applied to Boxed layout only.', 'howes')
        ),
		array(
			'id'            => 'global_background',
			'type'          => 'background',
			'title'         => __('Body Background Properties', 'howes'),
			'subtitle'      => __('Set background for main body. This is for main outer body background. For "Boxed" layout only.', 'howes'),
			'preview_media' => true,
			'output'        => array('body'),
			'default'       => array( "background-color" => "#f8f8f8", ),
			//'customizer'    => true,
		),
		array(
			'id'            => 'inner_background',
			'type'          => 'background',
			'title'         => __('Content Area Background Properties', 'howes'),
			'subtitle'      => __('Set background for content area.', 'howes'),
			'preview_media' => true,
			'output'        => array('body #main'),
			'default'       => array( "background-color" => "#ffffff", ),
			//'customizer'    => true,
		),
		
		/* Loader Image */
		array(
			'id'    =>'html-pagetranslation',
			'type'  => 'info',
			'title' => __('Page Translation Effect', 'howes'), 
			'desc'  => __('Select page translation effect for the site. We are using <strong>Animsition</strong> library for page transation and you can <a href="http://git.blivesta.com/animsition/" target="_blank">see preview of each translation here</a>.', 'howes')
        ),
		array(
			'id'       => 'pagetranslation',
			'type'     => 'radio',
			'title'    => __('Page translation effect', 'howes'), 
			'subtitle' => __('Select page translation effect here.', 'howes'),
			'options'  => array(
							'no'                           => __('No effect', 'howes'),
							'fade-in|fade-out'             => __('Fade', 'howes'),
							'fade-in-up|fade-out-down'     => __('Fade up', 'howes'),
							'fade-in-down|fade-out-up'     => __('Fade down', 'howes'),
							'fade-in-left|fade-out-left'   => __('Fade from left', 'howes'),
							'fade-in-right|fade-out-right' => __('Fade from right', 'howes'),
							'rotate-in|rotate-out'         => __('Rotate', 'howes'),
							'flip-in-x|flip-out-x'         => __('Flip X', 'howes'),
							'flip-in-y|flip-out-y'         => __('Flip Y', 'howes'),
							'zoom-in|zoom-out'             => __('Zoom', 'howes'),
						), //Must provide key => value pairs for radio options
			//'desc'   => __('This is the description field, again good for additional info.', 'howes'),
			'default'  => 'no',
			'customizer'=> false,
			//'value'  => '2'
		),
		
		
		/* Loader Image */
		array(
			'id'    =>'html-loaderimage',
			'type'  => 'info',
			'title' => __('Pre-loader image', 'howes'), 
			'desc'  => __('Select pre-loader image for the site. This will work on desktop, mobile and tablet devices.', 'howes')
        ),
		array(
			'id'       => 'loaderimg',
			'type'     => 'image_select',
			'title'    => __('Pre-loader Image', 'howes'), 
			'subtitle' => __('Please select site pre-loader image. <br /><br /><em><strong>Note: </strong>Please note that if you uploaded pre-loader image (in below option) than this pre-defined loader image will be ignored.</em>', 'howes'),
			'options'  => array(
				'1' => array(
					'alt' => __('Loader image 1', 'howes'),
					'img' => get_template_directory_uri() . '/images/loader1.gif'
				),
				'2' => array(
					'alt' => __('Loader image 2', 'howes'),
					'img' => get_template_directory_uri() . '/images/loader2.gif'
				),
				'3' => array(
					'alt' => __('Loader image 3', 'howes'),
					'img' => get_template_directory_uri() . '/images/loader3.gif'
				),
				'4' => array(
					'alt' => __('Loader image 4', 'howes'),
					'img' => get_template_directory_uri() . '/images/loader4.gif'
				),
				'5' => array(
					'alt' => __('Loader image 5', 'howes'),
					'img' => get_template_directory_uri() . '/images/loader5.gif'
				),
				'6' => array(
					'alt' => __('Loader image 6', 'howes'),
					'img' => get_template_directory_uri() . '/images/loader6.gif'
				),
				'7' => array(
					'alt' => __('Loader image 7', 'howes'),
					'img' => get_template_directory_uri() . '/images/loader7.gif'
				),
				'8' => array(
					'alt' => __('Loader image 8', 'howes'),
					'img' => get_template_directory_uri() . '/images/loader8.gif'
				),
				'9' => array(
					'alt' => __('Loader image 9', 'howes'),
					'img' => get_template_directory_uri() . '/images/loader9.gif'
				),
				'10' => array(
					'alt' => __('Loader image 10', 'howes'),
					'img' => get_template_directory_uri() . '/images/loader10.gif'
				),
				'11' => array(
					'alt' => __('Loader image 10', 'howes'),
					'img' => get_template_directory_uri() . '/images/loader11.gif'
				),
				'12' => array(
					'alt' => __('Loader image 10', 'howes'),
					'img' => get_template_directory_uri() . '/images/loader12.gif'
				),
				'13' => array(
					'alt' => __('Loader image 10', 'howes'),
					'img' => get_template_directory_uri() . '/images/loader13.gif'
				),
				'14' => array(
					'alt' => __('Loader image 10', 'howes'),
					'img' => get_template_directory_uri() . '/images/loader14.gif'
				),
				'15' => array(
					'alt' => __('Loader image 10', 'howes'),
					'img' => get_template_directory_uri() . '/images/loader15.gif'
				),
				'16' => array(
					'alt' => __('Loader image 10', 'howes'),
					'img' => get_template_directory_uri() . '/images/loader16.gif'
				),
				'17' => array(
					'alt' => __('Loader image 10', 'howes'),
					'img' => get_template_directory_uri() . '/images/loader17.gif'
				),
				'18' => array(
					'alt' => __('Loader image 10', 'howes'),
					'img' => get_template_directory_uri() . '/images/loader18.gif'
				),
			),
			'default'  => '1',
		),
		array(
			'id'       => 'loaderimage_custom',
			'type'     => 'media', 
			'title'    => __('Upload Pre-loader Image', 'howes'),
			'subtitle' => __('Custom pre-loader image that you want to show. You can create animated GIF image from your logo from <a href="http://animizer.net/en/animate-static-image" target="_blank">Animizer</a> website. <br /><br /><em><strong>Note: </strong>Please note that if you selected image here than the pre-defined loader image (in above option) will be ignored.</em>', 'howes'),
		),
		
		
		
		/* NiceScroll Options */
		array(
			'id'    =>'html-NiceScrollOptions',
			'type'  => 'info',
			'title' => __('Scroller Settings', 'howes'), 
			'desc'  => __('Set options for scrollbar.', 'howes')
		),
		/*array(
			'id'       => 'scroller_enable',
			'type'     => 'switch',
			'title'    => __('Enalbe NiceScroll', 'howes'), 
			'subtitle' => __('Select YES to enable NiceScroll (fancy scrollbar).', 'howes'),
			'on'       => 'Yes',
			'off'      => 'No',
			'default'  => '1', // 1 = on | 0 = off
		),*/
		
		array(
			'id'        => 'scroller_enable',
			'type'      => 'button_set',
			'title'     => __('Page Scrolling Effect', 'howes'),
			'subtitle'  => __('Select page scrolling effect. ', 'howes'),
			'desc'      => __('<ul><li><strong>NiceScroll:</strong> Contains fancy scrollbar and smooth page scroll</li><li><strong>SmoothScroll:</strong> contains only smooth page scroll</li><ul>', 'howes'),
			
			//Must provide key => value pairs for radio options
			'options'   => array(
				'1' => __('NiceScroll', 'howes'), 
				'2' => __('SmoothScroll', 'howes'),
				'3' => __('No effect', 'howes'),
			),
			'default'   => '2'
		),
		
		array(
			'id'       => 'scroller_speed',
			'type'     => 'text',
			'title'    => __('Page Scrolling Speed (mousescrollstep)', 'howes'),
			'subtitle' => __('Page scrolling speed with mouse wheel, default value is <code>40</code> (pixel)', 'howes'),
			'required' => array('scroller_enable','equals','1'),
			'customizer' => false,
			'default'  => __('40', 'howes'),
		),
		
		
		/* NiceScroll Options */
		array(
			'id'    =>'html-fonticonlibrary',
			'type'  => 'info',
			'title' => __('Font Icon Library Selection', 'howes'), 
			'desc'  => __('Select font-icon library. The more library you select the more loading in your site will be applied.', 'howes')
		),
		array(
			'id'        => 'fonticonlibrary',
			'type'      => 'checkbox',
			'title'     => __('Select Font Icon Library', 'howes'),
			'subtitle'  => __('Select font icon library', 'howes'),
			'desc'      => __('Select font icon library.', 'howes'),
			
			//Must provide key => value pairs for multi checkbox options
			'options'   => array(
				'fontawesome' => __('Font Awesome (558 icons)', 'howes'),
				'lineicons'   => __('Lineicons (58 icons)', 'howes'),
				'entypo'      => __('Entypo (284 icons)', 'howes'),
				'typicons'    => __('Typicons (308 icons)', 'howes'),
				'iconic'      => __('Iconic (151 icons)', 'howes'),
				'mpictograms' => __('Modern Pictograms (91 icons)', 'howes'),
				'meteocons'   => __('Meteocons (47 icons)', 'howes'),
				'mfglabs'     => __('MFG Labs (153 icons)', 'howes'),
				'maki'        => __('Maki (63 icons)', 'howes'),
				'zocial'      => __('Zocial (103 icons)', 'howes'),
				'brandico'    => __('Brandico (45 icons)', 'howes'),
				'elusive'     => __('Elusive (271 icons)', 'howes'),
				'websymbols'  => __('Web Symbols (85 icons)', 'howes'),
			),
			
			//See how std has changed? you also don't need to specify opts that are 0.
			'default'   => array(
				'fontawesome' => '1',
				'lineicons'   => '0',
				'entypo'      => '0',
				'typicons'    => '0',
				'iconic'      => '0',
				'mpictograms' => '0',
				'meteocons'   => '0',
				'mfglabs'     => '0',
				'maki'        => '0',
				'zocial'      => '0',
				'brandico'    => '0',
				'elusive'     => '0',
				'websymbols'  => '0',
			)
		),
		
		// One Page site
		array(
			'id'    =>'html-onepagesite',
			'type'  => 'info',
			'title' => __('One Page website', 'howes'), 
			'desc'  => __('Options for One Page website.', 'howes'),
        ),
		array(
			'id'       => 'one_page_site',
			'type'     => 'switch',
			'title'    => __('One Page Site', 'howes'), 
			'subtitle' => __('Set this option <code>YES</code> if your site is one page website.', 'howes'),
			'default'  => '0', // 1 = on | 0 = off
			'on'       => __('Yes', 'howes'),
			'off'      => __('No', 'howes'),
		),
		
	),
);








// Favicon Settings
$sections[] = array(
	'title'  => __('Favicon Settings', 'howes'),
	'header' => __('Favicon Settings', 'howes'),
	'customizer'=> false,
	'desc'   => __('Set all Favicon icons. Upload different Favicons for different type of devices. (Click here to <a href="http://en.wikipedia.org/wiki/Favicon" target="_blank"> know more about Favicon</a>). Also you can generate favicon from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site.', 'howes'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-bookmark',
	'fields' => array(
		array(
			'id'     => 'thememount-favicon-desc',
			'type'   => 'info',
			'style'  => 'success',
			'notice' => true,
			'title'  => __('TIP:', 'howes'),
			'desc'   => __('You can generate Favicon easily.  Just create a new PNG image with size <strong>260x260 pixel</strong> and upload on <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site. This site will create all required images and you just need to upload each image in each below options.', 'howes')
		),
		array(
			'id'       => 'favicon',
			'type'     => 'media',
			'url'      => false,
			'customizer'=> false,
			'title'    => __('Favicon image (favicon.ico icon file)', 'howes'),
			'subtitle' => __('Select or upload <strong>favicon.ico</strong> with size 48x48 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site.', 'howes'),
			'compiler' => 'true',
		),
		array(
			'id'       => 'favicon_16',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image (16x16 PNG image)', 'howes'),
			'subtitle' => __('Select or upload Favicon image with size 16x16 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'howes'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_32',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image (32x32 PNG image)', 'howes'),
			'subtitle' => __('Select or upload Favicon image with size 32x32 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'howes'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_96',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image (96x96 PNG image)', 'howes'),
			'subtitle' => __('Select or upload Favicon image with size 96x96 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'howes'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_160',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image (160x160 PNG image)', 'howes'),
			'subtitle' => __('Select or upload Favicon image with size 160x160 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'howes'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_192',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image (192x192 PNG image)', 'howes'),
			'subtitle' => __('Select or upload Favicon image with size 192x192 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'howes'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		
		array(
			'id'    =>'html-favicon',
			'type'  => 'info',
			'title' => __('Favicon icons for Apple devices', 'howes'), 
			'desc'  => __('Upload different Favicons for different type of devices. (Click here to <a href="http://en.wikipedia.org/wiki/Favicon" target="_blank"> know more about Favicon</a>). Also you can generate favicon from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site.', 'howes'),
        ),
		array(
			'id'       => 'favicon_57',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for Apple devices (57x57 PNG image)', 'howes'),
			'subtitle' => __('Select or upload Favicon image with size 57x57 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'howes'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_60',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for Apple devices (60x60 PNG image)', 'howes'),
			'subtitle' => __('Select or upload Favicon image with size 60x60 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'howes'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_72',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for Apple devices (72x72 PNG image)', 'howes'),
			'subtitle' => __('Select or upload Favicon image with size 72x72 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'howes'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_76',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for Apple devices (76x76 PNG image)', 'howes'),
			'subtitle' => __('Select or upload Favicon image with size 76x76 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'howes'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_114',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for Apple devices (114x114 PNG image)', 'howes'),
			'subtitle' => __('Select or upload Favicon image with size 114x114 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'howes'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_120',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for Apple devices (120x120 PNG image)', 'howes'),
			'subtitle' => __('Select or upload Favicon image with size 120x120 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'howes'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_144',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for Apple devices (144x144 PNG image)', 'howes'),
			'subtitle' => __('Select or upload Favicon image with size 144x144 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'howes'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_152',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for Apple devices (152x152 PNG image)', 'howes'),
			'subtitle' => __('Select or upload Favicon image with size 152x152 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'howes'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_180',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for Apple devices (180x180 PNG image)', 'howes'),
			'subtitle' => __('Select or upload Favicon image with size 180x180 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'howes'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		
		array(
			'id'    =>'html-favicon3',
			'type'  => 'info',
			'title' => __('Favicon image and color for Microsoft Tile link (for Microsoft Devices)', 'howes'), 
			'desc'  => __('Upload different Favicons for different type of devices. (<a href="http://www.buildmypinnedsite.com/en" target="_blank">Click here to know more about Favicon for Microsoft devices</a>).', 'howes'),
        ),
		array(
			'id'       => 'favicon_ms_tile_color',
			'type'     => 'color',
			'url'      => false,
			'title'    => __('Favicon Background Color for the MS App Tile link', 'howes'),
			'subtitle' => __('Select background color for Favicon Tile App link.', 'howes'),
			'compiler' => 'true',
			'default' => '#ffffff',
		),
		array(
			'id'       => 'favicon_ms_144',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for MicroSoft App link (144x144 PNG image)', 'howes'),
			'subtitle' => __('Select or upload Favicon image with size 144x144 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site.', 'howes'),
			'compiler' => 'true',
		),
		array(
			'id'       => 'favicon_ms_70',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for MicroSoft App link (70x70 PNG image)', 'howes'),
			'subtitle' => __('Select or upload Favicon image with size 70x70 or 128x128 (if with transparent border) pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site.', 'howes'),
			'compiler' => 'true',
		),
		array(
			'id'       => 'favicon_ms_150',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for MicroSoft App link (150x150 PNG image)', 'howes'),
			'subtitle' => __('Select or upload Favicon image with size 150x150 or 170x270 (if with transparent border) pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site.', 'howes'),
			'compiler' => 'true',
		),
		array(
			'id'       => 'favicon_ms_310_150',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for MicroSoft App link (310x150 PNG image)', 'howes'),
			'subtitle' => __('Select or upload Favicon image with size 310x150 or 558x270 (if with transparent border) pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site.', 'howes'),
			'compiler' => 'true',
		),
		array(
			'id'       => 'favicon_ms_310',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for MicroSoft App link (310x310 PNG image)', 'howes'),
			'subtitle' => __('Select or upload Favicon image with size 310x310 or 558x558 (if with transparent border) pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site.', 'howes'),
			'compiler' => 'true',
		),
	),
);








// Font Settings
$sections[] = array(
	'title'  => __('Font Settings', 'howes'),
	'header' => __('Font Settings', 'howes'),
	'customizer'=> false,
	'desc'   => __('Set different font style', 'howes'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-text-height',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'          => 'general_font',
			'type'        => 'typography', 
			'title'       => __('General Font', 'howes'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			'color'       => true,
			//'preview'   => false, // Disable the previewer
			'output'      => array('body'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('Select General font, color and size', 'howes'),
			'default'     => array(
				"font-family"  => "Open Sans",
				"google"       => "1",
				"font-backup"  => "'Trebuchet MS', Helvetica, sans-serif",
				"font-weight"  => "400",
				"font-size"    => "14px",
				"line-height"  => "20px",
				"color"        => "#6b6b6b"
			),
		),
		
		
		array(
			'id'          => 'widget_font',
			'type'        => 'typography', 
			'title'       => __('Widget Title Font', 'howes'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			//'color'     => false,
			//'preview'   => false, // Disable the previewer
			'output'      => array('body .widget .widget-title, body .widget .widgettitle, #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu > li.mega-menu-item > h4.mega-block-title'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('Select font, color and size for widget title', 'howes'),
			'default'=> array(
				"font-family" => "Roboto Slab",
				"google"      => "1",
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				"font-weight" => "400",
				"font-size"   => "18px",
				"line-height" => "20px",
				"color"       => "#282828"
			),
		),
		
		array(
			'id'          => 'button_font',
			'type'        => 'typography', 
			'title'       => __('Button Font', 'howes'),
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			'text-align'  => false,
			'font-size'   => false,
			'line-height' => false,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			'color'       => false,
			//'preview'   => false, // Disable the previewer
			'output'      => array('.woocommerce button.button, .woocommerce-page button.button, input, .vc_btn, .woocommerce-page a.button, .button, .wpb_button, button, .woocommerce input.button, .woocommerce-page input.button, .tp-button.big, .woocommerce #content input.button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce-page #content input.button, .woocommerce-page #respond input#submit, .woocommerce-page a.button, .woocommerce-page button.button, .woocommerce-page input.button'), // An array of CSS selectors
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('This fonts will be applied to all buttons in this site', 'howes'),
			'default'     => array(
				"font-family" => "Open Sans",
				"google"      => "1",
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
			),
		),
		
		array(
			'id'          => 'h1_heading_font',
			'type'        => 'typography', 
			'title'       => __('H1 Heading Font', 'howes'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			//'color'     => false,
			//'preview'   => false, // Disable the previewer
			'output'      => array('h1'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('Select General font, color and size', 'howes'),
			'default'     => array(
				"font-family" => "Roboto Slab",
				"google"      => "1",
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				"font-weight" => "400",
				"font-size"   => "32px",
				"line-height" => "34px",
				"color"       => "#282828"
			),
		),
		array(
			'id'          => 'h2_heading_font',
			'type'        => 'typography', 
			'title'       => __('H2 Heading Font', 'howes'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style' => false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			//'color'     => false,
			//'preview'   => false, // Disable the previewer
			'output'      => array('h2'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('Select General font, color and size', 'howes'),
			'default'     => array(
				"font-family" => "Roboto Slab",
				"google"      => "1",
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				"font-weight" => "400",
				"font-size"   => "28px",
				"line-height" => "30px",
				"color"       => "#282828"
			),
		),
		array(
			'id'          => 'h3_heading_font',
			'type'        => 'typography', 
			'title'       => __('H3 Heading Font', 'howes'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			//'color'     => false,
			//'preview'   => false, // Disable the previewer
			'output'      => array('h3'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('Select General font, color and size', 'howes'),
			'default'     => array(
				"font-family" => "Roboto Slab",
				"google"      => "1",
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				"font-weight" => "400",
				"font-size"   => "24px",
				"line-height" => "26px",
				"color"       => "#282828"
			),
		),
		array(
			'id'          => 'h4_heading_font',
			'type'        => 'typography', 
			'title'       => __('H4 Heading Font', 'howes'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			//'color'     => false,
			//'preview'   => false, // Disable the previewer
			'output'      => array('h4'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('Select General font, color and size', 'howes'),
			'default'     => array(
				"font-family" => "Roboto Slab",
				"google"      => "1",
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				"font-weight" => "400",
				"font-size"   => "18px",
				"line-height" => "20px",
				"color"       => "#282828",
			),
		),
		array(
			'id'          => 'h5_heading_font',
			'type'        => 'typography', 
			'title'       => __('H5 Heading Font', 'howes'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			//'color'     => false,
			//'preview'   => false, // Disable the previewer
			'output'      => array('h5'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('Select General font, color and size', 'howes'),
			'default'     => array(
				"font-family" => "Roboto Slab",
				"google"      => "1",
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				"font-weight" => "400",
				"font-size"   => "16px",
				"line-height" => "18px",
				"color"       => "#282828"
			),
		),
		array(
			'id'          => 'h6_heading_font',
			'type'        => 'typography', 
			'title'       => __('H6 Heading Font', 'howes'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			//'color'     => false,
			//'preview'   => false, // Disable the previewer
			'output'      => array('h6'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('Select General font, color and size', 'howes'),
			'default'     => array(
				"font-family" => "Roboto Slab",
				"google"      => "1",
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				"font-weight" => "400",
				"font-size"   => "14px",
				"line-height" => "16px",
				"color"       => "#282828"
			),
		),
		array(
			'id'		  => 'elementtitle',
			'type'		  => 'typography', 
			'title'		  => __('Element Title Font', 'howes'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			'color'      => false,
			//'preview'  => false, // Disable the previewer
			'output'     => array('.wpb_tabs_nav a.ui-tabs-anchor, .wpb_accordion_header > a, .vc_progress_bar .vc_label'), // An array of CSS selectors to apply this font style to dynamically
			'units'      => 'px', // Defaults to px
			'subtitle'   => __('This will be applied to Tab title, Accordion Title and Progress Bar title text.', 'howes'),
			'default'    => array(
				"font-family" => "Roboto Slab",
				"google"      => "1",
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				"font-weight" => "400",
				"font-size"   => "13px",
				"line-height" => "15px"
			),
		),
	),
);


// Floating Bar Settings
$sections[] = array(
	'title'      => __('Floating Bar Settings', 'howes'),
	//'customizer' => true,
	'header'     => __('Floating Bar Settings', 'howes'),
	'desc'       => __('This is settings page for Header Floating Bar.', 'howes'),
	'icon_class' => 'icon-large',
    'icon'       => 'el-icon-upload',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'       => 'topbar_show_team_search',
			'type'     => 'switch',
			'title'    => __('Show Floating Bar', 'howes'), 
			'subtitle' => __('Show or hide Floating Bar', 'howes'),
			'default'  => '1', // 1 = on | 0 = off
			//'required' => array('topbarhide','equals','0'),
			'on'       => 'Yes',
			'off'      => 'No',
		),
		
		array(
			'id'       => 'fbar_bg_color',
			'type'     => 'select',
			'title'    => __('Floating Bar Background Color', 'howes'), 
			'subtitle' => __('Select <code>Dark</code> color if you are going to select light color in above option.', 'howes'),
			'options'  => array(
					'skin'  => __('Skin Color as Background Color', 'howes'),
					'grey'  => __('Grey Color as Background Color', 'howes'),
					'dark'  => __('Dark Color as Background Color', 'howes'),
				),
			'default' => 'dark'
		),
		array(
			'id'       => 'fbar_text_color',
			'type'     => 'select',
			'title'    => __('Floating Bar Text Color', 'howes'), 
			'subtitle' => __('Select <code>Dark</code> color if you are going to select "Grey" color in above option.', 'howes'),
			'options'  => array(
					'white'  => __('White', 'howes'),
					'dark'   => __('Dark', 'howes'),
				),
			'default' => 'white'
		),
		
		array(
			'id'            => 'background',
			'type'          => 'background',
			'title'         => __('Floating Bar Background Properties', 'howes'),
			'subtitle'      => __('Set background for Floating bar. You can set color or image and also set other background related properties.', 'howes'),
			'preview_media' => true,
			'background-color' => false,
			'output'        => array('div.thememount-fbar-box-w'),
			'default'       => array( 
				"background-repeat"   => "no-repeat",
				"background-size"     => "cover",
				"background-position" => "center center",
				"background-image"    => get_template_directory_uri().'/images/fbar-bg.jpg',
			),
			//'customizer'    => true,
		),
		
		array(
			'id'       => 'topbar_handler_icon',
			'type'     => 'thememount_icon_select',
			'data'     => 'elusive',
			'title'    => __('Open Link Icon', 'howes'), 
			'subtitle' => __('Select icon for the link to open the Header Floating Bar.', 'howes'),
			'default'  => 'fa-plus',
			//'required' => array('topbarhide','equals','0'),
		),
		array(
			'id'       => 'topbar_handler_icon_close',
			'type'     => 'thememount_icon_select',
			'data'     => 'elusive',
			'title'    => __('Close Link Icon', 'howes'), 
			'subtitle' => __('Select icon for the link to close the Header Floating Bar', 'howes'),
			'default'  => 'fa-minus',
			//'required' => array('topbarhide','equals','0'),
		),
		
	),
);


// Topbar Settings
$sections[] = array(
	'title'  => __('Topbar Settings', 'howes'),
	//'customizer'=> true,
	'header' => __('Topbar Settings', 'howes'),
	'desc'   => __('Topbar settings', 'howes'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-tasks',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'       => 'topbarhide',
			'type'     => 'switch',
			'title'    => __('Hide Topbar', 'howes'), 
			'subtitle' => __('Check this option to hide the Topbar', 'howes'),
			'default'  => '0', // 1 = on | 0 = off
			'on'       => 'Yes',
			'off'      => 'No',
		),
		
		array(
			'id'       => 'topbarbgcolor',
			'type'     => 'color',
			'title'    => __('Topbar Background Color', 'howes'),
			'subtitle' => __('Custom background color for Topbar.', 'howes'),
			'default'  => '#f5f5f5',
			'required' => array('topbarhide','equals','0'),
			'validate' => 'color',
		),
		array(
			'id'       => 'topbar_text_color',
			'type'     => 'select',
			'title'    => __('Topbar Text Color', 'howes'), 
			'subtitle' => __('Select <code>Dark</code> color if you are going to select light color in above option.', 'howes'),
			'required' => array('topbarhide','equals','0'),
			'options'  => array(
					'white'  => __('White', 'howes'),
					'dark'   => __('Dark', 'howes'),
				),
			'default' => 'dark'
		),
		
		array(
			'id'    =>'html-topbarleft',
			'type'  => 'info',
			'title' => __('Topbar Left Area Content', 'howes'), 
			'desc'  => __('Content for Topbar left side area.', 'howes'),
        ),
		array(
			'id'       => 'topbartext',
			'type'     => 'textarea',
			'title'    => __('Topbar Text', 'howes'), 
			'subtitle' => __('Add content for Topbar text', 'howes'),
			'desc'     => __('HTML tags and shortcodes are allowed', 'howes'),
			'required' => array('topbarhide','equals','0'),
			'validate' => 'html',
			'default'  => '<ul class="top-contact"><li><i class="tmicon-fa-phone"></i>Call us now! <strong>0123 444 333</strong></li><li><i class="tmicon-fa-envelope-o"></i><a href="mailto:info@example.com">info@example.com</a></li></ul>'
		),
		
		array(
			'id'    =>'html-topbarright',
			'type'  => 'info',
			'title' => __('Topbar Right Area Content', 'howes'), 
			'desc'  => __('Content for Topbar right side area.', 'howes'),
        ),
		array(
			'id'       => 'topbarhidesocial',
			'type'     => 'switch',
			'title'    => __('Hide Social Icons in Topbar', 'howes'), 
			'subtitle' => __('Check this option to hide the Social icons in Topbar', 'howes'),
			'default'  => '0', // 1 = on | 0 = off
			'required' => array('topbarhide','equals','0'),
			'on'       => 'Yes',
			'off'      => 'No',
		),
		array(
			'id'       => 'topbarrighttext',
			'type'     => 'textarea',
			'title'    => __('Topbar Text For Right Area', 'howes'), 
			'subtitle' => __('This content will appear after social links', 'howes'),
			'desc'     => __('HTML tags and shortcodes are allowed', 'howes'),
			'required' => array('topbarhide','equals','0'),
			'validate' => 'html',
		),
	),
);


// Titlebar Settings
$sections[] = array(
	'title'  => __('Titlebar Settings', 'howes'),
	'header' => __('Titlebar Settings', 'howes'),
	'desc'   => __('Settings for titlebar', 'howes'),
	'icon_class' => 'icon-large',
	'customizer' => false,
    'icon'   => 'el-icon-lines',
	'fields' => array(
		array(
			'id'            => 'tbar-height',
			'type'          => 'slider',
			'title'         => __( 'Titlebar Height', 'howes' ),
			'subtitle'      => __( 'Set height of the Titlebar.', 'howes' ),
			'desc'          => __( 'Set height of the Titlebar.', 'howes' ),
			'default'       => 141,
			'min'           => 100,
			'step'          => 1,
			'max'           => 800,
			'display_value' => 'text',
		),
		array(
			'id'       => 'titlebar_text_color',
			'type'     => 'select',
			'title'    => __('Titlebar Text Color', 'howes'), 
			'subtitle' => __('Select <code>Dark</code> color if you are going to select light color in above option.', 'howes'),
			'options'  => array(
					'white'  => __('White', 'howes'),
					'dark'   => __('Dark', 'howes'),
				),
			'default' => 'white'
		),
		array(
			'id'       => 'tbar_hide_bcrumb',
			'type'     => 'checkbox',
			'title'    => __( 'Hide Breadcrumb', 'howes' ),
			'subtitle' => __( 'Check this box to hide breadcrumb globally', 'howes' ),
			'desc'     => __( 'Check this box to hide breadcrumb globally', 'howes' ),
			'default'  => '0'// 1 = on | 0 = off
		),
		
		 array(
			'id'    =>'html-tbardesign',
			'type'  => 'info',
			'title' => __('Titlebar View', 'howes'), 
			'desc'  => __('Select view of Titlebar.', 'howes'),
        ),
		array(
			'id'       => 'titlebar_view',
			'type'     => 'select',
			'title'    => __('Titlebar View', 'howes'), 
			'subtitle' => __('Select view of Titlebar.', 'howes'),
			'options'  => array(
					'default' => __('All Center (default)', 'howes'),
					'left'    => __('All Left', 'howes'),
					'right'   => __('All Right', 'howes'),
				),
			'default' => 'default'
		),
		
		array(
			'id'    =>'html-tbarbg',
			'type'  => 'info',
			'title' => __('Titlebar Background Options', 'howes'), 
			'desc'  => __('Set background options for Titlebar area.', 'howes'),
        ),
       
        
		array(
			'id'       => 'titlebar_bg_image_type',
			'type'     => 'select',
			'title'    => __('Titlebar Background Type', 'howes'), 
			'subtitle' => __('Please select background type for the titlebar', 'howes'),
			'options'  => array(
					'noimg'      => __('Color only', 'howes'),
					'predefined' => __('Color and predefined image (select from below)', 'howes'),
					'custom'     => __('Color and custom image (select from below)', 'howes'),
				),
			'default' => 'predefined'
		),
		array(
			'id'       => 'titlebar_bg_color',
			'type'     => 'color',
			'title'    => __('Titlebar Background Color', 'howes'),
			'subtitle' => __('Custom color for titlebar background.', 'howes'),
			'default'  => '#000000',
			'validate' => 'color',
		),
		array(
			'id'            => 'titlebar_bg_color_opacity',
			'type'          => 'slider',
			'title'         => __( 'Titlebar Background Color Opacity', 'howes' ),
			'subtitle'      => __( 'Select opacity for the Titlebar background color.', 'howes' ),
			'desc'          => __( '<strong>TIP: </strong> <br>Select <code>0</code> (zero) to set complete transparent color. This will hide the color completely and show image. <br></strong> Select <code>100</code> (one hundred) to remove color opacity and show only color.', 'howes' ),
			'default'       => 75,
			'min'           => 0,
			'step'          => 1,
			'max'           => 100,
			'display_value' => 'text',
			'required'      => array('titlebar_bg_image_type','equals', array('predefined', 'custom') ),
		),
		
		
		array(
			'id'       => 'titlebar_bg_image',
			'type'     => 'image_select',
			'title'    => __('Titlebar Background Image', 'howes'), 
			'subtitle' => __('Please select image for background of titlebar', 'howes'),
			'options'  => array(
				'1' => array(
					'alt' => __('Image 1', 'howes'),
					'img' => get_template_directory_uri() . '/images/titlebg/bg-title1.jpg'
				),
				'2' => array(
					'alt' => __('Image 2', 'howes'),
					'img' => get_template_directory_uri() . '/images/titlebg/bg-title2.jpg'
				),
				'3' => array(
					'alt' => __('Image 3', 'howes'),
					'img' => get_template_directory_uri() . '/images/titlebg/bg-title3.jpg'
				),
				'4' => array(
					'alt' => __('Image 4', 'howes'),
					'img' => get_template_directory_uri() . '/images/titlebg/bg-title4.jpg'
				),
				'5' => array(
					'alt' => __('Image 5', 'howes'),
					'img' => get_template_directory_uri() . '/images/titlebg/bg-title5.jpg'
				),
			),
			'default'  => '2',
			'required' => array('titlebar_bg_image_type','equals','predefined'),
		),
		array(
			'id'       => 'titlebar_bg_custom_image',
			'type'     => 'media',
			'required' => array('titlebar_bg_image','equals','custom'),
			'url'      => false,
			'title'    => __('Select Custom Titlebar Background Image', 'howes'),
			'subtitle' => __('Upload your own image that will be used as background for the Titlebar box.', 'howes'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
			'required' => array('titlebar_bg_image_type','equals','custom'),
		),
		/*array(
			'id'    =>'html-tbar-height',
			'type'  => 'info',
			'title' => __('Titlebar Height', 'howes'), 
			'desc'  => __('Set Titlebar height.', 'howes'),
        ),*/
		
	),
);


// Header Settings
$sections[] = array(
	'title'  => __('Header Settings', 'howes'),
	'header' => __('Header Settings', 'howes'),
	'desc'   => __('Header settings', 'howes'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-th-list',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'       => 'headerbgcolor',
			'type'     => 'color',
			'title'    => __('Header Background Color', 'howes'),
			'subtitle' => __('Custom color for header background.', 'howes'),
			'default'  => '#ffffff',
			'validate' => 'color',
		),
		array(
			'id'       => 'stickyheaderbgcolor',
			'type'     => 'color',
			'title'    => __('Sticky Header Background Color', 'howes'),
			'subtitle' => __('Custom color for header background when become sticky.', 'howes'),
			//'default'  => '#ffffff',
			'validate' => 'color',
		),
		array(
			'id'       => 'header_text_color',
			'type'     => 'select',
			'title'    => __('Header Text Color', 'howes'), 
			'subtitle' => __('Select <code>Dark</code> color if you are going to select light color in above option. <br> <strong>NOTE: This option is not used anymore. Please set text color from "Menu Settings" section.</strong>', 'howes'),
			'options'  => array(
					'white'  => __('White', 'howes'),
					'dark'   => __('Dark', 'howes'),
				),
			'default' => 'dark'
		),
		array(
			'id'       => 'logotype',
			'type'     => 'radio',
			'title'    => __('Logo type', 'howes'), 
			'subtitle' => __('Specify the type of logo. It can be or the text or the image', 'howes'),
			'options'  => array( 'text' => __('Logo as Text', 'howes'), 'image' => __('Logo as Image', 'howes') ),
			'default'  => 'image'
		),
		array(
			'id'       => 'logotext',
			'type'     => 'text',
			'required' => array('logotype','equals','text'),
			'title'    => __('Logo Text', 'howes'),
			'subtitle' => __('Enter the text to be used instead of the logo image', 'howes'),
			'default'  => 'Howes'
		),
		array(
			'id'          => 'logo_font',
			'type'        => 'typography', 
			'required'    => array('logotype','equals','text'),
			'title'       => __('Logo Font', 'howes'),
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'text-align'  => false,
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			'font-style'  => false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => false,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			'color'       => true,
			//'preview'   => false, // Disable the previewer
			'output'      => array('h1.site-title a'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('This will be applied to logo text only. Select Logo font-style and size', 'howes'),
			'default'     => array(
				'google'        => true,
				'font-family'   => 'Seaweed Script',
				"font-backup"   => "'Times New Roman', Times,serif",
				//'font-style'  => '700', 
				'font-weight'   => '400',
				'font-size'     => '36px', 
				'color'         => "#272727", 
				//'line-height' => '40px'
			),
		),
		array(
			'id'       => 'logoimg',
			'type'     => 'media',
			'required' => array('logotype','equals','image'),
			'url'      => false,
			'title'    => __('Logo Image', 'howes'),
			'subtitle' => __('Upload image that will be used as logo for the site', 'howes') . __('<strong>NOTE:</strong>Upload image that will be used as logo for the site', 'howes'),
			'compiler' => 'true',
			'default'  => array(
							'url'    => get_template_directory_uri() . '/images/logo.png',
							'width'  => 313,
							'height' => 100,
			),
		),
		array(
			'id'       => 'logoimg_sticky',
			'type'     => 'media',
			'required' => array('logotype','equals','image'),
			'url'      => false,
			'title'    => __('Logo Image for Sticky Header', 'howes'),
			'subtitle' => __('Upload image that will be used as logo for sticky header', 'howes'),
			'compiler' => 'true',
		),
		array(
			'id'            => 'logo-max-height',
			'type'          => 'slider',
			'title'         => __( 'Logo Max Height', 'howes' ),
			'subtitle'      => __( 'If you feel your logo looks small than increase this and adjust it.', 'howes' ),
			'desc'          => __( 'If you feel your logo looks small than increase this and adjust it.', 'howes' ),
			'default'       => 35,
			'min'           => 30,
			'step'          => 1,
			'max'           => 190,
			'display_value' => 'text',
			'required'      => array('logotype','equals','image'),
		),
		array(
			'id'            => 'logo-max-height-sticky',
			'type'          => 'slider',
			'title'         => __( 'Logo Max Height when Sticky Header', 'howes' ),
			'subtitle'      => __( 'Set logo when the header is sticky.', 'howes' ),
			'desc'          => __( 'Set logo when the header is sticky.', 'howes' ),
			'default'       => 35,
			'min'           => 10,
			'step'          => 1,
			'max'           => 190,
			'display_value' => 'text',
			'required'      => array('logotype','equals','image'),
		),
		array(
			'id'            => 'header-height',
			'type'          => 'slider',
			'title'         => __( 'Header Height (in pixel)', 'howes' ),
			'subtitle'      => __( 'You can set height of header area from here', 'howes' ),
			'desc'          => __( 'You can set height of header area from here', 'howes' ),
			'default'       => 79,
			'min'           => 60,
			'step'          => 1,
			'max'           => 200,
			'display_value' => 'text',
			//'required'      => array( 'headerstyle', 'equals', array('1','2') ),
		),
		array(
			'id'            => 'header-height-sticky',
			'type'          => 'slider',
			'title'         => __( 'Sticky Header Height (in pixel)', 'howes' ),
			'subtitle'      => __( 'You can set height of header area when it becomes sticky', 'howes' ),
			'desc'          => __( 'You can set height of header area when it becomes sticky', 'howes' ),
			'default'       => 73,
			'min'           => 60,
			'step'          => 1,
			'max'           => 160,
			'display_value' => 'text',
			//'required'      => array( 'headerstyle', 'equals', array('1','2') ),
		),
		
		/*array(
			'id'       => 'logoimg_retina',
			'type'     => 'media',
			'required' => array('logotype','equals','image'),
			'url'      => false,
			'title'    => __('Retina Logo Image', 'howes'),
			'subtitle' => __('Upload retina-ready logo image that will be used as logo for the site. Please note that the image size should be double sized (2x in width and height both) than normal logo (above option). Maximum height should be <strong>200 pixel</strong>.', 'howes'),
			'compiler' => 'true',
		),*/
		array(
			'id'    =>'html-showsearchbtn',
			'type'  => 'info',
			'title' => __('Search Button in Header', 'howes'), 
			'desc'  => __('Option to show or hide search button in header area.', 'howes'),
        ),
		array(
			'id'       => 'header_search',
			'type'     => 'switch',
			'title'    => __('Show Search Button', 'howes'), 
			'subtitle' => __('Set this option <code>YES</code> to show search button in header. The icon will be at the right side (after menu).', 'howes'),
			'default'  => '1', // 1 = on | 0 = off
			'on'       => __('Yes', 'howes'),
			'off'      => __('No', 'howes'),
		),
		array(
			'id'       => 'search_title',
			'type'     => 'text',
			'title'    => __('Search Form Title', 'howes'),
			'subtitle' => __('Write the search form title here. <br> Default: <code>Just type and press \'enter\'</code>', 'howes'),
			'default'  => __("Just type and press 'enter'", 'howes'),
		),
		array(
			'id'       => 'search_input',
			'type'     => 'text',
			'title'    => __('Search Form Input Word', 'howes'),
			'subtitle' => __('Write the search form input word here. <br> Default: <code>WRITE SEARCH WORD...</code>', 'howes'),
			'default'  => __("WRITE SEARCH WORD...", 'howes'),
		),
		array(
			'id'       => 'search_close',
			'type'     => 'text',
			'title'    => __('Search Form Close Button Text (SEO purpose)', 'howes'),
			'subtitle' => __('Write the search form close button text here. This is for SEO purpose only. <br> Default: <code>Close search</code>', 'howes'),
			'default'  => __("Close search", 'howes'),
		),
		
		array(
			'id'    =>'html-stickyheader',
			'type'  => 'info',
			'title' => __('Sticky Header', 'howes'), 
			'desc'  => __('Options for sticky header', 'howes')
        ),
		array(
			'id'       => 'stickyheader',
			'type'     => 'radio',
			'customizer' => false,
			'title'    => __('Enable Sticky Header', 'howes'), 
			'subtitle' => __('Select YES if you want the sticky header on page scroll', 'howes'),
			'options'  => array( 'y' => __('Yes', 'howes'), 'n' => __('No', 'howes') ),
			'default'  => 'y'
		),
		array(
			'id'    =>'html-headerstyle',
			'type'  => 'info',
			'title' => __('Header Style', 'howes'), 
			'desc'  => __('Options to change header style', 'howes')
        ),
		array(
			'id'       => 'headerstyle',
			'type'     => 'image_select',
			'title'    => __('Select Header Style', 'howes'), 
			'subtitle' => __('Please select header style', 'howes'),
			'options' => array(
				'1' => array(
					'alt' => __('Left logo and right menu', 'howes'),
					'img' => get_template_directory_uri() . '/inc/images/header-style1.png'
				),
				'2' => array(
					'alt' => __('Centre logo between menu', 'howes'),
					'img' => get_template_directory_uri() . '/inc/images/header-style2.png'
				),
				'3' => array(
					'alt' => __('Centre logo above menu', 'howes'),
					'img' => get_template_directory_uri() . '/inc/images/header-style3.png'
				),
				'4' => array(
					'alt' => __('Logo and Menu overlay on slider and Titlebar', 'howes'),
					'img' => get_template_directory_uri() . '/inc/images/header-style4.png'
				),
				'5' => array(
					'alt' => __('Logo and Menu overlay on slider and Titlebar', 'howes'),
					'img' => get_template_directory_uri() . '/inc/images/header-style5.png'
				),
				'6' => array(
					'alt' => __('Logo and Menu overlay on slider and Titlebar', 'howes'),
					'img' => get_template_directory_uri() . '/inc/images/header-style6.png'
				),
				'7' => array(
					'alt' => __('Boxed Header overlay on slider and Titlebar', 'howes'),
					'img' => get_template_directory_uri() . '/inc/images/header-style7.png'
				),
			),
			'default' => '1'
		),
		array(
			'id'            => 'center-logo-width',
			'type'          => 'slider',
			'title'         => __( 'Logo Area Width (pixel)', 'howes' ),
			'subtitle'      => __( 'This is the width of the logo area. This is for centre-logo header style only.', 'howes' ),
			'desc'          => __( 'You need to change this only when your menu overlays on the logo. This should be bigger that the logo width (ignore this if retina logo). Please set this and check your site for best results.', 'howes' ),
			'default'       => 350,
			'min'           => 10,
			'step'          => 5,
			'max'           => 500,
			'display_value' => 'text',
			'required'      => array('headerstyle', 'equals', '2'),
		),
		array(
			'id'            => 'first-menu-margin',
			'type'          => 'slider',
			'title'         => __( 'Menu Left margin (pixel)', 'howes' ),
			'subtitle'      => __( 'This is to set the logo appear at center with the menu. The logo will be always center. This is an advanced option.', 'howes' ),
			'desc'          => __( 'You need to change this only when you feel your menu is not center aligned with logo. Please set this and check your site for best results.', 'howes' ),
			'default'       => 50,
			'min'           => -500,
			'step'          => 5,
			'max'           => 500,
			'display_value' => 'text',
			'required'      => array('headerstyle', 'equals', '2'),
		),
		
		/*array(
			'id'    =>'html-headerheight',
			'type'  => 'info',
			'title' => __('Set Height of Header Area', 'howes'), 
			'desc'  => __('Option to set height of header area', 'howes'),
        ),*/
		
	),
);


// Menu Settings
$sections[] = array(
	'title'  => __('Menu Settings', 'howes'),
	'header' => __('Menu Settings', 'howes'),
	'desc'   => __('Menu settings', 'howes'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-th-list',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		
		// Responsive Menu Breakpoint
		array(
			'id'    =>'html-responsive_menu_breakpoint',
			'type'  => 'info',
			'title' => __('Responsive Menu Breakpoint', 'howes'), 
			'desc'  => __('Change options for responsive menu breakpoint.', 'howes')
        ),
		array(
			'id'       => 'menu_breakpoint',
			'type'     => 'radio',
			'title'    => __('Responsive Menu Breakpoint', 'howes'), 
			'subtitle' => __('Change options for responsive menu breakpoint.', 'howes'),
			'options'  => array(
				'1200'   => __('Large devices <small>Desktops (≥1200px)</small>', 'howes'),
				'992'    => __('Medium devices <small>Desktops and Tablets (≥992px)</small>', 'howes'),
				'768'    => __('Small devices <small>Mobile and Tablets (≥768px)</small>', 'howes'),
				'custom' => __('Custom (select pixel below)', 'howes'),
			),
			'default'  => '1200'
		),
		array(
			'id'            => 'menu_breakpoint_custom',
			'type'          => 'slider',
			'title'         => __( 'Custom Breakpoint for Menu (in pixel)', 'howes' ),
			'subtitle'      => __( 'Select after how many pixels the menu will become responsive.', 'howes' ),
			//'desc'          => __( 'Select how many product you want to show on SHOP page.', 'howes' ),
			'default'       => 1200,
			'min'           => 1,
			'step'          => 1,
			'max'           => 1200,
			'display_value' => 'text',
			'required'      => array('menu_breakpoint','equals','custom'),
		),
		
		// Main Menu Options
		array(
			'id'    =>'html-mainmenuoptions',
			'type'  => 'info',
			'title' => __('Main Menu Options', 'howes'), 
			'desc'  => __('Options for main menu in header', 'howes')
        ),
		array(
			'id'          => 'mainmenufont',
			'type'        => 'typography', 
			'title'       => __('Main Menu Font', 'howes'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			'color'       => true,
			//'preview'   => false, // Disable the previewer
			'output'      => array('ul.nav-menu li a, div.nav-menu > ul li a, #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal > li.mega-menu-item > a'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('Select font, color and size for main menu.', 'howes'),
			'default'     => array(
				"font-family" => "Roboto Slab",
				"google"      => "1",
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				"font-size"   => "12px",
				"line-height" => "12px",
				"color"       => "#333333",
				
			),
		),
		array(
			'id'       => 'stickymainmenufontcolor',
			'type'     => 'color',
			'title'    => __('Main Menu Font Color for Sticky Header', 'howes'),
			'subtitle' => __('Main menu font color when the header becomes sticky.', 'howes'),
			//'default'  => '#333333',
			'validate' => 'color',
		),
		array(
			'id'       => 'mainmenu_active_link_color',
			'type'     => 'select',
			'title'    => __('Main Menu Active Link Color', 'howes'), 
			'subtitle' => __('<strong>Tips:</strong>
								<ul>
									<li><code>Skin color (default):</code> Skin color for active link color.</li>
									<li><code>Custom color:</code> Custom color for active link color. Useful if you like to use any color for active link color.</li>
								</ul>
								', 'howes'),
			'options'  => array(
					'skin'   => __('Skin color (default)', 'howes'),
					'custom' => __('Custom color (select below)', 'howes'),
				),
			'default' => 'skin'
		),
		array(
			'id'       => 'mainmenu_active_link_custom_color',
			'type'     => 'color',
			'title'    => __('Main Menu Active Link Custom Color', 'howes'),
			'subtitle' => __('Custom color for main menu active menu text.', 'howes'),
			'default'  => '#ffffff',
			'validate' => 'color',
			'required' => array('mainmenu_active_link_color','equals','custom'),
		),
		
		// Dropdown menu options
		array(
			'id'    =>'html-dropmenuoptions',
			'type'  => 'info',
			'title' => __('Drop Down Menu Options', 'howes'), 
			'desc'  => __('Options for drop down menu in header', 'howes')
        ),
		array(
			'id'          => 'dropdownmenufont',
			'type'        => 'typography', 
			'title'       => __('Dropdown Menu Font', 'howes'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			'color'       => true,
			//'preview'   => false, // Disable the previewer
			'output'      => array('ul.nav-menu li ul li a, div.nav-menu > ul li ul li a, #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu a, #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu > li.mega-menu-item-type-widget'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('Select font, color and size for dropdown menu.', 'howes'),
			'default'     => array(
				"font-family" => "Open Sans",
				"google"      => "1",
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				"font-weight" => "400",
				"font-size"   => "13px",
				"line-height" => "18px",
				"color"       => "#676767",
			),
		),
		array(
			'id'       => 'dropmenu_active_link_color',
			'type'     => 'select',
			'title'    => __('Dropdown Menu Active Link Color', 'howes'), 
			'subtitle' => __('<strong>Tips:</strong>
								<ul>
									<li><code>Skin color (default):</code> Skin color for active link color.</li>
									<li><code>Custom color:</code> Custom color for active link color. Useful if you like to use any color for active link color.</li>
								</ul>
								', 'howes'),
			'options'  => array(
					'skin'   => __('Skin color (default)', 'howes'),
					'custom' => __('Custom color (select below)', 'howes'),
				),
			'default' => 'skin'
		),
		array(
			'id'       => 'dropmenu_active_link_custom_color',
			'type'     => 'color',
			'title'    => __('Dropdown Menu Active Link Custom Color', 'howes'),
			'subtitle' => __('Custom color for dropdown menu active menu text.', 'howes'),
			'default'  => '#ffffff',
			'validate' => 'color',
			'required' => array('dropmenu_active_link_color','equals','custom'),
		),
		
		
		array(
			'id'            => 'dropmenu_background',
			'type'          => 'background',
			'title'         => __('Dropdown Menu Background Properties', 'howes'),
			'subtitle'      => __('Set background for dropdown menu.', 'howes'),
			'preview_media' => true,
			'output'        => array('ul.nav-menu li ul, div.nav-menu > ul .children, #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu, #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu a:hover, #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu li:hover > a, #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu a'),
			'default'       => array( "background-color" => "#ffffff", ),
			//'customizer'    => true,
		),
		array(
			'id'       => 'dropdown_menu_separator',
			'type'     => 'radio',
			'title'    => __('Separator line between dropdown menu links', 'howes'), 
			'subtitle' => __('<strong>Tips:</strong>
								<ul>
									<li><code>Grey color as border color (default):</code> This is default border view. </li>
									<li><code>White color:</code> Select this option if you are going to select dark background color (for dropdown menu)</li>
									<li><code>No separator border:</code> Completely remove border. This will make your menu totally flat.</li>
								</ul>', 'howes'),
			'options'  => array(
							'grey'  => __('Grey color as border color (default)', 'howes'),
							'white' => __('White color as border color (for dark background color)', 'howes'),
							'no'    => __('No separator border', 'howes'),
						),
			'default'  => 'grey'
		),
		array(
			'id'          => 'megamenu_widget_title',
			'type'        => 'typography', 
			'title'       => __('Mega Menu Widget Font Settings', 'howes'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			'color'       => true,
			//'preview'   => false, // Disable the previewer
			'output'      => array('#navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu > li.mega-menu-item > h4.mega-block-title'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('Font settings for mega menu widget title. <br><br> <strong>NOTE: </strong> This will work only if you installed <code>Max Mega Menu</code> plugin and also activated in the main (primary) menu.', 'howes'),
			'default'     => array(
				"font-family" => "Roboto Slab",
				"google"      => "1",
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				"font-weight" => "400",
				"font-size"   => "18px",
				"line-height" => "20px",
				"color"       => "#282828",
			),
		),
	
	),
);




// Footer Settings
$sections[] = array(
	'title'  => __('Footer Settings', 'howes'),
	'header' => __('Footer Settings', 'howes'),
	'desc'   => __('Settings of the elements from the page footer area', 'howes'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-return-key',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'    =>'html-stickyfooter',
			'type'  => 'info',
			'title' => __('Sticky Footer', 'howes'), 
			'desc'  => __('Make footer sticky and visible on scrolling at bottom.', 'howes')
        ),
		array(
			'id'         => 'stickyfooter',
			'type'       => 'switch',
			'title'      => __('Sticky Footer', 'howes'), 
			'subtitle'   => __('Set this option <code>YES</code> to enable sticky footer on scrolling at bottom.', 'howes'),
			'on'         => 'Yes',
			'off'        => 'No',
			'default'    => '1', // 1 = on | 0 = off
			'customizer' => false,
		),
		
		
		array(
			'id'    =>'html-footer_column_layout',
			'type'  => 'info',
			'title' => __('Footer Column layout View', 'howes'), 
			'desc'  => __('Change view of Footer Columns.', 'howes')
        ),
		array(
			'id'      => 'footer_column_layout',
			'type'    => 'image_select',
			'title'   => __('Select Footer Column layout View', 'howes'), 
			'desc'    => __('Select Footer Column layout View.', 'howes'),
			'options' => array(
				'12' => array('title' => __('One Column', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_12.png'),
				'6_6' => array('title' => __('Two Columns', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_6_6.png'),
				'4_4_4' => array('title' => __('Three Columns', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_4_4_4.png'),
				'3_3_3_3' => array('title' => __('Four Columns', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_3_3_3_3.png'),
				
				
				'8_4' => array('title' => __('8 + 4 Columns', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_8_4.png'),
				'4_8' => array('title' => __('4 + 8 Columns', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_4_8.png'),
				
				'6_3_3' => array('title' => __('6 + 3 + 3 columns', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_6_3_3.png'),
				'3_3_6' => array('title' => __('3 + 3 + 6 columns', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_3_3_6.png'),
				'8_2_2' => array('title' => __('8 + 2 + 2 columns', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_8_2_2.png'),
				'2_2_8' => array('title' => __('2 + 2 + 8 columns', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_2_2_8.png'),
				
				'6_2_2_2' => array('title' => __('6 + 2 + 2 + 2 columns', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_6_2_2_2.png'),
				'2_2_2_6' => array('title' => __('2 + 2 + 2 + 6 columns', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_2_2_2_6.png'),
			),
			'default' => '3_3_3_3'
		),
		
		array(
			'id'    =>'html-footerwidgetarea',
			'type'  => 'info',
			'title' => __('Footer Widget Area', 'howes'), 
			'desc'  => __('Options to change settings for footer widget area.', 'howes')
        ),
		/*array(
			'id'       => 'footerwidget_bgcolor',
			'type'     => 'color',
			'title'    => __('Footer Background Color', 'howes'),
			'subtitle' => __('Custom color for footer background.', 'howes'),
			'default'  => '#252525',
			'validate' => 'color',
		),*/
		array(
			'id'            => 'footerwidget_bgimage',
			'type'          => 'background',
			'title'         => __('Footer Background', 'howes'),
			'subtitle'      => __('Footer background image', 'howes'),
			'preview_media' => true,
			//'background-color' => false,
			'output'        => array('#page footer.site-footer > div.footer'),
			'default'       => array(
								"background-color"    => "#282828",
								//"background-repeat"   => "no-repeat",
								//"background-position" => "center center",
								//"background-image"    => get_template_directory_uri() . '/images/map.png',
							),
			//'customizer'=> true,
		),
		array(
			'id'       => 'footerwidget_color',
			'type'     => 'select',
			'title'    => __('Text Color', 'howes'), 
			'subtitle' => __('Select <code>Dark</code> color if you are going to select light color in above option.', 'howes'),
			'options'  => array(
					'white'  => __('White', 'howes'),
					'dark'   => __('Dark', 'howes'),
				),
			'default' => 'white'
		),
		array(
			'id'    =>'html-footertextarea',
			'type'  => 'info',
			'title' => __('Footer Text Area', 'howes'), 
			'desc'  => __('Options to change settings for footer text area. This contains copyright info.', 'howes')
        ),
		array(
			'id'       => 'footertext_bgcolor',
			'type'     => 'color',
			'title'    => __('Footer Background Color', 'howes'),
			'subtitle' => __('Custom color for footer background.', 'howes'),
			'default'  => '#2f2f2f',
			'validate' => 'color',
		),
		array(
			'id'       => 'footertext_color',
			'type'     => 'select',
			'title'    => __('Text Color', 'howes'), 
			'subtitle' => __('Select <code>Dark</code> color if you are going to select light color in above option.', 'howes'),
			'options'  => array(
					'white'  => __('White', 'howes'),
					'dark'   => __('Dark', 'howes'),
				),
			'default' => 'white'
		),
		array(
			'id'       => 'copyrights',
			'type'     => 'editor',
			'title'    => __('Footer Text', 'howes'), 
			'subtitle' => __('You can use the following shortcodes in your footer text: <code>[site-url]</code> <code>[site-title]</code> <code>[site-tagline]</code> <code>[current-year]</code>', 'howes'),
			'default' => 'Copyright &copy; [current-year] <a href="[site-url]">[site-title]</a>. All rights reserved.',
		),
	),
);



// Login Page Settings
$sections[] = array(
	'title'  => __('Login Page Settings', 'howes'),
	'header' => __('Login Page Settings', 'howes'),
	//'customizer'=> false,
	'desc'   => __('Set options for login page.', 'howes'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-lock',
	'fields' => array(
		array(
			'id'            => 'login_background',
			'type'          => 'background',
			'title'         => __('Background Properties', 'howes'),
			'subtitle'      => __('Specify the type of background object.', 'howes'),
			'preview_media' => true,
			//'output'        => array('body.login'),
			'default'       => array(
				"background-color"    => "#ffffff",
				"background-repeat"   => "no-repeat",
				"background-size"     => "cover",
				"background-position" => "center center",
				"background-image"    => get_template_directory_uri().'/images/login-bg-image.jpg',
			),
			'customizer'=> false,
		),
	),
);


// Blog Settings
$sections[] = array(
	'title'  => __( 'Blog Settings', 'howes'),
	'header' => __( 'Blog Settings', 'howes'),
	'customizer'=> false,
	'desc'   => __('Settings for Blog section.', 'howes'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-pencil',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		/*array(
			'id'    =>'html-blogsettings',
			'type'  => 'info',
			'title' => __('Blog Settings', 'howes'), 
			'desc'  => __('Settings for blog section.', 'howes')
        ),*/
		array(
			'id'       => 'blog_text_limit',
			'type'     => 'slider',
			'title'    => __('Blog Excerpt Limit (in words)', 'howes'),
			'subtitle' => __('Set limit for small description. Select how many words you like to show. <br><strong>TIP: </strong> Select <code>0</code> (zero) to show excerpt or content before READ MORE break. <br>  ', 'howes'),
			'desc'     => __( 'Select how many products you want to show in the Related prodcuts area on single product page.', 'howes' ),
			'default'  => 0,
			'min'      => 0,
			'step'     => 1,
			'max'      => 500,
			'display_value' => 'text',
		),
		array(
			'id'       => 'blog_view',
			'type'     => 'select',
			'title'    => __('Blog view', 'howes'), 
			'subtitle' => __('Select blog view. The default view is classic list view. You can select two, three or four column blog view from here.', 'howes'),
			'options'  => array(
					'classic' => __('Classic View (default)', 'howes'),
					'two'     => __('Two Column view', 'howes'),
					'three'   => __('Three Column view', 'howes'),
					'four'    => __('Four Column view', 'howes'),
				),
			'default' => 'classic'
		),
	),
);




// Team Member Settings
$sections[] = array(
	'title'  => __( $howes['team_type_title'].' Settings', 'howes'),
	'header' => __( $howes['team_type_title'].' (Team Members) Settings', 'howes'),
	'customizer'=> false,
	'desc'   => __('Settings for <strong>'.$howes['team_type_title'].'</strong> custom post type. We are using "Team member" custom post type as <strong>'.$howes['team_type_title'].'</strong>. Here are some settings for this post type.', 'howes'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-user',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'       => 'team_before_title_text',
			'type'     => 'text',
			'title'    => __('Text Before Name of Member', 'howes'),
			'subtitle' => __('Text before name of Member (for single page only).', 'howes'),
			'default'  => __('About', 'howes'),
		),
	),
);



// Portfolio Settings
$sections[] = array(
	'title'  => __('Portfolio Settings', 'howes'),
	'header' => __('Portfolio Settings', 'howes'),
	'customizer'=> false,
	'desc'   => __('Portfolio section settings.', 'howes'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-th-large',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'       => 'portfolio_show_related',
			'type'     => 'switch',
			'title'    => __('Show Related Portfolio', 'howes'), 
			'subtitle' => __('Select YES to show related portfolio on single portfolio page.', 'howes'),
			'default'  => '1', // 1 = on | 0 = off
			'on'       => 'Yes',
			'off'      => 'No',
		),
		array(
			'id'       => 'portfolio_description',
			'type'     => 'text',
			'title'    => __('Description Title', 'howes'),
			'subtitle' => __('Title for the "Description" area. (For single portfolio only)', 'howes'),
			'default'  => __('Project Details', 'howes'),
		),
		array(
			'id'       => 'portfolio_project_details',
			'type'     => 'text',
			'title'    => __('Project Details Title', 'howes'),
			'subtitle' => __('Title for the "Project Details" area. (For single portfolio only)', 'howes'),
			'default'  => __('Our Skills', 'howes'),
		),
		array(
			'id'       => 'portfolio_related_title',
			'type'     => 'text',
			'title'    => __('Related Portfolio Title', 'howes'),
			'subtitle' => __('Title for the Releated Portfolio area. (For single portfolio only)', 'howes'),
			'default'  => __('Related  Projects', 'howes'),
		),
		array(
			'id'       => 'portfolio_viewstyle',
			'type'     => 'radio',
			'title'    => __('Single Portfolio View Style', 'howes'), 
			'subtitle' => __('Select view for single portfolio', 'howes'),
			'options'  => array( 
				'default'  => __('Left image and right content (default)', 'howes'),
				'top'      => __('Top image and bottom content', 'howes'),
			),
			'default'  => 'default'
		),
		
	),
);





// Error 404 Page Settings
$sections[] = array(
	'title'  => __('Error 404 Page Settings', 'howes'),
	'header' => __('Error 404 Page Settings', 'howes'),
	'customizer'=> false,
	'desc'   => __('Settings that determine how the error page will be looking', 'howes'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-warning-sign',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'       => 'error404',
			'type'     => 'textarea',
			'title'    => __('Error 404 Page Content', 'howes'),
			'subtitle' => __('Content of the page if error 404 occurred', 'howes'),
			'desc'     => __('HTML tags and shortcodes are allowed', 'howes'),
			'validate' => 'html',
			'default'  => __('<div class="thememount-big-icon"><i class="tmicon-fa-warning"></i></div><h1>404 ERROR</h1><p>This file may have been moved or deleted. Be sure to check your spelling.</p><a class="vc_btn vc_btn_skincolor vc_btn_md vc_btn_round" title="Back to Home" href="/">Back to Home</a><br><br><br>', 'howes'),
		),
		array(
			'id'       => 'error404_search',
			'type'     => 'switch',
			'title'    => __('Show Search Form', 'howes'), 
			'subtitle' => __('Set this option <code>YES</code> to show search form on the 404 page.', 'howes'),
			'default'  => '1', // 1 = on | 0 = off
			'on'       => __('Yes', 'howes'),
			'off'      => __('No', 'howes'),
		),
	),
);


// Search Page Settings
$sections[] = array(
	'title'  => __('Search Page Settings', 'howes'),
	'header' => __('Search Page Settings', 'howes'),
	'customizer'=> false,
	'desc'   => __('Settings that determine how the search results page will be looking', 'howes'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-search',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'       => 'searchnoresult',
			'type'     => 'textarea',
			'title'    => __('Content of the search page if no results found', 'howes'), 
			'subtitle' => __('Specify the content of the page that will be displayed if while search no results found', 'howes'),
			'desc'     => __('HTML tags and shortcodes are allowed', 'howes'),
			'validate' => 'html',
			'default'  => __('<div class="thememount-big-icon"><i class="tmicon-fa-search"></i></div><h4>No results were found for your search</h4></br>You may try the search with another query.<br><br><br>', 'howes'),
		),
	),
);



// Sidebars
$sections[] = array(
	'title'  => __('Sidebar', 'howes'),
	'customizer'=> false,
	'header' => __('Sidebar', 'howes'),
	'desc'   => __('Setup some extra sidebars for a page widgets', 'howes'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-pause',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'       => 'sidebars',
			'type'     => 'multi_text',
			'title'    => __('Custom Sidebars', 'howes'),
			'subtitle' => __('Specify the custom sidebars that can be used in the pages for a widgets', 'howes'),
		),
		array(
			'id'    =>'html-sidebars',
			'type'  => 'info',
			'title' => __('Sidebar Position', 'howes'), 
			'desc'  => __('Select sidebar position for different sections.', 'howes')
        ),
		array(
			'id'      => 'sidebar_page',
			'type'    => 'image_select',
			'title'   => __('Standard Pages Sidebar', 'howes'), 
			'desc'    => __('Select one of layouts for standard pages', 'howes'),
			'options' => array(
				'no'        => array('title' => __('No Sidebar', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_no_side.png'),
				'left'      => array('title' => __('Left Sidebar', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_left.png'),
				'right'     => array('title' => __('Right Sidebar', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_right.png'),
				'both'      => array('title' => __('Both Sidebars', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_both.png'),
				'bothleft'  => array('title' => __('Both at Left', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_left_both.png'),
				'bothright' => array('title' => __('Both at Right', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_right_both.png'),
			),
			'default' => 'right'
		),
		array(
			'id'      => 'sidebar_blog',
			'type'    => 'image_select',
			'title'   => __('Blog Page Sidebar', 'howes'), 
			'desc'    => __('Select one of layouts for blog page', 'howes'),
			'options' => array(
				'no'        => array('title' => __('No Sidebar', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_no_side.png'),
				'left'      => array('title' => __('Left Sidebar', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_left.png'),
				'right'     => array('title' => __('Right Sidebar', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_right.png'),
				'both'      => array('title' => __('Both Sidebars', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_both.png'),
				'bothleft'  => array('title' => __('Both at Left', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_left_both.png'),
				'bothright' => array('title' => __('Both at Right', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_right_both.png'),
			),
			'default' => 'right'
		),
		array(
			'id'      => 'sidebar_search',
			'type'    => 'image_select',
			'title'   => __('Search Page Sidebar', 'howes'), 
			'desc'    => __('Select one of layouts for search page', 'howes'),
			'options' => array(
				'no'        => array('title' => __('No Sidebar', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_no_side.png'),
				'left'      => array('title' => __('Left Sidebar', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_left.png'),
				'right'     => array('title' => __('Right Sidebar', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_right.png'),
				'both'      => array('title' => __('Both Sidebars', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_both.png'),
				'bothleft'  => array('title' => __('Both at Left', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_left_both.png'),
				'bothright' => array('title' => __('Both at Right', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_right_both.png'),
			),
			'default' => 'right'
		),
		array(
			'id'      => 'sidebar_woocommerce',
			'type'    => 'image_select',
			'title'   => __('WooCommerce Sidebar', 'howes'), 
			'desc'    => __('Select sidebar position for WooCommerce Shop and Single Product page', 'howes'),
			'options' => array(
				'no'    => array('title' => __('No Sidebar', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_no_side.png'),
				'left'  => array('title' => __('Left Sidebar', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_left.png'),
				'right' => array('title' => __('Right Sidebar', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_right.png'),
			),
			'default' => 'right'
		),
		array(
			'id'      => 'sidebar_bbpress',
			'type'    => 'image_select',
			'title'   => __('BBPress Sidebar', 'howes'), 
			'desc'    => __('Select sidebar position for BBPress pages', 'howes'),
			'options' => array(
				'left'  => array('title' => __('Left Sidebar', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_left.png'),
				'right' => array('title' => __('Right Sidebar', 'howes'), 'img' => get_template_directory_uri() . '/inc/images/layout_right.png'),
			),
			'default' => 'right'
		),
	),
);


// Social Links
$sections[] = array(
	'title'  => __('Social Links', 'howes'),
	'header' => __('Social Links', 'howes'),
	'customizer'=> false,
	'desc'   => __('Setup social links to show in header and footer', 'howes'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-group',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'     => 'kwayy-social-desc',
			'type'   => 'info',
			'style'  => 'success',
			'notice' => true,
			'title'  => __('TIP:', 'howes'),
			'desc'   => __('Not found your social service? No problem, we are ready to add new social service here. Please send us social service name via our <a href="http://support.thememount.com/" target="_blank">support system</a> and we will add it.', 'howes'),
		),
		array(
			'id'       => 'twitter',
			'type'     => 'textarea',
			'title'    => __('Twitter Link', 'howes'), 
			'subtitle' => __('Your Twitter Link', 'howes'),
			'desc'     => __('Paste URL only', 'howes'),
		),
		array(
			'id'       => 'youtube',
			'type'     => 'textarea',
			'title'    => __('YouTube Link', 'howes'), 
			'subtitle' => __('Your YouTube Link', 'howes'),
			'desc'     => __('Paste URL only', 'howes'),
		),
		array(
			'id'       => 'flickr',
			'type'     => 'textarea',
			'title'    => __('Flickr Link', 'howes'), 
			'subtitle' => __('Your Flickr Link', 'howes'),
			'desc'     => __('Paste URL only', 'howes'),
		),
		array(
			'id'       => 'facebook',
			'type'     => 'textarea',
			'title'    => __('Facebook Link', 'howes'), 
			'subtitle' => __('Your Facebook Link', 'howes'),
			'desc'     => __('Paste URL only', 'howes'),
		),
		array(
			'id'       => 'linkedin',
			'type'     => 'textarea',
			'title'    => __('LinkedIn Link', 'howes'), 
			'subtitle' => __('Your LinkedIn Link', 'howes'),
			'desc'     => __('Paste URL only', 'howes'),
		),
		array(
			'id'       => 'googleplus',
			'type'     => 'textarea',
			'title'    => __('Google+ Link', 'howes'), 
			'subtitle' => __('Your Google+ Link', 'howes'),
			'desc'     => __('Paste URL only', 'howes'),
		),
		array(
			'id'       => 'yelp',
			'type'     => 'textarea',
			'title'    => __('Yelp Link', 'howes'), 
			'subtitle' => __('Your Yelp Link', 'howes'),
			'desc'     => __('Paste URL only', 'howes'),
		),
		array(
			'id'       => 'dribbble',
			'type'     => 'textarea',
			'title'    => __('Dribbble Link', 'howes'), 
			'subtitle' => __('Your Dribbble Link', 'howes'),
			'desc'     => __('Paste URL only', 'howes'),
		),
		array(
			'id'       => 'pinterest',
			'type'     => 'textarea',
			'title'    => __('Pinterest Link', 'howes'), 
			'subtitle' => __('Your Pinterest Link', 'howes'),
			'desc'     => __('Paste URL only', 'howes'),
		),
		array(
			'id'       => 'podcast',
			'type'     => 'textarea',
			'title'    => __('Podcast Link', 'howes'), 
			'subtitle' => __('Your Podcast Link', 'howes'),
			'desc'     => __('Paste URL only', 'howes'),
		),
		array(
			'id'       => 'instagram',
			'type'     => 'textarea',
			'title'    => __('Instagram Link', 'howes'), 
			'subtitle' => __('Your Instagram Link', 'howes'),
			'desc'     => __('Paste URL only', 'howes'),
		),
		array(
			'id'       => 'xing',
			'type'     => 'textarea',
			'title'    => __('Xing Link', 'howes'), 
			'subtitle' => __('Your Xing Link', 'howes'),
			'desc'     => __('Paste URL only', 'howes'),
		),
		array(
			'id'       => 'vimeo',
			'type'     => 'textarea',
			'title'    => __('Vimeo Link', 'howes'), 
			'subtitle' => __('Your Vimeo Link', 'howes'),
			'desc'     => __('Paste URL only', 'howes'),
		),
		array(
			'id'       => 'vk',
			'type'     => 'textarea',
			'title'    => __('VK Link', 'howes'), 
			'subtitle' => __('Your VK Link', 'howes'),
			'desc'     => __('Paste URL only', 'howes'),
		),
		array(
			'id'       => 'rss',
			'type'     => 'switch',
			'title'    => __('Show RSS Link', 'howes'), 
			'on'       => 'Yes',
			'off'      => 'No',
			'subtitle' => __('Check this option to show RSS link with social icons list', 'howes'),
			'default'  => '1'// 1 = on | 0 = off
		),
	),
);




// WooCommerce Settings
$sections[] = array(
	'title'  => __('WooCommerce Settings', 'howes'),
	'header' => __('WooCommerce Settings', 'howes'),
	'customizer'=> false,
	'desc'   => __('Setup for WooCommerce shop section. Please make sure you installed WooCommerce plugin.', 'howes'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-shopping-cart',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		// WooCommerce settings
		/*array(
			'id'    =>'html-woocommerce-settings',
			'type'  => 'info',
			'title' => __('WooCommerce Settings', 'howes'), 
			'desc'  => __('Settings for the WooCommerce plugin.', 'howes')
        ),*/
		
		array(
			'id'       => 'wc-header-icon',
			'type'     => 'switch',
			'title'    => __('Show Cart Icon in Header', 'howes'), 
			'subtitle' => __('Select <code>YES</code> to show the cart icon in header. Select <code>NO</code> to hide the cart icon.', 'howes') . ' <br><br> ' . __('<strong>NOTE: </strong> Please note that if you haven\'t installed "WooCommerce" plugin than the icon will not appear even if you selected <code>YES</code> in this option.', 'howes') ,
			'on'       => 'Yes',
			'off'      => 'No',
			'default'  => '1', // 1 = on | 0 = off
			'customizer'=> false,
		),
		array(
			'id'       => 'woocommerce-column',
			'type'     => 'radio',
			'title'    => __('WooCommerce Product List Column', 'howes'), 
			'subtitle' => __('Select how many column you want to show for product list view.', 'howes'),
			'options'  => array(
				'1' => __('One Column', 'howes'),
				'2' => __('Two Columns', 'howes'),
				'3' => __('Three Columns', 'howes'),
				'4' => __('Four Columns', 'howes'),
			),
			'default'  => '3'
		),
		array(
			'id'            => 'woocommerce-product-per-page',
			'type'          => 'slider',
			'title'         => __( 'Products Per Page', 'howes' ),
			'subtitle'      => __( 'Select how many product you want to show on SHOP page.', 'howes' ),
			'desc'          => __( 'Select how many product you want to show on SHOP page.', 'howes' ),
			'default'       => 9,
			'min'           => 2,
			'step'          => 1,
			'max'           => 30,
			'display_value' => 'text',
		),
		
		array(
			'id'    =>'html-wc_single_product_page',
			'type'  => 'info',
			'title' => __('Single Product Page Settings', 'howes'), 
			'desc'  => __('Options for Single product page.', 'howes')
        ),
		array(
			'id'       => 'wc-single-show-related',
			'type'     => 'switch',
			'title'    => __('Show Related Products', 'howes'), 
			'subtitle' => __('Select <code>YES</code> to show Related Products below the product description on single page.', 'howes') ,
			'on'       => 'Yes',
			'off'      => 'No',
			'default'  => '1', // 1 = on | 0 = off
			'customizer'=> false,
		),
		array(
			'id'       => 'wc-single-related-column',
			'type'     => 'radio',
			'title'    => __('Column for Related Products', 'howes'), 
			'subtitle' => __('Select how many column you want to show for product list of related products.', 'howes'),
			'options'  => array(
				'1' => __('One Column', 'howes'),
				'2' => __('Two Columns', 'howes'),
				'3' => __('Three Columns', 'howes'),
				'4' => __('Four Columns', 'howes'),
			),
			'default'  => '3'
		),
		array(
			'id'            => 'wc-single-related-count',
			'type'          => 'slider',
			'title'         => __( 'Related Products Show', 'howes' ),
			'subtitle'      => __( 'Select how many products you want to show in the Related prodcuts area on single product page.', 'howes' ),
			'desc'          => __( 'Select how many products you want to show in the Related prodcuts area on single product page.', 'howes' ),
			'default'       => 3,
			'min'           => 1,
			'step'          => 1,
			'max'           => 8,
			'display_value' => 'text',
		),
		
	),
);




// Advanced Settings
$sections[] = array(
	'title'  => __('Advanced Settings', 'howes'),
	'header' => __('Advanced Settings', 'howes'),
	'customizer'=> false,
	'desc'   => __('Team Member section settings.', 'howes'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-wrench',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'    =>'html-teamoptionsadv',
			'type'  => 'info',
			'title' => __('Custom Post Type : Team member Settings', 'howes'), 
			'desc'  => __('Advanced settings for Team Member custom post type.', 'howes')
        ),
		array(
			'id'       => 'team_type_title',
			'type'     => 'text',
			'title'    => __('Title for Team Member Post Type', 'howes'),
			'subtitle' => __('This will change the Title for Team Member post type section.', 'howes'),
			'default'  => __('Team Members', 'howes'),
		),
		array(
			'id'       => 'team_type_slug',
			'type'     => 'text',
			'title'    => __('URL Slug for Team Member Post Type', 'howes'),
			'subtitle' => __('This will change the URL slug for Team Member post type section.', 'howes'),
			'default'  => 'team-members',
		),
		array(
			'id'       => 'team_group_title',
			'type'     => 'text',
			'title'    => __('Title for Team Group List', 'howes'),
			'subtitle' => __('Title for Team Group list for group page. This will appear at left sidebar.', 'howes'),
			'default'  => __('Team Group', 'howes'),
		),

		array(
			'id'       => 'team_group_slug',
			'type'     => 'text',
			'title'    => __('URL Slug for Team Group Link', 'howes'),
			'subtitle' => __('This will change the URL slug for Team Group link.', 'howes'),
			'default'  => 'team-group',
		),
		array(
			'id'       => 'team_type_archive_title',
			'type'     => 'text',
			'title'    => __('Title for archive page', 'howes'),
			'subtitle' => sprintf( __( 'Title for archive page of Team Member. <a href="%s"> Click here to view the page</a>', 'howes'), get_post_type_archive_link( 'team_member' ) ),
			'default'  => __('Team Members', 'howes'),
		),
		
		array(
			'id'    =>'html-adv_titlebaroptions',
			'type'  => 'info',
			'title' => __('Titlebar Options', 'howes'), 
			'desc'  => __('Change settings for Titlebar.', 'howes')
        ),
		array(
			'id'       => 'adv_tbar_catarc',
			'type'     => 'text',
			'title'    => __('Post Category <code>Category Archives:</code> Label Text', 'howes'),
			//'subtitle' => __('Post <code>Category Archives:</code> Label Text', 'howes'),
			'default'  => __('Category Archives: ', 'howes'),
		),
		array(
			'id'       => 'adv_tbar_tagarc',
			'type'     => 'text',
			'title'    => __('Post Tag <code>Tag Archives:</code> Label Text', 'howes'),
			//'subtitle' => __('Post <code>Tag Archives:</code> Label Text', 'howes'),
			'default'  => __('Tag Archives: ', 'howes'),
		),
		array(
			'id'       => 'adv_tbar_postclassified',
			'type'     => 'text',
			'title'    => __('Post Taxonomy <code>Posts classified under:</code> Label Text', 'howes'),
			//'subtitle' => __('Post Taxonomy <code>Posts classified under:</code> Label Text', 'howes'),
			'default'  => __('Posts classified under: ', 'howes'),
		),
		array(
			'id'       => 'adv_tbar_authorarc',
			'type'     => 'text',
			'title'    => __('Post Author <code>Author Archives:</code> Label Text', 'howes'),
			//'subtitle' => __('Post Author <code>Author Archives:</code> Label Text', 'howes'),
			'default'  => __('Author Archives: ', 'howes'),
		),
		
		
		array(
			'id'    =>'html-adv_dynamic_style',
			'type'  => 'info',
			'title' => __('Dynamic Style Position', 'howes'), 
			'desc'  => __('Change how the dynamic-style.php file\'s code will be appear.', 'howes')
        ),
		array(
			'id'       => 'dynamic-style-position',
			'type'     => 'radio',
			'title'    => __('Dynamic Style Position', 'howes'), 
			'subtitle' => __('- Select <strong>External</strong> to load the file external (the file name will be <code>dynamic-style.php</code>). <br><br> - Select <strong>Internal</strong> to load the dynamic style on page directly (useful for WPMU server).', 'howes'),
			'options'  => array( 'external' => __('External', 'howes'), 'internal' => __('Internal', 'howes') ),
			'default'  => 'external'
		),
		
		
		
		
		// WooCommerce settings
		/*array(
			'id'    =>'html-woocommerce-settings',
			'type'  => 'info',
			'title' => __('WooCommerce Settings', 'howes'), 
			'desc'  => __('Settings for the WooCommerce plugin.', 'howes')
        ),
		
		array(
			'id'       => 'woocommerce-column',
			'type'     => 'radio',
			'title'    => __('WooCommerce Product List Column', 'howes'), 
			'subtitle' => __('Select how many column you want to show for product list view.', 'howes'),
			'options'  => array(
				'1' => __('One Column', 'howes'),
				'2' => __('Two Columns', 'howes'),
				'3' => __('Three Columns', 'howes'),
				'4' => __('Four Columns', 'howes'),
			),
			'default'  => '3'
		),
		array(
			'id'            => 'woocommerce-product-per-page',
			'type'          => 'slider',
			'title'         => __( 'Products Per Page', 'howes' ),
			'subtitle'      => __( 'Select how many product you want to show on SHOP page.', 'howes' ),
			'desc'          => __( 'Select how many product you want to show on SHOP page.', 'howes' ),
			'default'       => 9,
			'min'           => 2,
			'step'          => 1,
			'max'           => 30,
			'display_value' => 'text',
		),*/
		
	),
);



// Custom Code
$sections[] = array(
	'title'  => __('Custom Code', 'howes'),
	'header' => __('Custom Code', 'howes'),
	'customizer'=> false,
	'desc'   => __('Add custom JS and CSS code', 'howes'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-pencil',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'       => 'custom_css_code',
			'type'     => 'ace_editor',
			'title'    => __('CSS Code', 'howes'), 
			'subtitle' => __('Paste your CSS code here.', 'howes'),
			'mode'     => 'css',
			'theme'    => 'monokai',
			'desc'     => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
			'default'  => ""
		),
		array(
			'id'       => 'custom_js_code',
			'type'     => 'ace_editor',
			'title'    => __('JS Code', 'howes'), 
			'subtitle' => __('Paste your JS code here.', 'howes'),
			'mode'     => 'javascript',
			'theme'    => 'chrome',
			'desc'     => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
			'default'  => ""
		),
		
		array(
			'id'    =>'html-logincode',
			'type'  => 'info',
			'title' => __('Custom Code for Login page', 'howes'), 
			'desc'  => __('Custom Code for Login page only. This will effect only login page and not effect any other pages or admin section.', 'howes')
        ),
		array(
			'id'       => 'login_custom_css_code',
			'type'     => 'ace_editor',
			'title'    => __('CSS Code for Login Page', 'howes'), 
			'subtitle' => __('Paste write CSS code here.', 'howes'),
			'mode'     => 'css',
			'theme'    => 'monokai',
			'desc'     => __('Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.', 'howes'),
			//'default'  => ""
		),
	),
);


$sections[] = array(
	'type' => 'divide',
);

$sections[] = array(
	'icon' => 'el-icon-info-sign',
	'title' => __('Theme Information', 'howes'),
	'desc' => __('<p class="description">This is the Description. Again HTML is allowed</p>', 'howes'),
	'fields' => array(
		array(
			'id'=>'raw_new_info',
			'type' => 'raw',
			'content' => $item_info,
		)
	),
);


$sections[] = array(
	'title'     => __('Import / Export', 'howes'),
	'desc'      => __('Import and Export your Redux Framework settings from file, text or URL.', 'howes'),
	'icon'      => 'el-icon-refresh',
	'fields'    => array(
		array(
			'id'            => 'opt-import-export',
			'type'          => 'import_export',
			'title'         => 'Import Export',
			'subtitle'      => 'Save and restore your Redux options',
			'full_width'    => false,
		),
	),
); 

/*****************************************************************************/



		

if (function_exists('wp_get_theme')){
	$theme_data = wp_get_theme();
	$theme_uri = $theme_data->get('ThemeURI');
	$description = $theme_data->get('Description');
	$author = $theme_data->get('Author');
	$version = $theme_data->get('Version');
	$tags = $theme_data->get('Tags');
}else{
	$theme_data = wp_get_theme(trailingslashit(get_stylesheet_directory()).'style.css');
	$theme_uri = $theme_data['URI'];
	$description = $theme_data['Description'];
	$author = $theme_data['Author'];
	$version = $theme_data['Version'];
	$tags = $theme_data['Tags'];
}	

$theme_info = '<div class="redux-framework-section-desc">';
$theme_info .= '<p class="redux-framework-theme-data description theme-uri">'.__('<strong>Theme URL:</strong> ', 'howes').'<a href="'.$theme_uri.'" target="_blank">'.$theme_uri.'</a></p>';
$theme_info .= '<p class="redux-framework-theme-data description theme-author">'.__('<strong>Author:</strong> ', 'howes').$author.'</p>';
$theme_info .= '<p class="redux-framework-theme-data description theme-version">'.__('<strong>Version:</strong> ', 'howes').$version.'</p>';
$theme_info .= '<p class="redux-framework-theme-data description theme-description">'.$description.'</p>';
if ( !empty( $tags ) ) {
	$theme_info .= '<p class="redux-framework-theme-data description theme-tags">'.__('<strong>Tags:</strong> ', 'howes').implode(', ', $tags).'</p>';	
}
$theme_info .= '</div>';

if(file_exists(dirname(__FILE__).'/README.md')){
$sections['theme_docs'] = array(
			'icon' => get_template_directory_uri().'assets/img/glyphicons/glyphicons_071_book.png',
			'title' => __('Documentation', 'howes'),
			'fields' => array(
				array(
					'id'=>'17',
					'type' => 'raw',
					'content' => file_get_contents(dirname(__FILE__).'/README.md')
					),				
			),
			
			);
}//if

global $ReduxFramework;
$ReduxFramework = new ReduxFramework($sections, $args, $tabs);

// END Sample Config


/**
 
 	Custom function for filtering the sections array. Good for child themes to override or add to the sections.
 	Simply include this function in the child themes functions.php file.
 
 	NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
 	so you must use get_template_directory_uri() if you want to use any of the built in icons
 
 **/
function add_another_section($sections){
    //$sections = array();
    $sections[] = array(
        'title' => __('A Section added by hook', 'howes'),
        'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'howes'),
		'icon' => 'el-icon-paper-clip',
		'icon_class' => 'icon-large',
        // Leave this as a blank section, no options just some intro text set above.
        'fields' => array()
    );

    return $sections;
}
add_filter('redux-opts-sections-redux-sample', 'add_another_section');


/**

	Custom function for filtering the args array given by a theme, good for child themes to override or add to the args array.

**/
function change_framework_args($args){
    //$args['dev_mode'] = false;
    
    return $args;
}
//add_filter('redux-opts-args-redux-sample-file', 'change_framework_args');





/** 

	Custom function for the callback referenced above

 */
function my_custom_field($field, $value) {
    print_r($field);
    print_r($value);
}

/**
 
	Custom function for the callback validation referenced above

**/
function validate_callback_function($field, $value, $existing_value) {
    $error = false;
    $value =  'just testing';
    /*
    do your validation
    
    if(something) {
        $value = $value;
    } elseif(something else) {
        $error = true;
        $value = $existing_value;
        $field['msg'] = 'your custom error message';
    }
    */
    
    $return['value'] = $value;
    if($error == true) {
        $return['error'] = $field;
    }
    return $return;
}

/**
	This is a test function that will let you see when the compiler hook occurs. 
	It only runs if a field	set with compiler=>true is changed.

**/
function testCompiler() {
	//echo "Compiler hook!";
}
add_action('redux-compiler-redux-sample-file', 'testCompiler');



/**
	Use this code to hide the activation notice telling users about a sample panel.

**/
if ( class_exists('ReduxFrameworkPlugin') ) {
	//remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );	
}

/**

	Use this code to hide the demo mode link from the plugin page. Only used when Redux is a plugin.

**/
function removeDemoModeLink() {
	if ( class_exists('ReduxFrameworkPlugin') ) {
		remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2 );
	}
}
//add_action('init', 'removeDemoModeLink');



