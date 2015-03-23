<?php


/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */
function thememount_vc_set_as_theme(){
	if( function_exists('vc_set_as_theme') ) vc_set_as_theme(true);
	//if( function_exists('vc_disable_frontend') ) vc_disable_frontend(); // This is to disable frontend editing
}
add_action('init', 'thememount_vc_set_as_theme');


/**
 * Icon Array
 */
global $thememount_iconsArray;
$allIcons = array();
foreach($thememount_iconsArray as $icon ){
	$allIcons[ucwords(str_replace('-',' ',$icon))] = $icon;
}



/**
 * Remove VC Metaboxes
 */
add_action( 'admin_head', 'thememount_remove_vc_meta_box' );
function thememount_remove_vc_meta_box() {
	remove_meta_box("vc_teaser", "portfolio", "side");
	remove_meta_box("vc_teaser", "page", "side"); 
	remove_meta_box("vc_teaser", "product", "side"); 
}




/**
 * Sample code to use in future
 */
// Set as Theme
/*
WPBakeryVisualComposerAbstract::$config['USER_DIR_NAME'] = 'inc/shortcodes';
WPBakeryVisualComposerAbstract::$config['default_post_types'] = array('post', 'page', 'portfolio', 'product');
vc_set_as_theme(true);
*/



/**
 * Adding Icon Selector parameter
 */
if( function_exists('add_shortcode_param') ){
	function thememount_iconselector_func($settings, $value) {
		//var_dump($settings);
		$dependency = vc_generate_dependencies_attributes($settings);
		$optionsList = '';
		//var_dump($settings);
		foreach( $settings['value'] as $val ){
			$selected =  ( $val==$value ) ? 'selected="selected"' : '' ;
			$optionsList .= '<option value="'.$val.'" '.$selected.'>'.$val.'</option>';
		}

		return '<div class="my_param_block">'
				.'<select name="'.$settings['param_name']
				.'" class="wpb_vc_param_value wpb-textinput thememount-icon-selector '
				.$settings['param_name'].' '.$settings['type'].'_field" '
				.' ' . $dependency . '>'
				.$optionsList
				.'</select>'
			.'</div>';
	}
	add_shortcode_param('thememount_iconselector', 'thememount_iconselector_func', get_template_directory_uri().'/inc/admin-custom-select2-runner.js' );
}



	if( !function_exists('thememount_vc_extraThings') ){
	/**
	 * Getting all Button Size to apply Service Box Buttons in Visual Composer
	 */
	function thememount_vc_extraThings() {

		/* Button Size */
		if( class_exists('WPBMap') ){
			$param2  = WPBMap::getParam('vc_button', 'size'); //Get current values stored in the color param in "Call to Action" element
			$btnSize = $param2['value'];
		};


		global $thememount_iconsArray;
		$allIcons = array();
		foreach($thememount_iconsArray as $icon ){
			$allIcons[ucwords(str_replace('-',' ',$icon))] = $icon;
		}

		$allIconsWithEmpty = array(__('No Icon', 'howes')=>'NO_ICON');
		$allIconsWithEmpty = $allIconsWithEmpty + $allIcons;

		
		if( class_exists('WPBMap') ){
		
			//global $newColorList;
			/*** Adding more colors in Visual Composer ***/
			$param1 = WPBMap::getParam('vc_button', 'color'); //Get current values stored in the color param in "Call to Action" element
			$oldColors = $param1['value'];
			$newColors = array(
				__('Skin color', 'howes') => 'skincolor',
				__('White', 'howes') => 'white',
			);
			$newColorList = $newColors + $oldColors;
			
			$param1['value'] = $newColorList;

			WPBMap::mutateParam('vc_cta_button', $param1);   //Finally "mutate" param with new values of Call To Action
			WPBMap::mutateParam('vc_button', $param1);       //Finally "mutate" param with new values of Button
			
			
			/**
			 * Adding more colors in Visual Composer (2nd version elements)
			 */
			$param2 = WPBMap::getParam('vc_button2', 'color'); //Get current values stored in the color param in "Call to Action" element
			$oldColors = $param2['value'];
			$newColors = array(
				__('Skin color', 'howes') => 'skincolor',
				__('White', 'howes') => 'white',
			);
			$newColorList = $newColors + $oldColors;
			
			$param2['value'] = $newColorList;

			WPBMap::mutateParam('vc_cta_button2', $param2);   //Finally "mutate" param with new values of Call To Action
			WPBMap::mutateParam('vc_button2', $param2);       //Finally "mutate" param with new values of Button
			
			
			
			
			/**
			 * Adding more colors in Visual Composer : Progress Bar
			 */
			$param3          = WPBMap::getParam('vc_progress_bar', 'bgcolor'); //Get current values stored in the color param in "Progressbar" element
			$oldColors3      = $param3['value'];
			$newColors3      = array( __('Skin color', 'howes') => 'skincolor' );
			$newColorList3   = $newColors3 + $oldColors3;
			$param3['value'] = $newColorList3;
			WPBMap::mutateParam('vc_progress_bar', $param3);       //Finally "mutate" param with new values of Button
			
		};
		
		
		if( function_exists('vc_map') ){
			vc_map( array(
				"name"     => __("ThemeMount Service Box",'howes'),
				"base"     => "servicebox",
				"class"    => "",
				'category' => __( 'ThemeMount Special Elements', 'howes' ),
				"icon"     => "icon-thememount-vc",
				"params"   => array(
					array(
						"type"       => "dropdown",
						"holder"     => "div",
						"class"      => "",
						"heading"    => __("Box Style",'howes'),
						"param_name" => "boxtype",
						"value"      => array(
							__('Left Icon (Rounded icon)','howes')	=> 'lefticon',
							__('Left Icon','howes')					=> 'lefticonspacing',
							__('Center Icon','howes')				=> 'centericon',
							__('Center Icon with Border','howes')	=> 'bordercentericon',
							__('Right Icon (Rounded icon)','howes')	=> 'righticon',
							__('Right Icon','howes')					=> 'righticonspacing',
						),
						"description" => __("There are different look of Service Boxes.",'howes')
					),
					array(
						"type" => "dropdown",
						"holder" => "div",
						"class" => "",
						"heading" => __("Box Hover Effect",'howes'),
						"param_name" => "hover",
						"value" => array(
							__('None','howes')         => '',
							__('Float Shadow','howes') => 'float-shadow',
							__('Grow','howes')         => 'grow',
							__('Shrink','howes')       => 'shrink',
							__('Skew','howes')         => 'skew',
							__('Skew Forward','howes') => 'skew-forward',
							__('Rotate','howes')       => 'rotate',
							__('Grow Rotate','howes')  => 'grow-rotate',
							__('Float','howes')        => 'float',
							__('Sink','howes')         => 'sink',
						),
						"description" => __("Select hover effect.",'howes')
					),
					array(
						"param_name"  => "icon",
						"type"        => "thememount_iconselector",
						"holder"      => "div",
						"class"       => "",
						"heading"     => __("Service Box Main Icon",'howes'),
						"value"       => $allIcons,
						"default"     => 'skype',
						"description" => __("Select icon for the Service Box.",'howes')
					),
					array(
						"type"			=> "textfield",
						"holder"		=> "div",
						"class"			=> "",
						"heading"		=> __("Title",'howes'),
						"param_name"	=> "title",
						"description"	=> __("Main title.",'howes')
					),
					array(
						'type'        => 'vc_link',
						"holder"      => "div",
						'heading'     => __("Title Link",'howes'),
						'param_name'  => 'titlelink',
						"description" => __("Add URL here if you like to add link to the title. If you don't want to add link, than leave this field blank.",'howes')
					),
					array(
						"type" => "textfield",
						"holder" => "div",
						"class" => "",
						"heading" => __("Sub Title",'howes'),
						"param_name" => "subtitle",
						//"value" => '',
						"description" => __("Subtitle.",'howes')
					),
					array(
						"type" => "textarea",
						"holder" => "div",
						"class" => "",
						"heading" => __("Content",'howes'),
						"param_name" => "contents",
						"value" => "",
						"description" => __("Content in normal text.",'howes')
					),
					array(
						"type"       => "dropdown",
						"holder"     => "div",
						"class"      => "",
						"heading"    => __("Bottom Link Type",'howes'),
						"param_name" => "buttontype",
						"value" => array(
							__('No link','howes')                  => 'no',
							__('Text Link without icon','howes')   => 'text',
							__('Text Link with icon','howes')      => 'icontext',
							__('Button link without icon','howes') => 'btn',
							__('Button link with icon','howes')    => 'iconbtn'
						),
						"description" => __("Select button type.",'howes')
					),
					array(
						"type" => "textfield",
						"holder" => "div",
						"class" => "",
						"heading" => __("Button/Link Text",'howes'),
						"param_name" => "buttontext",
						//"value" => __("Default params value"),
						"description" => __("Write button text here.",'howes')
					),
					array(
						'type'			=> 'dropdown',
						'heading'		=> __( 'Button style', 'howes' ),
						'param_name'	=> 'buttonstyle',
						'value'			=> getVcShared( 'button styles' ),
						'description'	=> __( 'Select button style.', 'howes' )
					),
					array(
						"type" 				 => "dropdown",
						"holder" 			 => "div",
						"class" 			 => "",
						"heading" 			 => __("Button Color",'howes'),
						"param_name" 		 => "buttoncolor",
						"value" 			 => $newColorList,
						"description" 		 => __("Select button Color.",'howes'),
						'param_holder_class' => 'vc-colored-dropdown'
					),
					array(
						'type'			=> 'dropdown',
						"heading"		=> __("Button Size",'howes'),
						'param_name'	=> 'buttonsize',
						'value'			=> getVcShared( 'sizes' ),
						'std'			=> 'md',
						"description"	=> __("Select button size.",'howes')
					),
					array(
						"param_name"  => "buttonicon",
						"type"        => "thememount_iconselector",
						"holder"      => "div",
						"class"       => "",
						"heading"     => __("Button Icon",'howes'),
						"value"       => $allIcons,
						"default"     => 'skype',
						"description" => __("Selct icon for the Service Box.",'howes')
					),
					array(
						'type'        => 'vc_link',
						"holder"      => "div",
						'heading'     => __("Button Link",'howes'),
						'param_name'  => 'buttonlink',
						"description" => __("Button link URL.",'howes')
					),
					array(
						"type"        => "dropdown",
						"holder"      => "div",
						"class"       => "vc_sb_iconposition",
						"heading"     => __("Icon Position in Button", "howes"),
						"param_name"  => "btniconposition",
						"value" => array(
							__('Icon at left in Button','howes')  => 'left',
							__('Icon at right in Button','howes') => 'right'
						),
						"description" => __("Select position for icon in button.",'howes')
					),
					array(
						"type" => "dropdown",
						"holder" => "div",
						"class" => "",
						"heading" => __("CSS Animation", "howes"),
						"param_name" => "css_animation",
						"value" => array(__('No','howes')=>'',__('Top to bottom','howes')=>'top-to-bottom',__('Bottom to top','howes')=>'bottom-to-top',__('Left to right','howes')=>'left-to-right', __('Right to left','howes')=>'right-to-left',__('Appear from center','howes')=>'appear' ),
						"description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "howes"),
					),
				)
			) );




		/**
		 * ThemeMount: Facts in digits
		**/
		if( function_exists('vc_map') ){
			vc_map( array(
				'name'		=> __( 'ThemeMount Facts in digits', 'howes' ),
				'base'		=> 'facts_in_digits',
				'class'		=> '',
				'icon'		=> 'icon-thememount-vc',
				'category'	=> __( 'ThemeMount Special Elements', 'howes' ),
				'params'	=> array(
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __('Header (optional)', 'howes'),
						'param_name'	=> 'title',
						'value'			=> '',
						'description'	=> __('Enter text which will be used as widget title. Leave blank if no title is needed.', 'howes')
					),
					array(
						"param_name"  => "icon",
						"type"        => "thememount_iconselector",
						"holder"      => "div",
						"class"       => "",
						"heading"     => __("Service Box Main Icon",'howes'),
						"value"       => $allIcons,
						"default"     => 'skype',
						"description" => __("Selct icon for the Service Box.",'howes')
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __('Number', 'howes'),
						'param_name'	=> 'digit',
						'value'			=> '10',
						'description'	=> __('Enter roating number digit here.', 'howes')
					),
				)
			));
		}

		
		
		/**
		 * ThemeMount: Tweeter box
		 */
		vc_map( array(
				"name"        => __("ThemeMount Twitter Box",'howes'),
				"base"        => "twitterbox",
				"description" => 'Twitter BOX',
				"class"       => "",
				'category' => __( 'ThemeMount Special Elements', 'howes' ),
				"icon"        => "icon-thememount-vc",
				"params"      => array(
					array(
						"type"			=> "textfield",
						"holder"		=> "div",
						"class"			=> "",
						"heading"		=> __("(Required) Twitter Consumer Key",'howes'),
						"param_name"	=> "consumer_key",
						"description"	=> __('Twitter Consumer Key from Twitter site. Fill all the four keys to show Twitter bar in footer. You can get all the keys from <a href="https://dev.twitter.com" target="_blank">https://dev.twitter.com</a> site.','howes')
					),
					array(
						"type"			=> "textfield",
						"holder"		=> "div",
						"class"			=> "",
						"heading"		=> __("(Required) Twitter Consumer Secret",'howes'),
						"param_name"	=> "consumer_secret",
						"description"	=> __('Twitter Consumer Secret from Twitter site.','howes')
					),
					array(
						"type"			=> "textfield",
						"holder"		=> "div",
						"class"			=> "",
						"heading"		=> __("(Required) Twitter Oauth Token",'howes'),
						"param_name"	=> "oauth_token",
						"description"	=> __('Twitter Oauth Token from Twitter site.','howes')
					),
					array(
						"type"			=> "textfield",
						"holder"		=> "div",
						"class"			=> "",
						"heading"		=> __("(Required) Twitter Oauth Token Secret",'howes'),
						"param_name"	=> "oauth_token_secret",
						"description"	=> __('Twitter Oauth Token Secret from Twitter site.','howes')
					),
					array(
						"type"			=> "textfield",
						"holder"		=> "div",
						"class"			=> "",
						"heading"		=> __("Twitter Username (optional)",'howes'),
						"param_name"	=> "username",
						"description"	=> __('(optional) Twitter user name. Example <code>envato</code>. <br> Leave this blank to show tweets from your account.','howes')
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						"heading"		=> __("Show Tweets",'howes'),
						"param_name"	=> "show",
						"description"	=> __('how many Tweets you like to show.','howes'),
						'value' => array(
							__( '1', 'js_composer' ) => '1',
							__( '2', 'js_composer' ) => '2',
							__( '3', 'js_composer' ) => '3',
							__( '4', 'js_composer' ) => '4',
							__( '5', 'js_composer' ) => '5',
							__( '6', 'js_composer' ) => '6',
							__( '7', 'js_composer' ) => '7',
							__( '8', 'js_composer' ) => '8',
							__( '9', 'js_composer' ) => '9',
							__( '10', 'js_composer' ) => '10',
						),
						'std' => '3',
					),
				)
		) );

			
		/**
		 * ThemeMount Separator with Icon
		 */
		vc_map( array(
			"name"     => __("ThemeMount Separator with Icon", "howes"),
			"base"     => "thememounticonseparator",
			"icon"     => "icon-thememount-vc",
			'category' => __( 'ThemeMount Special Elements', 'howes' ),
			"params"   => array(
				array(
					"type"        => "thememount_iconselector",
					"holder"      => "div",
					"heading"     => __("Icon", "howes"),
					"param_name"  => "icon",
					"value"       => $allIcons,
					"description" => __("Select icon for separator. Only visible if sub-heading is filled.",'howes')
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Style', 'js_composer' ),
					'param_name' => 'style',
					'value' => array(
						__( 'Border', 'js_composer' ) => '',
						__( 'Double Border', 'js_composer' ) => 'double',
						__( 'Dotted', 'js_composer' ) => 'dotted',
						__( 'Dashed', 'js_composer' ) => 'dashed',
					),
					'description' => __( 'Separator style.', 'js_composer' )
				),
				array(
					'type'       => 'dropdown',
					'heading'    => __( 'Element width', 'js_composer' ),
					'param_name' => 'elewidth',
					'value'      => array(
						__( '100%', 'js_composer' ) => '',
						__( '90%', 'js_composer' ) => '90',
						__( '80%', 'js_composer' ) => '80',
						__( '70%', 'js_composer' ) => '70',
						__( '60%', 'js_composer' ) => '60',
						__( '50%', 'js_composer' ) => '50',
					),
					'description' => __( 'Separator element width in percent.', 'js_composer' )
				),
				/*array(
					'type' => 'textfield',
					'heading' => __( 'Extra class name', 'js_composer' ),
					'param_name' => 'el_class',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
				),*/
			),
			//"js_view" => 'VcCallToActionView'
		) );
		
			
			
		} // if( function_exists('vc_map') )	
	}
}
add_action('init', 'thememount_vc_extraThings');





