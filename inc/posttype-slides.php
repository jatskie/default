<?php 
// Including Framework Master File
include_once('cuztom-helper-framework/cuztom.php');


/*****************************************/
/****** generating Custom Post Type *******/

// Slides Section
// Icon List for "menu_icon" : http://melchoyce.github.io/dashicons/
$slide = new Cuztom_Post_Type( 'Slide', array(
	'has_archive'         => true,
	'exclude_from_search' => false, // Whether to exclude posts with this post type from front end search results.
	'publicly_queryable'  => true, // Whether queries can be performed on the front end as part of parse_request().
	'supports'            => array( 'title', 'thumbnail' ),
	'menu_icon'           => 'dashicons-images-alt2',
) );
/*****************************************/


// Move Featured Image box from left to center only on CLIENTS custom_post_type
add_action('do_meta_boxes', 'thememount_slides_featured_image_box');
function thememount_slides_featured_image_box() {
	remove_meta_box( 'postimagediv', 'customposttype', 'side' );
	add_meta_box('postimagediv', __('Slide Image','howes'), 'post_thumbnail_meta_box', 'slide', 'normal', 'high');
}


/*********** Post Meta Box **************/
$slide->add_meta_box(
	'thememount_slides_options',
	'Slide Options', 
	array(
		array(
			'name'          => 'desc',
			'label'         => __( 'Description', 'howes'),
			'description'   => __( 'Add description text for this slide', 'howes'),
			'type'          => 'textarea'
		),
		array(
			'name'          => 'btntext',
			'label'         => __( 'Button Text', 'howes'),
			'description'   => __( 'Add text for button.', 'howes'),
			'type'          => 'text'
		),
		array(
			'name'          => 'btnlink',
			'label'         => __( 'Button Link', 'howes'),
			'description'   => __( 'Add URL for button.', 'howes'),
			'type'          => 'text'
		),
	)
);
/**********************************************/


/* Category */
// Project Category
$slide->add_taxonomy( 'slide_group' );



