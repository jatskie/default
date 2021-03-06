<?php 
// Including Framework Master File
include_once('cuztom-helper-framework/cuztom.php');


/*****************************************/
/**** Now generating Post Meta Boxes *****/

// Team Member section
// Icon List for "menu_icon" : http://melchoyce.github.io/dashicons/
// Portfolio Entry Details
$client  = new Cuztom_Post_Type( 'Client', array(
	'supports'    => array( 'title', 'thumbnail' ),
	'public'              => 1,
	'show_ui'             => 1,
	'publicly_queryable'  => 1,
	'query_var'           => 1,
	'rewrite'             => 1,
	'show_in_menu'        => true,
	'capability_type'     => 'post',
	'hierarchical'        => 1,
	'exclude_from_search' => true,
	'menu_icon'           => 'dashicons-businessman',
	'labels'              => array('menu_name'=>'Client Logos'),
) );


/* Category */
// Project Category
$client->add_taxonomy( 'Client Group' );



/* Change "Enter Title Here" */
function thememount_client_enter_title_here( $title ){
	$screen = get_current_screen();
	if ( 'client' == $screen->post_type ) {
		$title = __('Client Name', 'howes');
	}
	return $title;
}
add_filter( 'enter_title_here', 'thememount_client_enter_title_here' );



/* Text for the link to select Featured Image */
/*
function thememount_client_admin_post_thumbnail_html( $content ) {
	global $current_screen;
	if( 'client' == $current_screen->post_type ){
		return $content = str_replace( __( 'Set featured image', 'howes' ), __( 'Upload client image', 'howes' ), $content);
	} else {
		return $content;
	}
}
add_filter( 'admin_post_thumbnail_html', 'thememount_client_admin_post_thumbnail_html' );
*/

/*****************************************/





// Move Featured Image box from left to center only on CLIENTS custom_post_type
add_action('do_meta_boxes', 'thememount_client_featured_image_box');
function thememount_client_featured_image_box() {
	remove_meta_box( 'postimagediv', 'customposttype', 'client' );
	add_meta_box('postimagediv', __('Select/Upload image of the client','howes'), 'post_thumbnail_meta_box', 'client', 'normal', 'high');
}



/*********** Post Meta Box **************/
$client->add_meta_box( 
	'thememount_clients_details',
	__('Howes: Client Details', 'howes'),
	array(
		array(
			'name'          => 'clienturl',
			'label'         => __('Website Link', 'howes'),
			'description'   => __('(Optional) Please fill person or company\'s website link', 'howes'),
			'type'          => 'text'
		),
	)
);
/**********************************************/