/**
 * Service BoxIcon
 */
function thememount_vc_init_servicebox() {
	global $newColorList;
}
add_action('init', 'thememount_vc_init_servicebox');




/**
 * Visual Composer: Heading
 */
if( function_exists('vc_map') ){
	vc_map( array(
		"name"     => __("ThemeMount Heading", "howes"),
		"base"     => "heading",
		"icon"     => "icon-thememount-vc",
		'category' => __( 'ThemeMount Special Elements', 'howes' ),
		"params"   => array(
			array(
				"type"        => "textarea",
				"heading"     => __("Text for heading", "howes"),
				"description" => __("Write text for heading. Some HTML tags are allowed. <br><strong>Tip:</strong> You can add SPAN tag to add skin color to any text. Example: <code> Welcome to &lt;span&gt;OUR&lt;/span&gt; website. </code> ", "howes"),
				"param_name"  => "text",
				"value"       => __("Welcome to our site", "howes"),
			),
			array(
				"type"        => "textarea",
				"heading"     => __("Text for sub-heading", "howes"),
				"description" => __("Write text for sub-heading. Some HTML tags are allowed. <br><strong>Tip:</strong> You can add SPAN tag to add skin color to any text. Example: <code>Lorem Ipsum is simply &lt;span&gt;DUMMY&lt;/span&gt; text of the printing and typesetting industry.</code> ", "howes"),
				"param_name"  => "subtext",
			),
			array(
				"type"        => "dropdown",
				"heading"     => __("Heading Tag", "howes"),
				"description" => __("Select heading tag.", "howes"),
				"param_name"  => "tag",
				"value"       => array(
					__("H1", "howes") => "h1",
					__("H2", "howes") => "h2",
					__("H3", "howes") => "h3",
					__("H4", "howes") => "h4",
					__("H5", "howes") => "h5",
					__("H6", "howes") => "h6",
				),
			),
			/*array(
				"type"        => "thememount_iconselector",
				"holder"      => "div",
				"class"       => "vc_heading_sepicon",
				"heading"     => __("Separator Icon", "howes"),
				"param_name"  => "sepicon",
				"value"       => $allIconsWithEmpty,
				"description" => __("Select icon for separator. Only visible if sub-heading is filled.",'howes')
			),*/
			array(
				"type"        => "dropdown",
				"heading"     => __("Heading Align", "howes"),
				"description" => __("Select align for heading tag.", "howes"),
				"param_name"  => "align",
				"value"       => array(
					__("Left", "howes") => "left",
					__("Center", "howes") => "center",
					__("Right", "howes") => "right",
				),
			),
		),
		//"js_view" => 'VcCallToActionView'
	) );
}



/**
 * Team Member box
 */
