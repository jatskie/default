<?php 
// Including Framework Master File
include_once('cuztom-helper-framework/cuztom.php');



// This must bein INIT action otherwise it will not call and return empty data.
function thememount_post_meta_options(){
	
	// Including Framework Master File
	include_once('cuztom-helper-framework/cuztom.php');

	// Declaring Posts variable
	$post = new Cuztom_Post_Type('post');
	
	
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
	
	
	// All options as tabs: Titlebar Opitons, Slider Area Options, Sidebar Widget Options
	$post->add_meta_box(
		'thememount_post_options',
		'Howes: Post Options',
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
						'name'          => 'title',
						'label'         => __('Post Title', 'howes'),
						'description'   => __('(Optional) Replace current page title with this title. So Search results will show the original page title and the page will show this title.', 'howes'),
						'type'          => 'textarea'
					),
					array(
						'name'          => 'subtitle',
						'label'         => __('Post Subtitle', 'howes'),
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
			
				
				__('Sidebar Widget Options','howes') => array(
					array(
						'name'          => 'leftsidebar',
						'label'         => __('Left Sidebar', 'howes'),
						'description'   => __('(Optional) Select left sidebar', 'howes'),
						'type'          => 'select',
						'options'       => $sidebars
					),
					array(
						'name'          => 'rightsidebar',
						'label'         => __('Right Sidebar', 'howes'),
						'description'   => __('(Optional) Select right sidebar', 'howes'),
						'type'          => 'select',
						'options'       => $sidebars
					),
					array(
						'name'          => 'sidebarposition',
						'label'         => __('Sidebar Position', 'howes'),
						'description'   => __('(Optional) Select position for sidebars', 'howes'),
						'type'          => 'select',
						'options'       => array(
							''         => __('Global', 'howes'),
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
	
	
	
	
	
	
	
	
	
	
$post->add_meta_box(
	'thememount_post_gallery',
	'Howes: Gallery Post Format Images for Slider', 
	array(
		/* Image Slider */
		array(
			'name'          => 'slideimage1',
			'label'         => __('1st Slider Image', 'howes'),
			'description'   => __('Select 1st image for slider here. You can select your featured image here to show the featured image as first image in slider.', 'howes'),
			'type'          => 'image',
		),
		array(
			'name'          => 'slideimage2',
			'label'         => __('2nd Slider Image', 'howes'),
			'description'   => __('(optional) Select 2nd image for slider here.', 'howes'),
			'type'          => 'image',
		),
		array(
			'name'          => 'slideimage3',
			'label'         => __('3rd Slider Image', 'howes'),
			'description'   => __('(optional) Select 3rd image for slider here.', 'howes'),
			'type'          => 'image',
		),
		array(
			'name'          => 'slideimage4',
			'label'         => __('4th Slider Image', 'howes'),
			'description'   => __('(optional) Select 4th image for slider here.', 'howes'),
			'type'          => 'image',
		),
		array(
			'name'          => 'slideimage5',
			'label'         => __('5th Slider Image', 'howes'),
			'description'   => __('(optional) Select 5th image for slider here.', 'howes'),
			'type'          => 'image',
		),
		array(
			'name'          => 'slideimage6',
			'label'         => __('6th Slider Image', 'howes'),
			'description'   => __('(optional) Select 6h image for slider here.', 'howes'),
			'type'          => 'image',
		),
		array(
			'name'          => 'slideimage7',
			'label'         => __('7th Slider Image', 'howes'),
			'description'   => __('(optional) Select 7th image for slider here.', 'howes'),
			'type'          => 'image',
		),
		array(
			'name'          => 'slideimage8',
			'label'         => __('8th Slider Image', 'howes'),
			'description'   => __('(optional) Select 8th image for slider here.', 'howes'),
			'type'          => 'image',
		),
		array(
			'name'          => 'slideimage9',
			'label'         => __('9th Slider Image', 'howes'),
			'description'   => __('(optional) Select 9th image for slider here.', 'howes'),
			'type'          => 'image',
		),
		array(
			'name'          => 'slideimage10',
			'label'         => __('10th Slider Image', 'howes'),
			'description'   => __('(optional) Select 10th image for slider here.', 'howes'),
			'type'          => 'image',
		),
	)
);
	
	
	
	
	
	
	
	


	
	
}  // Function: thememount_slider_options_setup()

add_action( 'init', 'thememount_post_meta_options' );