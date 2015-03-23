<?php 
// Including Framework Master File
include_once('cuztom-helper-framework/cuztom.php');







// This must bein INIT action otherwise it will not call and return empty data.
function thememount_slider_options_setup(){
	
	// Including Framework Master File
	include_once('cuztom-helper-framework/cuztom.php');

	// Declaring Pages variable
	$pages = new Cuztom_Post_Type('page');
	
	
	// Retriving Custom Sidebars for use as option for dropdown
	global $howes;
	$sidebars = array(''=>'Default');
	if( isset($howes['sidebars']) && is_array($howes['sidebars']) && count($howes['sidebars'])>0 ){
		foreach($howes['sidebars'] as $sidebar){
			if( !empty($sidebar) && trim($sidebar)!='' ){
				$sidebar_key = str_replace('-','_',sanitize_title($sidebar));
				$sidebars[$sidebar_key] = $sidebar;
			}
		}
	}
	
		
	// Getting Slider Type
	$sliderType         = array();
	$sliderType['']     = __('No slider', 'howes');
	if ( is_plugin_active( 'revslider/revslider.php' ) ) { $sliderType['revslider'] = __('Slider Revolution', 'howes'); }
	$sliderType['nivo'] = __('Nivo Slider', 'howes');
	$sliderType['flex'] = __('Flex Slider', 'howes');
	
	if ( is_plugin_active( 'revslider/revslider.php' ) ) {
		
		/* Slider Revolution plugin is activated */
		global $wpdb;
		$sliders    = $wpdb->get_results("SELECT id,title,alias FROM ".$wpdb->prefix."revslider_sliders");
		$revSliders = array();
		if( $sliders!=false && count($sliders)>0 ){
			foreach($sliders as $slider) {$revSliders[ $slider->alias ] = $slider->title;}
		}
		
		$sliderOptions = array(
			array(
				'name'          => 'slidertype',
				'label'         => __('Select Slider', 'howes'),
				'description'   => __('Select slider which you want to show on this page. The slider will appear in header area.', 'howes'),
				'type'          => 'radios',
				'options'       => $sliderType,
				'default_value' => ''
			),
			array(
				'name'          => 'revslider_slider',
				'label'         => __('Select Slider for Slider Revolution', 'howes'),
				'description'   => __('Select slider for Slider Revolution.', 'howes'),
				'type'          => 'select',
				'options'       => $revSliders,
			),
		);
		
	} else {

		/* Slider Revolution plugin is not activated */
		$sliderOptions = array(
			array(
				'name'          => 'slidertype',
				'label'         => __('Select Slider', 'howes'),
				'description'   => __('Select slider which you want to show on this page. The slider will appear in header area.', 'howes'),
				'type'          => 'select',
				'options'       => $sliderType,
			),
		);
	}
	
	
	$allCat = get_terms( 'slide_group', 'hide_empty=0' );
	if( count($allCat)>0 ){
		
		// Preparing array of category list
		$catList = array();
		foreach( $allCat as $cat ){ $catList[$cat->slug] = $cat->name.' ('.$cat->count.')'; }
		$sliderOptions[] = array(
			'name'          => 'slidercat',
			'label'         => __('Select Slider Group', 'howes'),
			'description'   => __('Select slider group to fetch all slides. Please note that only selected group\'s slides will be shown in FLEX or NIVO slider.', 'howes'),
			'type'          => 'select',
			'options'       => $catList,
		);
	
	}
	
	// Wide or Boxed slider
	$sliderOptions[] = array(
			'name'          => 'slidersize',
				'label'         => __('Slide Size', 'howes'),
				'description'   => __('Select slider width size.', 'howes'),
				'type'          => 'radios',
				'options'       => array( 'wide'=>'Wide Slider', 'boxed'=>'Boxed Slider' ),
				'default_value' => 'wide'
		);
	
	
	// All options as tabs: Title Box Opitons, Slider Area Options, Sidebar Widget Options
	$pages->add_meta_box(
		'thememount_page_options',
		'Howes: Page Options',
		array(
			'tabs',
			array(
				__('Titlebar Options', 'howes') => array(
					array(
						'name'          => 'hidetitlebar',
						'label'         => __('Hide Titlebar', 'howes'),
						'description'   => __('If you want to hide title box than check this option', 'howes'),
						'type'          => 'checkbox'
					),
					array(
						'name'          => 'titlebar_view',
						'label'         => __('Titlebar View', 'howes'),
						'description'   => __('Select view of Titlebar.', 'howes'),
						'type'          => 'select',
						'options'       => array(
							'global'    => __('Global', 'howes'),
							'default'    => __('All Center', 'howes'),
							'left'       => __('All Left', 'howes'),
							'right'      => __('All Right', 'howes'),
						),
					),

					array(
						'name'          => 'title',
						'label'         => __('Page Title', 'howes'),
						'description'   => __('(Optional) Replace current page title with this title. So Search results will show the original page title and the page will show this title.', 'howes'),
						'type'          => 'textarea'
					),
					array(
						'name'          => 'subtitle',
						'label'         => __('Page Subtitle', 'howes'),
						'description'   => __('(Optional) Please fill page subtitle', 'howes'),
						'type'          => 'textarea'
					),
					array(
						'name'          => 'hidebreadcrumb',
						'label'         => __('Hide Breadcrumb', 'howes'),
						'description'   => __('If you want to hide breadcrumb than check this option', 'howes'),
						'type'          => 'checkbox'
					),
					array(
						'name'          => 'titlebar_bg_image',
						'label'         => __('Titlebar Background Image', 'howes'),
						'description'   => __('(Optional) Please select background image.', 'howes'),
						'type'          => 'select',
						'options'       => array(
									'global' => __('Global', 'howes'),
									'1'      => __('Image 1', 'howes'),
									'2'      => __('Image 2', 'howes'),
									'3'      => __('Image 3', 'howes'),
									'4'      => __('Image 4', 'howes'),
									'5'      => __('Image 5', 'howes'),
									'custom' => __('Custom image (selected below)', 'howes'),
						),
					),
					array(
						'name'        => 'titlebar_bg_image_custom',
						'label'       => __('Upload Titlebar Background Image', 'howes'),
						'description' => __('(Optional) Please upload image for background of Titlebar. Image size should be <code>1700px X 500px</code>.', 'howes'),
						'type'        => 'image',
					),
				),
			
				__('Slider Area Options','howes') => $sliderOptions,
				
				__('Sidebar Options','howes') => array(
					array(
						'name'          => 'leftsidebar',
						'label'         => __('Left Sidebar', 'howes'),
						'description'   => __('(Optional) Select left sidebar Widget position', 'howes'),
						'type'          => 'select',
						'options'       => $sidebars
					),
					array(
						'name'          => 'rightsidebar',
						'label'         => __('Right Sidebar', 'howes'),
						'description'   => __('(Optional) Select right sidebar Widget position', 'howes'),
						'type'          => 'select',
						'options'       => $sidebars
					),
					array(
						'name'          => 'sidebarposition',
						'label'         => __('Sidebar Position', 'howes'),
						'description'   => __('(Optional) Select position for sidebars', 'howes'),
						//'type'        => 'select',
						'type'          => 'radios',
						'options'       => array(
							''         => __('Global', 'howes'),
							'no'       => __('No Sidebar', 'howes'),
							'left'     => __('Left Sidebar only', 'howes'),
							'right'    => __('Right Sidebar only', 'howes'),
							'both'     => __('Both Left and Right Sidebars', 'howes'),
							'bothleft' => __('Both sidebars at Left side', 'howes'),
							'bothright'=> __('Both sidebars at Right side', 'howes'),
						)
					)
				)
			)
		)
	);




	
	
	
	
	
	
	
	
	
		
		
	// Topbar
	$pages->add_meta_box(
		'thememount_page_topbar',
		'Howes: Topbar Options',
		array(
			array(
				'name'          => 'topbarhide',
				'label'         => __('Hide Topbar', 'howes'),
				'description'   => __('If you want to hide Topbar than check this option', 'howes'),
				'type'          => 'select',
				'options'       => array(
					''           => __('Global', 'howes'),
					'1'          => __('Yes, hide Topbar', 'howes'),
					'0'          => __('No, show Topbar', 'howes'),
				),
				//'default_value' => '',
			),
			array(
				'name'          => 'topbarbgcolor',
				'label'         => __('Background Color', 'howes'),
				'description'   => __('Please select color for background', 'howes'),
				'type'          => 'select',
				'options'       => array(
					''           => __('Global', 'howes'),
					'darkgrey'   => __('Dark grey', 'howes'),
					'grey'       => __('Grey', 'howes'),
					'white'      => __('White', 'howes'),
					'skincolor'  => __('Skincolor', 'howes'),
				),
				//'default_value' => 'default',
			),
			array(
				'name'          => 'topbarhidesocial',
				'label'         => __('Hide Social Icons in Topbar', 'howes'),
				'description'   => __('Check this option to hide the Social icons in Topbar', 'howes'),
				'type'          => 'select',
				'options'       => array(
					''           => __('Global', 'howes'),
					'1'          => __('Yes, hide Topbar', 'howes'),
					'0'          => __('No, show Topbar', 'howes'),
				),
				//'default_value' => 'default',
			),
			/*array(
				'name'          => 'topbarsocialposition',
				'label'         => __('Social Icon Position', 'howes'),
				'description'   => __('Select where you want to show the social icons', 'howes'),
				'type'          => 'select',
				'options'       => array(
					''           => __('Global', 'howes'),
					'right'      => __('Right', 'howes'),
					'left'       => __('Left', 'howes'),
				),
				'default_value' => 'right',
			),*/
			array(
				'name'          => 'topbartext',
				'label'         => __('Topbar Text (overwrite default text)', 'howes'),
				'description'   => __('Add content for Topbar text. This will overwrite default text set in Theme Options.', 'howes'),
				'type'          => 'textarea'
			),
		)
	);
	
	
	
	
	
	
	
	// Show Template options if template selected
	$template_file = '';
	$post_id       = (isset($_GET['post']) && $_GET['post']!='') ? $_GET['post'] : '';
	if( $post_id=='' ){
		if( isset($_POST['post_ID']) && $_POST['post_ID']!='' ){
			$post_id = $_POST['post_ID'];
		}
	}
	if( $post_id!='' ){
		$template_file = get_post_meta($post_id,'_wp_page_template',true);
		$showPosts     = get_post_meta($post_id, '_thememount_page_template_show_posts', true);
		// Setting default show numbers
		$defaultShowPosts = '10';
		switch($template_file){
			case 'template-blog-2-columns.php': 
				$defaultShowPosts = '10';
				break;
			case 'template-blog-3-columns.php': 
				$defaultShowPosts = '9';
				break;
			case 'template-blog-4-columns.php': 
				$defaultShowPosts = '8';
				break;
		}
	}
	if(    $template_file == 'template-blog-2-columns.php'
		|| $template_file == 'template-blog-3-columns.php'
		|| $template_file == 'template-blog-4-columns.php'
	){
		$pages->add_meta_box(
			'thememount_page_template',
			'Howes: Template Options',
			array(
				array(
					'name'        => 'show_posts',
					'label'       => __('Show Posts', 'howes'),
					'description' => __('How many posts you like to show on Two, Thee or Four column blog view.', 'howes'),
					'type'        => 'select',
					'options'     => array(
						'global'     => __('Global', 'howes'),
						'1'          => __('1', 'howes'),
						'2'          => __('2', 'howes'),
						'3'          => __('3', 'howes'),
						'4'          => __('4', 'howes'),
						'5'          => __('5', 'howes'),
						'6'          => __('6', 'howes'),
						'7'          => __('7', 'howes'),
						'8'          => __('8', 'howes'),
						'9'          => __('9', 'howes'),
						'10'          => __('10', 'howes'),
						'11'          => __('11', 'howes'),
						'12'          => __('12', 'howes'),
						'13'          => __('13', 'howes'),
						'14'          => __('14', 'howes'),
						'15'          => __('15', 'howes'),
						'16'          => __('16', 'howes'),
						'17'          => __('17', 'howes'),
						'18'          => __('18', 'howes'),
						'19'          => __('19', 'howes'),
						'20'          => __('20', 'howes'),
					),
					'default_value' => $defaultShowPosts,
				),
				
			)
		);
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	


	// Portfolio Options
	/*$pages->add_meta_box(
		'thememount_portfolio_options',
		'Howes: Portfolio Options',
		array(
			array(
				'name'          => 'portfolio',
				'label'         => __('Portfolio Columns', 'howes'),
				'description'   => __('Please select how many columns you want to show', 'howes'),
				'type'          => 'select',
				'options'       => array(
					//'metro' => __('Metro Style', 'howes'),
					'two'   => __('Two Columns', 'howes'),
					'three' => __('Three Columns', 'howes'),
					'four'  => __('Four Columns', 'howes'),
					//'mix'   => __('Mix Columns', 'howes')
				)
			),
			array(
				'name'          => 'projectperpage',
				'label'         => __('Projects on the page', 'howes'),
				'description'   => __('Enter the maximum number of projects to be shown on page', 'howes'),
				'type'          => 'select',
				'default_value' => '9',
				'options'       => array(
					'-1'  => 'All',
					'2'  => '2',
					'3'  => '3',
					'4'  => '4',
					'5'  => '5',
					'6'  => '6',
					'7'  => '7',
					'8'  => '8',
					'9'  => '9',
					'10' => '10',
					'11' => '11',
					'12' => '12',
					'13' => '13',
					'14' => '14',
					'15' => '15',
					'16' => '16',
					'17' => '17',
					'18' => '18',
					'19' => '19',
					'20' => '20',
					'21' => '21',
					'22' => '22',
					'23' => '23',
					'24' => '24',
					'25' => '25',
					'26' => '26',
					'27' => '27',
					'28' => '28',
					'29' => '29',
					'30' => '30'
				)
			),
			
			// Show Sortable Category Links
			array(
				'name'          => 'sortablecategory',
				'label'         => __('Show Sortable Category Links', 'howes'),
				'description'   => __('Show sortable category links above Portfolio items so user can sort by category by just single click', 'howes'),
				'type'          => 'radios',
				'default_value' => 'yes',
				'options'       => array(
					'yes' => __('Yes', 'howes'),
					'no'  => __('No', 'howes')
				)
			),
			// Show Sortable Category Links
			array(
				'name'          => 'categorylist',
				'label'         => __('Selected Category Only', 'howes'),
				'description'   => __('If you want to show only selected category than select the categories from here. <br> <strong>Note:</strong> If you want to show all categories than don\'t select any category', 'howes'),
				'type'          => 'term_checkboxes',
				'args'          => array(
					'taxonomy'   => 'portfolio_category',
					'hide_empty' => false,
				)
			),
		)
	);*/
	
	
	
	
	


}  // Function: thememount_slider_options_setup()

add_action( 'admin_init', 'thememount_slider_options_setup' );