function thememount_team_member_options(){

	$teamGroups           = get_terms( 'team_group', array( 'hide_empty' => false ) );
	$teamGroupList        = array();
	$teamGroupList['All'] = '';
	foreach($teamGroups as $teamGroup){
		$name                   = $teamGroup->name.' ('.$teamGroup->count.')';
		$teamGroupList[ $name ] = $teamGroup->slug;
	}
	
	if( function_exists('vc_map') ){
		vc_map( array(
			"name"     => __("ThemeMount Team Members", "howes"),
			"base"     => "team",
			"icon"     => "icon-thememount-vc",
			'category' => __( 'ThemeMount Special Elements', 'howes' ),
			"params"   => array(
				array(
					"type"        => "textarea",
					"holder"      => "div",
					"class"       => "",
					"heading"     => __("Box Title",'howes'),
					"description" => __("Write box title here.",'howes'),
					"param_name"  => "title",
					//"value"       => '',
				),
				array(
					"type"        => "textarea",
					"holder"      => "div",
					"class"       => "",
					"heading"     => __("Box Sub-title",'howes'),
					"description" => __("Write box sub-title here.",'howes'),
					"param_name"  => "subtitle",
					//"value"       => '',
				),
				array(
					"type"        => "dropdown",
					"heading"     => __("Title Align", "howes"),
					"description" => __("Select align for title and sub-title tag.", "howes"),
					"param_name"  => "align",
					"value"       => array(
						__("Left", "howes")   => "left",
						__("Center", "howes") => "center",
						__("Right", "howes")  => "right",
					),
				),
				array(
					"type"        => "dropdown",
					"heading"     => __("Team Group", "howes"),
					"param_name"  => "groupslug",
					"description" => __("Select group to show Team Members from selected group only. Select ALL to show all Team Members.", "howes"),
					"value"       => $teamGroupList,
				),
				array(
					"type"        => "dropdown",
					"heading"     => __("Show", "howes"),
					"param_name"  => "show",
					"description" => __("Total Team Members you want to show.", "howes"),
					"value"       => array(
						__("All Team Members", "howes") => "-1",
						__("1 Team Member", "howes")  => "1",
						__("2 Team Members", "howes") => "2",
						__("3 Team Members", "howes") => "3",
						__("4 Team Members", "howes") => "4",
						__("5 Team Members", "howes") => "5",
						__("6 Team Members", "howes") => "6",
						__("7 Team Members", "howes") => "7",
						__("8 Team Members", "howes") => "8",
						__("9 Team Members", "howes") => "9",
						__("10 Team Members", "howes") => "10",
					),
				),
				array(
					"type"        => "dropdown",
					"heading"     => __("Column", "howes"),
					"param_name"  => "column",
					"description" => __("Select button alignment.", "howes"),
					"value"       => array(
						__("Four Columns",  "howes") => "four",
						__("One Column",    "howes") => "one",
						__("Two Columns",   "howes") => "two",
						__("Three Columns", "howes") => "three",
					),
					"param_value" => "four",
				),
				array(
					"type"        => "dropdown",
					"holder"      => "div",
					"class"       => "",
					"heading"     => __("View",'howes'),
					"description" => __("Select the view. Show as normal row and column or show with carousel effect.",'howes'),
					"param_name"  => "view",
					"value"       => array(
						__('Row and Column (default)','howes') => 'default',
						__('Carousel effect','howes')          => 'carousel',
					)
				),
			),
			//"js_view" => 'VcCallToActionView'
		) );
	}
}
add_action( 'admin_init', 'thememount_team_member_options' );




/**
 * Testimonial box
 */
function thememount_vc_testimonials(){
	if( function_exists('vc_map') ){
	
	
	
		// Fetching all Testmonial group names
		$testimonial_groups = get_terms( 'testimonial_group', array('hide_empty'=>false) );
		$testimonialGroups = array( __("All", "howes") => "" );
		foreach( $testimonial_groups as $group ){
			$totalcount = 0;
			if( trim($group->count) > 0 ){
				$totalcount = $group->count;
			}
			$testimonialGroups[ $group->name.' ('.$totalcount.')' ] = $group->slug;
		}
	
	
		vc_map( array(
			"name"     => __("ThemeMount Testimonial Box", "howes"),
			"base"     => "testimonial",
			"icon"     => "icon-thememount-vc",
			'category' => __( 'ThemeMount Special Elements', 'howes' ),
			"params"   => array(
				array(
				  "type"        => "textfield",
				  "heading"     => __("Box Title", "howes"),
				  "param_name"  => "title",
				  "description" => __("What text use as a title. Leave blank if no title is needed.", "howes")
				),
				array(
				  "type"        => "textfield",
				  "heading"     => __("Box Sub-title", "howes"),
				  "param_name"  => "subtitle",
				  "description" => __("What text use as a sub-title. Leave blank if no sub-title is needed.", "howes")
				),
				array(
					"type"        => "dropdown",
					"heading"     => __("Title Align", "howes"),
					"description" => __("Select align for title and sub-title tag.", "howes"),
					"param_name"  => "align",
					"value"       => array(
						__("Left", "howes")   => "left",
						__("Center", "howes") => "center",
						__("Right", "howes")  => "right",
					),
				),
				/*array(
					"type"        => "thememount_iconselector",
					"holder"      => "div",
					"heading"     => __("Separator Icon", "howes"),
					"param_name"  => "sepicon",
					"value"       => $allIconsWithEmpty,
					"description" => __("Select icon for separator. Only visible if sub-heading is filled.",'howes')
				),*/
				array(
					"type"        => "dropdown",
					"heading"     => __("From Group", "howes"),
					"param_name"  => "group",
					"description" => __("Select group so it will show Testimonials from selected group only.", "howes"),
					"value"       => $testimonialGroups,
					"param_value" => "three",
				),
				array(
					"type"        => "dropdown",
					"heading"     => __("Show", "howes"),
					"param_name"  => "show",
					"description" => __("Total Team Members you want to show.", "howes"),
					"value"       => array(
						__("All Testimonials", "howes") => "-1",
						__("1 Testimonial", "howes")  => "1",
						__("2 Testimonials", "howes") => "2",
						__("3 Testimonials", "howes") => "3",
						__("4 Testimonials", "howes") => "4",
						__("5 Testimonials", "howes") => "5",
						__("6 Testimonials", "howes") => "6",
						__("7 Testimonials", "howes") => "7",
						__("8 Testimonials", "howes") => "8",
						__("9 Testimonials", "howes") => "9",
						__("10 Testimonials", "howes") => "10",
						__("11 Testimonials", "howes") => "11",
						__("12 Testimonials", "howes") => "12",
						__("13 Testimonials", "howes") => "13",
						__("14 Testimonials", "howes") => "14",
						__("15 Testimonials", "howes") => "15",
						__("16 Testimonials", "howes") => "16",
						__("17 Testimonials", "howes") => "17",
						__("18 Testimonials", "howes") => "18",
						__("19 Testimonials", "howes") => "19",
						__("20 Testimonials", "howes") => "20",
					),
				),
				array(
					"type"        => "dropdown",
					"heading"     => __("Column", "howes"),
					"param_name"  => "column",
					"description" => __("Select button alignment.", "howes"),
					"value"       => array(
						__("Three Columns", "howes") => "three",
						__("One Column",    "howes") => "one",
						__("Two Columns",   "howes") => "two",
						__("Four Columns",  "howes") => "four",
					),
					"param_value" => "three",
				),
				array(
					"type"        => "dropdown",
					"holder"      => "div",
					"class"       => "",
					"heading"     => __("Blog View",'howes'),
					"description" => __("Select blog view. Show as normal row and column or show with carousel effect.",'howes'),
					"param_name"  => "view",
					"value"       => array(
						__('Row and Column (default)','howes') => 'default',
						__('Carousel effect','howes')          => 'carousel',
					)
				),
			),
			//"js_view" => 'VcCallToActionView'
		) );
	}
}


add_action('init', 'thememount_vc_testimonials');




/**
 * Client box
 */
function thememount_vc_clients(){
	
	global $allIconsWithEmpty;
	
	if( function_exists('vc_map') ){

		// Fetching all client group names
		$client_groups = get_terms( 'client_group', array('hide_empty'=>false) );
		//var_dump($client_groups);
		$clientGroups = array( __("All", "howes") => "" );
		foreach( $client_groups as $group ){
			$clientGroups[ $group->name.' ('.$group->count.')' ] = $group->slug;
		}
		
		vc_map( array(
			"name"     => __("ThemeMount Client's Logo Box", "howes"),
			"base"     => "clients",
			"icon"     => "icon-thememount-vc",
			'category' => __( 'ThemeMount Special Elements', 'howes' ),
			"params"   => array(
				array(
				  "type"        => "textfield",
				  "heading"     => __("Box Title", "howes"),
				  "param_name"  => "title",
				  "description" => __("What text use as a title. Leave blank if no title is needed.", "howes")
				),
				array(
				  "type"        => "textfield",
				  "heading"     => __("Box Sub-title", "howes"),
				  "param_name"  => "subtitle",
				  "description" => __("What text use as a sub-title. Leave blank if no sub-title is needed.", "howes")
				),
				array(
					"type"        => "dropdown",
					"heading"     => __("Title Align", "howes"),
					"description" => __("Select align for title and sub-title tag.", "howes"),
					"param_name"  => "align",
					"value"       => array(
						__("Left", "howes")   => "left",
						__("Center", "howes") => "center",
						__("Right", "howes")  => "right",
					),
				),
				/*array(
					"type"        => "thememount_iconselector",
					"holder"      => "div",
					"class"       => "vc_heading_sepicon",
					"heading"     => __("Separator Icon", "howes"),
					"param_name"  => "sepicon",
					"value"       => $allIconsWithEmpty,
					"description" => __("Select icon for separator. Only visible if sub-heading is filled.",'howes')
				),*/
				array(
					"type"        => "dropdown",
					"heading"     => __("Show", "howes"),
					"param_name"  => "show",
					"description" => __("Total Team Members you want to show.", "howes"),
					"value"       => array(
						__("All Clients", "howes") => "-1",
						__("1 Client", "howes")  => "1",
						__("2 Clients", "howes") => "2",
						__("3 Clients", "howes") => "3",
						__("4 Clients", "howes") => "4",
						__("5 Clients", "howes") => "5",
						__("6 Clients", "howes") => "6",
						__("7 Clients", "howes") => "7",
						__("8 Clients", "howes") => "8",
						__("9 Clients", "howes") => "9",
						__("10 Clients", "howes") => "10",
						__("11 Clients", "howes") => "11",
						__("12 Clients", "howes") => "12",
						__("13 Clients", "howes") => "13",
						__("14 Clients", "howes") => "14",
						__("15 Clients", "howes") => "15",
						__("16 Clients", "howes") => "16",
						__("17 Clients", "howes") => "17",
						__("18 Clients", "howes") => "18",
						__("19 Clients", "howes") => "19",
						__("20 Clients", "howes") => "20",
					),
				),
				array(
					"type"        => "dropdown",
					"heading"     => __("Column", "howes"),
					"param_name"  => "column",
					"description" => __("Select button alignment.", "howes"),
					"value"       => array(
						__("Three Columns", "howes") => "three",
						__("One Column",    "howes") => "one",
						__("Two Columns",   "howes") => "two",
						__("Four Columns",  "howes") => "four",
					),
					"param_value" => "three",
				),
				
				array(
					"type"        => "dropdown",
					"heading"     => __("From Group", "howes"),
					"param_name"  => "group",
					"description" => __("Select group so it will show client logo from selected group only.", "howes"),
					"value"       => $clientGroups,
					"param_value" => "three",
				),
				
				array(
					"type"        => "dropdown",
					"holder"      => "div",
					"class"       => "",
					"heading"     => __("Portfolio View",'howes'),
					"description" => __("Select portfolio view. Show as normal row and column or show with carousel effect.",'howes'),
					"param_name"  => "view",
					"value"       => array(
						__('Row and Column (default)','howes') => 'default',
						__('Carousel effect','howes')          => 'carousel',
					)
				),
			),
			//"js_view" => 'VcCallToActionView'
		) );
	}
}
add_action('init', 'thememount_vc_clients');



	
	


