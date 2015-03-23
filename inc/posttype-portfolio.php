<?php
// Including Framework Master File
include_once('cuztom-helper-framework/cuztom.php');


/******************************************/
/****** generating Custom Post Type *******/

// Portfolio section
// Icon List for "menu_icon" : http://melchoyce.github.io/dashicons/
$portfolio = new Cuztom_Post_Type( 'Portfolio',
	array(
		'has_archive' => false,
		'supports'    => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon'   => 'dashicons-screenoptions',
	), array(
		'name'               => __('Portfolio','howes'),
		'singular_name'      => __('Portfolio','howes'),
		'add_new'            => __('Add New','howes'),
		'add_new_item'       => __('Add New Portfolio','howes'),
		'edit_item'          => __('Edit Portfolio','howes'),
		'new_item'           => __('New Portfolio','howes'),
		'all_items'          => __('All Portfolio','howes'),
		'view_item'          => __('View Portfolio','howes'),
		'search_items'       => __('Search Portfolio','howes'),
		'not_found'          => __('No Portfolio found','howes'),
		'not_found_in_trash' => __('No Portfolio found in Trash','howes'),
		'parent_item_colon'  => '',
		'menu_name'          => __('Portfolio','howes')
  ) );

$portfolio->add_meta_box(
	'thememount_portfolio_data',
	__('Howes: Portfolio Options','howes'),
	array(
		array(
			'name'        => 'clientname',
			'label'       => __('Client Name','howes'),
			'description' => __('(Optional) Please fill client or company name','howes'),
			'type'        => 'text'
		),
		
		
		array(
			'name'        => 'clientlink',
			'label'       => __('Client Link','howes'),
			'description' => __('(Optional) Please fill client link','howes'),
			'type'        => 'text'
		),
		array(
			'name'        => 'skills',
			'label'       => __('Skills','howes'),
			'description' => __('(Optional) Please fill special skills','howes'),
			'type'        => 'text'
		),
		array(
			'name'        => 'linktext',
			'label'       => __('Project Link Text','howes'),
			'description' => __('(Optional) Please fill project link text. Example <code>Read More</code>','howes'),
			'type'        => 'text'
		),
		array(
			'name'        => 'linkurl',
			'label'       => __('Project Link URL','howes'),
			'description' => __('(Optional) Please fill project link URL. This will become the link for the "Project Link Text" word.','howes'),
			'type'        => 'text'
		),
		
		
	)
);



$portfolio->add_meta_box(
	'thememount_portfolio_featured',
	'Howes: Featured Image / Video / Slider', 
	array(
		array(
			'name'          => 'featuredtype',
			'label'         => __('Featured Image/Video', 'howes'),
			'description'   => __('Select what you want to show as featured. Image or Video', 'howes'),
			'type'          => 'radios',
			'options'       => array(
				'image'       => __('Featured Image', 'howes'),
				'video'       => __('Video (YouTube or Vimeo)', 'howes'),
				//'videoplayer' => __('Video (MP4, WEBM, OGG or OGV video file)', 'howes'),
				'audioembed'  => __('Audio (SoundCloud embed code)', 'howes'),
				//'audioplayer' => __('Audio (MP3, WAV or OGG audio file)', 'howes'),
				'slider'	  => __('Image Slider', 'howes'),
			),
			'default_value' => 'image'
		),
		
		/* Video (YouTube or Vimeo) */
		array(
			'name'          => 'videourl',
			'label'         => __('YouTube or Vimeo URL', 'howes'),
			'description'   => __('Paste YouTube or Vimeo URL here.', 'howes'),
			'type'          => 'textarea',
		),
		
		/* Video (MP4, WEBM, OGG or OGV video file) */
		/*array(
			'name'          => 'videofile_mp4',
			'label'         => __('Select MP4 file for video player', 'howes'),
			'description'   => __('Upload and select MP4 file for video player', 'howes'),
			'type'          => 'file',
		),
		array(
			'name'          => 'videofile_webm',
			'label'         => __('Select WEBM file for video player', 'howes'),
			'description'   => __('Upload and select WEBM file for video player', 'howes'),
			'type'          => 'file',
		),
		array(
			'name'          => 'videofile_ogv',
			'label'         => __('Select OGV (or OGG video) file for video player', 'howes'),
			'description'   => __('Upload and select OGV (or OGG video) file for video player', 'howes'),
			'type'          => 'file',
		), */
		
		/* Audio (SoundCloud embed code) */
		array(
			'name'          => 'audiocode',
			'label'         => __('SoundCloud (or any other service) Embed Code', 'howes'),
			'description'   => __('Paste SoundCloud or any other service embed code here.', 'howes'),
			'type'          => 'textarea',
		),
		
		/* Audio (MP3, WAV or OGG audio file) */
		/*array(
			'name'          => 'audiofile_mp3',
			'label'         => __('Select MP3 file for audio player', 'howes'),
			'description'   => __('Upload and select MP3 file for audio player', 'howes'),
			'type'          => 'file',
		),
		array(
			'name'          => 'audiofile_wav',
			'label'         => __('Select WAV file for audio player', 'howes'),
			'description'   => __('Upload and select WAV file for audio player', 'howes'),
			'type'          => 'file',
		),
		array(
			'name'          => 'audiofile_oga',
			'label'         => __('Select OGA (or OGG audio) file for audio player', 'howes'),
			'description'   => __('Upload and select OGA (or OGG audio) file for audio player', 'howes'),
			'type'          => 'file',
		), */
		
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



$portfolio->add_meta_box(
	'thememount_portfolio_view',
	'Howes: Portfolio View Style', 
	array(
		array(
			'name'          => 'viewstyle',
			'label'         => __('Portfolio View Style', 'howes'),
			'description'   => __('Select view for single portfolio', 'howes'),
			'type'          => 'radios',
			'options'       => array(
				'global'      => __('Global', 'howes'),
				'default'     => __('Left image and right content (default)', 'howes'),
				'top'         => __('Top image and bottom content', 'howes'),
			),
			'default_value' => 'global'
		),
	)
);


// Project Category
$portfolio->add_taxonomy( 'portfolio_category' );
