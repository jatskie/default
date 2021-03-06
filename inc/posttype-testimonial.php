<?php 
// Including Framework Master File
include_once('cuztom-helper-framework/cuztom.php');


/*****************************************/
/**** Now generating Post Meta Boxes *****/

// Team Member section
// Icon List for "menu_icon" : http://melchoyce.github.io/dashicons/
// Portfolio Entry Details
$testimonial  = new Cuztom_Post_Type( 'Testimonial', array(
	'supports'    => array( 'title', 'editor', 'thumbnail' ),
	'public'              => 1,
	'show_ui'             => 1,
	'publicly_queryable'  => 1,
	'query_var'           => 1,
	'rewrite'             => 1,
	'show_in_menu'        => true,
	'capability_type'     => 'post',
	'hierarchical'        => 1,
	'exclude_from_search' => true,
	'menu_icon'           => 'dashicons-format-status',
) );


/* Change "Enter Title Here" */
function thememount_testimonial_enter_title_here( $title ){
	$screen = get_current_screen();
	if ( 'testimonial' == $screen->post_type ) {
		$title = __('Person or company Name', 'howes');
	}
	return $title;
}
add_filter( 'enter_title_here', 'thememount_testimonial_enter_title_here' );


/* Text for the link to select Featured Image */
/*
function thememount_testimonial_admin_post_thumbnail_html( $content ) {
	global $current_screen;
	if( 'testimonial' == $current_screen->post_type ){
		return $content = str_replace( __( 'Set featured image', 'howes' ), __( 'Upload person image or company logo', 'howes' ), $content);
	} else {
		return $content;
	}
}
add_filter( 'admin_post_thumbnail_html', 'thememount_testimonial_admin_post_thumbnail_html' );
*/
/*****************************************/





// Move Featured Image box from left to center only on CLIENTS custom_post_type
add_action('do_meta_boxes', 'thememount_testimonial_featured_image_box');
function thememount_testimonial_featured_image_box() {
	remove_meta_box( 'postimagediv', 'customposttype', 'testimonial' );
	add_meta_box('postimagediv', __('Select/Upload image of person or company','howes'), 'post_thumbnail_meta_box', 'testimonial', 'normal', 'high');
}



/*********** Post Meta Box **************/
$testimonial->add_meta_box( 
	'thememount_testimonials_details',
	__('Howes: Testimonial Details', 'howes'),
	array(
		array(
			'name'          => 'clienturl',
			'label'         => __('Website Link', 'howes'),
			'description'   => __('(Optional) Please fill person or company\'s website link', 'howes'),
			'type'          => 'text'
		),
		array(
			'name'          => 'designation',
			'label'         => __('Person designation or company name', 'howes'),
			'description'   => __('(Optional) Please fill designation of the person. Fill Company name if it is a company.', 'howes'),
			'type'          => 'text'
		),
		
		
	)
);
/**********************************************/



// Testimonial Group
$testimonial->add_taxonomy( 'Testimonial Group' );