/**
 * Portfolio Box
 */
if( function_exists('vc_map') ){
	vc_map( array(
		"name"     => __("ThemeMount Portfolio Box",'howes'),
		"base"     => "portfoliobox",
		"class"    => "",
		'category' => __( 'ThemeMount Special Elements', 'howes' ),
		"icon"     => "icon-thememount-vc",
		"params"   => array(
			/*array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Text Position",'howes'),
				"description" => __("Select where you want to show text details (Title and Sub-title text contents). Select LEFT to show at left side or select TOP CENTER to show at top as center.",'howes'),
				"param_name"  => "textposition",
				"value"       => array(
					__('Left','howes')       => 'left',
					__('Top Center','howes') => 'top',
				)
			),*/
			array(
				"type"        => "textarea",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Box Title",'howes'),
				"description" => __("Write box title here.",'howes'),
				"param_name"  => "title",
				//"value"     => __("Our Latest Projects",'howes'),
			),
			array(
				"type"        => "textarea",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Box Sub-title",'howes'),
				"description" => __("Write box sub-title here.",'howes'),
				"param_name"  => "subtitle",
				//"value"       => __("Lorem ipsum dolor sit amet, consectetur adipiscing elit.",'howes'),
			),
			array(
				"type"        => "dropdown",
				"heading"     => __("Title Align", "howes"),
				"description" => __("Select align for title and sub-title tag.", "howes"),
				"param_name"  => "align",
				"value"       => array(
					__("Left", "howes")   => "left",
					__("Center", "howes") => "center",
					__("Right", "howes")  => "right",
				),
			),
			/*array(
				"type"        => "thememount_iconselector",
				"holder"      => "div",
				"class"       => "vc_heading_sepicon",
				"heading"     => __("Separator Icon", "howes"),
				"param_name"  => "sepicon",
				"value"       => $allIconsWithEmpty,
				"description" => __("Select icon for separator. Only visible if sub-heading is filled.",'howes')
			),*/
			array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Show Sortable Category Links",'howes'),
				"description" => __("Show sortable category links above Portfolio items so user can sort by category by just single click.",'howes'),
				"param_name"  => "sortable",
				"value"       => array(
					__('No','howes')  => 'no',
					__('Yes','howes') => 'yes',
				)
			),
			array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Show Pagination",'howes'),
				"description" => __("Show pagination links below portfolio boxes.",'howes'),
				"param_name"  => "pagination",
				"value"       => array(
					__('No','howes')  => 'no',
					__('Yes','howes') => 'yes',
				)
			),
			array(
				"type"        => "textfield",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Button Text",'howes'),
				"description" => __("Write button text here.",'howes'),
				"param_name"  => "btntext",
				"value"       => ''
			),
			array(
				"type"        => "textfield",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Button Link (URL)",'howes'),
				"description" => __("Write URL for the button.",'howes'),
				"param_name"  => "btnlink",
				"value"       => ''
			),
			array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Show Portfolio Item",'howes'),
				"description" => __("How many portfolio item you want to show.",'howes'),
				"param_name"  => "show",
				"value"       => array(
					__('3','howes')=>'3',
					__('4','howes')=>'4',
					__('5','howes')=>'5',
					__('6','howes')=>'6',
					__('7','howes')=>'7',
					__('8','howes')=>'8',
					__('9','howes')=>'9',
					__('10','howes')=>'10',
					__('11','howes')=>'11',
					__('12','howes')=>'12',
					__('13','howes')=>'13',
					__('14','howes')=>'14',
					__('15','howes')=>'15',
					__('16','howes')=>'16',
					__('17','howes')=>'17',
					__('18','howes')=>'18',
					__('19','howes')=>'19',
					__('20','howes')=>'20',
					__('21','howes')=>'21',
					__('22','howes')=>'22',
					__('23','howes')=>'23',
					__('24','howes')=>'24',
				)
			),
			array(
				"type"        => "dropdown",
				"heading"     => __("Column", "howes"),
				"param_name"  => "column",
				"description" => __("Select column.", "howes"),
				"value"       => array(
					__("Three Columns", "howes") => "three",
					__("One Column",    "howes") => "one",
					__("Two Columns",   "howes") => "two",
					__("Four Columns",  "howes") => "four",
				),
			),
			array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Portfolio View",'howes'),
				"description" => __("Select portfolio view. Show as normal row and column or show with carousel effect.",'howes'),
				"param_name"  => "view",
				"value"       => array(
					__('Row and Column (default)','howes') => 'default',
					__('Carousel effect','howes')          => 'carousel',
				)
			),
			/*array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Portfolio View Area",'howes'),
				"description" => __("Select portfolio view area. Want to show in Box area or in Full-Width area.",'howes'),
				"param_name"  => "viewarea",
				"value"       => array(
					__('Boxed (default)','howes') => 'boxed',
					__('Full Width','howes')      => 'fullwidth',
				)
			),*/
		)
	) );
} // if( function_exists('vc_map') )


	





if( class_exists('TribeEvents') ){
	/**
	 * Events Calendar list in Visual Composer
	 */
	vc_map( array(
		"name"     => __("ThemeMount Events Box", "howes"),
		"base"     => "eventsbox",
		"icon"     => "icon-thememount-vc",
		'category' => __( 'ThemeMount Special Elements', 'howes' ),
		"params"   => array(
			array(
				"type"        => "textarea",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Box Title",'howes'),
				"description" => __("Write box title here.",'howes'),
				"param_name"  => "title",
				//"value"     => __("Our Latest Projects",'howes'),
			),
			array(
				"type"        => "textarea",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Box Sub-title",'howes'),
				"description" => __("Write box sub-title here.",'howes'),
				"param_name"  => "subtitle",
				//"value"       => __("Lorem ipsum dolor sit amet, consectetur adipiscing elit.",'howes'),
			),
			array(
				"type"        => "dropdown",
				"heading"     => __("Title Align", "howes"),
				"description" => __("Select align for title and sub-title tag.", "howes"),
				"param_name"  => "align",
				"value"       => array(
					__("Left", "howes")   => "left",
					__("Center", "howes") => "center",
					__("Right", "howes")  => "right",
				),
			),
			array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Show Pagination",'howes'),
				"description" => __("Show pagination links below portfolio boxes.",'howes'),
				"param_name"  => "pagination",
				"value"       => array(
					__('No','howes')  => 'no',
					__('Yes','howes') => 'yes',
				)
			),
			array(
				"type"        => "textfield",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Button Text",'howes'),
				"description" => __("Write button text here.",'howes'),
				"param_name"  => "btntext",
				"value"       => ''
			),
			array(
				"type"        => "textfield",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Button Link (URL)",'howes'),
				"description" => __("Write URL for the button.",'howes'),
				"param_name"  => "btnlink",
				"value"       => ''
			),
			array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Show Events Item",'howes'),
				"description" => __("How many events you want to show.",'howes'),
				"param_name"  => "show",
				"value"       => array(
					__('3','howes')=>'3',
					__('4','howes')=>'4',
					__('5','howes')=>'5',
					__('6','howes')=>'6',
					__('7','howes')=>'7',
					__('8','howes')=>'8',
					__('9','howes')=>'9',
					__('10','howes')=>'10',
					__('11','howes')=>'11',
					__('12','howes')=>'12',
					__('13','howes')=>'13',
					__('14','howes')=>'14',
					__('15','howes')=>'15',
					__('16','howes')=>'16',
					__('17','howes')=>'17',
					__('18','howes')=>'18',
					__('19','howes')=>'19',
					__('20','howes')=>'20',
					__('21','howes')=>'21',
					__('22','howes')=>'22',
					__('23','howes')=>'23',
					__('24','howes')=>'24',
				)
			),
			array(
				"type"        => "dropdown",
				"heading"     => __("Column", "howes"),
				"param_name"  => "column",
				"description" => __("Select column.", "howes"),
				"value"       => array(
					__("Three Columns", "howes") => "three",
					__("One Column",    "howes") => "one",
					__("Two Columns",   "howes") => "two",
					__("Four Columns",  "howes") => "four",
				),
			),
			array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Events View",'howes'),
				"description" => __("Select events view. Show as normal row and column or show with carousel effect.",'howes'),
				"param_name"  => "view",
				"value"       => array(
					__('Row and Column (default)','howes') => 'default',
					__('Carousel effect','howes')          => 'carousel',
				)
			),
		),
		//"js_view" => 'VcCallToActionView'
	) );
}

	
	
	
	
	
	
/**
 * ThemeMount Contact Details Box
 */
if( function_exists('vc_map') ){
	vc_map( array(
		"name"     => __("ThemeMount Contact Details Box",'howes'),
		"base"     => "contactbox",
		"class"    => "",
		'category' => __( 'ThemeMount Special Elements', 'howes' ),
		"icon"     => "icon-thememount-vc",
		"params" => array(
			/*array(
				"type"        => "textfield",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Box Title",'howes'),
				"description" => __("Write box title here.",'howes'),
				"param_name"  => "title",
				"value"       => __("Get in touch",'howes'),
			),*/
			array(
				"type"        => "textfield",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Phone",'howes'),
				"description" => __("Write phone number here. Example: <code>(+01) 123 456 7890</code>",'howes'),
				"param_name"  => "phone",
			),
			array(
				"type"        => "textfield",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Email",'howes'),
				"description" => __("Write email here. Example: <code>info@example.com</code>",'howes'),
				"param_name"  => "email",
			),
			array(
				"type"        => "textfield",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Website",'howes'),
				"description" => __("Write website URL here. Example: <code>www.example.com</code>",'howes'),
				"param_name"  => "website",
			),
			array(
				"type"        => "textarea",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Address",'howes'),
				"description" => __("Write address here. <br> Example: <code>Honey Business <br> 24 Fifth st., Los Angeles, <br> USA</code>",'howes'),
				"param_name"  => "address",
			),
			array(
				"type"        => "textarea",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Time",'howes'),
				"description" => __("Write time here. <br> Example: <code>Mon to Sat - 9:00am to 6:00pm<br>(Sunday Closed)</code>",'howes'),
				"param_name"  => "time",
			),
		)
	) );
}









/**
 * ThemeMount Blog Box
 */	
if( function_exists('vc_map') ){

	$postCatList = get_categories();
	//var_dump($postCatList);
	$catList = array();
	$catList[ __('All', 'howes') ] = '';
	foreach($postCatList as $cat){
		$catList[ __($cat->name, 'howes') . ' (' . $cat->count . ')' ] = $cat->slug;
	}
	//var_dump($catList);

	vc_map( array(
		"name"     => __("ThemeMount Blog Box",'howes'),
		"base"     => "blogbox",
		"class"    => "",
		'category' => __( 'ThemeMount Special Elements', 'howes' ),
		"icon"     => "icon-thememount-vc",
		"params"   => array(
			/*array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Text Position",'howes'),
				"description" => __("Select where you want to show text details (Title and Sub-title text contents). Select LEFT to show at left side or select TOP CENTER to show at top as center.",'howes'),
				"param_name"  => "textposition",
				"value"       => array(
					__('Left','howes')       => 'left',
					__('Top Center','howes') => 'top',
				)
			),*/
			array(
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => __("Box Title",'howes'),
				"description" => __("Write box title here.",'howes'),
				"param_name" => "title",
				//"value" => __("Our Latest Blog",'howes'),
			),
			array(
				"type"        => "textarea",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Box Sub-title",'howes'),
				"description" => __("Write box sub-title here.",'howes'),
				"param_name"  => "subtitle",
				//"value"       => __("Lorem ipsum dolor sit amet, consectetur adipiscing elit.",'howes'),
			),
			array(
				"type"        => "dropdown",
				"heading"     => __("Title Align", "howes"),
				"description" => __("Select align for title and sub-title tag.", "howes"),
				"param_name"  => "align",
				"value"       => array(
					__("Left", "howes")   => "left",
					__("Center", "howes") => "center",
					__("Right", "howes")  => "right",
				),
			),
			/*array(
				"type"        => "thememount_iconselector",
				"holder"      => "div",
				"class"       => "vc_heading_sepicon",
				"heading"     => __("Separator Icon", "howes"),
				"param_name"  => "sepicon",
				"value"       => $allIconsWithEmpty,
				"description" => __("Select icon for separator. Only visible if sub-heading is filled.",'howes')
			),*/
			array(
				"type"        => "textfield",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Button Text",'howes'),
				"description" => __("Write button text here.",'howes'),
				"param_name"  => "btntext",
				"value"       => ''
			),
			array(
				"type"        => "textfield",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Button Link (URL)",'howes'),
				"description" => __("Write URL for the button.",'howes'),
				"param_name"  => "btnlink",
				"value"       => ''
			),
			array(
				"type"        => "dropdown",
				"heading"     => __("From Category", "howes"),
				"description" => __("If you like to show posts from selected category than select the category here.", "howes") . __("The brecket number shows how many posts there in the category.", "howes"),
				"param_name"  => "category",
				"value"       => $catList,
			),
			array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Show Posts",'howes'),
				"description" => __("How many post you want to show.",'howes'),
				"param_name"  => "show",
				"value"       => array(
					__('1','howes')=>'1',
					__('2','howes')=>'2',
					__('3','howes')=>'3',
					__('4','howes')=>'4',
					__('5','howes')=>'5',
					__('6','howes')=>'6',
					__('7','howes')=>'7',
					__('8','howes')=>'8',
					__('9','howes')=>'9',
					__('10','howes')=>'10',
					__('11','howes')=>'11',
					__('12','howes')=>'12',
					__('13','howes')=>'13',
					__('14','howes')=>'14',
					__('15','howes')=>'15',
					__('16','howes')=>'16',
					__('17','howes')=>'17',
					__('18','howes')=>'18',
					__('19','howes')=>'19',
					__('20','howes')=>'20',
					__('21','howes')=>'21',
					__('22','howes')=>'22',
					__('23','howes')=>'23',
					__('24','howes')=>'24',
				)
			),
			array(
				"type"        => "dropdown",
				"heading"     => __("Column", "howes"),
				"param_name"  => "column",
				"description" => __("Select column.", "howes"),
				"value"       => array(
					__("Three Columns", "howes") => "three",
					__("One Column",    "howes") => "one",
					__("Two Columns",   "howes") => "two",
					__("Four Columns",  "howes") => "four",
				),
			),
			array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Blog View",'howes'),
				"description" => __("Select blog view. Show as normal row and column or show with carousel effect.",'howes'),
				"param_name"  => "view",
				"value"       => array(
					__('Row and Column (default)','howes') => 'default',
					__('Carousel effect','howes')          => 'carousel',
				)
			),
		)
	) );
}






/**
 * Adding extra parameters in VC
 */	
if( function_exists('vc_add_param') ){
	
	vc_add_param( 'vc_row', array(
		'type'        => 'textfield',
		'heading'     => __('ID (For Anchor link)', 'howes'),
		'param_name'  => 'anchor',
		"description" => __("Anchor for one-page site navigation link. Technically, this will add <code>id</code> tag to the row <code>div</code>. Example, <code>&lt;div id=&quot;foo&quot;&gt;</code>",'howes')
	));
	
	vc_add_param( 'vc_row', array(
		'type'	      => 'checkbox',
		'class'       => '',
		'heading'     => __('Full Width ROW', 'howes'),
		"description" => __("Set full width (100%) of the ROW instead of the boxed ROW.", "howes"),
		'param_name'  => 'fullwidth',
		'value'       => array(
				'' => 'true'
		)
	));
	
	vc_add_param( 'vc_row', array(
		"type"        => "dropdown",
		"heading"     => __("Text Color", "howes"),
		"description" => __("Select text color.", "howes"),
		"param_name"  => "textcolor",
		"value"       => array(
			__("Use color set in \"Font Color\" option (default)", "howes") => "default",
			__("Dark Color", "howes") => "dark",
			__("White Color", "howes") => "white",
			__("Skin Color", "howes") => "skin",
		),
	));

	vc_add_param( 'vc_row', array(
		"type"        => "dropdown",
		"heading"     => __("Background Color", "howes"),
		"description" => __("Select Background Color. If you select color and also select background Video or background Image than the color will be overlay with some opacity.", "howes"),
		"param_name"  => "bgtype",
		"value"       => array(
			__("Background Color & Image set in \"Design Options\" tab (default)", "howes") => "default",
			__("Skin Color as Background Color", "howes") => "skin",
			__("Grey Color as Background Color", "howes") => "grey",
			__("Dark Color as Background Color", "howes") => "dark",
			//__("Background Video (set video path below) with Skin color overlay", "howes") => "videoskin",
			//__("Background Video (set video path below) with Dark color overlay", "howes") => "videogrey",
		),
	));
	
	vc_add_param( 'vc_row', array(
		'type'	      => 'checkbox',
		'class'       => '',
		'heading'     => __('Enable parallax', 'howes'),
		"description" => __("The background-image is fixed with regard to the ROW. Technically, it will add <code>background-attachment:fixed</code> to the ROW", "howes"),
		'param_name'  => 'parallax',
		'value'       => array(
				'' => 'true'
		)
	));
	
	/*vc_add_param( 'vc_row', array(
		"type"        => "dropdown",
		"heading"     => __("Predefined Background Color", "howes"),
		"description" => __("Select predefined background color.", "howes"),
		"param_name"  => "bgprecolor",
		"value"       => array(
			__("Skin Color as Background Color", "howes") => "skin",
			__("Grey Color as Background Color", "howes") => "grey",
			__("Dark Color as Background Color", "howes") => "dark",
		),
	));*/
	
	/*vc_add_param( 'vc_row', array(
		'type'	      => 'checkbox',
		'class'       => '',
		'heading'     => __('Predefined Background Color Overlay (only for image and video background type)', 'howes'),
		"description" => __("This will set transparent color layer on video or image background.", "howes"),
		'param_name'  => 'coloroverlay',
		'value'       => array(
				'' => 'true'
		)
	));*/
	
	// video background
	vc_add_param('vc_row', array(
		'type'        => 'textfield',
		'class'       => '',
		'heading'     => __('Video background (mp4)', 'howes'),
		'param_name'  => 'bg_video_src_mp4',
		'value'       => '',
		"description" => __("Fill URL of MP4 video that you want to show as background. This will use HTML5 VIDEO tag.",'howes')
	));

	vc_add_param('vc_row', array(
		'type'        => 'textfield',
		'class'       => '',
		'heading'     => __('Video background (ogg or ogv)', 'howes'),
		'param_name'  => 'bg_video_src_ogg',
		'value'       => '',
		"description" => __("Fill URL of OGG or OGV video that you want to show as background. This will use HTML5 VIDEO tag.",'howes')
	));

	vc_add_param('vc_row', array(
		'type'        => 'textfield',
		'class'       => '',
		'heading'     => __('Video background (webm)', 'howes'),
		'param_name'  => 'bg_video_src_webm',
		'value'       => '',
		"description" => __("Fill URL of WEBM video that you want to show as background. This will use HTML5 VIDEO tag.",'howes')
	));
	
	global $thememount_iconsArray;
	foreach($thememount_iconsArray as $icon ){
		$allIcons[ucwords(str_replace('-',' ',$icon))] = $icon;
	}
	
	
	vc_add_param( 'vc_button2', array(
		"type"        => "dropdown",
		"heading"     => __("Button Icon Position", "howes"),
		"description" => __("Select icon position in button.", "howes"),
		"param_name"  => "btniconposition",
		"value"       => array(
			__("No icon", "howes") => "no",
			__("Left icon", "howes") => "left",
			__("Right icon", "howes") => "right",
		),
	));
	
	vc_add_param( 'vc_button2', array(
		"type"        => "thememount_iconselector",
		"heading"     => __("Button Icon", "howes"),
		"description" => __("Select button icon.", "howes"),
		"param_name"  => "btnicon",
		"value"       => $allIcons,
	));
	
	vc_add_param( 'vc_cta_button2', array(
		"type"        => "dropdown",
		"heading"     => __("Button Icon Position", "howes"),
		"description" => __("Select icon position in button.", "howes"),
		"param_name"  => "btniconposition",
		"value"       => array(
			__("No icon", "howes") => "no",
			__("Left icon", "howes") => "left",
			__("Right icon", "howes") => "right",
		),
	));
	
	vc_add_param( 'vc_cta_button2', array(
		"type"        => "thememount_iconselector",
		"heading"     => __("Button Icon", "howes"),
		"description" => __("Select button icon.", "howes"),
		"param_name"  => "btnicon",
		"value"       => $allIcons,
	));
	
	
	vc_add_param( 'vc_cta_button2', array(
		"type"        => "dropdown",
		"heading"     => __("Big Font Style", "howes"),
		"description" => __("Select YES to use big size font for this CTA2.", "howes"),
		"param_name"  => "bigfont",
		"value"       => array(
			__("No", "howes") => "",
			__("Yes", "howes") => "yes",
		),
	));
	
	vc_add_param( 'vc_cta_button2', array(
		"type"        => "dropdown",
		"heading"     => __("Add separator below \"Heading first line\" title", "howes"),
		"description" => __("Select YES to show a small separator line below \"Heading first line\" title.", "howes"),
		"param_name"  => "sepline",
		"value"       => array(
			__("No", "howes")  => "",
			__("Yes", "howes") => "yes",
		),
	));
	
}




/************************** Custom Template *****************************/
add_filter( 'vc_load_default_templates', 'my_custom_template_for_vc' );
function my_custom_template_for_vc($maindata) {
	
	$maindata = array();
	
	/* ***************** */
	
	
	// Sample Homepage 1
    $data               = array();
    $data['name']       = __( 'Main Homepage', 'howes' );
    $data['image_path'] = get_template_directory_uri() . '/inc/images/sample-page.png' ; // always use preg replace to be sure that "space" will not break logic
    $data['custom_class'] = 'howes_home_template';
    $data['content']    = <<<CONTENTTTTTTTTTTT
        [vc_row css=".vc_custom_1414998073536{margin-bottom: 0px !important;padding-top: 35px !important;padding-right: 0px !important;padding-bottom: 15px !important;padding-left: 0px !important;}" textcolor="default" bgtype="skin" bgprecolor="skin"][vc_column width="1/1"][vc_cta_button2 h2="WELCOME TO HOWES !" style="rounded" txt_align="center" title="Text on the button" btn_style="rounded" color="skincolor" size="md" position="right" btniconposition="no" btnicon="fa-adjust"][/vc_column][/vc_row][vc_row bgcolor="white" paddingtop="40px" contentalign="center" rowwidth="default" textcolor="default" bgimageposition="fixed" bgtype="dark" bgprecolor="skin" css=".vc_custom_1415006285661{padding-bottom: 50px !important;background-image: url(http://howes-data.thememount.com/wp-content/uploads/2014/07/parallax4.jpg?id=1443) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" parallax="true"][vc_column width="1/3"][servicebox boxtype="centericon" icon="fa-sign-in" buttontype="text" title="UNIQUE DESIGN" css_animation="appear" btn_effect="colortoborder" buttontext="More..." contents="Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa qua. " buttoncolor="white" buttonsize="md" buttonicon="fa-angle-double-right" buttoneffect="colortoborder" btniconposition="right" buttonlink="url:%23||" buttonstyle="square" subtitle="Sed ut perspiciatis unde"]Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.[/servicebox][/vc_column][vc_column width="1/3"][servicebox boxtype="centericon" icon="fa-tablet" buttontype="text" title="100% RESPONSIVE" css_animation="appear" btn_effect="colortoborder" buttontext="More..." contents="Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa qua. " buttoncolor="white" buttonsize="md" buttonicon="fa-angle-double-right" buttoneffect="colortoborder" btniconposition="right" buttonlink="url:%23||" buttonstyle="square" subtitle="Omnis iste natus error"]Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.[/servicebox][/vc_column][vc_column width="1/3"][servicebox boxtype="centericon" icon="fa-send-o" buttontype="text" title="FREE SUPPORT" css_animation="appear" btn_effect="colortoborder" buttontext="More..." contents="Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa qua. " buttoncolor="white" buttonsize="md" buttonicon="fa-angle-double-right" buttoneffect="colortoborder" btniconposition="right" buttonlink="url:%23||" buttonstyle="square" subtitle="Totam rem aperiam"]Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.[/servicebox][/vc_column][/vc_row][vc_row bgcolor="white" contentalign="default" rowwidth="default" textcolor="default" bgimageposition="fixed" bgtype="default" bgprecolor="skin" fullwidth="true" css=".vc_custom_1414564902018{padding-bottom: 0px !important;}"][vc_column width="1/1"][portfoliobox sortable="no" show="8" column="four" view="default" viewarea="boxed" title="OUR RECENT PROJECTS" align="center" pagination="no" subtitle="Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."][/vc_column][/vc_row][vc_row bgcolor="dark" bgimage="http://addyson-data.thememount.com/wp-content/uploads/2013/12/parralaxbg.jpg" contentalign="default" rowwidth="wide" textcolor="default" bgimageposition="fixed" css=".vc_custom_1416299586979{padding-bottom: 45px !important;background-image: url(http://howes-data.thememount.com/wp-content/uploads/2014/07/bg10.jpg?id=1473) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" bgtype="grey" bgprecolor="dark" coloroverlay="true" parallax="true"][vc_column width="1/1"][heading text="ABOUT THE HOWES" tag="h2" align="center" subtext="There is no one who loves pain itself There are many variations Ipsum available"][vc_row_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticon" icon="fa-bolt" contents="There are many variations of passages of Lorem Ipsum available" buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="CLEAN MODERN CODE"][servicebox boxtype="lefticon" icon="fa-bullhorn" contents="There are many variations of passages of Lorem Ipsum available" buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="RESPONSIVE &amp; RETINA"][servicebox boxtype="lefticon" icon="fa-mobile-phone" contents="There are many variations of passages of Lorem Ipsum available" buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="TRULY MULTI-PURPOSE"][servicebox boxtype="lefticon" icon="fa-eye" contents="There are many variations of passages of Lorem Ipsum available" buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="RETINA READY"][/vc_column_inner][vc_column_inner width="1/3"][vc_single_image image="1237" css_animation="top-to-bottom" alignment="center" border_color="grey" img_link_target="_self" img_size="full"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="righticon" icon="fa-code" contents="There are many variations of passages of Lorem Ipsum available" buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="HTML5 VIDEO"][servicebox boxtype="righticon" icon="fa-external-link" contents="There are many variations of passages of Lorem Ipsum available" buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="PARALLAX SUPPORT"][servicebox boxtype="righticon" icon="fa-cloud-upload" contents="There are many variations of passages of Lorem Ipsum available" buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="ENDLESS POSSIBILITIES"][servicebox boxtype="righticon" icon="fa-minus-square-o" contents="There are many variations of passages of Lorem Ipsum available" buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="BOXED &amp; WIDE LAYOUTS"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row textcolor="default" bgtype="dark" bgprecolor="grey" css=".vc_custom_1416299419815{background-image: url(http://howes-data.thememount.com/wp-content/uploads/2014/07/parallax4.jpg?id=1443) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" parallax="true"][vc_column width="1/4"][facts_in_digits title="PROJECTS" icon="fa-gear" digit="3000"][/vc_column][vc_column width="1/4"][facts_in_digits title="CLIENTS" icon="fa-suitcase" digit="145"][/vc_column][vc_column width="1/4"][facts_in_digits title="AWARDS" icon="fa-bullhorn" digit="124"][/vc_column][vc_column width="1/4"][facts_in_digits title="FACEBOOK LIKE" icon="fa-thumbs-o-up" digit="1257"][/vc_column][/vc_row][vc_row textcolor="default" bgtype="default" bgprecolor="skin"][vc_column width="1/1"][blogbox show="6" column="three" view="carousel" title="LATEST NEWS" subtitle="Lorem Ipsum is simply dummy text of the printing and typesetting industry" align="center"][/vc_column][/vc_row][vc_row textcolor="default" bgtype="skin" css=".vc_custom_1416299628221{padding-top: 70px !important;padding-bottom: 70px !important;background-image: url(http://howes-data.thememount.com/wp-content/uploads/2014/07/parallax4.jpg?id=1443) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" parallax="true"][vc_column width="1/1"][twitterbox show="3" consumer_key="v6t8tY3ZCKyZnZ5J1vBDA" consumer_secret="73K8GXdgriSFlff01t68e608y1sy5gvvuBgmCXlGEQg" oauth_token="198949585-yOkBOaBtYfsBLIgGlgUXRNwkIIWOSCnk3SMOjzKx" oauth_token_secret="wcTRHKILxqcsu0Lka3Vh2J0DGr7oR6pBMLdLtnwo5E" username="envato"][/vc_column][/vc_row][vc_row bgcolor="white" contentalign="default" textcolor="default" bgimageposition="fixed" bgtype="grey" bgprecolor="grey" css=".vc_custom_1414845757016{padding-bottom: 60px !important;}"][vc_column width="1/1"][team show="4" column="four" style="default" title="OUR TEAM" view="default" align="center" subtitle="Neque porro quisquam est qui dolorem ipsum quia dolor sit amet"][/vc_column][/vc_row][vc_row bgcolor="white" contentalign="default" textcolor="default" bgimageposition="fixed" bgtype="default" bgprecolor="grey" css=".vc_custom_1415164047402{background-image: url(http://howes-data.thememount.com/wp-content/uploads/2014/07/bg10.jpg?id=1473) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" parallax="true"][vc_column width="1/1"][testimonial align="center" show="5" column="three" view="carousel" title=" OUR CLIENTS LOVE US" subtitle="Lorem ipsum dolor sit amet, consectetur adipiscing elit. In accumsan porttitor egestas."][vc_empty_space height="60px"][thememounticonseparator icon="fa-heart"][vc_empty_space height="45px"][clients align="center" show="4" column="four" view="default"][/vc_column][/vc_row][vc_row bgcolor="white" contentalign="default" textcolor="default" bgimageposition="fixed" bgtype="skin" bgprecolor="grey" css=".vc_custom_1414572360261{padding-top: 50px !important;padding-bottom: 50px !important;}"][vc_column width="1/1"][vc_cta_button2 h2="CREATE A PERFECT WEBSITE FOR MULTIPURPOSE" style="square" txt_align="center" title="GET IT NOW" btn_style="square" color="white" size="md" position="bottom" btniconposition="right" btnicon="fa-angle-right" link="url:%23||"][/vc_column][/vc_row]
CONTENTTTTTTTTTTT;
	$maindata[] = $data;
	
	
	
	
	
	// Sample Homepage 1
    $data               = array();
    $data['name']       = __( 'Corporate', 'howes' );
    $data['image_path'] = get_template_directory_uri() . '/inc/images/sample-page1.png' ; // always use preg replace to be sure that "space" will not break logic
    $data['custom_class'] = 'howes_home_1_template';
    $data['content']    = <<<CONTENTTTTTTTTTTT
        [vc_row][vc_column width="1/1"][vc_row_inner][vc_column_inner width="1/1"][heading text="WE ARE AMAZING" tag="h2" align="center" subtext="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/3"][vc_single_image image="1208" css_animation="top-to-bottom" border_color="grey" img_link_target="_self" img_size="370x300"][vc_column_text]
<h4>OUR VISION</h4>
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][vc_single_image image="1208" css_animation="top-to-bottom" border_color="grey" img_link_target="_self" img_size="370x300"][vc_column_text]
<h4>OUR VALUES</h4>
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.[/vc_column_text][/vc_column_inner][vc_column_inner width="1/3"][vc_single_image image="1208" css_animation="top-to-bottom" border_color="grey" img_link_target="_self" img_size="370x300"][vc_column_text]
<h4>OUR PHILOSOPHY</h4>
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.[/vc_column_text][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row textcolor="default" bgtype="grey" css=".vc_custom_1414824210130{padding-bottom: 35px !important;}"][vc_column width="1/1"][heading text="OUR SERVICES" tag="h2" align="center" subtext="Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."][vc_row_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-tablet" contents="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et magna aliqua." buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="FULLY RESPONSIVE"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-compass" contents="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et magna aliqua." buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="UNIQUE DESIGN"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-crosshairs" contents="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et magna aliqua." buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="GREAT SUPPORT"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-thumbs-o-up" contents="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et magna aliqua." buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="HTML5 &amp; CSS3"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-location-arrow" contents="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et magna aliqua." buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="ENDLESS POSIBILITES"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-cog" contents="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et magna aliqua." buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="WEB DEVELOPMENT"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row textcolor="default" bgtype="default"][vc_column width="1/1"][portfoliobox align="center" sortable="yes" pagination="no" btntext="VIEW MORE WORKS" show="6" column="three" view="default" title="LATEST PROJECTS" subtitle="There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain" btnlink="#"][/vc_column][/vc_row][vc_row textcolor="default" bgtype="grey" css=".vc_custom_1416299805050{padding-top: 50px !important;padding-bottom: 50px !important;background-image: url(http://howes-data.thememount.com/wp-content/uploads/2014/07/bg10.jpg?id=1473) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" parallax="true"][vc_column width="1/1"][twitterbox show="3" consumer_key="v6t8tY3ZCKyZnZ5J1vBDA" consumer_secret="73K8GXdgriSFlff01t68e608y1sy5gvvuBgmCXlGEQg" oauth_token="198949585-yOkBOaBtYfsBLIgGlgUXRNwkIIWOSCnk3SMOjzKx" oauth_token_secret="wcTRHKILxqcsu0Lka3Vh2J0DGr7oR6pBMLdLtnwo5E" username="mojomarketplace"][/vc_column][/vc_row][vc_row textcolor="default" bgtype="default" css=".vc_custom_1414823478018{background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column width="1/1"][clients align="center" show="6" column="four" view="carousel" title="OUR CLIIENT" subtitle=" It is a long established fact that a reader will be distracted by the readable"][/vc_column][/vc_row]
CONTENTTTTTTTTTTT;
	$maindata[] = $data;
	
	
	// Sample Homepage 2
    $data               = array();
    $data['name']       = __( 'Creative', 'howes' );
    $data['image_path'] = get_template_directory_uri() . '/inc/images/sample-page2.png' ; // always use preg replace to be sure that "space" will not break logic
    $data['custom_class'] = 'howes_home_2_template';
    $data['content']    = <<<CONTENTTTTTTTTTTT
        [vc_row textcolor="default" bgtype="grey" css=".vc_custom_1414826353647{padding-top: 60px !important;padding-bottom: 50px !important;}"][vc_column width="1/3"][servicebox boxtype="bordercentericon" icon="fa-send-o" buttontype="btn" buttonstyle="square" buttoncolor="black" buttonsize="sm" buttonicon="fa-adjust" btniconposition="left" title="FULLY RESPONSIVE" contents="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore Lorem ipsum dolor sit amet, consectetur." subtitle="Neque porro quisquam est" buttontext="VIEW MORE" buttonlink="url:%23||"][/vc_column][vc_column width="1/3"][servicebox boxtype="bordercentericon" icon="fa-gear" buttontype="btn" buttonstyle="square" buttoncolor="black" buttonsize="sm" buttonicon="fa-adjust" btniconposition="left" title="EASY TO CUSTOMIZE" contents="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore Lorem ipsum dolor sit amet, consectetur." subtitle="Consectetur adipisci velit" buttontext="VIEW MORE" buttonlink="url:%23||"][/vc_column][vc_column width="1/3"][servicebox boxtype="bordercentericon" icon="fa-life-ring" buttontype="btn" buttonstyle="square" buttoncolor="black" buttonsize="sm" buttonicon="fa-adjust" btniconposition="left" title="24/7 SUPPORT" contents="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore Lorem ipsum dolor sit amet, consectetur." subtitle="Dolorem ipsum quia" buttontext="VIEW MORE" buttonlink="url:%23||"][/vc_column][/vc_row][vc_row][vc_column width="1/1"][portfoliobox align="center" sortable="no" pagination="no" btntext="MORE WORKS" btnlink="#" show="5" column="three" view="carousel" title="Latest Projects" subtitle="Neque porro quisquam est qui dolorem ipsum quia."][/vc_column][/vc_row][vc_row css=".vc_custom_1416299959768{padding-bottom: 0px !important;background-image: url(http://howes-data.thememount.com/wp-content/uploads/2014/07/parallax4.jpg?id=1443) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" textcolor="white" bgtype="dark" parallax="true"][vc_column width="1/1"][heading text="AWESOME PARALLAX SECTION" tag="h2" align="center" subtext="Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum has been."][vc_single_image image="1546" css_animation="bottom-to-top" border_color="grey" img_link_target="_self" img_size="full"][/vc_column][/vc_row][vc_row textcolor="default" bgtype="default" css=".vc_custom_1414828319936{padding-bottom: 35px !important;}"][vc_column width="1/1"][heading text="CORE FEATURES" tag="h2" align="center" subtext="Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit."][vc_row_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-thumbs-o-up" contents="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et magna aliqua." buttontype="text" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="HTML5 &amp; CSS3" buttontext="Read More..." buttonlink="url:%23||"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-location-arrow" contents="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et magna aliqua." buttontype="text" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="ENDLESS POSIBILITES" buttontext="Read More..." buttonlink="url:%23||"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-cog" contents="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et magna aliqua." buttontype="text" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="WEB DEVELOPMENT" buttontext="Read More..." buttonlink="url:%23||"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-star" contents="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et magna aliqua." buttontype="text" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="EASY &amp; FLEXIBLE" buttontext="Read More..." buttonlink="url:%23||"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-hand-o-up" contents="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et magna aliqua." buttontype="text" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="ONE CLICK DEMO CONTENT" buttontext="Read More..." buttonlink="url:%23||"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-cube" contents="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et magna aliqua." buttontype="text" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="CUSTOM BACKGROUNDS" buttontext="Read More..." buttonlink="url:%23||"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row textcolor="default" bgtype="grey"][vc_column width="1/1"][team align="center" show="5" column="four" view="carousel" title="HOWES TEAM" subtitle="There is no one who loves pain itself, who seeks after."][/vc_column][/vc_row][vc_row textcolor="default" bgtype="default"][vc_column width="1/1"][testimonial align="center" show="5" column="three" view="carousel" title="CLIENTS TESTIMONIAL" subtitle="There are many variations of passages of Lorem Ipsum available"][/vc_column][/vc_row][vc_row textcolor="default" bgtype="skin" css=".vc_custom_1414829356703{padding-top: 40px !important;padding-bottom: 40px !important;}"][vc_column width="1/1"][vc_cta_button2 h2="ARE YOU READY FOR AWESOMENESS? THIS IS CALL TO ACTION" style="square" txt_align="left" title="CLICK HERE" btn_style="square" color="white" size="md" position="right" btniconposition="no" btnicon="fa-adjust" link="url:%23||"]Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...[/vc_cta_button2][/vc_column][/vc_row]
CONTENTTTTTTTTTTT;
	$maindata[] = $data;
	
	
	
	// Sample Homepage 3
    $data               = array();
    $data['name']       = __( 'Agency', 'howes' );
    $data['image_path'] = get_template_directory_uri() . '/inc/images/sample-page3.png' ; // always use preg replace to be sure that "space" will not break logic
    $data['custom_class'] = 'howes_home_3_template';
    $data['content']    = <<<CONTENTTTTTTTTTTT
        [vc_row css=".vc_custom_1414831596704{padding-bottom: 40px !important;}" textcolor="default" bgtype="default"][vc_column width="1/1"][heading text="HELLO, WELCOME TO HOWES" tag="h2" align="center" subtext="There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing of text. "][/vc_column][/vc_row][vc_row textcolor="default" bgtype="grey" css=".vc_custom_1414832497042{padding-bottom: 55px !important;}"][vc_column width="1/3"][servicebox boxtype="centericon" icon="fa-cloud-upload" contents="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the dummy text ever since." buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="EASY TO CUSTOMIZE"][/vc_column][vc_column width="1/3"][servicebox boxtype="centericon" icon="fa-code" contents="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the dummy text ever since." buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="FONT AWESOME ICON"][/vc_column][vc_column width="1/3"][servicebox boxtype="centericon" icon="fa-gear" contents="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the dummy text ever since." buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="SEO FRIENDLY"][/vc_column][/vc_row][vc_row textcolor="default" bgtype="dark" css=".vc_custom_1416300146289{padding-top: 100px !important;padding-bottom: 100px !important;background-image: url(http://howes-data.thememount.com/wp-content/uploads/2014/07/parallax4.jpg?id=1443) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" parallax="true"][vc_column width="1/1"][vc_cta_button2 h2="HOWES IS THE BEST QUALITY PRODUCT ON MOJO" h4="Have you fallen in love yet?" style="rounded" txt_align="center" title="GET IT NOW" btn_style="square" color="skincolor" size="lg" position="bottom" btniconposition="no" btnicon="fa-adjust" link="url:%23||"]Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's ever since.[/vc_cta_button2][/vc_column][/vc_row][vc_row textcolor="default" bgtype="grey"][vc_column width="2/3"][blogbox align="left" show="2" column="two" view="default" title="LATEST NEWS"][/vc_column][vc_column width="1/3"][vc_accordion title="OUR SERVICES"][vc_accordion_tab title="Responsive Ready"][vc_column_text]Lorem ipsum <strong>dolor sit amet</strong>, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore consectetur adipisicing elit, sed<strong> do eiusmod tempor incididun</strong>t ut. interdum dapibus. Curabitur euismod sem vel velit blan Aenean molestie faucibus fringilla.[/vc_column_text][/vc_accordion_tab][vc_accordion_tab title="Web Development"][vc_column_text]Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.[/vc_column_text][/vc_accordion_tab][vc_accordion_tab title="Motion Design"][vc_column_text]Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.[/vc_column_text][/vc_accordion_tab][vc_accordion_tab title="Font Awesome Icons"][vc_column_text]Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.[/vc_column_text][/vc_accordion_tab][vc_accordion_tab title="Logo Design"][vc_column_text]Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.[/vc_column_text][/vc_accordion_tab][vc_accordion_tab title="Marketing Strategies"][vc_column_text]Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.[/vc_column_text][/vc_accordion_tab][/vc_accordion][/vc_column][/vc_row][vc_row fullwidth="true" textcolor="default" bgtype="default"][vc_column width="1/1"][portfoliobox align="center" sortable="no" pagination="no" show="8" column="four" view="default" title="OUR WORKS" subtitle="Duo te veritus iracundia. At ullum oporteat adversarium per." btntext="MORE WORKS" btnlink="#"][/vc_column][/vc_row][vc_row textcolor="default" bgtype="grey"][vc_column width="1/1"][testimonial align="center" show="5" column="three" view="carousel" title="OUR CLIENTS" subtitle="Eum case latine scripta ex, elitr affert diceret has ad, malis hendrerit ad pro."][/vc_column][/vc_row][vc_row][vc_column width="1/1"][team align="center" show="4" column="four" view="default" title="TEM MEMBERS" subtitle="Usu natum maiestatis at ius iriure mediocrem indicant ceter."][/vc_column][/vc_row][vc_row css=".vc_custom_1414833987443{padding-top: 50px !important;padding-bottom: 50px !important;}" textcolor="default" bgtype="skin"][vc_column width="1/1"][twitterbox show="3" consumer_key="v6t8tY3ZCKyZnZ5J1vBDA" consumer_secret="73K8GXdgriSFlff01t68e608y1sy5gvvuBgmCXlGEQg" oauth_token="198949585-yOkBOaBtYfsBLIgGlgUXRNwkIIWOSCnk3SMOjzKx" oauth_token_secret="wcTRHKILxqcsu0Lka3Vh2J0DGr7oR6pBMLdLtnwo5E" username="mojomarketplace"][/vc_column][/vc_row]
CONTENTTTTTTTTTTT;
	$maindata[] = $data;
	
	
	
	// Sample Homepage 4
    $data               = array();
    $data['name']       = __( 'Portfolio', 'howes' );
    $data['image_path'] = get_template_directory_uri() . '/inc/images/sample-page4.png' ; // always use preg replace to be sure that "space" will not break logic
    $data['custom_class'] = 'howes_home_4_template';
    $data['content']    = <<<CONTENTTTTTTTTTTT
        [vc_row][vc_column width="1/1"][portfoliobox align="center" sortable="yes" pagination="no" show="9" column="three" view="default" title="WELCOME TO PORTFOLIO" subtitle="Lorem ipsum dolor sit amet feugiat delicata liberavisse cum maiorum assum."][/vc_column][/vc_row][vc_row textcolor="default" bgtype="grey" css=".vc_custom_1414835597515{padding-bottom: 35px !important;}"][vc_column width="1/1"][heading text="OUR SERVICES" tag="h2" align="center" subtext="Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."][vc_row_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-tablet" contents="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et magna aliqua." buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="FULLY RESPONSIVE"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-compass" contents="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et magna aliqua." buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="UNIQUE DESIGN"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-crosshairs" contents="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et magna aliqua." buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="GREAT SUPPORT"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-thumbs-o-up" contents="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et magna aliqua." buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="HTML5 &amp; CSS3"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-location-arrow" contents="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et magna aliqua." buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="ENDLESS POSIBILITES"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-cog" contents="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et magna aliqua." buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="WEB DEVELOPMENT"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row][vc_column width="1/1"][team align="center" show="4" column="four" view="default" title="OUR TEAM" subtitle="Lorem ipsum dolor sit amet feugiat delicata liberavisse cum maiorum assum omnium suavitate ancillae conceptam."][/vc_column][/vc_row]
CONTENTTTTTTTTTTT;
	$maindata[] = $data;
	
	
	
	
	// Sample Homepage 5
    $data               = array();
    $data['name']       = __( 'Parallax', 'howes' );
    $data['image_path'] = get_template_directory_uri() . '/inc/images/sample-page5.png' ; // always use preg replace to be sure that "space" will not break logic
    $data['custom_class'] = 'howes_home_4_template';
    $data['content']    = <<<CONTENTTTTTTTTTTT
        [vc_row css=".vc_custom_1416300343166{padding-bottom: 55px !important;background-image: url(http://howes-data.thememount.com/wp-content/uploads/2014/07/parallax4.jpg?id=1443) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" textcolor="default" bgtype="dark" parallax="true"][vc_column width="1/1"][heading text="WE CREATE YOUR BUSINESS TO SUCCESS" tag="h2" align="center" subtext="Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt"][vc_row_inner][vc_column_inner width="1/3"][servicebox boxtype="centericon" icon="fa-cog" contents="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's " buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="WHAT WE DO"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="centericon" icon="fa-cloud-upload" contents="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's " buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="OUR GOAL"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="centericon" icon="fa-check-square-o" contents="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's " buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="STRATEGY"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row css=".vc_custom_1416300377405{padding-bottom: 60px !important;background-image: url(http://howes-data.thememount.com/wp-content/uploads/2014/07/bg10.jpg?id=1473) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" textcolor="default" bgtype="grey" parallax="true"][vc_column width="1/1"][portfoliobox align="center" sortable="no" pagination="no" show="6" column="three" view="default" title="OUR WORK" subtitle="Lorem Ipsum is simply dummy text of the printing and typesetting industry"][/vc_column][/vc_row][vc_row css=".vc_custom_1416300415416{background-image: url(http://howes-data.thememount.com/wp-content/uploads/2014/07/parallax4.jpg?id=1443) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" textcolor="default" bgtype="skin" parallax="true"][vc_column width="1/1"][twitterbox show="3" consumer_key="v6t8tY3ZCKyZnZ5J1vBDA" consumer_secret="73K8GXdgriSFlff01t68e608y1sy5gvvuBgmCXlGEQg" oauth_token="198949585-yOkBOaBtYfsBLIgGlgUXRNwkIIWOSCnk3SMOjzKx" oauth_token_secret="wcTRHKILxqcsu0Lka3Vh2J0DGr7oR6pBMLdLtnwo5E" username="envato"][/vc_column][/vc_row][vc_row css=".vc_custom_1416300502411{background-image: url(http://howes-data.thememount.com/wp-content/uploads/2014/07/bg10.jpg?id=1473) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" textcolor="default" bgtype="grey" parallax="true"][vc_column width="1/1"][team align="center" show="-1" column="four" view="carousel" title="OUR TEAM WORK" subtitle="Simply dummy text of the printing and typesetting industry"][/vc_column][/vc_row][vc_row css=".vc_custom_1415430539665{background-image: url(http://howes-data.thememount.com/wp-content/uploads/2014/07/bg10.jpg?id=1473) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" textcolor="default" bgtype="default" parallax="true"][vc_column width="1/1"][testimonial align="center" show="5" column="three" view="carousel" title="OUR TESTIMONIAL" subtitle="Ipsum is simply dummy text of the printing and typesetting industrydummy"][/vc_column][/vc_row]
CONTENTTTTTTTTTTT;
	$maindata[] = $data;
	
	
	
	
	// Sample Homepage 6
    $data               = array();
    $data['name']       = __( 'Home Shop', 'howes' );
    $data['image_path'] = get_template_directory_uri() . '/inc/images/sample-page6.png' ; // always use preg replace to be sure that "space" will not break logic
    $data['custom_class'] = 'howes_home_4_template';
    $data['content']    = <<<CONTENTTTTTTTTTTT
        [vc_row textcolor="default" bgtype="grey" css=".vc_custom_1415698103484{padding-top: 40px !important;padding-bottom: 5px !important;}"][vc_column width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-truck" buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="FREE SHIPPINGon order over $150.00"][/vc_column][vc_column width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-reply-all" buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="FREE RETURNfree 90 days return"][/vc_column][vc_column width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-send-o" buttontype="no" buttonstyle="rounded" buttoncolor="skincolor" buttonsize="md" buttonicon="fa-adjust" btniconposition="left" title="MEMBER DISCOUNT free register"][/vc_column][/vc_row][vc_row css=".vc_custom_1415698485944{padding-bottom: 60px !important;}" textcolor="default" bgtype="default"][vc_column width="1/1"][heading text="FEAUTURED PRODUCTS" tag="h2" align="center" subtext="Neque porro quisquam est qui dolorem ipsum quia dolor sit amet"][vc_column_text][featured_products per_page="4" columns="4"][/vc_column_text][/vc_column][/vc_row][vc_row css=".vc_custom_1415698428732{padding-top: 0px !important;}" textcolor="default" bgtype="default"][vc_column width="2/3"][vc_single_image image="1649" border_color="grey" img_link_target="_self" link="#" img_size="741x188"][/vc_column][vc_column width="1/3"][vc_single_image image="1650" border_color="grey" img_link_target="_self" link="#" img_size="399x208"][/vc_column][/vc_row][vc_row css=".vc_custom_1415704912637{padding-top: 0px !important;padding-bottom: 40px !important;}" textcolor="default" bgtype="default"][vc_column width="1/1"][heading text="NEW ARRIVALS" tag="h2" align="center" subtext="There is no one who loves pain itself, who seeks after it and wants to have it"][vc_column_text][recent_products per_page="4" columns="4"][/vc_column_text][/vc_column][/vc_row][vc_row textcolor="default" bgtype="default" css=".vc_custom_1415703449913{padding-top: 0px !important;}"][vc_column width="1/1"][blogbox align="center" show="5" column="three" view="carousel" title="OUR LATEST BLOG" subtitle="There are many variations of passages of Lorem Ipsum"][/vc_column][/vc_row][vc_row textcolor="default" bgtype="grey"][vc_column width="1/1"][clients align="center" show="4" column="four" view="default" title="OUR BRAND" subtitle="Lorem Ipsum is simply dummy text of the printing"][/vc_column][/vc_row]
CONTENTTTTTTTTTTT;
	$maindata[] = $data;
	
	
	
	/************* END of Visual Composer Template list ***************/
	
	
	// Return all VC templates
	return $maindata;
	
}




